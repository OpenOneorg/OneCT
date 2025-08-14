<?php
    require_once '../include/config.php';
    include '../include/web/user.php';
    require '../vendor/autoload.php';

    include "../api/user.php";
    include "../api/comments.php";
    include "../api/wall.php";

    ini_set("display_errors", "false");

    $text = '';
    $user = new user();
    $wall = new comments();
    $wall_1 = new wall();

    $data_group = array(
        'owner_id' => 0,
        'admin' => [0]
    );

    class Post {
        // Заглушка
        public function isbuttons() {
            return false;
        }

        public function isdelete($i) {
            global $user_idss;

            if($user_idss[$i]['id'] == $_SESSION['user']['user_id'] or $_SESSION['user']['priv'] >= 2){
                return true;
            } else {
                return false;
            }
        }
    }

    // Выкладывание поста

    if(isset($_POST['do_post'])){
        $result = $wall->add($_SESSION['user']['token'], $_POST['text'], $_GET['id']);
        if(isset($result['error'])){
            $text = $result['error'];
        }
    }

    // Лайк

    if(isset($_GET['like'])){
        $result = $wall_1->like($_SESSION['user']['token'], $_GET['like']);
        if(isset($result['error'])){
            $text = $result['error'];
        }
        header("Location: comments.php?id=". (int)$_GET['id']);
        exit();
    }

    // Удаление поста

    if(isset($_GET['del'])){
        $result = $wall->delete($_SESSION['user']['token'], $_GET['del']);
        if(isset($result['error'])){
            $text = $result['error'];
        }
        header("Location: comments.php?id={$_GET['id']}");
        exit();
    }
    
    $data_wall = $wall->get($_SESSION['user']['token'], $_GET['id'], $_GET['p']);
    $data = $data_wall['post'];

    // Проверка на существование комментах

    if($data_wall['post']['id_from'] == 0){
        header("Location: index.php");
    } else {
        // Узнавание о пользователях из комментов
        
        $user_idss = '';
        $i = 0;

        foreach($data_wall['comments'] as $data_comment){
            $user_idss = $user_idss . (string)$data_comment['user_id'] . ',';
            $i++;
        }

        $user_idss = $user->getuser($user_idss);
        $user_post = $user->getuser($data_wall['post']['user_id']. ',' .$data_wall['post']['id_from']);
        $user_ids[0] = $user_post[0];
        $from_ids[0] = $user_post[1];
    }

    $post = new Post();

    use Smarty\Smarty;
    $smarty = new Smarty();

    if($_SESSION['theme_type'] == 1){
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$_SESSION['theme']. '/comments');
    } elseif($_SESSION['theme_type'] == 2) {
        $smarty->setTemplateDir(__DIR__ . '/../themes/' .$style. '/comments');
    }
    $smarty->assign('post', $post);
    $smarty->assign('text', $text);
    $smarty->assign('data', $data);
    $smarty->assign('from_ids', $from_ids);
    $smarty->assign('user_ids', $user_ids);
    $smarty->assign('user_idss', $user_idss);
    $smarty->assign('data_wall', $data_wall);
    include '../include/web/template.php';
    $smarty->display('comments.tpl');