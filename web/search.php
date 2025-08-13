<?php
    require_once '../include/config.php';
    include '../include/web/user.php';
    require '../vendor/autoload.php';

    include "../api/search.php";

    $search = new search();

    $data = $search->user($_GET['q'], $_GET['p']);
    $data_count = $data['count'];
    unset($data['count']);

    use Smarty\Smarty;
    $smarty = new Smarty();

    if($_SESSION['theme_type'] == 1){
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$_SESSION['theme']. '/search');
    } elseif($_SESSION['theme_type'] == 2) {
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$style. '/search');
    }

    $smarty->assign('data_count', $data_count);
    $smarty->assign('data', $data);
    include '../include/web/template.php';

    $smarty->display('search.tpl');