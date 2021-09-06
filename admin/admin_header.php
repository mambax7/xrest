<?php

/**
 * Invoice Transaction Gateway with Modular Plugin set
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Co-Op http://www.chronolabs.coop/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xrest
 * @since           1.30.0
 * @author          Simon Roberts <simon@chronolabs.coop>
 * @translation     Erol Konik <aphex@aphexthemes.com>
 * @translation     Mariane <mariane_antoun@hotmail.com>
 * @translation     Voltan <voltan@xoops.ir>
 * @translation     Ezsky <ezskyyoung@gmail.com>
 * @translation     Richardo Costa <lusopoemas@gmail.com>
 * @translation     Kris_fr <kris@frxoops.org>
 */
require dirname(__DIR__, 3) . '/include/cp_header.php';

if (!defined('_CHARSET')) {
    define('_CHARSET', 'UTF-8');
}
if (!defined('_CHARSET_ISO')) {
    define('_CHARSET_ISO', 'ISO-8859-1');
}

$GLOBALS['myts'] = MyTextSanitizer::getInstance();

$moduleHandler                = xoops_getHandler('module');
$configHandler                = xoops_getHandler('config');
$GLOBALS['xrestModule']       = $moduleHandler->getByDirname('xrest');
$GLOBALS['xrestModuleConfig'] = $configHandler->getConfigList($GLOBALS['xrestModule']->getVar('mid'));

xoops_load('pagenav');
xoops_load('xoopslists');
xoops_load('xoopsformloader');

require_once $GLOBALS['xoops']->path('class' . DS . 'xoopsmailer.php');
require_once $GLOBALS['xoops']->path('class' . DS . 'xoopstree.php');

if (file_exists($GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php'))) {
    require_once $GLOBALS['xoops']->path('/Frameworks/moduleclasses/moduleadmin/moduleadmin.php');
    //return true;
} else {
    echo xoops_error("Error: You don't use the Frameworks \"admin module\". Please install this Frameworks");
    //return false;
}
$GLOBALS['xrestImageIcon']  = XOOPS_URL . '/' . $GLOBALS['xrestModule']->getInfo('icons16');
$GLOBALS['xrestImageAdmin'] = XOOPS_URL . '/' . $GLOBALS['xrestModule']->getInfo('icons32');

if ($GLOBALS['xoopsUser']) {
    $modulepermHandler = xoops_getHandler('groupperm');
    if (!$modulepermHandler->checkRight('module_admin', $GLOBALS['xrestModule']->getVar('mid'), $GLOBALS['xoopsUser']->getGroups())) {
        redirect_header(XOOPS_URL, 1, _NOPERM);
        exit();
    }
} else {
    redirect_header(XOOPS_URL . '/user.php', 1, _NOPERM);
    exit();
}

if (!isset($GLOBALS['xoopsTpl']) || !is_object($GLOBALS['xoopsTpl'])) {
    require_once XOOPS_ROOT_PATH . '/class/template.php';
    $GLOBALS['xoopsTpl'] = new XoopsTpl();
}

$GLOBALS['xoopsTpl']->assign('pathImageIcon', $GLOBALS['xrestImageIcon']);

require_once $GLOBALS['xoops']->path('/modules/xrest/include/common.php');
require_once $GLOBALS['xoops']->path('/modules/xrest/include/functions.php');
require_once $GLOBALS['xoops']->path('/modules/xrest/include/forms.xrest.php');

xoops_load('pagenav');
xoops_load('xoopsmultimailer');

