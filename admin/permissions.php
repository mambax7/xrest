<?php

use XoopsModules\Xrest\{
    Helper
};

require_once __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsform/grouppermform.php';

xoops_loadLanguage('forms');
$op = ($_REQUEST['op'] ?? 'default');

xoops_cp_header();
$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation('permissions.php');

switch ($op) {
    case 'default':
    default:
        $moduleHandler          = xoops_getHandler('module');
        $GLOBALS['xrestModule'] = $moduleHandler->getByDirname('xrest');
        // View Categories permissions
        $pluginsHandler = Helper::getInstance()->getHandler('plugins');
        $plugins        = $pluginsHandler->getObjects(null, true);
        if (count($plugins)) {
            $form_view = new \XoopsGroupPermForm(
                _XREST_FRM_VIEW_FUNCTION,
                $GLOBALS['xrestModule']->getVar('mid'),
                'plugin_call',
                "<img id='toptableicon' src="
                . XOOPS_URL
                . '/modules/'
                . $GLOBALS['xrestModule']->dirname()
                . "/images/close12.gif alt=''></a>"
                . _XREST_FRM_PERMISSIONSVIEWMAN
                . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">"
                . _XREST_FRM_VIEW_FUNCTION
                . '</span>',
                'admin/permissions.php'
            );
            foreach ($plugins as $plugin_id => $plugin) {
                $form_view->addItem($plugin_id, $plugin->getVar('plugin_name'));
            }
            echo $form_view->render();
        } else {
            echo "<img id='toptableicon' src="
                 . XOOPS_URL
                 . '/modules/'
                 . $GLOBALS['xrestModule']->dirname()
                 . "/images/close12.gif alt=''></a>&nbsp;"
                 . _XREST_FRM_PERMISSIONSVIEWMAN
                 . "</h3><div id='toptable'><span style=\"color: #567; margin: 3px 0 0 0; font-size: small; display: block; \">"
                 . _XREST_FRM_NOPERMSSET
                 . '</span>';
        }
        echo '</div>';
        echo "<br>\n";
        break;
}
xoops_cp_footer();

?>
