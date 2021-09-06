<?php

use Xmf\Module\Admin;
use XoopsModules\Xrest\{
    Helper
};
/** @var Admin $adminObject */
/** @var Helper $helper */


include dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName = \basename(\dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

$helper = Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

$pathIcon32 = Admin::menuIconPath('');
$pathModIcon32 = XOOPS_URL .   '/modules/' . $moduleDirName . '/assets/images/icons/32/';
if (is_object($helper->getModule()) && false !== $helper->getModule()->getInfo('modicons32')) {
    $pathModIcon32 = $helper->url($helper->getModule()->getInfo('modicons32'));
}

$moduleHandler          = xoops_getHandler('module');
$GLOBALS['xrestModule'] = $moduleHandler->getByDirname('xrest');

$adminmenu[] = [
    'title' => _XREST_MI_ADMINMENU_0,
    'link'  => 'admin/index.php?op=dashboard',
    'icon'  => $pathIcon32 . '/home.png',
    'image' => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => _XREST_MI_ADMINMENU_1,
    'link'  => 'admin/index.php?op=tables',
    'icon'  => $pathModIcon32 . '/xrest.tables.png',
    'image' => $pathModIcon32 . '/xrest.tables.png',
];

$adminmenu[] = [
    'title' => _XREST_MI_ADMINMENU_2,
    'link'  => 'admin/index.php?op=fields',
    'icon'  => $pathModIcon32 . '/xrest.fields.png',
    'image' => $pathModIcon32 . '/xrest.fields.png',
];

$adminmenu[] = [
    'title' => _XREST_MI_ADMINMENU_3,
    'link'  => 'admin/index.php?op=views',
    'icon'  => $pathModIcon32 . '/xrest.views.png',
    'image' => $pathModIcon32 . '/xrest.views.png',
];

$adminmenu[] = [
    'title' => _XREST_MI_ADMINMENU_4,
    'link'  => 'admin/index.php?op=plugins',
    'icon'  => $pathModIcon32 . '/xrest.plugins.png',
    'image' => $pathModIcon32 . '/xrest.plugins.png',
];

$adminmenu[] = [
    'title' => _XREST_MI_ADMINMENU_5,
    'link'  => 'admin/permissions.php',
    'icon'  => $pathModIcon32 . '/xrest.permissions.png',
    'image' => $pathModIcon32 . '/xrest.permissions.png',
];

//$adminmenu[] = [
//    'title' => _XREST_MI_ADMINMENU_6,
//    'link'  => 'admin/index.php?op=about',
//    'icon'  => $pathIcon32 . '/about.png',
//    'image' => $pathIcon32 . '/about.png',
//];

if (is_object($helper->getModule()) && $helper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE'),
        'link' => 'admin/migrate.php',
        'icon' => $pathIcon32 . '/database_go.png',
    ];
}

$adminmenu[] = [
    'title' => _MI_XREST_MENU_ABOUT,
    'link' => 'admin/about.php',
    'icon' => $pathIcon32 . '/about.png',
];
