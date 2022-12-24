<?php
    ob_start();
	session_start();

	$pageTitle = 'Image Gallery';

	if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
	{
        //check if the user is already loged in by checking if there is a session containing the user name and password
        //here if not so direct the user to index.php
        ?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="..\CSS\viewStyle.css"> 
    <link rel="stylesheet" href="..\CSS\navbarStyle.css">
    <link rel="stylesheet" href="..\CSS\headerbar.css">
    <title>Document</title>
</head>

<body>
    <?php
    //includes
    include("..\\Includes\\Design\\headerbar.php");
    include("..\\Includes\\Design\\navbar.php");
    include("..\\Includes\\functions\\database-connection.php");

    //script to change the color of the clicked link in the nav bar
    ?>
    
    <script>
        var active = document.getElementsByClassName("active-link");//get the elements that are marked a active
        for(var i=0;active.length >0;i++){
            //remove the class name "active-link" from the elements in active
            active[i].classList.remove("active-link");
        }
        var nav =document.getElementById("navbar");
        nav.getElementsByClassName("dashboard")[0].classList.add("active-link");
    </script>

    <?php
    //loop over all the values in $_POST
    //if there is some thing like Update || Delete
    //then get this key that it is setted  
    //and substring it to know the table , the action and the id
    $i=0;
    foreach($_POST as $key => $value){
        $i++;//counter to know the position
        
        if(preg_match('`Update`',$key) || preg_match('`Delete`',$key)){
            //echo "*********************************************************<br>";
            $substr = explode("_",$key);
            $action = $substr[0];
            $table = $substr[1];
            $id = $substr[2];
            //connect to the database
            $db = connect();
            

            if($action == "Delete"){
                $query = "DELETE FROM $table WHERE ID = '".$id."'";
                
                if($db->query($query) === false ){
                    die("can't delete");
                }
                
                $stmt = $db->prepare($query);
                $stmt->execute();
            }
            if($action == "Update"){
                $query = "UPDATE $table SET NAME=?,SPRICE=?,MPRICE=?,LPRICE=? WHERE ID = '$id'";
                $stmt = $db->prepare($query);
                $sprice =$_POST[$id."_sprice"];
                $mprice =$_POST[$id."_mprice"];
                $lprice =$_POST[$id."_lprice"];
                //if it is empty so enter it into the database as null
                if($sprice == ""){
                    $sprice = null;
                }
                if($lprice == ""){
                    $lprice = null;
                }
                if($mprice == ""){
                    $mprice = null;
                }
                $stmt->bind_param("ssss",$_POST[$id."_name"],$sprice,$mprice,$lprice);
                $stmt->execute();
            }/*
            echo "<br>$action $table $id<br>";
            echo $query;*/
        }/*
        echo $_POST[$key];
        echo $key." => ".$value."<br>";*/
    }
    

?>
    <?php
    //if we were in another page and directed into this page
    if(isset($_GET['menuid'])){
        $menuId   = $_GET["menuid"];
        $menuname = $_GET["menuname"];
    }
    //if we were in this page and we perform an action 
    //that results in losing the values of menuid and menu name
    if(isset($_POST['menuid'])){
        //echo "**************************************************************";
        $menuId  = $_POST["menuid"];
        $menuname = $_POST["menuname"];
    }
    
//get the menu ID from get
//connect to the database
$db = connect();

echo '<div id="menu_content_out" >';
echo '<div id="menu_content" >';
echo '<div id="main_title" >';
echo "<h1>".$menuname."</h1>";//this is getted from get
echo '</div>';
//open a form
echo "<form method=\"post\" action = \"view.php\">";//method=\"post\" action = \"view.php\"
//read the drinks
//then check if empty table don't view it 
//else view the table 
$table = "drinks";
$query = "SELECT * FROM drinks WHERE MENU_ID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s",$menuId );
$stmt->execute();

$stmt->bind_result($id,$menuId ,$name,$sprice,$mprice,$lprice);
$entered = false;
if(!$entered){
    //print here since if table is empty so the admin can add products
    //so print these
    echo "<table style=\" \">";
    echo "<tr colspan=4 style=\"\"><td class='title' colspan=4 style=\" \">Drinks</td></tr>";
    echo '<tr><th>Name</th><th>Small price</th><th>Meduim price</th><th>Large price</th><td style="visibility:hidden;"></td></tr>';
    $entered = true;
}
while($stmt->fetch()){
    echo "<tr id=\"".$name."_row\">";
    echo "<td><input type=\"text\" name=\"".$id."_name\" id=\"\" value = \"".$name."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_sprice\" id=\"\" value = \"".$sprice."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_mprice\" id=\"\" value = \"".$mprice."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_lprice\" id=\"\" value = \"".$lprice."\"></td>";
    echo '<td class="'.$name.'_inner" style="visibility:hidden;background-color: inherit;"><input type="submit" name="Delete_drinks_'.$id.'" class="deletebtn" value=""  data-toggle="tooltip" title="Delete"><input type="submit" name="Update_drinks_'.$id.'" class="updatebtn" value=""  data-toggle="tooltip" title="Update"></td>';
    echo "</tr>";


}
if($entered){//we was inside the loop and we exit it 
            //so we need to close the table tag
    //add the addition button
    echo "<tr style=\"\"><td></td><td></td><td></td><td class='addbtn' style=\" \"><a href='addToTable.php?table=".$table."&menu_id=".$menuId ."&menu_name=".$menuname."'><img src='../images/add.png'></a></td></tr>";
    echo "</table>";//                                                                                                            ^getted from get                

}
//before closing the form save the menu name && menu id 
//since we will loose them when performing the deletion and updating the products
//so store them in a hidden inputs
echo '<input type="hidden" name="menuid" value="'.$menuId .'">'; 
echo '<input type="hidden" name="menuname" value="'.$menuname.'">'; 
//close the form
echo "</form>";
//open a form
echo "<form method=\"post\" action = \"view.php\">";//method=\"post\" action = \"view.php\"

//read the meals
//then check if empty table don't view it 
//else view the table 
$table = "meals";
$query = "SELECT * FROM meals WHERE MENU_ID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s",$menuId );
$stmt->execute();
$stmt->bind_result($id,$menuId ,$name,$sprice,$mprice,$lprice);
$entered = false;
if(!$entered){
    //print here since if table is empty so the admin can add products
    //so print these
    echo "<table style=\" \">";
    echo "<tr colspan=4 style=\"\"><td class='title' colspan=4 style=\" \">Meals</td></tr>";
    echo '<tr><th>Name</th><th>Small price</th><th>Meduim price</th><th>Large price</th><td style="visibility:hidden;"></td></tr>';
    $entered = true;
}
while($stmt->fetch()){

    echo "<tr id=\"".$name."_row\">";
    echo "<td><input type=\"text\" name=\"".$id."_name\" id=\"\" value = \"".$name."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_sprice\" id=\"\" value = \"".$sprice."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_mprice\" id=\"\" value = \"".$mprice."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_lprice\" id=\"\" value = \"".$lprice."\"></td>";
    echo '<td class="'.$name.'_inner" style="visibility:hidden;background-color: inherit;"><input type="submit" name="Delete_meals_'.$id.'" class="deletebtn" value=""  data-toggle="tooltip" title="Delete"><input type="submit" name="Update_meals_'.$id.'" class="updatebtn" value="" data-toggle="tooltip" title="Update"></td>';
    echo "</tr>";


}
if($entered){//we was inside the loop and we exit it 
            //so we need to close the table tag
    //add the addition button
    echo "<tr style=\"\"><td></td><td></td><td></td><td class='addbtn' style=\" \"><a href='addToTable.php?table=".$table."&menu_id=".$menuId ."&menu_name=".$menuname."'><img src='../images/add.png'></a></td></tr>";
    echo "</table>";//                                                                                                            ^getted from get                

}


//before closing the form save the menu name && menu id 
//since we will loose them when performing the deletion and updating the products
//so store them in a hidden inputs
echo '<input type="hidden" name="menuid" value="'.$menuId  .'">'; 
echo '<input type="hidden" name="menuname" value="'.$menuname.'">'; 
//close the form
echo "</form>";
//open a form
echo "<form method=\"post\" action = \"view.php\">";


//read the pizzas
//then check if empty table don't view it 
//else view the table 
$table = "pizzas";
$query = "SELECT * FROM pizzas WHERE MENU_ID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s",$menuId  );
$stmt->execute();
$stmt->bind_result($id,$menuId  ,$name,$sprice,$mprice,$lprice);
$entered = false;
if(!$entered){
    //print here since if table is empty so the admin can add products
    //so print these
    echo "<table style=\" \">";
    echo "<tr colspan=4 style=\"\"><td class='title' colspan=4 style=\" \">Pizzas</td></tr>";
    echo '<tr><th>Name</th><th>Small price</th><th>Meduim price</th><th>Large price</th><td style="visibility:hidden;"></td></tr>';
    $entered = true;
}
while($stmt->fetch()){

    echo "<tr id=\"".$name."_row\">";
    echo "<td><input type=\"text\" name=\"".$id."_name\" id=\"\" value = \"".$name."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_sprice\" id=\"\" value = \"".$sprice."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_mprice\" id=\"\" value = \"".$mprice."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_lprice\" id=\"\" value = \"".$lprice."\"></td>";
    echo '<td class="'.$name.'_inner" style="visibility:hidden;background-color: inherit;"><input type="submit" name="Delete_pizzas_'.$id.'" class="deletebtn" value="" data-toggle="tooltip" title="Delete"><input type="submit" name="Update_pizzas_'.$id.'" class="updatebtn" value="" data-toggle="tooltip" title="Delete"></td>';
    echo "</tr>";


}
if($entered){//we was inside the loop and we exit it 
            //so we need to close the table tag
    //add the addition button
    echo "<tr style=\"\"><td></td><td></td><td></td><td class='addbtn' style=\" \"><a href='addToTable.php?table=".$table."&menu_id=".$menuId  ."&menu_name=".$menuname."'><img src='../images/add.png'></a></td></tr>";
    echo "</table>";//                                                                                                            ^getted from get                

}


//before closing the form save the menu name && menu id 
//since we will loose them when performing the deletion and updating the products
//so store them in a hidden inputs

echo '<input type="hidden" name="menuid" value="'.$menuId  .'">'; 
echo '<input type="hidden" name="menuname" value="'.$menuname.'">'; 
//close the form
echo "</form>";
//open a form
echo "<form method=\"post\" action = \"view.php\">";


//read the salads
//then check if empty table don't view it 
//else view the table 
$table = "salads";
$query = "SELECT * FROM salads WHERE MENU_ID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s",$menuId  );
$stmt->execute();
$stmt->bind_result($id,$menuId  ,$name,$sprice,$mprice,$lprice);
$entered = false;
if(!$entered){
    //print here since if table is empty so the admin can add products
    //so print these
    echo "<table style=\" \">";
    echo "<tr colspan=4 style=\"\"><td class='title' colspan=4 style=\" \">Salads</td></tr>";
    echo '<tr><th>Name</th><th>Small price</th><th>Meduim price</th><th>Large price</th><td style="visibility:hidden;"></td></tr>';
    $entered = true;
}
while($stmt->fetch()){

    echo "<tr id=\"".$name."_row\">";
    echo "<td><input type=\"text\" name=\"".$id."_name\" id=\"\" value = \"".$name."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_sprice\" id=\"\" value = \"".$sprice."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_mprice\" id=\"\" value = \"".$mprice."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_lprice\" id=\"\" value = \"".$lprice."\"></td>";
    echo '<td class="'.$name.'_inner" style="visibility:hidden;background-color: inherit;"><input type="submit" name="Delete_salads_'.$id.'" class="deletebtn" value="" data-toggle="tooltip" title="Delete"><input type="submit" name="Update_salads_'.$id.'" class="updatebtn" value="" data-toggle="tooltip" title="Update"></td>';
    echo "</tr>";


}
if($entered){//we was inside the loop and we exit it 
            //so we need to close the table tag
    //add the addition button
    echo "<tr style=\"\"><td></td><td></td><td></td><td class='addbtn' style=\" \"><a href='addToTable.php?table=".$table."&menu_id=".$menuId  ."&menu_name=".$menuname."'><img src='../images/add.png'></a></td></tr>";
    echo "</table>";//                                                                                                            ^getted from get                

}


//before closing the form save the menu name && menu id 
//since we will loose them when performing the deletion and updating the products
//so store them in a hidden inputs

echo '<input type="hidden" name="menuid" value="'.$menuId  .'">'; 
echo '<input type="hidden" name="menuname" value="'.$menuname.'">'; 
//close the form
echo "</form>";
//open a form
echo "<form method=\"post\" action = \"view.php\">";


//read the sandwiches
//then check if empty table don't view it 
//else view the table 
$table = "sandwiches";
$query = "SELECT * FROM sandwiches WHERE MENU_ID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s",$menuId  );
$stmt->execute();
$stmt->bind_result($id,$menuId  ,$name,$sprice,$mprice,$lprice);
$entered = false;
if(!$entered){
    //print here since if table is empty so the admin can add products
    //so print these
    echo "<table style=\" \">";
    echo "<tr colspan=4 style=\"\"><td class='title' colspan=4 style=\" \">Sandwiches</td></tr>";
    echo '<tr><th>Name</th><th>Small price</th><th>Meduim price</th><th>Large price</th><td style="visibility:hidden;"></td></tr>';
    $entered = true;
}
while($stmt->fetch()){
    
    echo "<tr id=\"".$name."_row\">";
    echo "<td><input type=\"text\" name=\"".$id."_name\" id=\"\" value = \"".$name."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_sprice\" id=\"\" value = \"".$sprice."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_mprice\" id=\"\" value = \"".$mprice."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_lprice\" id=\"\" value = \"".$lprice."\"></td>";
    echo '<td class="'.$name.'_inner" style="visibility:hidden;background-color: inherit;"><input type="submit" name="Delete_sandwiches_'.$id.'" class="deletebtn" value="" data-toggle="tooltip" title="Delete"><input type="submit" name="Update_sandwiches_'.$id.'" class="updatebtn" value="" data-toggle="tooltip" title="Update"></td>';
    echo "</tr>";


}
if($entered){//we was inside the loop and we exit it 
            //so we need to close the table tag
    //add the addition button
    echo "<tr style=\"\"><td></td><td></td><td></td><td class='addbtn' style=\" \"><a href='addToTable.php?table=".$table."&menu_id=".$menuId  ."&menu_name=".$menuname."'><img src='../images/add.png'></a></td></tr>";
    echo "</table>";//                                                                                                            ^getted from get                

}


//before closing the form save the menu name && menu id 
//since we will loose them when performing the deletion and updating the products
//so store them in a hidden inputs

echo '<input type="hidden" name="menuid" value="'.$menuId  .'">'; 
echo '<input type="hidden" name="menuname" value="'.$menuname.'">'; 
//close the form
echo "</form>";
//open a form
echo "<form method=\"post\" action = \"view.php\">";


//read the sweets
//then check if empty table don't view it 
//else view the table 
$table = "sweets";
$query = "SELECT * FROM sweets WHERE MENU_ID = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("s",$menuId  );
$stmt->execute();
$stmt->bind_result($id,$menuId  ,$name,$sprice,$mprice,$lprice);
$entered = false;
if(!$entered){
    //print here since if table is empty so the admin can add products
    //so print these
    echo "<table style=\" \">";
    echo "<tr colspan=4 style=\"\"><td class='title' colspan=4 style=\" \">Sweets</td></tr>";
    echo '<tr><th>Name</th><th>Small price</th><th>Meduim price</th><th>Large price</th><td style="visibility:hidden;"></td></tr>';
    $entered = true;
}
while($stmt->fetch()){
    
    echo "<tr id=\"".$name."_row\">";
    echo "<td><input type=\"text\" name=\"".$id."_name\" id=\"\" value = \"".$name."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_sprice\" id=\"\" value = \"".$sprice."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_mprice\" id=\"\" value = \"".$mprice."\"></td>";
    echo "<td><input type=\"text\" name=\"".$id."_lprice\" id=\"\" value = \"".$lprice."\"></td>";
    echo '<td class="'.$name.'_inner" style="visibility:hidden;background-color: inherit;"><input type="submit" name="Delete_sweets_'.$id.'" class="deletebtn" value="" data-toggle="tooltip" title="Delete"><input type="submit" name="Update_sweets_'.$id.'" class="updatebtn" value="" data-toggle="tooltip" title="Update"></td>';
    echo "</tr>";


}
if($entered){//we was inside the loop and we exit it 
            //so we need to close the table tag
    //add the addition button
    echo "<tr style=\"\"><td></td><td></td><td></td><td class='addbtn' style=\" \"><a href='addToTable.php?table=".$table."&menu_id=".$menuId  ."&menu_name=".$menuname."'><img src='../images/add.png'></a></td></tr>";
    echo "</table>";//                                                                                                            ^getted from get                

}


echo "</form>";
echo "</div>";
echo "</div>";
?>

    <script src="..\JavaScript\view.js"></script>
    
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