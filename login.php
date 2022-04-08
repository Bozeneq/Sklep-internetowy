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
    <title>Document</title>
</head>
<body>
    <form action="login.php" method="post">
        Login <input type="text" name="login"><br>
        Hasło <input type="password" name="pass"><br>
        <input type="submit" value="Zaloguj">
    </form>
    <?php if(isset($_SESSION["info"])) { echo $_SESSION["info"]; } ?>
</body>
</html>