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

    $_GET['p'] = (int)$_GET['p'];

    class Post {
        public function isbuttons($i) {
            global $from_ids, $user_ids;

            if($user_ids[$i]['id'] == $_SESSION['user']['user_id'] or $from_ids[$i]['id'] == $_SESSION['user']['user_id'] or $_SESSION['user']['priv'] >= 2){
                return true;
            } else {
                return false;
            }
        }
    }

    // Выкладывание поста

    if(isset($_POST['do_post'])){
        $result = $wall->add($_SESSION['user']['token'], $_POST['text'], $_SESSION['user']['user_id'], 0);
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
        header("Location: feed.php?p={$_GET['p']}#post{$_GET['like']}");
        exit();
    }

    // Удаление поста

    if(isset($_GET['del'])){
        $result = $wall->delete($_SESSION['user']['token'], $_GET['del']);
        if(isset($result['error'])){
            $text = $result['error'];
        }
        header("Location: feed.php?p={$_GET['p']}");
        exit();
    }


    // Узнавание о пользователях со стены

    $data_wall = $wall->getglobal($_SESSION['user']['token'], (int)$_GET['p']);
    
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

    $post = new Post();

    use Smarty\Smarty;
    $smarty = new Smarty();

    if($_SESSION['theme_type'] == 1){
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$_SESSION['theme']. '/feed');
    } elseif($_SESSION['theme_type'] == 2) {
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$style. '/feed');
    }
    $smarty->assign('post', $post);
    $smarty->assign('text', $text);
    $smarty->assign('data_wall', $data_wall);
    $smarty->assign('from_ids', $from_ids);
    $smarty->assign('user_ids', $user_ids);
    include '../include/web/template.php';

    $smarty->display('feed.tpl');