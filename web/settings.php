<?php
    require_once '../include/config.php';
    include '../include/web/user.php';
    require_once "../vendor/autoload.php";
        
    use Otp\Otp;
    use Otp\GoogleAuthenticator;
    use ParagonIE\ConstantTime\Encoding;
    use chillerlan\QRCode\QRCode;

    switch($_GET['page']){
        case NULL:
            include "../api/user.php";

            $user = new user();

            function getInfos($directory, $jsonFile, $jsonParametr) {
                $result = [];
            
                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
            
                
                foreach ($iterator as $file) {
                    if ($file->isFile() && $file->getFilename() === $jsonFile) {
                        $filePath = $file->getPathname();
                        $lang = basename($file->getPath());
            
                        $jsonContent = json_decode(file_get_contents($filePath), true);
                        if ($jsonContent !== null) {
                            $result[$lang] = $jsonContent[$jsonParametr];
                        }
                    }
                }
            
                return $result;
            }

            $langs = getInfos('../lang', 'lang.json', 'lang_name');
            $themes = getInfos('../themes', 'theme.json', 'name');
            $them_type = getInfos('../themes', 'theme.json', 'type');

            if(isset($_POST['do_change'])){
                $result = $user->change($_SESSION['user']['token'], $_POST['name'], $_POST['desc'], $_POST['yespost']);
                $_SESSION['lang'] = $_POST['language'];
                $_SESSION['theme'] = $_POST['theme'];
                $_SESSION['theme_type'] = $them_type[$_POST['theme']];

                header("Refresh:0");
            }

            $data = $user->profile($_SESSION['user']['token']);
            break;
        case 'pass':
            $change = "UPDATE users SET pass = '" .password_hash($_POST['pass'], PASSWORD_DEFAULT). "' WHERE id = '" .$_SESSION['user']['user_id']. "'";
            $user = $db->query('SELECT pass FROM users where id = ' .(int)$_SESSION['user']['user_id'])->fetch();

            if(isset($_POST['do_change'])){
                if(!password_verify($_POST['oldpass'], $user['pass'])){
                    $error = $lang['old_pass_no'];
                }

                if($_POST['pass'] != $_POST['pass2']){
                    $error = $lang['2_pass_no'];
                }

                if(empty(trim($_POST['pass']))){
                    $error = $lang['pass_empty'];
                }
                
                if(empty($error)){
                    $db->query($change);
                    header("Location: index.php");
                }
            }
            break;
        case 'otp':
            if($user_account['2fa'] == 0){
                if(isset($_POST['do_2fa'])){
                    $otp = new Otp();
            
                    if($otp->checkTotp(Encoding::base32DecodeUpper($_SESSION['secret']), $_POST['code'])) {
                        $query = "UPDATE users SET secret = '" .$_SESSION['secret']. "' WHERE token = '" .$_SESSION['user']['token']. "'";
                        $db->query($query);
                        header('Location: settings.php');
                    } else{
                        $text = $lang['no_code'];
                    }
                }
            
                $secret = GoogleAuthenticator::generateRandom();
                $_SESSION['secret'] = $secret;
                $qr = GoogleAuthenticator::getKeyUri('totp', $sitename.':' . $user_account['username'], $secret);
                $qrimg = (new QRCode)->render($qr . '&issuer='.$sitename);
            } else {
                if(isset($_POST['do_unbind'])){
                    $change = "UPDATE users SET secret='' WHERE id = '" .$_SESSION['user']['user_id']. "'";
                    $user = $db->query('SELECT pass FROM users where id = ' .(int)$_SESSION['user']['user_id'])->fetch();

                    if(!password_verify($_POST['pass'], $user['pass'])){
                        $error = $lang['pass_no'];
                    }
    
                    if(empty($error)){
                        $db->query($change);
                        header("Location: settings.php");
                    }
                }
            }
            break;
    }

    use Smarty\Smarty;
    $smarty = new Smarty();

    if($_SESSION['theme_type'] == 1){
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$_SESSION['theme']. '/settings');
    } elseif($_SESSION['theme_type'] == 2) {
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$style. '/settings');
    }

    $smarty->assign('data', $data);
    $smarty->assign('langs', $langs);
    $smarty->assign('themes', $themes);
    $smarty->assign('user_account', $user_account);
    include '../include/web/template.php';

    switch($_GET['page']){
        case NULL:
            $smarty->display('settings.tpl');
            break;
        case 'pass':
            $smarty->assign('error', $error);
            $smarty->display('pass.tpl');
            break;
        case 'otp':
            $smarty->assign('secret', $secret);
            $smarty->assign('text', $text);
            $smarty->assign('qrimg', $qrimg);
            $smarty->assign('error', $error);

            if($user_account['2fa'] == 0){
                $smarty->display('otp.tpl');
            } else {
                $smarty->display('dotp.tpl');
            }
            break;
    }