<?php

    session_start();

    if(!isset($_SESSION["zalogowany"])) {
        header("Location: login.php");
        exit();
    } else {
        unset($_SESSION["zalogowany"]);
        session_destroy();
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Nastąpiło wylogowanie</p>
    <a href="login.php">Strona główna</a>
</body>
</html>