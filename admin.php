<?php
    $conn = new mysqli("localhost", "root", "", "sklep3ptp");
    session_start();
    if(!isset($_SESSION["zalogowany"])) {
        header("Location: glowna.php");
        exit();
    } else {
        $query = "SELECT admin FROM users WHERE login = '".$_SESSION["zalogowany"]."'";
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
        $result = $conn->query($query);

        $query = "SELECT product_id FROM products ORDER BY product_id DESC LIMIT 1";
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

    if(isset($_POST["ed"])){
        $value = number_format($_POST['price'], 2);
        $query = "UPDATE products SET product = '".$_POST['product']."', description = '".$_POST['description']."', price = ".$_POST['price']." WHERE product_id = ".$_POST['id'];
        $result = $conn->query($query);

        $query = "DELETE FROM product_cat WHERE product_id = ".$_POST['id'];
        $conn->query($query);

        $query = "SELECT product_id FROM products WHERE product_id =".$_POST['id'];
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

    if(isset($_POST['addCat'])){
        $i = 1;
        $query = "SELECT * FROM categories";
        $result = $conn->query($query);
        while($row = $result->fetch_object()){
            if(isset($_POST['category'.$i])){
                $query = "INSERT INTO product_cat (prod_cat_id, product_id, category_id) VALUES (NULL, ".$_POST['addCat'].", $row->category_id)";
                $conn->query($query);
            }
            $i++;
        }
    }

    if(isset($_POST['delete'])){
        $query = "DELETE FROM product_cat WHERE product_id = ".$_POST['delete'];
        $conn->query($query);
        $query = "DELETE FROM products WHERE product_id = ".$_POST['delete'];
        $conn->query($query);
    }

    //||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

    if(isset($_POST["newCat"])){
        $query = "INSERT INTO categories (category_id, category) VALUES (NULL, '".$_POST['category']."')";
        $result = $conn->query($query);
    }

    if(isset($_POST["edCat"])){
        $query = "UPDATE categories SET category = '".$_POST['category']."' WHERE category_id = ".$_POST['id'];
        $result = $conn->query($query);
    }

    if(isset($_POST['deleteCat'])){
        $query = "DELETE FROM product_cat WHERE category_id = ".$_POST['deleteCat'];
        $conn->query($query);
        $query = "DELETE FROM categories WHERE category_id = ".$_POST['deleteCat'];
        $conn->query($query);
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
            <h1>Panel administracyjny</h1>
            <?php
                if(isset($_POST['new'])){
                    echo "<h2 style='color: red;'><u>Utworzono przedmiot</u></h2>";
                }
                if(isset($_POST['delete'])){
                    echo "<h2 style='color: red;'><u>Usunięto przedmiot</u></h2>";
                }
                if(isset($_POST['ed'])){
                    echo "<h2 style='color: red;'><u>Zedytowano przedmiot</u></h2>";
                }
                if(isset($_POST['edit'])){
                    echo "<h2>Edytuj przedmiot</h2>";
                } else {
                    echo "<h2>Dodaj przedmiot</h2>";
                }
            
                if(isset($_POST['edit'])){
                    $query1 = "SELECT * FROM products WHERE product_id =".$_POST['edit'];
                    $result1 = $conn->query($query1);
                    $row1 = $result1->fetch_object();
                    echo "
                    <form action='admin.php' method='POST' id='editForm'>
                        <h3>Nazwa produktu</h3>
                        <input type='text' name='product' value='".$row1->product."'><br>
                        <h3>Opis produktu</h3> 
                        <textarea name='description' form='editForm'>".$row1->description."</textarea>
                        <h3>Cena (pln)</h3> 
                        <input type='number' name='price' step='0.01' value='".$row1->price."'><br>
                        <h3>Kategorie</h3>
                    ";
                    $query2 = "SELECT * FROM products WHERE product_id =".$_POST['edit'];
                    $result2 = $conn->query($query2);
                    $row2 = $result2->fetch_object();


                    $query1 = "SELECT * FROM product_cat WHERE product_id = ".$_POST['edit'];
                    $result1 = $conn->query($query1);

                    $query = "SELECT * FROM categories";
                    $result = $conn->query($query);
                    $i = 1;
                    while($row = $result->fetch_object()){
                        echo "<input type='checkbox' name='category".$i."' value='".$row->category_id."' ";

                        $query1 = "SELECT * FROM product_cat WHERE product_id = ".$_POST['edit'];
                        $result1 = $conn->query($query1);
                        while($row1 = $result1->fetch_object()){
                            if($row1->category_id == $row->category_id){
                                echo "checked";
                            }
                        }

                        echo">".$row->category."<br>";
                        $i++;
                    }
                    echo "<input type='submit' value='Edytuj' id='wyslij' name='ed'> 
                    <input type='hidden' name='id' value='".$_POST['edit']."'>
                    </form>";
                } else {
                    echo "
                    <form action='admin.php' method='POST' id='addForm'>
                        <h3>Nazwa produktu</h3>
                        <input type='text' name='product'><br>
                        <h3>Opis produktu</h3> 
                        <textarea name='description' form='addForm'></textarea>
                        <h3>Cena (pln)</h3> 
                        <input type='number' name='price' step='0.01'><br>
                        <h3>Kategorie</h3>
                    ";

                    $query = "SELECT * FROM categories";
                    $result = $conn->query($query);
                    $i = 1;
                    while($row = $result->fetch_object()){
                        echo "<input type='checkbox' name='category".$i."' value='".$row->category_id."'>".$row->category."<br>";
                        $i++;
                    }
                    echo "<input type='submit' value='Utwórz' id='wyslij' name='new'> </form>";
                }
                
            ?>
            <h2>Przedmioty</h2>
                <table>
                    <tr>
                        <th>Produkt</th>
                        <th>Opis</th>
                        <th>Cena</th>
                        <th>Kategorie</th>
                        <th>Opcje</th>
                    </tr>
                        <?php
                        
                        $query = "SELECT * FROM products";
                        $result = $conn->query($query);

                        while($row = $result->fetch_object()){
                            echo "<tr>
                                <td>".$row->product."</td>
                                <td>".$row->description."</td>
                                <td>".$row->price."</td>
                                <td>";

                            $query = "SELECT * FROM product_cat LEFT JOIN categories USING(category_id) WHERE product_id = ".$row->product_id;
                            $result2 = $conn->query($query);
                            echo "|";
                            while($cats = $result2->fetch_object()){
                                echo $cats->category."|";
                            }
                            
                            
                            echo"</td>
                                <td>
                                    <button form='addForm' type='submit' name='edit' value='".$row->product_id."'>Edytuj</button>
                                    <button form='addForm' type='submit' name='addCat' value='".$row->product_id."'>Dodaj kategorię</button>
                                    <button form='addForm' type='submit' name='delete' value='".$row->product_id."'>Usuń</button>
                                </td>
                            </tr>";
                        }
                        ?>
                </table>

<!--||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||-->

            <?php
                if(isset($_POST['newCat'])){
                    echo "<h2 style='color: red;'><u>Utworzono kategorię</u></h2>";
                }
                if(isset($_POST['deleteCat'])){
                    echo "<h2 style='color: red;'><u>Usunięto kategorię</u></h2>";
                }
                if(isset($_POST['edCat'])){
                    echo "<h2 style='color: red;'><u>Zedytowano kategorię</u></h2>";
                }
                if(isset($_POST['editCat'])){
                    echo "<h2>Edytuj kategorię</h2>";
                } else {
                    echo "<h2>Dodaj kategorię</h2>";
                }
            
                if(isset($_POST['editCat'])){
                    $query1 = "SELECT * FROM categories WHERE category_id =".$_POST['editCat'];
                    $result1 = $conn->query($query1);
                    $row1 = $result1->fetch_object();
                    echo "
                    <form action='admin.php' method='POST' id='editCForm'>
                        <h3>Nazwa produktu</h3>
                        <input type='text' name='category' value='".$row1->category."'><br>
                        <input type='submit' value='Edytuj' id='wyslij' name='edCat'> 
                        <input type='hidden' name='id' value='".$_POST['editCat']."'>
                    </form>";
                } else {
                    echo "
                    <form action='admin.php' method='POST' id='addCForm'>
                        <h3>Nazwa produktu</h3>
                        <input type='text' name='category'><br>
                        <input type='submit' value='Utwórz' id='wyslij' name='newCat'> 
                    </form>";
                }
                
            ?>
            <h2>Przedmioty</h2>
                <table>
                    <tr>
                        <th>Kategoria</th>
                        <th>Opcje</th>
                    </tr>
                        <?php
                        
                        $query = "SELECT * FROM categories";
                        $result = $conn->query($query);

                        while($row = $result->fetch_object()){
                            echo "<tr>
                                <td>".$row->category."</td>
                                <td>
                                    <button form='addCForm' type='submit' name='editCat' value='".$row->category_id."'>Edytuj</button>
                                    <button form='addCForm' type='submit' name='deleteCat' value='".$row->category_id."'>Usuń</button>
                                </td>
                            </tr>";
                        }
                        ?>
                </table>
        </div>
    </div>
</body>
</html>