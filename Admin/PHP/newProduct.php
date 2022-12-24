<?php
    ob_start();
	session_start();

	$pageTitle = 'Image Gallery';

	if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
	{
        //check if the user is already loged in by checking if there is a session containing the user name and password
        //here if not so direct the user to index.php
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="..\CSS\add.css">
    <link rel="stylesheet" href="..\CSS\viewStyle.css"> 
    <link rel="stylesheet" href="..\CSS\navbarStyle.css">
    <link rel="stylesheet" href="..\CSS\headerbar.css">
    <title>Newly addded product</title>
</head>
<body>
<?php
    include("..\\Includes\\Design\\headerbar.php");
    include("..\\Includes\\Design\\navbar.php");
    include("..\\Includes\\functions\\database-connection.php");
?>
<?php
    echo '<div id="main_container">';
    //in adding a product
    if(isset($_POST["ADD"])){
        $db = connect();
        $table = $_POST["table"];
        $menu_id = $_POST["menu_id"];
        $menu_name =$_POST["menu_name"];

        $query = 'INSERT INTO `'.$table.'` (ID,MENU_ID,NAME,SPRICE,MPRICE,LPRICE) VALUES (NULL,'.$menu_id.',';
        if($_POST["name"] == ""){
            die("Can't insert a product without a name");
        }else{
            $query .="'".$_POST["name"]."',";
        }
        if($_POST["sprice"] == ""){
            $query .="NULL,";
        }else{
            if(!is_numeric($_POST["sprice"]))die('<div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <p>You have entered a non-numeric value for price !!!!
        </p></div>');
            $query .="".$_POST["sprice"].",";
        }
        if($_POST["mprice"] == ""){
            $query .="NULL,";
        }else{
            if(!is_numeric($_POST["mprice"]))die('<div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <p>You have entered a non-numeric value for price !!!!
        </p></div>');
            $query .="".$_POST["mprice"].",";
        }
        if($_POST["lprice"] == ""){
            $query .="NULL)";
        }else{
            if(!is_numeric($_POST["lprice"]))die('<div class="alert alert-warning alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <p>You have entered a non-numeric value for price !!!!
        </p></div>');
            $query .="".$_POST["lprice"].")";
        }
        echo $query;
        $stmt = $db->prepare($query);
        $stmt->execute();
        header("Location:view.php?menuid=".$menu_id."&menuname=".$menu_name);
        //after doing the direction page give it the menu_id in the location link
    }
?>
<?php
    $table = $_GET["table"];
    $menu_id = $_GET["menu_id"];
    $menu_name =$_GET["menu_name"];
    echo '<div class="display-5">New product in '.$menu_name.' in '.$table.' table</div>';
    echo '<form class="was-validated" method = "post" action = "newProduct.php" id="createForm">';
    echo "<ul>";
    echo '<li>Product name: </li><li><input type="text" name = "name"  class="form-control" required></li><br>';
    echo '<li>Product small price: </li><li><input type="text" name = "sprice"  class="form-control" ></li><br>';
    echo '<li>Product meduim price: </li><li><input type="text" name = "mprice"  class="form-control" ></li><br>';
    echo '<li>Product large price: </li><li><input type="text" name = "lprice"  class="form-control" ></li><br>';
    /*echo '<div class="valid-feedback">OK</div>
    <div class="invalid-feedback">This field is mandatory.</div>';*/
    echo "</ul>";


    //store the values of the table name and the menu id
    echo '<input type="hidden" name = "table" value="'.$table.'"">';
    echo '<input type="hidden" name = "menu_id" value="'.$menu_id.'">';
    echo '<input type="hidden" name = "menu_name" value="'.$menu_name.'">';
    echo '<input type="submit" name="ADD" value="ADD" id="add" class="btn " style="border-color: #6c757d;" data-toggle="tooltip" title="Add product">';
    echo '</form>';
    echo "</div>";
?>
</body>
</html>
<?php
    }
    else
    {
        header('Location: ..\\index.php');
        exit();
    }
?>