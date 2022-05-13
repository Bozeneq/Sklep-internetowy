<?php

    $conn = new mysqli("localhost", "root", "", "sklep3ptp");

    session_start();

    if(isset($_SESSION["zalogowany"])) {
        header("Location: glowna.php");
        exit();
    }

    if(isset($_POST["login"]) && isset($_POST["pass"])) {
        $query = "SELECT * FROM users";
        $result = $conn->query($query);

        while($row = $result->fetch_object()){
            if($_POST["login"] == $row->login) {
                if($_POST["pass"] == $row->password){
                    $_SESSION["zalogowany"] = $row->login;
                    header("Location: glowna.php");
                    exit();
                } else {
                    $_SESSION["info"] = "Błędne hasło";
                    header("Location: login.php");
                    exit();
                }
            }
        }
        
        $_SESSION["info"] = "Dane niepoprawne. Spróbuj ponownie.";
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
        input, h3, form{
            text-align: center;
        }
        #wyslij{
            margin: 5px;
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
            <form action="login.php" method="post">
                <h3>Login</h3>
                <input type="text" name="login"><br>
                <h3>Hasło</h3> 
                <input type="password" name="pass"><br>
                <input type="submit" value="Zaloguj" id="wyslij">
            </form>
            <h3><a href="register.php">Zarejestruj</a></h3>
            <h3><a href="glowna.php">Strona główna</a></h3>
            <?php if(isset($_SESSION["info"])) { echo $_SESSION["info"]; } ?>
    </div>
</body>
</html>