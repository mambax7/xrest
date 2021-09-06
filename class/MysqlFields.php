<?php

namespace XoopsModules\Xrest;

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

/**
 * Class for Blue Room XRest 1.52
 * @author    Simon Roberts <simon@chronolabs.coop>
 * @copyright copyright (c) 2012-2011 chronolabs.coop
 * @package   kernel
 */
class MysqlFields extends \XoopsObject
{
    public function __construct($id = null)
    {
        $this->initVar('Field', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Type', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Null', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Key', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Default', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Extra', XOBJ_DTYPE_OTHER, null, false);
    }
}

