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
    <title>Bzynoland</title>
    <style>
        #border{
            width: 60%;
            padding-left: 20%;
        }
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
        #loged{
            float: right;
        }
    </style>
</head>
<body>
    <div id="border">
            <ul>
                <li><a href="glowna.php">Główna</a></li>
                <li id="loged">

                    <?php 
                    
                    if(isset($_SESSION["zalogowany"])){
                        echo "<a href='uzytkownik.php'>Zalogowano jako ".$_SESSION["zalogowany"]."</a>"; 
                    } 
                    else{
                        echo "<a href='login.php'>Zaloguj/Zarejestruj</a>";
                    }

                    ?>

                    <li>
            </ul>
            <p>Nastąpiło wylogowanie</p>
            <a href="glowna.php">Strona główna</a>
    </div>
</body>
</html>