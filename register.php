<?php

    $conn = new mysqli("localhost", "root", "", "sklep3ptp");

    session_start();

    if(isset($_SESSION["zalogowany"])) {
        header("Location: glowna.php");
        exit();
    }

    if(isset($_POST["login"]) && isset($_POST["pass"]) && isset($_POST["name"]) && isset($_POST["surname"])) {

        $query = "INSERT INTO users (user_id, login, password, admin, name, surename) VALUES (NULL, '".$_POST['login']."', '".$_POST['pass']."', '0', '".$_POST['name']."', '".$_POST['surname']."')";
        $query2 = "SELECT * FROM users";
        $result = $conn->query($query2);
        $check = 1;

        while($row = $result->fetch_object()){
            if($_POST["login"] == $row->login) {
                echo "Taki login już istnieje";
                $check--;
                break;
            }
        }

        if($check != 0){
            if ($conn->query($query) === TRUE) {
                echo "Zarejestrowano";
            } else {
                echo "Error: " . $query . "<br>" . $conn->error;
            }
        }
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
        <div id="site">
            <ul>
                <li><a href="glowna.php">Główna</a></li>
                <li id="loged" class="dropdown">

                    <?php 
                    
                    if(isset($_SESSION["zalogowany"])){
                        echo "<a href='uzytkownik.php' class='dropbtn'>Zalogowano jako ".$_SESSION["zalogowany"]."</a>"; 
                        $query = "SELECT admin FROM users WHERE name = '".$_SESSION["zalogowany"]."'";
                        $result = $conn->query($query);
                        $row = $result->fetch_object();
                        if($row->admin == 1){
                            echo "<div class='dropdown-content'>
                            <a href='uzytkownik.php'>Ustawienia użytkownika</a>
                            <a href='admin.php'>Panel administracyjny</a>
                            <a href='wyloguj.php'>Wyloguj</a>
                            </div>";
                        } else {
                            echo "<div class='dropdown-content'>
                            <a href='uzytkownik.php'>Ustawienia użytkownika</a>
                            <a href='wyloguj.php'>Wyloguj</a>
                            </div>";
                        }
                    } 
                    else{
                        echo "<a href='login.php'>Zaloguj/Zarejestruj</a>";
                    }

                    ?>

                </li>
            </ul>
            <h1>Rejestracja</h1>
            <form action="register.php" method="post">
            Login <input type="text" name="login"><br>
            Hasło <input type="password" name="pass"><br>
            Imię <input type="text" name="name"><br>
            Nazwisko <input type="text" name="surname"><br>
            <input type="submit" value="Rejestruj">
        </form>
        <a href="login.php">Zaloguj</a>
        <?php if(isset($_SESSION["info"])) { echo $_SESSION["info"]; } ?>
        </div>
</div>
</body>
</html>