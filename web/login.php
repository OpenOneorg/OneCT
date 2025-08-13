<?php 
    require_once '../include/config.php';
    include "../api/account.php";
    require '../vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    if(isset($_SESSION['user']['token'])){
        header("Location: user.php");
    }

    switch($_GET['page']){
        case NULL:
            if(isset($_POST['login'])){
                $login = new account();
                $info = $login->login($_POST['email'], $_POST['pass'], $_POST['code']);

                if(isset($info['error'])){
                    $text = $info['error'];

                    if($info['error'] == $lang_api_acc_not_act){
                        $_SESSION['activation'] = $_POST['email'];
                        header("Location: login.php?page=activation");
                    }
                } elseif(isset($info['token'])){
                    $_SESSION['user'] = $info;
                    header("Location: user.php");
                }
            }
            break;
        case 'activation':
            if(!empty($_SESSION['activation'])){
                $user_info = $db->query("SELECT * FROM users WHERE email = " .$db->quote($_SESSION['activation']))->fetch();
                $act_info = $db->query("SELECT * FROM activation WHERE user_id = " .(int)$user_info['id'])->fetch();

                if($act_info == NULL){
                    $key = bin2hex(random_bytes(16));
                    $query = $db->query("INSERT INTO activation (actkey, user_id) VALUES (" .$db->quote($key). "," .$user_info['id']. ")");
                    $link = $url . '/web/activation.php?key=' . $key;

                    include "../include/mail.php";

                    $mail = new PHPMailer(true);
                    $mail->CharSet = 'UTF-8';

                    $mail->isSMTP();
                    $mail->Host = $mailconn['host'];
                    $mail->SMTPAuth = true;
                    $mail->Username = $mailconn['user'];
                    $mail->Password = $mailconn['pass'];

                    if($mailconn['secure']){
                        $mail->SMTPSecure = $mailconn['smtpsecure'];
                    } else {
                        $mail->SMTPSecure = false;
                        $mail->SMTPAutoTLS = false;
                    }

                    $mail->Port = $mailconn['port'];
                    $mail->setFrom($mailconn['user'], '');
                    $mail->addAddress($_SESSION['activation'], $user_info['name']); 

                    $mail->Subject = $mailconn['subject'];
                    $mail->msgHTML($mailconn['msgText']);
                    if (!$mail->send())
                        die('У тебя сервер говно');
                }
            } else {
                header("Location: index.php");
            }
            break;
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

    switch($_GET['page']){
        case NULL:
            $smarty->display('login.tpl');
            break;
        case 'activation':
            $smarty->display('activation.tpl');
            break;
    }
?>