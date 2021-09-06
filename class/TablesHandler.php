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
class TablesHandler extends \XoopsPersistableObjectHandler
{
    public function __construct(\XoopsDatabase $db)
    {
        $this->db = $db;
        parent::__construct($db, 'xrest_tables', Tables::class, 'tbl_id', 'tablename');
    }

    public function getTablesInDatabase($database, $prefix = '')
    {
        if (empty($prefix)) {
            $sql = 'SHOW TABLE STATUS FROM `' . $database . '`';
        } else {
            $sql = 'SHOW TABLE STATUS FROM `' . $database . '` LIKE "' . $prefix . '%"';
        }
        $result = $GLOBALS['xoopsDB']->queryF($sql);
        $ret    = [];
        $i      = 1;
        while (false !== ($row = $GLOBALS['xoopsDB']->fetchArray($result))) {
            if ('VIEW' != $row['Comment'] && 'TRIGGER' != $row['Comment'] && 'STORE PROCEEDURE' != $row['Comment']) {
                $ret[$i] = new MysqlTables();
                $ret[$i]->assignVars($row);
                $i++;
            }
        }
        return $ret;
    }

    public function getViewsInDatabase($database)
    {
        $sql    = 'SHOW TABLE STATUS FROM `' . $database . '`';
        $result = $GLOBALS['xoopsDB']->queryF($sql);
        $ret    = [];
        $i      = 1;
        while (false !== ($row = $GLOBALS['xoopsDB']->fetchArray($result))) {
            if ('VIEW' == $row['Comment']) {
                $ret[$i] = new MysqlTables();
                $ret[$i]->assignVars($row);
                $i++;
            }
        }
        return $ret;
    }

    public function getTableWithName($tablename, $view = false)
    {
        $criteria = new \CriteriaCompo(new \Criteria('`tablename`', $tablename));
        $criteria->add(new \Criteria('`view`', $view));
        if (0 == $this->getCount($criteria)) {
            return false;
        } elseif ($objects = $this->getObjects($criteria, false)) {
            return $objects[0] ?? false;
        }
        return false;
    }

    public function getViewWithName($viewname)
    {
        return $this->getTableWithName($viewname, true);
    }
}

