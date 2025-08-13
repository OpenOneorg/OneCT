<?php 
    require_once '../include/config.php';
	require '../vendor/autoload.php';

	ini_set('display_errors', false);

    if(isset($_SESSION['user']['token'])){
        header("Location: user.php");
    }
							
	if(isset($_POST['do_signup'])){
        $checkemail = "SELECT email FROM users WHERE email = " .$db->quote($_POST['email']);
        $checkip = "SELECT ip FROM users WHERE ip = " .$db->quote($_SERVER['REMOTE_ADDR']);
        $createacc = "INSERT INTO users(name, email, pass, ip) VALUES (
            " .$db->quote($_POST['username']). ", 
            " .$db->quote($_POST['email']). ", 
            '" .password_hash($_POST['pass'], PASSWORD_DEFAULT). "', 
            " .$db->quote($_SERVER['REMOTE_ADDR']). ")";

		if(!$mail_activation){
			if($db->query($checkip)->rowCount() != 0){
				$text = $lang['full_ip'];
			}
		}
		
		if(empty(trim($_POST['username']))){
			$text = $lang['no_user'];
		}
						
		if(empty(trim($_POST['email']))){
			$text = $lang['no_email'];
		}
						
		if(empty(trim($_POST['pass']))){
			$text = $lang['no_pass'];
		}	
						
		if($_POST['pass2'] != $_POST['pass'] ){
			$text = $lang['no_2_pass'];
		}

		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
			$text = $lang['invalid_email'];
		}
						
		if($db->query($checkemail)->rowCount() != 0){
			$text = $lang['full_email'];
		}	
		
		if($_SESSION['code'] != $_POST['captcha']){
			$text = $lang['no_captcha'];
		}	

		if(empty(trim($text))){
			if($db->query($createacc)){
				$text = $lang['yes_reg'];
			} else {
				$text = $lang['server_error'];
			}
		}
	}

	use Smarty\Smarty;
    $smarty = new Smarty();

	if($_SESSION['theme_type'] == 1){
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$_SESSION['theme']. '/auth');
    } elseif($_SESSION['theme_type'] == 2) {
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$style. '/auth');
    }
    $smarty->assign('text', $text);
    include '../include/web/template.php';
	$smarty->display('reg.tpl');
?>