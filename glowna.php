<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bzynoland</title>
    <style>
        html{
            background-color:#f2d9fa;
            color: white;
        }
        #border{
            padding-left: 15%;
            height: 1000px;
        }
        #site{
            width: 80%;
            background: #5d446e;
            height: 100%;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #26154f;
            }

        li {
            float: left;
        }

        li a, .dropbtn {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover, .dropdown:hover .dropbtn {
            background-color: #a99adb;
        }

        li.dropdown {
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #26154f;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: white;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #a99adb;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        #loged{
            float: right;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <div id="border">
        <div id="site">
            <ul>
                <li><a href="glowna.php">Główna</a></li>
                <li id="loged" class="dropdown">

                    <?php 
                    
                    if(isset($_SESSION["zalogowany"])){
                        echo "<a href='uzytkownik.php' class='dropbtn'>Zalogowano jako ".$_SESSION["zalogowany"]."</a>"; 
                        echo "<div class='dropdown-content'>
                        <a href='uzytkownik.php'>Ustawienia</a>
                        <a href='wyloguj.php'>Wyloguj</a>
                    </div>";
                    } 
                    else{
                        echo "<a href='login.php'>Zaloguj/Zarejestruj</a>";
                    }

                    ?>

                    <li>
            </ul>
            <h1>Sklep internetowy Bzynoland</h1>
        </div>
    </div>
</body>
</html>