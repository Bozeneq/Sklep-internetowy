<?php
    $conn = new mysqli("localhost", "root", "", "sklep3ptp");
    session_start();

    if(isset($_POST['nick'])){
        $query = "SELECT * FROM users WHERE login = '".$_SESSION['zalogowany']."'";
        $result = $conn->query($query);
        $row = $result->fetch_object();
        if($row->password == $_POST['pass']){
            //$query = "UPDATE users SET login = 'adam01', password = 'lisjan', name = 'Adam', surename = 'Kowalczyk' WHERE user_id = ".$row->user_id;
            $query = "UPDATE users SET login = '".$_POST['nick']."' WHERE login = '".$_SESSION['zalogowany']."'";
            if($conn->query($query)){
                $_SESSION['zalogowany'] = $_POST['nick'];
            }
        }
    }

    if(isset($_POST['name'])){
        $query = "SELECT * FROM users WHERE login = '".$_SESSION['zalogowany']."'";
        $result = $conn->query($query);
        $row = $result->fetch_object();
        if($row->password == $_POST['pass']){
            $query = "UPDATE users SET name = '".$_POST['name']."', surename = '".$_POST['surename']."' WHERE login = '".$_SESSION['zalogowany']."'";
            $conn->query($query);
        }
    }

    if(isset($_POST['NEWpass'])){
        $query = "SELECT * FROM users WHERE login = '".$_SESSION['zalogowany']."'";
        $result = $conn->query($query);
        $row = $result->fetch_object();
        if($row->password == $_POST['pass']){
            //$query = "UPDATE users SET login = 'adam01', password = 'lisjan', name = 'Adam', surename = 'Kowalczyk' WHERE user_id = ".$row->user_id;
            $query = "UPDATE users SET password = '".$_POST['NEWpass']."' WHERE login = '".$_SESSION['zalogowany']."'";
            $conn->query($query);
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
    <link rel="stylesheet" href="style.css" type="text/css">
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
                        $query = "SELECT admin FROM users WHERE login = '".$_SESSION["zalogowany"]."'";
                        $result = $conn->query($query);
                        $row = $result->fetch_object();
                        if($row->admin == 1){
                            echo "<div class='dropdown-content'>
                            <a href='koszyk.php'>Koszyk</a>
                            <a href='uzytkownik.php'>Ustawienia użytkownika</a>
                            <a href='admin.php'>Panel administracyjny</a>
                            <a href='wyloguj.php'>Wyloguj</a>
                            </div>";
                        } else {
                            echo "<div class='dropdown-content'>
                            <a href='koszyk.php'>Koszyk</a>
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
                    <th>Data zamówienia</th>
                    <th>Adres</th>
                </tr>
                <?php
                    if(isset($_POST['adress'])){
                        $query1 = "SELECT user_id FROM users WHERE login='".$_SESSION['zalogowany']."'";
                        $result1 = $conn->query($query1);
                        $user = $result1->fetch_object();

                        $query="INSERT INTO orders(order_id, user_id, status, date, adress) VALUES (NULL, ".$user->user_id.", 'przetwarzanie', '".date('Y/m/d')."', '".$_POST['adress']."')";
                        $result = $conn->query($query);

                        $query="SELECT * FROM orders ORDER BY order_id DESC LIMIT 1";
                        $result = $conn->query($query);
                        $order = $result->fetch_object();

                        $query1 = "SELECT * FROM cart WHERE user_id IN (SELECT user_id FROM users WHERE login='".$_SESSION['zalogowany']."')";
                        $result1 = $conn->query($query1);
                        while($row = $result1->fetch_object()){
                            $query="INSERT INTO order_prod(id, order_id, product_id, id) VALUES (NULL, ".$order->order_id.", ".$row->product_id.", ".$row->number.")";
                            $result = $conn->query($query);

                            $query= "DELETE FROM cart WHERE cart_id =".$row->cart_id;
                            $conn->query($query);
                        }
                    }

                    $query = "SELECT * FROM orders WHERE user_id IN (SELECT user_id FROM users WHERE login='".$_SESSION['zalogowany']."')";
                    $result = $conn->query($query);

                    while($row = $result->fetch_object()){
                        echo "
                        <tr>
                            <td>".$row->order_id."</td>
                            <td>".$row->status."</td>
                            <td>".$row->date."</td>
                            <td>".$row->adress."</td>
                        <tr>
                        ";
                    }
                ?>
            </table>
            <h2>Zmiana danych</h2>
            <?php
                if(isset($_POST['nick'])){
                    echo "<h2 style='color: red;'>Zmieniono nazwę na \"".$_POST['nick']."\"</h2>";
                }
            ?>
            <h3>Zmień nazwę</h3>
            <form action='uzytkownik.php' method='POST'>
                    <h4>Nowa nazwa</h4>
                    <input type='text' name='nick'><br>
                    <h4>Potwierdź hasłem</h4>
                    <input type='password' name='pass'></br>
                    <input type='submit' value='Zmień nazwę'>
            </form>
            <br>
            <h3>Zmień dane osobowe</h3>
            <?php
                if(isset($_POST['nick'])){
                    echo "<h2 style='color: red;'>Zmieniono dane osobowe</h2>";
                }
            ?>
            <form action='uzytkownik.php' method='POST'>
                    <h4>Imię</h4>
                    <input type='text' name='name'><br>
                    <h4>Nazwisko</h4>
                    <input type='text' name='surename'><br>
                    <h4>Potwierdź hasłem</h4>
                    <input type='password' name='pass'></br>
                    <input type='submit' value='Zmień dane'>
            </form>
            <br>
            <h3>Zmień hasło</h3>
            <?php
                if(isset($_POST['nick'])){
                    echo "<h2 style='color: red;'>Zmieniono hasło</h2>";
                }
            ?>
            <form action='uzytkownik.php' method='POST'>
                    <h4>Stare hasło</h4>
                    <input type='password' name='pass'><br>
                    <h4>Nowe hasło</h4>
                    <input type='password' name='NEWpass'></br>
                    <input type='submit' value='Zmień hasło'>
            </form>
        </div>
    </div>
</body>
</html>