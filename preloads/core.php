<?php
/**
 * @package        xortify
 * @subpackage     module
 * @description    Sector Nexoork Security Drone
 * @author         Simon Roberts WISHCRAFT <simon@chronolabs.coop>
 * @author         Richardo Costa TRABIS
 * @copyright      copyright (c) 2010-2013 XOOPS.org
 * @licence        GPL 2.0 - see docs/LICENCE.txt
 */

defined('XOOPS_ROOT_PATH') || die('Restricted access');

class XrestCorePreload extends XoopsPreloadItem
{
    public function eventCoreIncludeCommonEnd($args)
    {
        $moduleHandler          = xoops_getHandler('module');
        $configHandler          = xoops_getHandler('config');
        $GLOBALS['xrestModule'] = $moduleHandler->getByDirname('xrest');
        if (is_object($GLOBALS['xrestModule'])) {
            $GLOBALS['xrestModuleConfig'] = $configHandler->getConfigList($GLOBALS['xrestModule']->getVar('mid'));
        }
        require_once XOOPS_ROOT_PATH . '/class/cache/xoopscache.php';
        $result = \XoopsCache::read('xrest_cleanup_last');
        if ((isset($result['when']) ? (float)$result['when'] : -microtime(true)) + $GLOBALS['xrestModuleConfig']['run_cleanup'] <= microtime(true)) {
            $result          = [];
            $result['when']  = microtime(true);
            $result['files'] = 0;
            foreach (self::getFileListAsArray(XOOPS_VAR_PATH . '/caches/xoops_cache/', 'xrest') as $id => $file) {
                $result['files']++;
                @unlink(XOOPS_VAR_PATH . '/caches/xoops_data/' . $file);
            }
            $result['took'] = microtime(true) - $result['when'];
            \XoopsCache::write('xrest_cleanup_last', $result, $GLOBALS['xrestModuleConfig']['run_cleanup'] * 2);
        }
    }

    public static function getFileListAsArray($dirname, $prefix = 'xrest')
    {
        $filelist = [];
        if ('/' == substr($dirname, -1)) {
            $dirname = substr($dirname, 0, -1);
        }
        if (is_dir($dirname) && $handle = opendir($dirname)) {
            while (false !== ($file = readdir($handle))) {
                if (!preg_match('/^[\.]{1,2}$/', $file) && is_file($dirname . '/' . $file)) {
                    if (!empty($prefix) && strpos(' ' . $file, $prefix) > 0) {
                        $filelist[$file] = $file;
                    } elseif (empty($prefix)) {
                        $filelist[$file] = $file;
                    }
                }
            }
            closedir($handle);
            asort($filelist);
            reset($filelist);
        }
        return $filelist;
    }
}

?>
