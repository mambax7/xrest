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
class Fields extends \XoopsObject
{
    public function __construct($id = null)
    {
        $this->initVar('fld_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('tbl_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('key', XOBJ_DTYPE_INT, null, false);
        $this->initVar('fieldname', XOBJ_DTYPE_TXTBOX, null, false, 220);
        $this->initVar('allowpost', XOBJ_DTYPE_INT, null, false);
        $this->initVar('allowretrieve', XOBJ_DTYPE_INT, null, false);
        $this->initVar('allowupdate', XOBJ_DTYPE_INT, null, false);
        $this->initVar('visible', XOBJ_DTYPE_INT, null, false);
        $this->initVar('string', XOBJ_DTYPE_INT, null, false);
        $this->initVar('int', XOBJ_DTYPE_INT, null, false);
        $this->initVar('float', XOBJ_DTYPE_INT, null, false);
        $this->initVar('text', XOBJ_DTYPE_INT, null, false);
        $this->initVar('other', XOBJ_DTYPE_INT, null, false);
        $this->initVar('crc', XOBJ_DTYPE_INT, null, false);
    }
}

