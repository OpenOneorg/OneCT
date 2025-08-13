<?php 
    include_once "../api/account.php";
    $check = new account();

    if(isset($_SESSION['user']['token'])){
        $user_account = $check->check($_SESSION['user']['token']);

        if($user_account['account_login'] != 1){
            unset($_SESSION['user']);
            header("Location: index.php");
            exit();
        }
    } else {
        header("Location: login.php");
        exit();
    }
?>