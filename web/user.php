<?php
    require_once '../include/config.php';
    include '../include/web/user.php';
    require '../vendor/autoload.php';

    include "../api/user.php";
    include "../api/wall.php";

    $text = '';
    $user = new user();
    $wall = new wall();

    $data_group = array(
        'owner_id' => 0,
        'admin' => [0]
    );

    switch($_GET['page']){
        case NULL:
            if((int)$_GET['id'] < 0){
                header("Location: group.php?id=" .((int)$_GET['id'] * -1));
                exit();
            }

            $_GET['p'] = (int)$_GET['p'];

            

            // Выкладывание поста

            if(isset($_POST['do_post'])){
                $result = $wall->add($_SESSION['user']['token'], $_POST['text'], $_GET['id'], 0);
                if(isset($result['error'])){
                    $text = $result['error'];
                    if(isset($result['left'])){
                        $text = $text . $lang['left1'] . $result['left'] . $lang['left2'];
                    }
                }
            }

            // Лайк

            if(isset($_GET['like'])){
                $result = $wall->like($_SESSION['user']['token'], $_GET['like']);
                if(isset($result['error'])){
                    $text = $result['error'];
                }
                header("Location: user.php?id={$_GET['id']}&p={$_GET['p']}#post{$_GET['like']}");
                exit();
            }

            // Закреп

            if(isset($_GET['pin'])){
                $result = $wall->pin($_SESSION['user']['token'], $_GET['pin']);
                if(isset($result['error'])){
                    $text = $result['error'];
                }
                header("Location: user.php?id={$_GET['id']}&p={$_GET['p']}");
                exit();
            }

            // Удаление поста

            if(isset($_GET['del'])){
                $result = $wall->delete($_SESSION['user']['token'], $_GET['del']);
                if(isset($result['error'])){
                    $text = $result['error'];
                }
                header("Location: user.php?id={$_GET['id']}&p={$_GET['p']}");
                exit();
            }

            // А твой ли профиль?

            if($_GET['id'] == $_SESSION['user']['user_id']){
                $data_user[0] = $user->profile($_SESSION['user']['token']);
                $_SESSION['user']['priv'] = $data_user[0]['privilege'];
            } else{
                $data_user = $user->getuser($_GET['id']);
            }

            // Проверка на существование профиля

            if($data_user[0]['username'] == $lang['api']['not_found'] or isset($data_user['error'])){
                header("Location: user.php?id=" .$_SESSION['user']['user_id']);
            } else {
                // Узнавание о пользователях со стены

                $data_wall = $wall->getbyuser($_SESSION['user']['token'], $_GET['id'], (int)$_GET['p']);
                
                $user_ids = '';
                $from_ids = '';
                $i = 0;

                foreach($data_wall as $data){
                    $user_ids = $user_ids . (string)$data['user_id'] . ',';
                    $from_ids = $from_ids . (string)$data['id_from'] . ',';
                    $i++;
                }

                $user_ids = $user->getuser($user_ids);
                $from_ids = $user->getuser($from_ids);
            }

            class Post {
                public function isbuttons($i) {
                    global $from_ids, $user_ids;

                    if($_GET['id'] == $_SESSION['user']['user_id'] or $user_ids[$i]['id'] == $_SESSION['user']['user_id'] or $from_ids[$i]['id'] == $_SESSION['user']['user_id'] or $_SESSION['user']['priv'] >= 2){
                        return true;
                    } else {
                        return false;
                    }
                }

                public function openwall() {
                    global $data_user;

                    if($_GET['id'] == $_SESSION['user']['user_id'] or $data_user[0]['openwall'] == true) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }

            $post = new Post();

            break;
        case 'avatar':
            if(isset($_POST['do_change'])){
                $result = $user->avatar($_SESSION['user']['token']);
                header("Location: index.php");
            }

            break;
    }

    $site_header = array(
        $lang['change_avatar'] => '?page=avatar'
    );

    use Smarty\Smarty;
    $smarty = new Smarty();

    if($_SESSION['theme_type'] == 1){
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$_SESSION['theme']. '/users');
    } elseif($_SESSION['theme_type'] == 2) {
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$style. '/users');
    }
    
    $smarty->assign('data_user', $data_user);
    $smarty->assign('post', $post);
    $smarty->assign('text', $text);
    $smarty->assign('data_wall', $data_wall);
    $smarty->assign('from_ids', $from_ids);
    $smarty->assign('user_ids', $user_ids);
    include '../include/web/template.php';

    switch($_GET['page']){
        case NULL:
            $smarty->display('user.tpl');
            break;
        case 'avatar':
            $smarty->display('avatar.tpl');
            break;
    }