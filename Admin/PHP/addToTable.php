<?php
    ob_start();
	session_start();

	$pageTitle = 'Image Gallery';
    include("..\\Includes\\functions\\database-connection.php");

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
    <title>AddToTable</title>
</head>
<body>
<?php
//the user want to add a newly product
if(isset($_POST["NEW"])){
    $table=$_POST["table"];
    $menu_id = $_POST["menu_id"];
    $menu_name = $_POST["menu_name"];

    header("Location:newProduct.php?menu_id=".$menu_id."&menu_name=".$menu_name."&table=".$table);
}
//the user want to add an existing product to his menu 
if(isset($_POST["ADD"])&&isset($_POST["choice"])){
    $table=$_POST["table"];
    $menu_id = $_POST["menu_id"];
    $menu_name = $_POST["menu_name"];
    
    $db = connect();
    for($i=0;$i<count($_POST['choice']);$i++){
        $choice = explode("_",$_POST['choice'][$i]);
        $query = 'INSERT INTO `'.$table.'` (ID,MENU_ID,NAME,SPRICE,MPRICE,LPRICE) VALUES ';
        if($choice[2] == ""){
            $query .= '(NULL, '.$menu_id.',"'.$choice[1].'",NULL,';//.$choice[3].','.$choice[4].')';
        }else{
            $query .= '(NULL, '.$menu_id.',"'.$choice[1].'",'.$choice[2].',';
        }
        if($choice[3] == ""){
            $query .= 'NULL,';
        }else{
            $query .= $choice[3].',';
        }
        if($choice[4] == ""){
            $query .= 'NULL)';
        }else{
            $query .= $choice[4].")";
        }
        //$query = '(NULL, '.$menu_id.','.$choice[1].','.$choice[2].','.$choice[3].','.$choice[4].')';
        
        echo "<br>".$query."<br>";
        
        $stmt = $db->prepare($query);
        $stmt->execute();

    }
    header("Location:view.php?menuid=".$menu_id."&menuname=".$menu_name);
    //after doing the direction page give it the menu_id in the location link
}
?>
<?php
    include("..\\Includes\\Design\\headerbar.php");
    include("..\\Includes\\Design\\navbar.php");
?>
<?php
    if(isset($_GET['menu_name'])){
        $menu_name = $_GET['menu_name'];
        $menu_id = $_GET['menu_id'];
        $table = $_GET['table'];
        //connect to data base
        //to get all the products which are not found in our menu 
        $db = connect();

        $query = "SELECT ID,NAME,MENU_ID,SPRICE,MPRICE,LPRICE,COUNT(NAME) C ";
        $query .= "FROM ".$table." t "; 
        $query .= "GROUP BY NAME ";
        $query .= "HAVING t.MENU_ID != ? AND C = 1 ";

        $stmt = $db->prepare($query);
        $stmt->bind_param('s',$menu_id);
        $stmt->execute();

        $stmt->bind_result($id,$name,$mid,$sprice,$mprice,$lprice,$c);
        echo '<div id="main_container">';
        echo "<h1>Products not added to your ".$menu_name."</h1>";
        echo '<form method = "post" action = "addToTable.php">';
        while($stmt->fetch()){
            echo '<div class="check"><input type="checkbox" name="choice[]" id="" value="'.$id.'_'.$name.'_'.$sprice.'_'.$mprice.'_'.$lprice.'">'.$name.'</div><br><br>';
        }
        echo '<input type="hidden" name = "table" value="'.$table.'">';
        echo '<input type="hidden" name = "menu_id" value="'.$menu_id.'">';
        echo '<input type="hidden" name = "menu_name" value="'.$menu_name.'">';
        echo '<div id="new_container">';
        echo '<input type="submit" name="ADD" value="ADD" id="addbtn" toggle-data="tooltip" title="Add to menu">';
        echo '<input type="submit" name="NEW" value="" id="new" toggle-data="tooltip" title="New product"></div>';
        echo '</form>';
        echo "</div>";
    }
    
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