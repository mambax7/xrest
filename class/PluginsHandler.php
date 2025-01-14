<?php

namespace XoopsModules\Xrest;

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

xoops_load('xoopscache');


/**
 * XOOPS policies handler class.
 * This class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 *
 * @author  Simon Roberts <simon@chronolabs.coop>
 * @package kernel
 */
class PluginsHandler extends \XoopsPersistableObjectHandler
{
    public function __construct(\XoopsDatabase $db)
    {
        $this->db = $db;
        parent::__construct($db, 'xrest_plugins', Plugins::class, 'plugin_id', 'plugin_name');
    }

    public function getServerExtensions()
    {
        return $this->getFileListAsArray($GLOBALS['xoops']->path('modules/xrest/plugins/'));
    }

    private function getDirListAsArray($dirname)
    {
        $ignored = [];
        $list    = [];
        if ('/' != substr($dirname, -1)) {
            $dirname .= '/';
        }
        $u = 0;
        if ($handle = opendir($dirname)) {
            while ($file = readdir($handle)) {
                if (0 === strpos($file, '.') || in_array(strtolower($file), $ignored)) {
                    continue;
                }
                if (is_dir($dirname . $file)) {
                    $list[$u++] = $file;
                }
            }
            closedir($handle);
            asort($list);
            reset($list);
        }
        //print_r($list);
        return $list;
    }

    private function getFileListAsArray($dirname, $prefix = '', $extension = '.php')
    {
        $filelist = [];
        if ('/' == substr($dirname, -1)) {
            $dirname = substr($dirname, 0, -1);
        }
        $u = 0;
        if (is_dir($dirname) && $handle = opendir($dirname)) {
            while (false !== ($file = readdir($handle))) {
                if (!preg_match('/^[\.]{1,2}$/', $file) && is_file($dirname . '/' . $file)) {
                    $file = $prefix . $file;
                    $extension;
                    if (strtolower(substr($file, strlen($file) - strlen($extension), strlen($extension))) == strtolower($extension)) {
                        $filelist[$u++] = $file;
                    } elseif ('*.*' == $extension) {
                        $filelist[$u++] = $file;
                    }
                }
            }
            closedir($handle);
            asort($filelist);
            reset($filelist);
        }
        return $filelist;
    }

    public function getPluginWithName($plugin_name)
    {
        $criteria = new \CriteriaCompo(new \Criteria('`plugin_name`', $plugin_name));
        if (0 == $this->getCount($criteria)) {
            return false;
        } elseif ($objects = $this->getObjects($criteria, false)) {
            return $objects[0] ?? false;
        }
        return false;
    }

    public function getPluginWithFile($plugin_file)
    {
        $criteria = new \CriteriaCompo(new \Criteria('`plugin_file`', $plugin_file));
        if (0 == $this->getCount($criteria)) {
            return false;
        } elseif ($objects = $this->getObjects($criteria, false)) {
            return $objects[0] ?? false;
        }
        return false;
    }
}

