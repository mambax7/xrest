<?php

/*
 *   Plugin function (Must have same case and filename as plugin)
   */
function tweet($username, $password, $nick, $message)
{
    if (strlen($message) < 10) {
        return ['CODE' => 300];
    }

    global $xoopsModuleConfig, $xoopsConfig;

    if (1 == $xoopsModuleConfig['site_user_auth']) {
        if ($ret = check_for_lock(basename(__FILE__), $username, $password)) {
            return $ret;
        }
        if (!checkright(basename(__FILE__), $username, $password)) {
            mark_for_lock(basename(__FILE__), $username, $password);
            return ['ErrNum' => 9, 'ErrDesc' => 'No Permission for plug-in'];
        }
    }

    include $GLOBALS['xoops']->path('modules/twitterbomb/include/functions.php');
    xoops_load('xoopscache');
    set_time_limit(480);

    $GLOBALS['myts'] = MyTextSanitizer::getInstance();

    $moduleHandler                      = xoops_getHandler('module');
    $configHandler                      = xoops_getHandler('config');
    $GLOBALS['twitterbombModule']       = $moduleHandler->getByDirname('twitterbomb');
    $GLOBALS['twitterbombModuleConfig'] = $configHandler->getConfigList($GLOBALS['twitterbombModule']->getVar('mid'));

    $tweet            = '#' . str_replace(['@', '+', '%'], '', $nick) . ' - ' . twitterbomb_TweetString(htmlspecialchars_decode($message), $GLOBALS['twitterbombModuleConfig']['scheduler_aggregate'], $GLOBALS['twitterbombModuleConfig']['scheduler_wordlength']);
    $logHandler       = xoops_getModuleHandler('log', 'twitterbomb');
    $schedulerHandler = xoops_getModuleHandler('scheduler', 'twitterbomb');
    $oauthHandler     = xoops_getModuleHandler('oauth', 'twitterbomb');
    $urlsHandler      = xoops_getModuleHandler('urls', 'twitterbomb');

    $oauth = $oauthHandler->getRootOauth(true);

    $ret = XoopsCache::read('tweetbomb_scheduler_' . md5('2' . '2'));
    if (!is_array($ret)) {
        $ret = [];
    }

    $schedule = $schedulerHandler->create();
    $schedule->setVar('cid', '2');
    $schedule->setVar('catid', '2');
    $schedule->setVar('mode', 'direct');
    $schedule->setVar('pre', '#sex');
    $schedule->setVar('text', $tweet);
    $schedule->setVar('uid', user_uid($username, $password));
    $schedule = $schedulerHandler->get($schedulerHandler->insert($schedule));
    $url      = $urlsHandler->getUrl($schedule->getVar('cid'), $schedule->getVar('catid'));
    $link     = XOOPS_URL . '/modules/twitterbomb/go.php?sid=' . $schedule->getVar('sid') . '&cid=' . $schedule->getVar('cid') . '&catid=' . $schedule->getVar('catid') . '&uri=' . urlencode(sprintf($url, urlencode(str_replace(['#', '@'], '', $tweet))));
    $log      = $logHandler->create();
    $log->setVar('provider', 'scheduler');
    $log->setVar('cid', $schedule->getVar('cid'));
    $log->setVar('catid', $schedule->getVar('catid'));
    $log->setVar('sid', $schedule->getVar('sid'));
    $log->setVar('url', $link);
    $log->setVar('tweet', substr($tweet, 0, 139));
    $log->setVar('tags', twitterbomb_ExtractTags($tweet));
    $log  = $logHandler->get($lid = $logHandler->insert($log, true));
    $link = XOOPS_URL . '/modules/twitterbomb/go.php?sid=' . $schedule->getVar('sid') . '&cid=' . $schedule->getVar('cid') . '&lid=' . $lid . '&catid=' . $schedule->getVar('catid') . '&uri=' . urlencode(sprintf($url, urlencode(str_replace(['#', '@'], '', $tweet))));
    $link = twitterbomb_shortenurl($link);
    $log->setVar('url', $link);
    $log = $logHandler->get($lid = $logHandler->insert($log, true));
    if ($id = $oauth->sendTweet($schedule->getVar('pre') . ' ' . $tweet, $link, true)) {
        if ($GLOBALS['twitterbombModuleConfig']['tags']) {
            $tagHandler = xoops_getModuleHandler('tag', 'tag');
            $tagHandler->updateByItem(twitterbomb_ExtractTags($tweet), $lid, $GLOBALS['twitterbombModule']->getVar('dirname'), $schedule->getVar('catid'));
        }
        $log->setVar('id', $id);
        $log->setVar('alias', $nick);
        $logHandler->insert($log, true);
        $schedule->setVar('when', time());
        $schedule->setVar('tweeted', time());
        $schedulerHandler->insert($schedule);
        $ret[]['title']                  = $tweet;
        $ret[count($ret)]['link']        = $link;
        $ret[count($ret)]['description'] = htmlspecialchars_decode($tweet);
        $ret[count($ret)]['lid']         = $lid;
        $ret[count($ret)]['sid']         = $schedule->getVar('sid');
        if (count($ret) > $GLOBALS['twitterbombModuleConfig']['scheduler_items']) {
            foreach ($ret as $key => $value) {
                if (count($ret) > $GLOBALS['twitterbombModuleConfig']['scheduler_items']) {
                    unset($ret[$key]);
                }
            }
        }
        XoopsCache::write('tweetbomb_scheduler_' . md5('2' . '2'), $ret, $GLOBALS['twitterbombModuleConfig']['interval_of_cron'] + $GLOBALS['twitterbombModuleConfig']['scheduler_cache']);
        return ['CODE' => 200];
    } else {
        $schedule->setVar('when', time());
        $schedulerHandler->insert($schedule);
        @$logHandler->delete($log, true);
        return ['CODE' => 100];
    }
}

/*
 *   XSD Variable Definitions (REST JSON/XML/SERIALISATION ONLY)
 */
function tweet_xsd_rest($parser)
{
    $xsd                  = [];
    $i                    = 0;
    $xsd['request'][$i++] = ['name' => 'username', 'type' => 'string'];
    $xsd['request'][$i++] = ['name' => 'password', 'type' => 'string'];
    $xsd['request'][$i++] = [
        'name'  => 'nick',
        'items' => [
            ['name' => 'password', 'type' => 'string'],
            ['name' => 'password', 'type' => 'string'],
        ],
    ];
    $xsd['request'][$i++] = ['name' => 'message', 'type' => 'string'];

    $i                     = 0;
    $xsd['response'][$i++] = ['name' => 'ERRNUM', 'type' => 'integer'];
    $xsd['response'][$i++] = ['name' => 'RESULT', 'type' => 'string'];
    $xsd['response'][$i++] = ['name' => 'CODE', 'type' => 'string'];

    return $xsd;
}

/*
 *   XSD Variable Definitions - See Templating *.XML (SOAP ONLY)
 */
function tweet_xsd_soap($parser)
{
    $xsd                  = [];
    $i                    = 0;
    $xsd['request'][$i++] = ['name' => 'username', 'type' => 'string'];
    $xsd['request'][$i++] = ['name' => 'password', 'type' => 'string'];
    $xsd['request'][$i++] = ['name' => 'nick', 'type' => 'string'];
    $xsd['request'][$i++] = ['name' => 'message', 'type' => 'string'];

    $i                     = 0;
    $xsd['response'][$i++] = ['name' => 'ERRNUM', 'type' => 'integer'];
    $xsd['response'][$i++] = ['name' => 'RESULT', 'type' => 'string'];
    $xsd['response'][$i++] = ['name' => 'CODE', 'type' => 'string'];

    return $xsd;
}

/*
 *   Enabled to true if base default WSDL is issued (SOAP ONLY)
 *
 *   See: http://www.w3.org/TR/wsdl#_wsdl
 */
function tweet_wsdl()
{
    return false;
}

/*
 *   Enabled to true if services default WSDL is issued (SOAP ONLY)
 *
 *   See: http://www.w3.org/TR/wsdl#_style
 */
function tweet_wsdl_service()
{
    return false;
}

/*
 *   Enabled to true if services default WSDL is issued (SOAP ONLY)
 *
 *   See: http://www.w3.org/TR/wsdl#_documentation
 */
function tweet_wsdl_documentation($plugin, $parser)
{
    $doc = '';
    $doc .= '';
    $doc .= '';
    $doc .= '';
    $doc .= '';
    return $doc;
}

?>
