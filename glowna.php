<?php

    session_start();

    if(!isset($_SESSION["zalogowany"])) {
        header("Location: login.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover {
            background-color: #111;
        }
        li div {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 2;
        }
    </style>
</head>
<body>
    <ul>
        <li><a href="glowna.php">Główna</a></li>
        <li><a href="login.php">Zaloguj</a></li>
        <li><div>Zalogowano jako <?php echo $_SESSION["zalogowany"]; ?></div><li>
    </ul>
    <h1>Witamy użytkownika <?php echo $_SESSION["zalogowany"]; ?></h1>
    <a href="wyloguj.php">Wyloguj</a>
</body>
</html>