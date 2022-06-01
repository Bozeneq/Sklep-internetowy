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
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div id="border">
        <div id="site">
            <ul>
                <li><a href="glowna.php">Główna</a></li>
                <?php
                    $query = "SELECT * FROM categories";
                    $result = $conn->query($query);
                    while($row = $result->fetch_object()){
                        echo "<li><a href='glowna.php?category=".$row->category_id."'>".$row->category."</a></li>";
                    }
                ?>

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
            <h1>Sklep internetowy D&D Cave</h1>

            <?php
            
                if(isset($_GET['category'])){
                    $query = "SELECT * FROM product_cat LEFT JOIN products USING(product_id) WHERE category_id = ".$_GET['category'];
                    $result = $conn->query($query);
                    while($row = $result->fetch_object()){
                        echo "<form action='koszyk.php' method='POST' id='".$row->product_id."'></form>
                        <table class='product'>
                            <tr>
                                <td><h2>".$row->product."</h2></td>
                                <td></td>
                                <td><button form='".$row->product_id."' value='".$row->product_id."' name='add'>Do koszyka</button></td>
                            </tr>
                            <tr>
                                <td><h3>".$row->price."zł</h3></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan='3'>".$row->description."</td>
                            </tr>
                        </table>";
                    }
                }
                else{
                    $query = "SELECT * FROM products";
                    $result = $conn->query($query);
                    while($row = $result->fetch_object()){
                        echo "<form action='koszyk.php' method='POST' id='".$row->product_id."'></form>
                        <table class='product'>
                            <tr>
                                <td><h2>".$row->product."</h2></td>
                                <td></td>
                                <td><button form='".$row->product_id."' value='".$row->product_id."' name='add'>Do koszyka</button></td>
                            </tr>
                            <tr>
                                <td><h3>".$row->price."zł</h3></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan='3'>".$row->description."</td>
                            </tr>
                        </table>";
                    }
                }
            
            ?>
        </div>
    </div>
</body>
</html>