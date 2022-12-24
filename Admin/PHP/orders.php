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
    <link rel="stylesheet" href="..\CSS\dashboard.css">
    <title>Document</title>
</head>

<body>
    <?php
        include("..\\Includes\\Design\\headerbar.php");
        include("..\\Includes\\Design\\navbar.php");
        include("..\\Includes\\functions\\database-connection.php");
    ?>
    <script>
        var active = document.getElementsByClassName("active-link");//get the elements that are marked a active
        for(var i=0;active.length >0;i++){
            //remove the class name "active-link" from the elements in active
            active[i].classList.remove("active-link");
        }
        var nav =document.getElementById("navbar");
        nav.getElementsByClassName("orders")[0].classList.add("active-link");
    </script>
<?php
$db = connect();
?>
    <div style="margin-left: 250px;padding:20px;height: -webkit-fill-available;" class="shadow">
        <h1 style="color: #5a5c69!important;font-size: 1.75rem;font-weight: 400;line-height: 1.2;margin-bottom: 1.5rem!important;">Orders</h1>
        <div id="accordion">
            <div class=" container ">
                <?php
                    
                    echo '<div class="card">';
                    echo '<div class="card-header"><a class="btn" data-bs-toggle="collapse" href="#collapseOne" style="font-size: x-large;font-weight: 300;"> Current orders</a></div>';
                    echo '</div><div id="collapseOne" class="collapse show" data-bs-parent="#accordion">';
                    echo '<div class="card-body">';
                    //use the past db connection
                    $date = date("Y-m-d H:i");
                    $query = "SELECT * FROM orders WHERE DATE > ?";
                    
                    $stmt=$db->prepare($query);
                    $stmt->bind_param("s",$date);
                    $stmt->execute();
                    $stmt->bind_result($id,$clientid,$dd,$address);
                    echo '<table class="table table-bordered table-hover">';
                    echo "<tr><td>Order_ID</td><td>CLIENT_NAME</td><td>DATE</td><td>ADDRESS</td><td>ORDERS</td><td>TOTAL</td></tr>";
                    $db2 = connect();
                    $db3 = connect();
                    while($stmt->fetch()){
                        //take customer name
                        $query2 = "SELECT FIRST_NAME,LAST_NAME FROM clients WHERE CLIENT_ID=?";
                        $stmt2=$db2->prepare($query2);
                        $stmt2->bind_param("i",$clientid);
                        $stmt2->execute();
                        $stmt2->bind_result($fn,$ln);  
                        $stmt2->fetch();
                        unset($stmt2);
                        
                        $query2 = "SELECT MENU_ID,TABLE_NAME,PRODUCT_ID,QUANTITY,DESCRIPTION FROM `orders-info` WHERE ORDER_ID=?";
                        //echo $query2;
                        $stmt2=$db2->prepare($query2);
                        $stmt2->bind_param("i",$id);
                        $stmt2->execute();
                        $stmt2->bind_result($menuid,$table,$pid,$q,$desc);  
                        echo '<tr><td>'.$id.'</td><td>'.$fn." ".$ln.'</td><td>'.$dd.'</td><td>'.$address.'</td><td>';

                        $total = 0;
                        //TO TAKE THE PRICE OF THE PRODUCT
                        //in the description we have large || meduim || small
                        //so take the first letter from them
                        echo "<ul style='list-style-type: auto;margin: 0;'>";
                        while($stmt2->fetch()){
                            //loop to print all the products
                            
                            $letter = strtoupper(substr($desc,0,1));
                            $query3 = "SELECT NAME,".$letter."PRICE FROM ".$table." WHERE MENU_ID=? AND ID=?" ;
                            $stmt3=$db3->prepare($query3);
                            $stmt3->bind_param("ii",$menuid,$pid);
                            $stmt3->execute();
                            $stmt3->bind_result($name,$price); 
                            $stmt3->fetch();
                            echo "<li>".$name."-->".$price."</li>";
                            $total += $price;
                            unset($stmt3);
                            
                        }
                        echo "<ul>";
                        echo "</td><td>".$total."</td></tr>";
                        unset($stmt2);
                        
                    }
                    unset($stmt);
                    echo "</table>";
                    echo "</div>";
                    echo "</div>";
                ?>
                <?php
                    
                    echo '<div class="card">';
                    echo '<div class="card-header"><a class="btn" data-bs-toggle="collapse" href="#collapseTwo" style="font-size: x-large;font-weight: 300;"> All orders</a></div>';
                    echo '</div><div id="collapseTwo" class="collapse fade" data-bs-parent="#accordion">';
                    echo '<div class="card-body">';
                    //use the past db connection
                    $query = "SELECT * FROM orders";
                    
                    $stmt=$db->prepare($query);
                    $stmt->execute();
                    $stmt->bind_result($id,$clientid,$dd,$address);
                    echo '<table class="table table-bordered table-hover">';
                    echo "<tr><td>Order_ID</td><td>CLIENT_NAME</td><td>DATE</td><td>ADDRESS</td><td>ORDERS</td><td>TOTAL</td></tr>";
                    $db2 = connect();
                    $db3 = connect();
                    while($stmt->fetch()){
                        //take customer name
                        $query2 = "SELECT FIRST_NAME,LAST_NAME FROM clients WHERE CLIENT_ID=?";
                        $stmt2=$db2->prepare($query2);
                        $stmt2->bind_param("i",$clientid);
                        $stmt2->execute();
                        $stmt2->bind_result($fn,$ln);  
                        $stmt2->fetch();
                        unset($stmt2);
                        
                        $query2 = "SELECT MENU_ID,TABLE_NAME,PRODUCT_ID,QUANTITY,DESCRIPTION FROM `orders-info` WHERE ORDER_ID=?";
                        //echo $query2;
                        $stmt2=$db2->prepare($query2);
                        $stmt2->bind_param("i",$id);
                        $stmt2->execute();
                        $stmt2->bind_result($menuid,$table,$pid,$q,$desc);  
                        echo '<tr><td>'.$id.'</td><td>'.$fn." ".$ln.'</td><td>'.$dd.'</td><td>'.$address.'</td><td>';

                        $total = 0;
                        //TO TAKE THE PRICE OF THE PRODUCT
                        //in the description we have large || meduim || small
                        //so take the first letter from them
                        echo "<ul style='list-style-type: auto;margin: 0;'>";
                        while($stmt2->fetch()){
                            //loop to print all the products
                            
                            $letter = strtoupper(substr($desc,0,1));
                            $query3 = "SELECT NAME,".$letter."PRICE FROM ".$table." WHERE MENU_ID=? AND ID=?" ;
                            $stmt3=$db3->prepare($query3);
                            $stmt3->bind_param("ii",$menuid,$pid);
                            $stmt3->execute();
                            $stmt3->bind_result($name,$price); 
                            $stmt3->fetch();
                            echo "<li>".$name."-->".$price."</li>";
                            $total += $price;
                            unset($stmt3);
                            
                        }
                        echo "<ul>";
                        echo "</td><td>".$total."</td></tr>";
                        unset($stmt2);
                        
                    }
                    echo "</table>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                ?>
            </div>
        </div>
    </div>
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