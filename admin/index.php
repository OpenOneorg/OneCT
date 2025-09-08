<?php 
    require_once '../include/config.php';
    
    if($_SESSION['user']['priv'] != 3){
        header("Location: ../index.php");
    }
?>

<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="panel.php?file=default.css&amp;version=5.4.0">
    <link rel="stylesheet" href="adminer.css">
</head>
<body>
    <div id="content">
        <form action="panel.php" method="post">
            <input type="hidden" name="auth[driver]" value="server">
            <input type="hidden" name="auth[username]" value="<?php echo($dbconn['user']); ?>">
            <input type="hidden" name="auth[password]" value="<?php echo($dbconn['pass']); ?>">
            <p>Это админ панель с <input type="submit" value="Adminer"> потому что его хватает достаточно даже. А так, в админ панеле будут появляться новые функции</p>
        </form>
    </div>
    <div id="menu">
        <h1><a id="h1">Admin Panel</a></h1>
    </div>
</body>
</html>