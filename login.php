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
    <title>D&D Cave</title>
    <link rel="stylesheet" href="style.css">
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
            <h1>Zaloguj</h1>
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