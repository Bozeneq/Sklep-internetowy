<?php
    $conn = new mysqli("localhost", "root", "", "sklep3ptp");
    session_start();
    if(!isset($_SESSION["zalogowany"])) {
        header("Location: glowna.php");
        exit();
    } else {
        $query = "SELECT admin FROM users WHERE name = '".$_SESSION["zalogowany"]."'";
        $result = $conn->query($query);
        $row = $result->fetch_object();
        if($row->admin != 1){
            header("Location: glowna.php");
            exit();
        }
    }

    if(isset($_POST["new"])){
        $value = number_format($_POST['price'], 2);
        $query = "INSERT INTO products (product_id, product, description, price) VALUES (NULL, '".$_POST['product']."', '".$_POST['description']."', ".$value.")";
        $conn->query($query);

        $query = "SELECT product_id FROM products WHERE product = '".$_POST['product']."'";
        $result = $conn->query($query);
        $id = $result->fetch_object();

        $i = 1;
        $query = "SELECT * FROM categories";
        $result = $conn->query($query);
        while($row = $result->fetch_object()){
            if(isset($_POST['category'.$i])){
                $query = "INSERT INTO product_cat (prod_cat_id, product_id, category_id) VALUES (NULL, $id->product_id, $row->category_id)";
                $conn->query($query);
            }
            $i++;
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
            <h1>Panel administracyjny</h1>
            <?php
                if(isset($_POST['new'])){
                    echo "<h2><u>Utworzono przedmiot</u></h2>";
                }
            ?>
            <h2>Dodaj przedmiot</h2>
                <form action="admin.php" method="post">
                    <h3>Nazwa produktu</h3>
                    <input type="text" name="product"><br>
                    <h3>Opis produktu</h3> 
                    <input type="text" name="description"><br>
                    <h3>Cena (pln)</h3> 
                    <input type="number" name="price" step="0.01"><br>
                    <h3>Kategorie</h3>
                        <?php
                            $query = "SELECT * FROM categories";
                            $result = $conn->query($query);
                            $i = 1;
                            while($row = $result->fetch_object()){
                                echo "<input type='checkbox' name='category".$i."' value='".$row->category_id."'>".$row->category."<br>";
                                $i++;
                            }
                            
                        ?>
                    <input type="submit" value="Utwórz" id="wyslij" name="new">
                </form>
        </div>
    </div>
</body>
</html>