<?php
    $conn = new mysqli("localhost", "root", "", "sklep3ptp");
    session_start();
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
            <h1>Ustawienia użytkownika</h1>
            <h2>Zamówienia</h2>
            <table>
                <tr>
                    <th>Id</th>
                    <th>Status</th>
                    <th>Data</th>
                </tr>
                <?php
                    $query = "SELECT * FROM orders WHERE user_id IN (SELECT user_id FROM users WHERE login='".$_SESSION['zalogowany']."')";
                    $result = $conn->query($query);

                    while($row = $result->fetch_object()){
                        echo "
                        <tr>
                            <td>".$row->order_id."</td>
                            <td>".$row->status."</td>
                            <td>".$row->data."</td>
                        <tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </div>
</body>
</html>