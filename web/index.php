<?php 
require '../vendor/autoload.php';
    require_once '../include/config.php';
    
    ini_set('display_errors', false);

    if($_GET['page'] == NULL){
        if(isset($_SESSION['user']['token'])){
            header("Location: user.php");
        }
    }

    use Smarty\Smarty;
    $smarty = new Smarty();

    if($_SESSION['theme_type'] == 1){
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$_SESSION['theme']. '/index');
    } elseif($_SESSION['theme_type'] == 2) {
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$style. '/index');
    }
    include '../include/web/template.php';

    switch($_GET['page']){
        case NULL:
            $smarty->display('index.tpl');
            break;
        case 'terms':
            $smarty->display('terms.tpl');
            break;
        case 'authors':
            $data = $db->query("SELECT id, name, img100 FROM users WHERE priv > 1");
            $smarty->assign("data", $data);
            $smarty->display('authors.tpl');
            break;
    };