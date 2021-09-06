<?php

namespace XoopsModules\Xrest;

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

/**
 * Class for Blue Room Xrest 1.52
 * @author    Simon Roberts <simon@chronolabs.coop>
 * @copyright copyright (c) 2012-2011 chronolabs.coop
 * @package   kernel
 */
class Tables extends \XoopsObject
{
    public function __construct($id = null)
    {
        $this->initVar('tbl_id', XOBJ_DTYPE_INT, null, false);
        $this->initVar('tablename', XOBJ_DTYPE_TXTBOX, null, false, 220);
        $this->initVar('allowpost', XOBJ_DTYPE_INT, null, false);
        $this->initVar('allowretrieve', XOBJ_DTYPE_INT, null, false);
        $this->initVar('allowupdate', XOBJ_DTYPE_INT, null, false);
        $this->initVar('visible', XOBJ_DTYPE_INT, null, false);
        $this->initVar('view', XOBJ_DTYPE_INT, null, false);
    }
}
