<?php 
    include "../include/config.php";

    $act_info = $db->query("SELECT * FROM activation WHERE actkey = " .$db->quote($_GET['key']))->fetch();

    if($act_info != NULL){
        $user_info = $db->query("SELECT * FROM users WHERE email = " .(int)$act_info['user_id'])->fetch();
        $query = "UPDATE users SET auth = 1 WHERE id = " . (int)$act_info['user_id'];
        $query2 = "DELETE FROM `activation` WHERE user_id = " . (int)$act_info['user_id'];

        $_SESSION['user'] = array(
            'token' => $user_info['token'],
            'user_id' => $user_info['id']
        );
        unset($_SESSION['activation']);

        $db->query($query);
        $db->query($query2);
        header("Location: index.php");
    } else {
        http_response_code(400);
        echo("The link is not valid");
    }