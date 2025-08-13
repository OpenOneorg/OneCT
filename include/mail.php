<?php 
    $mailconn = array(
        'host' => '',
        'user' => '',
        'pass' => '',
        'port' => 25,
        'subject' => "Вход в {$sitename}",
        'secure' => false,
        'smtpsecure' => 'ssl',
        'msgText' => '
            <html>
                <body>
                    <center style="background: #E0E0E0;">
                        <h1 style="background: rgb(74,20,140); color: white; padding: 8px;">Вход в ' .$sitename. '</h1>
                        <div style="padding-bottom: 16px; color: black;">
                            <p>Держите ссылку по которой вы сможете активировать аккаунт в ' .$sitename. ':</p>
                            <a href="'. $link .'">'. $link .'</a><br><br>
                        </div>
                    </center>
                </body>
            </html>'
    );
?>