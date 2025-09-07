<?php
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "ALTER TABLE post MODIFY post VARCHAR(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $db->exec($sql);

    $sql = "ALTER TABLE comments MODIFY text VARCHAR(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $db->exec($sql);

    $sql = "ALTER TABLE users MODIFY descr VARCHAR(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $db->exec($sql);

    unlink(__FILE__);
?>