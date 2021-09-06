<?php

namespace XoopsModules\Xrest;

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}


/**
 * XOOPS policies handler class.
 * This class is responsible for providing data access mechanisms to the data source
 * of XOOPS user class objects.
 *
 * @author  Simon Roberts <simon@chronolabs.coop>
 * @package kernel
 */
class FieldsHandler extends \XoopsPersistableObjectHandler
{
    public function __construct(\XoopsDatabase $db)
    {
        $this->db = $db;
        parent::__construct($db, 'xrest_fields', Fields::class, 'fld_id', 'fieldname');
    }

    public function getFieldFromTable($table)
    {
        $sql    = 'SHOW FIELDS FROM `' . $GLOBALS['xoopsDB']->prefix($table) . '`';
        $result = $GLOBALS['xoopsDB']->queryF($sql);
        $ret    = [];
        $i      = 1;
        while (false !== ($row = $GLOBALS['xoopsDB']->fetchArray($result))) {
            $ret[$i] = new XrestMysqlFields();
            $ret[$i]->assignVars($row);
            $i++;
        }
        return $ret;
    }

    public function getFieldWithNameAndTableID($fieldname, $tbl_id)
    {
        $criteria = new \CriteriaCompo(new \Criteria('`fieldname`', $fieldname));
        $criteria->add(new \Criteria('`tbl_id`', $tbl_id));
        if (0 == $this->getCount($criteria)) {
            return false;
        } elseif ($objects = $this->getObjects($criteria, false)) {
            return $objects[0] ?? false;
        }
        return false;
    }
}

?>
