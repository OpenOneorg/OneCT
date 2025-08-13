<?php
    
    $smarty->assign('lang', $lang);
    $smarty->assign('sitename', $sitename);
    $smarty->assign('themedir', "../themes/{$_SESSION['theme']}");
    $smarty->assign('site_header', $site_header);
    $smarty->assign('side_menu', $side_menu);
    $smarty->assign('footer_links', $footer_links);
    $smarty->assign('phpver', phpversion());
    $smarty->assign('sqlver', $db->query('SELECT VERSION()')->fetchColumn());
    $smarty->assign('links', $links);
?>