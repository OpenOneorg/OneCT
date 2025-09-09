<?php
    require_once 'db.php';

    session_start();

    $url = 'http://localhost'; // Туда пишем домен вашего сайта
    $sitename = 'OneCt';
    $style = 'std';
    $antispam = 30;
    $mail_activation = false;
    $links = array(
        'Telegram' => 'https://t.me/openone_channel',
        'Github' => 'https://github.com/OpenOneorg/onect',
        'API' => 'https://github.com/OpenOneorg/OneCT/wiki/API'
    );

    // Выполнение конфига

    $db = new PDO("mysql:host=" .$dbconn['server']. ";dbname=" .$dbconn['db'],
        $dbconn['user'],
        $dbconn['pass']
    );

    $db->exec("set names utf8mb4");

    if($db == false){
        die('Ошибка подключение базы данных');
    }

    if(!isset($_SESSION['theme'])){
        $_SESSION['theme'] = $style;
        $_SESSION['theme_type'] = 1;
    }
    
    if(!isset($_SESSION['lang'])){
        if(is_dir('../lang/' . substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))){
            $_SESSION['lang'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        } else {
            $_SESSION['lang'] = 'en';
        }
    }

    // Для API

    include "../lang/en/lang.php";
    if(!include "../lang/{$_SESSION['lang']}/lang.php"){
        include "../lang/en/lang.php";
    }

    if(isset($_SESSION['user']['token'])){
        $side_menu = array(
            $lang['home'] => 'index.php',
            $lang['feed'] => 'feed.php',
            $lang['search'] => 'search.php',
            $lang['settings'] => 'settings.php'
        );

        if($_SESSION['user']['priv'] == 3){
            $side_menu[$lang['admin_panel']] = '../admin';
        }
    } else {
        $side_menu = array(
            $lang['login'] => 'login.php',
            $lang['reg'] => 'reg.php'
        );
    }

    $footer_links = array(
        $lang['terms'] => 'index.php?page=terms',
        $lang['authors'] => 'index.php?page=authors'
    );

    if (file_exists('../include/update.php')) {
        include 'update.php';
    }
?>
