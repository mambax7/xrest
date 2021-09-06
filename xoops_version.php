<?php
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 xoops.org                           //
//                       <https://www.xoops.org>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //

require __DIR__ . '/preloads/autoloader.php';

$moduleDirName      = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);

$modversion = [
    'version'             => 2.00,
    'module_status'       => 'Alpha 1',
    'release_date'        => '2021/09/04',
    'name'                => _MI_XREST_NAME,
    'description'         => _MI_XREST_DESC,
    'official'            => 0,
    //1 indicates official XOOPS module supported by XOOPS Dev Team, 0 means 3rd party supported
    'author'              => 'Chronolabs Cooperative',
    'credits'             => 'Simon Roberts, Mamba, XOOPS Development Team',
    'author_mail'         => 'author-email',
    'author_website_url'  => 'https://xoops.org, www.chronolabs.com.au',
    'author_website_name' => 'XOOPS',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html/',
    //    'help'                => 'page=help',
    // ------------------- Folders & Files -------------------
    'release_info'        => 'Changelog',
    'release_file'        => XOOPS_URL . "/modules/$moduleDirName/docs/changelog.txt",

    'manual'              => 'link to manual file',
    'manual_file'         => XOOPS_URL . "/modules/$moduleDirName/docs/install.txt",
    // images
    'image'               => 'assets/images/logoModule.png',
    'iconsmall'           => 'assets/images/iconsmall.png',
    'iconbig'             => 'assets/images/iconbig.png',
    'dirname'             => $moduleDirName,
    // Local path icons
    'modicons16'          => 'assets/images/icons/16',
    'modicons32'          => 'assets/images/icons/32',
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb/viewforum.php?forum=28/',
    'support_name'        => 'Support Forum',
    'submit_bug'          => 'https://github.com/XoopsModules25x/' . $moduleDirName . '/issues',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    // ------------------- Min Requirements -------------------
    'min_php'             => '7.2',
    'min_xoops'           => '2.5.10',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.5'],
    // ------------------- Admin Menu -------------------
    'system_menu'         => 1,
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // ------------------- Main Menu -------------------
    'hasMain'             => 1,
    // ------------------- Install/Update -------------------
    'onInstall'           => 'include/oninstall.php',
    'onUpdate'            => 'include/onupdate.php',
    //  'onUninstall'         => 'include/onuninstall.php',
    // -------------------  PayPal ---------------------------
    'paypal'              => [
        'business'      => 'xoopsfoundation@gmail.com',
        'item_name'     => 'Donation : ' . _MI_XREST_NAME,
        'amount'        => 0,
        'currency_code' => 'USD',
    ],
    // ------------------- Mysql -----------------------------
    'sqlfile'             => ['mysql' => 'sql/mysql.sql'],
    // ------------------- Tables ----------------------------
    'tables'              => [
        $moduleDirName . '_' . 'tables',
        $moduleDirName . '_' . 'fields',
        $moduleDirName . '_' . 'plugins',
    ],
];

// Smarty
$modversion['use_smarty'] = 0;

// ------------------- Help files ------------------- //
$modversion['help']        = 'page=help';
$modversion['helpsection'] = [
    ['name' => _MI_XREST_OVERVIEW, 'link' => 'page=help'],
    ['name' => _MI_XREST_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => _MI_XREST_LICENSE, 'link' => 'page=license'],
    ['name' => _MI_XREST_SUPPORT, 'link' => 'page=support'],
];

// Templates

$modversion['templates'] = [
    ['file' => 'complex_wsdl.xml', 'description' => 'SOAP 1.1 Request/Response via HTTP [WSDL Complex Sub-Template]'],
    ['file' => 'element_wsdl.xml', 'description' => 'SOAP 1.1 Request/Response via HTTP [WSDL Elemental Complex Sub-Template]'],
    ['file' => 'plugin_services.xml', 'description' => 'SOAP 1.1 Request/Response via HTTP - Alternative authoring style for the service [Services]'],
    ['file' => 'plugin_wsdl.xml', 'description' => 'SOAP 1.1 Request/Response via HTTP - Alternative authoring style for the service [WSDL]'],
    ['file' => 'plugin_xsd.xml', 'description' => 'SOAP 1.1 Request/Response via HTTP - Alternative authoring style for the service [XSD]'],
    ['file' => 'wsdl.xml', 'description' => 'SOAP 1.1 Request/Response via HTTP'],
];



$modversion['config'][] = [
    'name'        => 'site_user_auth',
    'title'       => '_XREST_MI_USERAUTH',
    'description' => '_XREST_MI_USERAUTHDESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];

$modversion['config'][] = [
    'name'        => 'wsdl',
    'title'       => '_XREST_MI_WSDL',
    'description' => '_XREST_MI_WSDL_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];

$modversion['config'][] = [
    'name'        => 'run_cleanup',
    'title'       => '_XREST_MI_SECONDS_TO_CLEANUP',
    'description' => '_XREST_MI_SECONDS_TO_CLEANUP_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 86400,
    'options'     => [
        _XREST_MI_SECONDS_2419200 => 2419200,
        _XREST_MI_SECONDS_604800  => 604800,
        _XREST_MI_SECONDS_86400   => 86400,
        _XREST_MI_SECONDS_43200   => 43200,
        _XREST_MI_SECONDS_3600    => 3600,
        _XREST_MI_SECONDS_1800    => 1800,
        _XREST_MI_SECONDS_1200    => 1200,
        _XREST_MI_SECONDS_600     => 600,
        _XREST_MI_SECONDS_300     => 300,
        _XREST_MI_SECONDS_180     => 180,
        _XREST_MI_SECONDS_60      => 60,
        _XREST_MI_SECONDS_30      => 30,
    ],
];

$modversion['config'][] = [
    'name'        => 'plugin_list_cache',
    'title'       => '_XREST_MI_SECONDS_LIST_CACHE',
    'description' => '_XREST_MI_SECONDS_LIST_CACHE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 3600,
    'options'     => [
        _XREST_MI_SECONDS_2419200 => 2419200,
        _XREST_MI_SECONDS_604800  => 604800,
        _XREST_MI_SECONDS_86400   => 86400,
        _XREST_MI_SECONDS_43200   => 43200,
        _XREST_MI_SECONDS_3600    => 3600,
        _XREST_MI_SECONDS_1800    => 1800,
        _XREST_MI_SECONDS_1200    => 1200,
        _XREST_MI_SECONDS_600     => 600,
        _XREST_MI_SECONDS_300     => 300,
        _XREST_MI_SECONDS_180     => 180,
        _XREST_MI_SECONDS_60      => 60,
        _XREST_MI_SECONDS_30      => 30,
    ],
];

$modversion['config'][] = [
    'name'        => 'lock_seconds',
    'title'       => '_XREST_MI_SECONDS',
    'description' => '_XREST_MI_SECONDS_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 180,
    'options'     => [
        _XREST_MI_SECONDS_3600 => 3600,
        _XREST_MI_SECONDS_1800 => 1800,
        _XREST_MI_SECONDS_1200 => 1200,
        _XREST_MI_SECONDS_600  => 600,
        _XREST_MI_SECONDS_300  => 300,
        _XREST_MI_SECONDS_180  => 180,
        _XREST_MI_SECONDS_60   => 60,
        _XREST_MI_SECONDS_30   => 30,
    ],
];

// mt_srand((((float)('0' . substr(microtime(), strpos(microtime(), ' ') + 1, strlen(microtime()) - strpos(microtime(), ' ') + 1))) * random_int(30, 99999)));
// mt_srand((((float)('0' . substr(microtime(), strpos(microtime(), ' ') + 1, strlen(microtime()) - strpos(microtime(), ' ') + 1))) * random_int(30, 99999)));

$modversion['config'][] = [
    'name'        => 'lock_random_seed',
    'title'       => '_XREST_MI_USERANDOMLOCK',
    'description' => '_XREST_MI_USERANDOMLOCK_DESC',
    'formtype'    => 'text',
    'valuetype'   => 'int',
    'default'     => random_int(30, 170),
];

$modversion['config'][] = [
    'name'        => 'cache_seconds',
    'title'       => '_XREST_MI_SECONDSCACHE',
    'description' => '_XREST_MI_SECONDSCACHE_DESC',
    'formtype'    => 'select',
    'valuetype'   => 'int',
    'default'     => 3600,
    'options'     => [
        _XREST_MI_SECONDS_3600 => 3600,
        _XREST_MI_SECONDS_1800 => 1800,
        _XREST_MI_SECONDS_1200 => 1200,
        _XREST_MI_SECONDS_600  => 600,
        _XREST_MI_SECONDS_300  => 300,
        _XREST_MI_SECONDS_180  => 180,
        _XREST_MI_SECONDS_60   => 60,
        _XREST_MI_SECONDS_30   => 30,
    ],
];

/**
 * Show Developer Tools?
 */
$modversion['config'][] = [
    'name'        => 'displayDeveloperTools',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
