<?php 
    ini_set('display_errors', false); // Скрываем рукожопость автора

    require_once "../include/config.php";

    class wall{
        // Держи свою глобальную ленту, петушок

        function getglobal($token, $page){
            global $db, $url, $lang;
            $response = array();
            
            $get_user_token = $db->query("SELECT * FROM users WHERE token = " .$db->quote($token));
            $user_id = $get_user_token->fetch()['id'];

            if(!empty(trim($token)) or $token != null){
                if($get_user_token->rowCount() == 0){
                    http_response_code(403);
                    $response = array(
                        'error' => $lang['api']['bad_token']
                    );
                } else {
                    if((int)$page < 0) $page = 0;
                    $wall = $db->query("SELECT * FROM post ORDER BY date DESC LIMIT 10 OFFSET " .(int)$page * 10);
                    
                    $i = 0;
                    while($list = $wall->fetch(PDO::FETCH_ASSOC)){
                        $likes_count = $db->query("SELECT * FROM likes WHERE post_id = " .(int)$list['id'])->rowCount();
                        $comments_count = $db->query("SELECT * FROM comments WHERE post_id = " .(int)$list['id'])->rowCount();
                        $youtlike = $db->query("SELECT * FROM likes WHERE post_id = " .$list['id']. " AND user_id = " .$user_id);

                        $response[$i] = [
                            'id' => (int)$list['id'],
                            'id_from' => (int)$list['id_user'],
                            'user_id' => (int)$list['id_who'],
                            'text' => htmlspecialchars($list['post']),
                            'text_html' => nl2br(htmlspecialchars($list['post'])),
                            'date' => (int)$list['date'],
                            'likes' => (int)$likes_count,
                            'liked' => boolval($youtlike->rowCount()),
                            'comments' => (int)$comments_count
                        ];

                        if($list['img'] != null){
                            $response[$i]['image'] = $url . substr($list['img'], 2);
                        }
                        $i++;
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
        
        function getbyuser($token, $id, $page){
            global $db, $url, $lang;
            $response = array();
            
            $get_user_token = $db->query("SELECT * FROM users WHERE token = " .$db->quote($token));
            $user_id = $get_user_token->fetch()['id'];

            if(!empty(trim($token)) or $token != null){
                if($get_user_token->rowCount() == 0){
                    http_response_code(403);
                    $response = array(
                        'error' => $lang['api']['bad_token']
                    );
                } else {
                    if((int)$page < 0) $page = 0;
                    $wall = $db->query("SELECT * FROM post WHERE id_user = " .(int)$id. " ORDER BY pin DESC, date DESC LIMIT 10 OFFSET " .(int)$page * 10);
                    
                    $i = 0;
                    while($list = $wall->fetch(PDO::FETCH_ASSOC)){
                        $likes_count = $db->query("SELECT * FROM likes WHERE post_id = " .(int)$list['id'])->rowCount();
                        $comments_count = $db->query("SELECT * FROM comments WHERE post_id = " .(int)$list['id'])->rowCount();
                        $youtlike = $db->query("SELECT * FROM likes WHERE post_id = " .$list['id']. " AND user_id = " .$user_id);

                        $response[$i] = [
                            'id' => (int)$list['id'],
                            'id_from' => (int)$list['id_user'],
                            'user_id' => (int)$list['id_who'],
                            'text' => htmlspecialchars($list['post']),
                            'text_html' => nl2br(htmlspecialchars($list['post'])),
                            'date' => (int)$list['date'],
                            'is_pin' => boolval($list['pin']),
                            'likes' => (int)$likes_count,
                            'liked' => boolval($youtlike->rowCount()),
                            'comments' => (int)$comments_count
                        ];

                        if($list['img'] != null){
                            $response[$i]['image'] = $url . substr($list['img'], 2);
                        }
                        $i++;
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

        function delete($token, $id){
            global $db, $lang;
            $response = array();
            
            $get_user_token = $db->query("SELECT * FROM users WHERE token = " .$db->quote($token));
            $user_data = $get_user_token->fetch();

            if(!empty(trim($token)) or $token != null){
                if($get_user_token->rowCount() == 0){
                    http_response_code(403);
                    $response = array(
                        'error' => $lang['api']['bad_token']
                    );
                } else {
                    $error = 0;

                    $post = $db->query("SELECT * FROM post WHERE id = " .(int)$id)->fetch();

                    if((int)$post['id_user'] >= 0){
                        if($post['id_user'] != $user_data['id'] and $post['id_who'] != $user_data['id']){
                            if($user_data['priv'] <= 1){
                                $error = 1;
                                $response = array('error' => $lang['api']['wall_access_denied']);
                            }                            
                        }
                    } else {
                        $group = $db->query("SELECT * FROM groups WHERE id = '" .((int)$post['id_user'] * -1). "'")->fetch(PDO::FETCH_ASSOC);

                        if((int)$group['owner_id'] != (int)$user_data['id']){
                            if($group['admins'] != NULL){
                                $group_admins = json_decode($group['admins'], true);

                                if(!in_array((int)$user_data['id'], $group_admins)){
                                    if($user_data['priv'] <= 1){
                                        http_response_code(400);
                                        $error = 1;
                                        $response = array('error' => $lang['api']['wall_access_denied']);
                                    }
                                }
                            } else {
                                http_response_code(400);
                                $error = 1;
                                $response = array('error' => $lang['api']['wall_access_denied']);
                            }
                        }
                    }
                    
                    if($error == 0){
                        $db->query("DELETE FROM post WHERE id = " .(int)$id);
                        $db->query("DELETE FROM likes WHERE post_id = " .(int)$id);
                        $db->query("DELETE FROM comments WHERE post_id = " .(int)$id);
                        unlink($post['img']);
                        $response = array(1);
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

        function like($token, $id){
            global $db, $lang;
            $response = array();
            
            $get_user_token = $db->query("SELECT * FROM users WHERE token = " .$db->quote($token));
            $user_data = $get_user_token->fetch();

            if(!empty(trim($token)) or $token != null){
                if($get_user_token->rowCount() == 0){
                    http_response_code(403);
                    $response = array(
                        'error' => $lang['api']['bad_token']
                    );
                } else  {
                    $like_data = $db->query("SELECT * FROM likes WHERE post_id = " .(int)$id. " AND user_id = " .$user_data['id'])->fetch();
                    $post_id = $db->query("SELECT * FROM post WHERE id = '" .(int)$id. "'")->fetch();

                    if(!empty($post_id)){
                        if(!empty($like_data)){
                            // Убираем лайк
                            $db->query("DELETE FROM likes WHERE post_id = " .(int)$id. " AND user_id = " .$user_data['id']);
                            $response = array(0);
                        } elseif(empty($like_data)){
                            // Добавляем лайк
                            $db->query("INSERT INTO likes (post_id, user_id) VALUES (" .(int)$id. ", " .$user_data['id']. ")");
                            $response = array(1);
                        }
                    } else {
                        http_response_code(403);
                        $response = array(
                            'error' => $lang['api']['no_post_id']
                        );
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

        function pin($token, $id){
            global $db, $lang;
            $response = array();
            
            $get_user_token = $db->query("SELECT * FROM users WHERE token = " .$db->quote($token));
            $user_data = $get_user_token->fetch();

            if(!empty(trim($token)) or $token != null){
                if($get_user_token->rowCount() == 0){
                    http_response_code(403);
                    $response = array(
                        'error' => $lang['api']['bad_token']
                    );
                } else{
                    $post = $db->query("SELECT * FROM post WHERE id = " .(int)$id)->fetch();
                    $error = 0;

                    if((int)$post['id_user'] >= 0){
                        if($post['id_user'] != $user_data['id']){
                            http_response_code(403);
                            $error = 1;
                            $response = array('error' => $lang['api']['wall_access_denied']);
                        }
                    } else {
                        $group = $db->query("SELECT * FROM groups WHERE id = '" .((int)$post['id_user'] * -1). "'")->fetch(PDO::FETCH_ASSOC);

                        if((int)$group['owner_id'] != (int)$user_data['id']){
                            if($group['admins'] != NULL){
                                $group_admins = json_decode($group['admins'], true);

                                if(!in_array((int)$user_data['id'], $group_admins)){
                                    http_response_code(400);
                                    $error = 1;
                                    $response = array('error' => $lang['api']['wall_access_denied']);
                                }
                            } else {
                                http_response_code(400);
                                $error = 1;
                                $response = array('error' => $lang['api']['wall_access_denied']);
                            }
                        }
                    } 

                    if($error == 0){
                        if($post['pin'] == 1){
                            // Открепить пост
                            $db->query("UPDATE post SET pin = 0 WHERE id = " .(int)$id);
                            $response = array(0);
                        } elseif($post['pin'] == 0){
                            // Закрепить пост
                            $db->query("UPDATE post SET pin = 1 WHERE id = " .(int)$id);
                            $response = array(1);
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

        // Я эту функцию ненавижу
        function add($token, $text, $id, $anonim){
            global $db, $antispam, $lang;
            $response = array();
            
            $get_user_token = $db->query("SELECT * FROM users WHERE token = " .$db->quote($token));
            $user_data = $get_user_token->fetch();

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

                    $error = 0;
                    $predlozhka = 1;

                    if(empty(trim($text)) and empty($_FILES['file']['tmp_name'])){
                        $error = 1;
                        http_response_code(400);
                        $response = array('error' => $lang['api']['no_text_or_image']);
                    }
                    

                    if((int)$id >= 0){
                        if((int)$id != $user_data['id']){
                            $owner = $db->query("SELECT yespost FROM users WHERE id = " .(int)$id);
                            if($owner->fetch()['yespost'] == 0){
                                $error = 1;
                                http_response_code(400);
                                $response = array('error' => $lang['api']['wall_access_denied']);
                            }
                        }
                    } else {
                        $group = $db->query("SELECT * FROM groups WHERE id = '" .((int)$id * -1). "'")->fetch(PDO::FETCH_ASSOC);

                        if((int)$group['type'] == 0){
                            if((int)$group['owner_id'] != (int)$user_data['id']){
                                if($group['admins'] != NULL){
                                    $group_admins = json_decode($group['admins'], true);

                                    if(!in_array((int)$user_data['id'], $group_admins)){
                                        http_response_code(400);
                                        $error = 1;
                                        $response = array('error' => $lang['api']['wall_access_denied']);
                                    }
                                } else {
                                    http_response_code(400);
                                    $error = 1;
                                    $response = array('error' => $lang['api']['wall_access_denied']);
                                }
                            }
                        } else {
                            if($group['type'] == 1){
                                $predlozhka = 0;
                            }
                        }
                    }

                    if((int)$id == 0){
                        $error = 1;
                        http_response_code(400);
                        $response = array('error' => $lang['api']['no_user_id']);
                    }

                    if(true){
                        $recent = $db->query("SELECT * FROM post WHERE id_who = " .(int)$user_data['id']. " ORDER BY date DESC")->fetch();
                        $date = time() - $recent['date'];
            
                        if($date <= $antispam){
                            $error = 1;
                            http_response_code(400);
                            $response = array('error' => $lang['api']['antispam'], 'left' => $antispam - $date);
                        }
                    }

                    // Загрузка

                    function fuckimg($src, $width, $height){
                        global $_FILES, $error;

                        if($_FILES['file']['type'] == 'image/jpeg'){
                            $file = imagecreatefromjpeg($src);
                        } elseif($_FILES['file']['type'] == 'image/png'){
                            $file = imagecreatefrompng($src);
                        } elseif($_FILES['file']['type'] == 'image/bmp'){
                            $file = imagecreatefrombmp($src);
                        } elseif($_FILES['file']['type'] == 'image/gif'){
                            $file = imagecreatefromgif($src);
                        } elseif($_FILES['file']['type'] == 'image/webp'){
                            $file = imagecreatefromwebp($src);
                        } else {
                            http_response_code(400);
                            $error = 1; 
                        }
                        
                        $imgwidth= imagesx($file);
                        $imgheight= imagesy($file);
                        
                        if(($imgheight / $imgwidth) >= 4){
                            http_response_code(400);
                            $error = 1; 
                        } elseif(($imgheight / $imgwidth) <= 0.3){
                            http_response_code(400);
                            $error = 1;
                        }                          
                        
                        if($error == 0){
                            $imgwidth= imagesx($file);
                            $imgheight= imagesy($file);
                
                            if($width == 0){
                                $width = ($height / $imgwidth) * $imgheight;
                            } elseif($height == 0){
                                $height = ($width / $imgheight) * $imgwidth;
                            }
                
                            $size = imagecreatetruecolor((int)$height, (int)$width);
                
                            imagecopyresampled($size, $file, 0, 0, 0, 0, (int)$height, (int)$width,  imagesx($file), imagesy($file));
                
                            $filesrc = '../cdn/' .uniqid(). '.jpg';
                
                            imagejpeg($size, $filesrc, 80);

                            return $filesrc;
                        }
                    }                  

                    // Омагад, костыли
                    if(!empty($_FILES)){
                        if($_FILES['file']['error'] == 0){
                            if(!unlink(fuckimg($_FILES['file']['tmp_name'], 0, 50))){
                                $error = 1;
                                $response = array('error' => $lang['api']['bad_image']);
                            }
                        }
                    }

                    if($error == 0){
                        if(isset($group)){
                            if((int)$anonim == 1){
                                $user_data['id'] = (int)$id;
                            }                            
                        }

                        if(empty($_FILES) or $_FILES['file']['error'] != 0){
                            $query = "INSERT INTO post(id_user, id_who, post, date, verify) VALUES (
                                " .(int)$id. ", 
                                " .(int)$user_data['id']. ", 
                                " .$db->quote($text). ", 
                                " .time(). ", 
                                " .$predlozhka. ")";
                        }else{
                            $query = "INSERT INTO post(id_user, id_who, post, date, img, verify) VALUES (
                                " .(int)$id. ", 
                                " .(int)$user_data['id']. ", 
                                " .$db->quote($text). ", 
                                " .time(). ", 
                                '" .fuckimg($_FILES['file']['tmp_name'], 0, 640). "', 
                                " .$predlozhka. ")";
                        }

                        if($db->query($query)){
                            if($predlozhka == 0){
                                $response = array(2);
                            }else {
                                $response = array(1);
                            }
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

        $wall = new wall();

        switch($_REQUEST['method']){
            case 'getglobal':
                echo json_encode($wall->getglobal($_REQUEST['token'], $_REQUEST['p']));
                break;
            case 'getbyuser':
                echo json_encode($wall->getbyuser($_REQUEST['token'], $_REQUEST['id'], $_REQUEST['p']));
                break;
            case 'delete':
                echo json_encode($wall->delete($_REQUEST['token'], $_REQUEST['id']));
                break;
            case 'like':
                echo json_encode($wall->like($_REQUEST['token'], $_REQUEST['id']));
                break;
            case 'pin':
                echo json_encode($wall->pin($_REQUEST['token'], $_REQUEST['id']));
                break;
            case 'add':
                echo json_encode($wall->add($_REQUEST['token'], $_REQUEST['text'], $_REQUEST['id'], $_REQUEST['anonim']));
                break;
            default:
                http_response_code(400);
                echo json_encode(array('error' => $lang['api']['invalid_method']));
                break;
        }

        $db = null;
    }