<?php
    require_once '../include/config.php';
    include '../include/web/user.php';
    require '../vendor/autoload.php';

    use Smarty\Smarty;
    $smarty = new Smarty();

    if($_SESSION['theme_type'] == 1){
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$_SESSION['theme']. '/messenger');
    } elseif($_SESSION['theme_type'] == 2) {
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$style. '/messenger');
    }

    include '../include/web/template.php';

    $smarty->display('chats.tpl');