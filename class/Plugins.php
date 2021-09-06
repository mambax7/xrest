<?php

namespace XoopsModules\Xrest;

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

xoops_load('xoopscache');

/**
 * Class for Blue Room XRest 1.52
 * @author    Simon Roberts <simon@chronolabs.coop>
 * @copyright copyright (c) 2012-2011 chronolabs.coop
 * @package   kernel
 */
class Plugins extends \XoopsObject
{
    public function __construct($id = null)
    {
        $this->initVar('plugin_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('plugin_name', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('plugin_file', XOBJ_DTYPE_TXTBOX, null, false, 255);
        $this->initVar('active', XOBJ_DTYPE_INT, null, false);
    }
}
