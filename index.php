<?php

require dirname(__DIR__, 2) . '/mainfile.php';
if (empty($_POST) && empty($_GET)) {
    header('Location: ' . XOOPS_URL);
    exit;
} else {
    error_reporting(0);
    require __DIR__ . '/include/server.php';
    exit;
}
?>
