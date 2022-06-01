<?php
    $conn = new mysqli("localhost", "root", "", "sklep3ptp");
    session_start();

    if(isset($_POST['add'])){
        $query1 = "SELECT user_id FROM users WHERE login ='".$_SESSION['zalogowany']."'";
        $result1 = $conn->query($query1);
        $user = $result1->fetch_object();

        $query2 = "SELECT * FROM products WHERE product_id ='".$_POST['add']."'";
        $result2 = $conn->query($query2);
        $product = $result2->fetch_object();

        $query3 = "SELECT * FROM cart WHERE product_id = ".$_POST['add']." AND user_id = ".$user->user_id;
        $result3 = $conn->query($query3);
        $count = 0;
        while($row = $result3->fetch_object()){
            $count++;
        }

        if($count != 0){
            $query = $query = "UPDATE cart SET number = cart.number + 1 WHERE product_id = ".$_POST['add']." AND user_id = ".$user->user_id;
            $result = $conn->query($query);
        } else {
            $query = "INSERT INTO cart(cart_id, product_id, user_id, number) VALUES (NULL,'".$product->product_id."','".$user->user_id."',1)";
            $result = $conn->query($query);
        }

    }

    if(isset($_POST['change'])){
        if($_POST['change'] == 1){
            $query = "UPDATE cart SET number = cart.number + 1 WHERE cart_id = ".$_POST['id'];
            $result = $conn->query($query);
        } else {
            $query = "SELECT * FROM cart WHERE cart_id =".$_POST['id'];
            $result = $conn->query($query);
            $row = $result->fetch_object();
            if($row->number == 1){
                $query = "DELETE FROM cart WHERE cart_id = ".$_POST['id'];
                $result = $conn->query($query);
            } else {
                $query = "UPDATE cart SET number = cart.number - 1 WHERE cart_id = ".$_POST['id'];
                $result = $conn->query($query);
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
            <h1>Koszyk</h1>
            <?php
                $query = "SELECT * FROM products RIGHT JOIN cart USING(product_id) LEFT JOIN users USING(user_id) WHERE login = '".$_SESSION["zalogowany"]."'";
                $result = $conn->query($query);
                $count = 0;
                $sum = 0;
                while($row = $result->fetch_object()){
                    $count++;
                }

                if ($count == 0){
                    echo "<h2>Twój koszyk jest pusty.</h2>";
                } else {
                    echo "<table>
                        <tr>
                            <th>Produkt</th>
                            <th>Cena</th>
                            <th>Ilość</th>
                        </tr>";
                    $query = "SELECT * FROM products RIGHT JOIN cart USING(product_id) LEFT JOIN users USING(user_id) WHERE login = '".$_SESSION["zalogowany"]."'";
                    $result = $conn->query($query);
                    while($row = $result->fetch_object()){
                        echo "<form action='koszyk.php' method='POST' id='".$row->cart_id."'><input type='hidden' name='id' value ='".$row->cart_id."'></form>
                        <tr>
                            <td>".$row->product."</td>
                            <td>".$row->price."zł</td>
                            <td><button form='".$row->cart_id."' name='change' value='0'>-</button> ".$row->number." <button form='".$row->cart_id."' name='change' value='1'>+</button></td>
                        </tr>";
                        $sum += $row->price * $row->number;
                    }

                    echo "</table>
                    <h2>Cena łącznie: ".$sum."zł</h2>";


                    echo"<form action='zamow.php' method='POST'>
                        <input type='submit' name='order' value='Zamów'>

                    </form>";

                }
            ?>
        </div>
    </div>
</body>
</html>