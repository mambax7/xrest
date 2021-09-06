<?php

require __DIR__ . '/admin_header.php';

$op     = ($_REQUEST['op'] ?? 'dashboard');
$tbl_id = ($_REQUEST['tbl_id'] ?? 0);

switch ($op) {
    default:
    case 'dashboard':

        xoops_load('xoopscache');
        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation('index.php?op=dashboard');

        $pluginsHandler = xoops_getModuleHandler('plugins', 'xrest');
        $tablesHandler  = xoops_getModuleHandler('tables', 'xrest');
        $fieldsHandler  = xoops_getModuleHandler('fields', 'xrest');

        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->addInfoBox(_XREST_AM_XREST_SUMANDTOTAL);
        $adminObject->addInfoBoxLine(_XREST_AM_XREST_SUMANDTOTAL, '<label>' . _XREST_AM_XREST_TOTAL_PLUGINS . '</label>', $pluginsHandler->getCount(), ($pluginsHandler->getCount() > 0 ? 'Green' : 'Red'));
        $adminObject->addInfoBoxLine(_XREST_AM_XREST_SUMANDTOTAL, '<label>' . _XREST_AM_XREST_TOTAL_ACTIVE_PLUGINS . '</label>', $pluginsHandler->getCount(new Criteria('`active`', '1', '=')), ($pluginsHandler->getCount(new Criteria('`active`', '1', '=')) > 0 ? 'Green' : 'Red'));
        $adminObject->addInfoBoxLine(_XREST_AM_XREST_SUMANDTOTAL, '<label>' . _XREST_AM_XREST_TOTAL_INACTIVE_PLUGINS . '</label>', $pluginsHandler->getCount(new Criteria('`active`', '0', '=')), ($pluginsHandler->getCount(new Criteria('`active`', '0', '=')) > 0 ? 'Green' : 'Red'));
        $adminObject->addInfoBoxLine(_XREST_AM_XREST_SUMANDTOTAL, '<label>' . _XREST_AM_XREST_TOTAL_FAILED_PLUGINS . '</label>', (int)XoopsCache::read('xrest_plugins_failed'), ((int)XoopsCache::read('xrest_plugins_failed') > 0 ? 'Red' : 'Green'));
        $adminObject->addInfoBoxLine(_XREST_AM_XREST_SUMANDTOTAL, '<label>' . _XREST_AM_XREST_TOTAL_TABLES . '</label>', $tablesHandler->getCount(new Criteria('`view`', '0', '=')), ($tablesHandler->getCount(new Criteria('`view`', '0', '=')) > 0 ? 'Green' : 'Red'));
        $adminObject->addInfoBoxLine(_XREST_AM_XREST_SUMANDTOTAL, '<label>' . _XREST_AM_XREST_TOTAL_VIEWS . '</label>', $tablesHandler->getCount(new Criteria('`view`', '1', '=')), ($tablesHandler->getCount(new Criteria('`view`', '1', '=')) > 0 ? 'Green' : 'Red'));
        $adminObject->addInfoBoxLine(_XREST_AM_XREST_SUMANDTOTAL, '<label>' . _XREST_AM_XREST_TOTAL_FIELDS . '</label>', $fieldsHandler->getCount(), ($tablesHandler->getCount() > 0 ? 'Green' : 'Red'));
        $adminObject->addInfoBoxLine(
            _XREST_AM_XREST_SUMANDTOTAL,
            '<label>' . _XREST_AM_XREST_AVERAGE_FIELDS . '</label>',
            number_format(($fieldsHandler->getCount() + 1) / ($tablesHandler->getCount(new Criteria('`view`', '0', '=')) + 1), 2),
            (number_format(($fieldsHandler->getCount() + 1) / ($tablesHandler->getCount(new Criteria('`view`', '0', '=')) + 1), 2) > 0 ? 'Green' : 'Red')
        );
        $lastplugin = XoopsCache::read('xrest_plugins_last');
        if (count($lastplugin) >= 5) {
            $adminObject->addInfoBox(_XREST_AM_XREST_LASTANDDATE);
            $adminObject->addInfoBoxLine(_XREST_AM_XREST_LASTANDDATE, '<label>' . _XREST_AM_XREST_LAST_PLUGINS_CALLED . '</label>', $lastplugin['plugin'], 'Blue');
            if (!empty($lastplugin['user'])) {
                $adminObject->addInfoBoxLine(_XREST_AM_XREST_LASTANDDATE, '<label>' . _XREST_AM_XREST_LAST_PLUGINS_CALLEDBY . '</label>', $lastplugin['user'], 'Blue');
            }
            $adminObject->addInfoBoxLine(_XREST_AM_XREST_LASTANDDATE, '<label>' . _XREST_AM_XREST_LAST_PLUGINS_CALLEDWHEN . '</label>', date(_DATESTRING, $lastplugin['when']), 'Blue');
            $adminObject->addInfoBoxLine(_XREST_AM_XREST_LASTANDDATE, '<label>' . _XREST_AM_XREST_LAST_PLUGINS_TOOKTOEXECUTE . '</label>', $lastplugin['took'], 'Blue');
            $adminObject->addInfoBoxLine(_XREST_AM_XREST_LASTANDDATE, '<label>' . _XREST_AM_XREST_LAST_PLUGINS_EXECUTED . '</label>', $lastplugin['executed'], 'Green');
            $adminObject->addInfoBoxLine(_XREST_AM_XREST_LASTANDDATE, '<label>' . _XREST_AM_XREST_LAST_PLUGINS_EXECUTION . '</label>', $lastplugin['execution'], 'Green');
        }
        $lastcleanup = XoopsCache::read('xrest_cleanup_last');
        if (3 == count($lastcleanup)) {
            $adminObject->addInfoBox(_XREST_AM_XREST_CLEANUPANDDATE);
            $adminObject->addInfoBoxLine(_XREST_AM_XREST_CLEANUPANDDATE, '<label>' . _XREST_AM_XREST_LAST_CLEANUP_WHEN . '</label>', date(_DATESTRING, $lastcleanup['when']), 'Purple');
            $adminObject->addInfoBoxLine(_XREST_AM_XREST_CLEANUPANDDATE, '<label>' . _XREST_AM_XREST_LAST_CLEANUP_FILES . '</label>', $lastcleanup['files'], 'Purple');
            $adminObject->addInfoBoxLine(_XREST_AM_XREST_CLEANUPANDDATE, '<label>' . _XREST_AM_XREST_LAST_CLEANUP_TOOKTOEXECUTE . '</label>', $lastcleanup['took'], 'Purple');
        }
        $adminObject->displayIndex();
        xoops_cp_footer();
        break;
    case 'about':
        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation('index.php?op=about');

        $paypalitemno = 'XRESTABOUT100';
        $aboutAdmin   = \Xmf\Module\Admin::getInstance();
        $about        = $aboutAdmin->renderAbout($paypalitemno, false);
        $donationform = [
            0   => '<form name="donation" id="donation" action="http://www.chronolabs.coop/modules/xpayment/" method="post" onsubmit="return xoopsFormValidate_donation();">',
            1   => '<table class="outer" cellspacing="1" width="100%"><tbody><tr><th colspan="2">'
                   . constant('_XREST_AM_MAKE_DONATION')
                   . '</th></tr><tr align="left" valign="top"><td class="head"><div class="xoops-form-element-caption-required"><span class="caption-text">Donation Amount</span><span class="caption-marker">*</span></div></td><td class="even"><select size="1" name="item[A][amount]" id="item[A][amount]" title="Donation Amount"><option value="5">5.00 AUD</option><option value="10">10.00 AUD</option><option value="20">20.00 AUD</option><option value="40">40.00 AUD</option><option value="60">60.00 AUD</option><option value="80">80.00 AUD</option><option value="90">90.00 AUD</option><option value="100">100.00 AUD</option><option value="200">200.00 AUD</option></select></td></tr><tr align="left" valign="top"><td class="head"></td><td class="even"><input class="formButton" name="submit" id="submit" value="'
                   . _SUBMIT
                   . '" title="'
                   . _SUBMIT
                   . '" type="submit"></td></tr></tbody></table>',
            2   => '<input name="op" id="op" value="createinvoice" type="hidden"><input name="plugin" id="plugin" value="donations" type="hidden"><input name="donation" id="donation" value="1" type="hidden"><input name="drawfor" id="drawfor" value="Chronolabs Co-Operative" type="hidden"><input name="drawto" id="drawto" value="%s" type="hidden"><input name="drawto_email" id="drawto_email" value="%s" type="hidden"><input name="key" id="key" value="%s" type="hidden"><input name="currency" id="currency" value="AUD" type="hidden"><input name="weight_unit" id="weight_unit" value="kgs" type="hidden"><input name="item[A][cat]" id="item[A][cat]" value="XDN%s" type="hidden"><input name="item[A][name]" id="item[A][name]" value="Donation for %s" type="hidden"><input name="item[A][quantity]" id="item[A][quantity]" value="1" type="hidden"><input name="item[A][shipping]" id="item[A][shipping]" value="0" type="hidden"><input name="item[A][handling]" id="item[A][handling]" value="0" type="hidden"><input name="item[A][weight]" id="item[A][weight]" value="0" type="hidden"><input name="item[A][tax]" id="item[A][tax]" value="0" type="hidden"><input name="return" id="return" value="http://www.chronolabs.coop/modules/donations/success.php" type="hidden"><input name="cancel" id="cancel" value="http://www.chronolabs.coop/modules/donations/success.php" type="hidden"></form>',
            'D' => '',
            3   => '',
            4   => '<!-- Start Form Validation JavaScript //-->
<script type="text/javascript">
<!--//
function xoopsFormValidate_donation() { var myform = window.document.donation; 
var hasSelected = false; var selectBox = myform.item[A][amount];for (i = 0; i < selectBox.options.length; i++ ) { if (selectBox.options[i].selected === true && selectBox.options[i].value != \'\') { hasSelected = true; break; } }if (!hasSelected) { window.alert("Please enter Donation Amount"); selectBox.focus(); return false; }return true;
}
//--></script>
<!-- End Form Validation JavaScript //-->',
        ];
        $paypalform   = [
            0 => '<form action="https://www.paypal.com/cgi-bin/webscr" method="post">',
            1 => '<input name="cmd" value="_s-xclick" type="hidden">',
            2 => '<input name="hosted_button_id" value="%s" type="hidden">',
            3 => '<img alt="" src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" height="1" border="0" width="1">',
            4 => '<input src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!" border="0" type="image">',
            5 => '</form>',
        ];
        for ($key = 0; $key <= 4; $key++) {
            switch ($key) {
                case 2:
                    $donationform[$key] = sprintf(
                        $donationform[$key],
                        $GLOBALS['xoopsConfig']['sitename'] . ' - ' . (strlen($GLOBALS['xoopsUser']->getVar('name')) > 0 ? $GLOBALS['xoopsUser']->getVar('name') . ' [' . $GLOBALS['xoopsUser']->getVar('uname') . ']' : $GLOBALS['xoopsUser']->getVar('uname')),
                        $GLOBALS['xoopsUser']->getVar('email'),
                        XOOPS_LICENSE_KEY,
                        strtoupper($GLOBALS['xrestModule']->getVar('dirname')),
                        strtoupper($GLOBALS['xrestModule']->getVar('dirname')) . ' ' . $GLOBALS['xrestModule']->getVar('name')
                    );
                    break;
            }
        }

        $istart = strpos($about, ($paypalform[0]), 1);
        $iend   = strpos($about, ($paypalform[5]), $istart + 1) + strlen($paypalform[5]) - 1;
        echo(substr($about, 0, $istart - 1));
        echo implode("\n", $donationform);
        echo(substr($about, $iend + 1, strlen($about) - $iend - 1));
        xoops_cp_footer();
        break;
    case 'fields':

        if (!$tbl_id) {
            $tbl_id = 1;
        }

        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation('index.php?op=fields');

        echo xrest_admin_form_select_table($tbl_id);
        echo "<div style='clear:both;'></div>";
        echo xrest_admin_form_select_fields($tbl_id);
        xoops_cp_footer();
        break;

    case 'views':

        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation('index.php?op=views');

        echo xrest_admin_form_select_views(XOOPS_DB_NAME);
        xoops_cp_footer();
        break;

    case 'plugins':

        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation('index.php?op=plugins');

        echo xrest_admin_form_select_plugins();
        xoops_cp_footer();
        break;

    case 'tables':

        xoops_cp_header();
        $adminObject = \Xmf\Module\Admin::getInstance();
        $adminObject->displayNavigation('index.php?op=tables');

        echo xrest_admin_form_select_tables(XOOPS_DB_NAME, XOOPS_DB_PREFIX);
        xoops_cp_footer();
        break;

    case 'savefields':
        $fieldsHandler = xoops_getModuleHandler('fields', 'xrest');
        foreach ($_POST['id'] as $id => $fld_id) {
            switch ($fld_id) {
                case 'new':
                    $field = $fieldsHandler->create();
                    $field->setVars($_POST[$id]);
                    $field->setVar('tbl_id', $_POST['tbl_id']);
                    $fieldsHandler->insert($field);
                    break;
                default:
                    $field = $fieldsHandler->get($fld_id);
                    $field->setVars($_POST[$id]);
                    $fieldsHandler->insert($field);
            }
        }
        redirect_header('index.php?op=fields&tbl_id=' . $tbl_id, 2, _XREST_AM_MSG_SAVEFIELDS_DATABASE_UPDATED);
        break;

    case 'savetables':

        $tablesHandler = xoops_getModuleHandler('tables', 'xrest');
        foreach ($_POST['id'] as $id => $tbl_id) {
            switch ($tbl_id) {
                case 'new':
                    $table = $tablesHandler->create();
                    $table->setVars($_POST[$id]);
                    $tablesHandler->insert($table);
                    break;
                default:
                    $table = $tablesHandler->get($tbl_id);
                    $table->setVars($_POST[$id]);
                    $tablesHandler->insert($table);
            }
        }
        redirect_header('index.php?op=tables', 2, _XREST_AM_MSG_SAVETABLES_DATABASE_UPDATED);
        break;
    case 'saveviews':

        $tablesHandler = xoops_getModuleHandler('tables', 'xrest');
        foreach ($_POST['id'] as $id => $tbl_id) {
            switch ($tbl_id) {
                case 'new':
                    $table = $tablesHandler->create();
                    $table->setVars($_POST[$id]);
                    $table->setVar('view', true);
                    $tablesHandler->insert($table);
                    break;
                default:
                    $table = $tablesHandler->get($tbl_id);
                    $table->setVars($_POST[$id]);
                    $tablesHandler->insert($table);
            }
        }
        redirect_header('index.php?op=views', 2, _XREST_AM_MSG_SAVEVIEWS_DATABASE_UPDATED);
        break;

    case 'saveplugins':

        $pluginsHandler = xoops_getModuleHandler('plugins', 'xrest');
        foreach ($_POST['id'] as $id => $plugin_id) {
            switch ($plugin_id) {
                case 'new':
                    $plugin = $pluginsHandler->create();
                    $plugin->setVars($_POST[$id]);
                    $pluginsHandler->insert($plugin);
                    break;
                default:
                    $plugin = $pluginsHandler->get($plugin_id);
                    $plugin->setVars($_POST[$id]);
                    $pluginsHandler->insert($plugin);
            }
        }
        redirect_header('index.php?op=plugins', 2, _XREST_AM_MSG_SAVEPLUGINS_DATABASE_UPDATED);
        break;
}

?>
