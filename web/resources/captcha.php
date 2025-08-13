<?php
    session_start();

    $width = 120;
    $height = 50;
    $font_size = 16;
    $let_amount = 5;
    $fon_let_amount = 30;
    $font = dirname(__FILE__) . "/fc.ttf";
    
    $letters = array('a', 's', 'd', 'g', 'h', '1', '4', '8', 'r', 'e', 'm');		

    $background_color = array(mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));

    $foreground_color = array(mt_rand(0, 100), mt_rand(0, 100), mt_rand(0, 100));

    $src = imagecreatetruecolor($width,$height);		
        
    $fon = imagecolorallocate($src, $background_color[0], $background_color[1], $background_color[2]);

    imagefill($src,0,0,$fon);

    for($i=0; $i < $let_amount; $i++){
        $color = imagecolorallocatealpha($src, $foreground_color[0], $foreground_color[1], $foreground_color[2], rand(20,40)); //Цвет шрифта
        $letter = $letters[rand(0,sizeof($letters)-1)];
        $size = rand($font_size*2-2,$font_size*2+2);
        $x = ($i+1)*$font_size + rand(2,5);
        $y = (($height*2)/3) + rand(0,5);							
        $cod[] = $letter;
        imagettftext($src,$size,rand(0,15),$x,$y,$color,$font,$letter);
    }

    $foreground = imagecolorallocate($src, $foreground_color[0], $foreground_color[1], $foreground_color[2]);

    imageline($src, 0, 0,  $width, 0, $foreground);
    imageline($src, 0, 0,  0, $height, $foreground);
    imageline($src, 0, $height-1,  $width, $height-1, $foreground);
    imageline($src, $width-1, 0,  $width-1, $height, $foreground);

    $cod = implode("",$cod);
    
    header("Content-type: image/gif");

    imagegif($src); 

    $_SESSION['code'] = $cod;
?>
