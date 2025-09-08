<?php // adminer-plugins.php
include '../include/db.php';

return array(
    new AdminerEditorSetup('server', $dbconn['server'], $dbconn['db']),
    // You can specify all plugins here or just the ones needing configuration.
);