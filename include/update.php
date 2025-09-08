<?php
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "ALTER TABLE post MODIFY post VARCHAR(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $db->exec($sql);

    $sql = "ALTER TABLE comments MODIFY text VARCHAR(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $db->exec($sql);

    $sql = "ALTER TABLE users MODIFY descr VARCHAR(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $db->exec($sql);

    $sql = "ALTER TABLE users MODIFY priv INT(1) NOT NULL DEFAULT 0 COMMENT '0 -- No priv. 1 -- Verify. 2 -- Moderator. 3 -- Admin'";
    $db->exec($sql);

    $sql = "ALTER TABLE users MODIFY yespost INT(1) NOT NULL DEFAULT 0 COMMENT 'Is the wall open for use?'";
    $db->exec($sql);

    $sql = "ALTER TABLE users MODIFY secret VARCHAR(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'Secret code for 2fa'";
    $db->exec($sql);

    $sql = "ALTER TABLE users MODIFY auth INT(1) NOT NULL DEFAULT 0 COMMENT 'Is the account activated with email authentication enabled?'";
    $db->exec($sql);

    unlink(__FILE__);
?>