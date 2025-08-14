<?php 
    ini_set('display_errors', false); // Скрываем рукожопость автора

    require_once "../include/config.php";

    // Извини, мне заебало вставлять комментариии, поэтому без них

    class comments{
        function get($token, $id, $page){
            global $db, $url, $lang;
            $response = array();
            
            function makeLinks($text) {
                $pattern = '~((https?://)?([a-z0-9-]+\.)+[a-z]{2,}(/\S*)?)~i';
                
                $replacedText = preg_replace_callback($pattern, function($matches) {
                    $url = $matches[0];
                    if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
                        $url = 'http://' . $url;
                    }
                    return '<a href="' . $url . '" target="_blank" rel="noopener noreferrer">' . $matches[0] . '</a>';
                }, $text);
                
                return $replacedText;
            }

            $get_user_token = $db->query("SELECT * FROM users WHERE token = " .$db->quote($token));

            if(!empty(trim($token)) or $token != null){
                if($get_user_token->rowCount() == 0){
                    http_response_code(403);
                    $response = array(
                        'error' => $lang['api']['bad_token']
                    );
                } else {
                    $wall = $db->query("SELECT * FROM post WHERE id = " .(int)$id)->fetch(PDO::FETCH_ASSOC);
                    $likes_count = $db->query("SELECT * FROM likes WHERE post_id = " .(int)$id)->rowCount();
                    $youtlike = $db->query("SELECT * FROM likes WHERE post_id = " .(int)$id. " AND user_id = " .$get_user_token->fetch(PDO::FETCH_ASSOC)['id']);

                    $response['post'] = [
                        'id' => (int)$wall['id'],
                        'id_from' => (int)$wall['id_user'],
                        'user_id' => (int)$wall['id_who'],
                        'text' => htmlspecialchars($wall['post']),
                        'text_html' => makeLinks(nl2br(htmlspecialchars($wall['post']))),
                        'date' => (int)$wall['date'],
                        'liked' => boolval($youtlike->rowCount()),
                        'likes' => (int)$likes_count,
                    ];

                    if($wall['img'] != null){
                        $response['post']['image'] = $url . substr($wall['img'], 2);
                    }

                    $query = $db->query("SELECT * FROM comments WHERE post_id = " .(int)$id. " ORDER BY date ASC LIMIT 10 OFFSET " .(int)$page * 10);

                    $i = 0;
                    while($list = $query->fetch(PDO::FETCH_ASSOC)){
                        $response['comments'][$i] = [
                            'id' => (int)$list['id'],
                            'post_id' => (int)$list['post_id'],
                            'user_id' => (int)$list['user_id'],
                            'text' => htmlspecialchars($list['text']),
                            'text_html' => makeLinks(nl2br(htmlspecialchars($list['text']))),
                            'date' => (int)$list['date']
                        ];
    ;

                        $i++;
                    }

                    return $response;
                }
            } else{
                http_response_code(403);
                $response = array(
                    'error' => $lang['api']['bad_token']
                );
            }

            return $response;
        }

        function delete($token, $id){
            global $db, $lang;
            $response = array();
            
            $get_user_token = $db->query("SELECT * FROM users WHERE token = " .$db->quote($token));
            $user_data = $get_user_token->fetch(PDO::FETCH_ASSOC);

            if(!empty(trim($token)) or $token != null){
                if($get_user_token->rowCount() == 0){
                    http_response_code(403);
                    $response = array(
                        'error' => $lang['api']['bad_token']
                    );
                } else {
                    if($user_data['ban'] == 1){
                        $db->query("UPDATE users SET token='' WHERE token=" .$db->quote($token));
                        header("Refresh: 0");
                    }
                    
                    $post = $db->query("SELECT * FROM comments WHERE id = " .(int)$id)->fetch(PDO::FETCH_ASSOC);

                    if($post['user_id'] == $user_data['id'] or $user_data['priv'] >= 2){
                        $db->query("DELETE FROM comments WHERE id = " .(int)$id);
                        $response = array(1);
                    } else {
                        http_response_code(403);
                        $response = array(0);
                    }
                }         
            } else{
                http_response_code(403);
                $response = array(
                    'error' => $lang['api']['bad_token']
                );
            }

            return $response;
        }

        // Ладно, тут будут комментарии
        function add($token, $text, $id){
            global $db, $antispam, $lang;
            $response = array();
            
            $get_user_token = $db->query("SELECT * FROM users WHERE token = " .$db->quote($token));
            $user_data = $get_user_token->fetch(PDO::FETCH_ASSOC);

            if(!empty(trim($token)) or $token != null){
                if($get_user_token->rowCount() == 0){
                    http_response_code(403);
                    $response = array(
                        'error' => $lang['api']['bad_token']
                    );
                } else {
                    $error = 0;

                    // Где текст?           
                    if(empty(trim($text))){
                        $error = 1;
                        http_response_code(400);
                        $response = array('error' => $lang['api']['no_text']);
                    }

                    // Да над каким постом ты будешь делать комментарий?
                    if((int)$id <= 0){
                        $error = 1;
                        http_response_code(400);
                        $response = array('error' => $lang['api']['no_post_id']);
                    }

                    // Система поиска спамеров активирована
                    if(true){
                        $recent = $db->query("SELECT * FROM comments WHERE user_id =  " .(int)$user_data['id']. " ORDER BY date DESC")->fetch(PDO::FETCH_ASSOC);
                        $date = time() - $recent['date'];
            
                        if($date <= $antispam){
                            $error = 1;
                            http_response_code(400);
                            $response = array('error' => $lang['api']['antispam'], 'left' => $antispam - $date);
                        }
                    }

                    // Пропускаю
                    if($error == 0){
                        $query = "INSERT INTO comments(post_id, user_id, text, date) VALUES (
                            " .(int)$id. ", 
                            " .(int)$user_data['id']. ", 
                            " .$db->quote($text). ", 
                            " .time(). ")";

                        if($db->query($query)){
                            $response = array(1);
                        }else{
                            http_response_code(500);
                            $response = array(0);
                        }
                    }
                }
            } else{
                http_response_code(403);
                $response = array(
                    'error' => $lang['api']['bad_token']
                );
            }

            return $response;
        }

    }

    if(isset($_REQUEST['method'])){
        header('Content-Type: application/json');

        $comments = new comments();

        switch($_REQUEST['method']){
            case 'get':
                echo json_encode($comments->get($_REQUEST['token'], $_REQUEST['id'], $_REQUEST['page']));
                break;
            case 'delete':
                echo json_encode($comments->delete($_REQUEST['token'], $_REQUEST['id']));
                break;
            case 'add':
                echo json_encode($comments->add($_REQUEST['token'], $_REQUEST['text'], $_REQUEST['id']));
                break;
            default:
                http_response_code(400);
                echo json_encode(array('error' => $lang['api']['invalid_method']));
                break;
        }

        $db = null;
    }

    