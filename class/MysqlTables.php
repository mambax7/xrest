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
class MysqlTables extends \XoopsObject
{
    public function __construct($id = null)
    {
        $this->initVar('Name', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Engine', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Version', XOBJ_DTYPE_INT, null, false);
        $this->initVar('Row_format', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Rows', XOBJ_DTYPE_INT, null, false);
        $this->initVar('Avg_row_length', XOBJ_DTYPE_INT, null, false);
        $this->initVar('Data_length', XOBJ_DTYPE_INT, null, false);
        $this->initVar('Max_data_length', XOBJ_DTYPE_INT, null, false);
        $this->initVar('Index_length', XOBJ_DTYPE_INT, null, false);
        $this->initVar('Data_free', XOBJ_DTYPE_INT, null, false);
        $this->initVar('Auto_increment', XOBJ_DTYPE_INT, null, false);
        $this->initVar('Created_time', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Updated_time', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Check_time', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Collation', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Checksum', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Create_options', XOBJ_DTYPE_OTHER, null, false);
        $this->initVar('Comment', XOBJ_DTYPE_OTHER, null, false);
    }
}
