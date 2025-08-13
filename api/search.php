<?php 
    ini_set('display_errors', false); // Скрываем рукожопость автора

    require_once "../include/config.php";

    class search{
        function user($query, $page){
            global $db, $url;
            $response = array();

            $qq = $db->query("SELECT * FROM users WHERE name LIKE " .$db->quote("%" .$query. "%"). " AND ban = '0' ORDER BY id DESC LIMIT 50 OFFSET " .(int)$page * 50);

            $response['count'] = $db->query("SELECT * FROM users WHERE name LIKE " .$db->quote("%" .$query. "%"). " AND ban = '0'")->rowCount();

            $i = 0;
            while($list = $qq->fetch(PDO::FETCH_ASSOC)){
                $response[$i] = [
                    'id' => (int)$list['id'],
                    'username' => htmlspecialchars($list['name']),
                    'privilege' => (int)$list['priv']
                ];

                if(!empty($list['img'])){
                    $response[$i]['img'] = $url . substr($list['img'], 2);
                    $response[$i]['img50'] = $url . substr($list['img50'], 2);
                    $response[$i]['img100'] = $url . substr($list['img100'], 2);
                    $response[$i]['img200'] = $url . substr($list['img200'], 2);
                } else {
                    $response[$i]['img'] = $url . '/themes/std/imgs/blankimg.jpg';
                    $response[$i]['img50'] = $url . '/themes/std/imgs/blankimg.jpg';
                    $response[$i]['img100'] = $url . '/themes/std/imgs/blankimg.jpg';
                    $response[$i]['img200'] = $url . '/themes/std/imgs/blankimg.jpg';
                }

                $i++;
            }

            return $response;
        }
    }

    if(isset($_REQUEST['method'])){
        header('Content-Type: application/json');

        $search = new search();

        switch($_REQUEST['method']){
            case 'user':
                echo json_encode($search->user($_REQUEST['q'], $_REQUEST['p']));
                break;
            default:
                http_response_code(400);
                echo json_encode(array('error' => $lang['api']['invalid_method']));
                break;
        }

        $db = null;
    }

    