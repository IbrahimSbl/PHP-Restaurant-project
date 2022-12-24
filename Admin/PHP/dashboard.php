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
        nav.getElementsByClassName("dashboard")[0].classList.add("active-link");
    </script>
    <?php
        //calculate the total number of clients , users , menus and orders
        $db=connect();
        $query = "SELECT COUNT(*) FROM clients";
        $stmt=$db->prepare($query);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        //store in variable
        $clients = $count;   

        unset($stmt);
        $query = "SELECT COUNT(*) FROM users";
        $stmt=$db->prepare($query);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        //store in variable
        $users = $count;  

        unset($stmt);
        $query = "SELECT COUNT(*) FROM orders";
        $stmt=$db->prepare($query);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        //store in variable
        $orders = $count;  

        unset($stmt);
        $query = "SELECT COUNT(*) FROM menus";
        $stmt=$db->prepare($query);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        //store in variable
        $menus = $count;  
        unset($stmt);
    ?>
    <div style="margin-left: 250px;padding:20px;/*height: -webkit-fill-available;*/" class="shadow">
        <h1 style="color: #5a5c69!important;font-size: 1.75rem;font-weight: 400;line-height: 1.2;margin-bottom: 1.5rem!important;">Dashboard</h1>
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-header"  style="background-color:#5cb85c;color:white;">
                        <div class="row" style="">
                            <div class="col-sm-3">
                                <img src="../images/users.png" alt="">
                            </div>
                            <div class="col-sm-9 text-right">
                                <div class="number"><?php echo $clients; ?></div>
                                <div >Total clients</div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-body" style="padding:0;">
                        <a href="./clients.php" style="color:#5cb85c;">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><img src="../images/arrow-green.png" alt=""></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-header"  style="background-color:#337ab7;color:white;">
                        <div class="row" style="">
                            <div class="col-sm-3">
                                <img src="../images/admin.png" alt="">
                            </div>
                            <div class="col-sm-9 text-right">
                                <div class="number"><?php echo $users; ?></div>
                                <div >Total users</div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-body" style="padding:0;">
                        <a href="./users.php" style="color:#337ab7;">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><img src="../images/arrow-blue.png" alt=""></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-header"  style="background-color:#d9534f;color:white;">
                        <div class="row" style="">
                            <div class="col-sm-3">
                                <img src="../images/utensils.png" alt="">
                            </div>
                            <div class="col-sm-9 text-right">
                                <div class="number"><?php echo $menus; ?></div>
                                <div >Total menus</div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-body" style="padding:0;">
                        <a href="./menus.php" style="color:#d9534f;">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><img src="../images/arrow-red.png" alt=""></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                    <div class="card-header"  style="background-color:#f0ad4e;color:white;">
                        <div class="row" style="">
                            <div class="col-sm-3">
                                <img src="../images/pizza.png" alt="">
                            </div>
                            <div class="col-sm-9 text-right">
                                <div class="number"><?php echo $orders; ?></div>
                                <div >Total orders</div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-body" style="padding:0;">
                        <a href="./orders.php" style="color:#f0ad4e;">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><img src="../images/arrow-orange.png" alt=""></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                    </div>

                </div>
            </div>

        </div>
    
        <ul class="nav nav-tabs">
            <li class="nav-item active">
                <a class="nav-link active" data-bs-toggle="tab" href="#current">Current reservations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#future">Future reservations</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#all">All reservations</a>   
            </li>
        </ul>
        <div class ="tab-content">
            <div class="tab-pane container active" id="current">
                <?php
                    //use the past db connection
                    $date = date("Y-m-d H:i");
                    $query = "SELECT * FROM reservation WHERE selected_time > ?";
                    $stmt=$db->prepare($query);
                    $stmt->bind_param("s",$date);
                    $stmt->execute();
                    $stmt->bind_result($id,$clientid,$dd,$guests);
                    echo '<div class="card">';
                    echo '<div class="card-header">Current</div>';
                    echo '<div class="card-body">';
                    echo '<table class="table table-bordered table-hover">';
                    echo "<tr><td>RESERVATION_ID</td><td>CLIENT_NAME</td><td>DATE</td><td>NUMBER_GUESTS</td></tr>";
                    $db2 = connect();
                    while($stmt->fetch()){
                        $query2 = "SELECT FIRST_NAME,LAST_NAME FROM clients WHERE CLIENT_ID=?";
                        $stmt2=$db2->prepare($query2);
                        $stmt2->bind_param("i",$clientid);
                        $stmt2->execute();
                        $stmt2->bind_result($fn,$ln);  
                        $stmt2->fetch();
                        unset($stmt2);
                        echo '<tr><td>'.$id.'</td><td>'.$fn." ".$ln.'</td><td>'.$dd.'</td><td>'.$guests.'</td></tr>';
                    }
                    echo "</table>";
                    echo "</div>";
                    echo "</div>";
                ?>
            </div>
            <div class="tab-pane container" id="future">
                <?php
                    //use the past db connection
                    $curr1 = date("Y-m-d");
                    //echo $curr1." 23:59:59";
                    $curr = $curr1." 23:59:59";
                    $query = "SELECT * FROM reservation WHERE selected_time > ?";
                    //echo "<br>".$query;
                    $stmt=$db->prepare($query);
                    $stmt->bind_param("s",$curr);
                    $stmt->execute();
                    $stmt->bind_result($id,$clientid,$dd,$guests);
                    echo '<div class="card">';
                    echo '<div class="card-header">Future</div>';
                    echo '<div class="card-body">';
                    echo '<table class="table table-bordered table-hover">';
                    echo "<tr><td>RESERVATION_ID</td><td>CLIENT_NAME</td><td>DATE</td><td>NUMBER_GUESTS</td></tr>";
                    $db2 = connect();
                    while($stmt->fetch()){
                        $query2 = "SELECT FIRST_NAME,LAST_NAME FROM clients WHERE CLIENT_ID=?";
                        $stmt2=$db2->prepare($query2);
                        $stmt2->bind_param("s",$clientid);
                        $stmt2->execute();
                        $stmt2->bind_result($fn,$ln);  
                        $stmt2->fetch();
                        unset($stmt2);
                        echo '<tr><td>'.$id.'</td><td>'.$fn." ".$ln.'</td><td>'.$dd.'</td><td>'.$guests.'</td></tr>';
                    }
                    echo "</table>";
                    echo "</div>";
                    echo "</div>";
                ?>
            </div>
            <div class="tab-pane container " id="all">
                <?php
                    //use the past db connection
                    $query = "SELECT * FROM reservation";
                    $stmt=$db->prepare($query);
                    $stmt->execute();
                    $stmt->bind_result($id,$clientid,$dd,$guests);
                    echo '<div class="card">';
                    echo '<div class="card-header">ALL reservations</div>';
                    echo '<div class="card-body">';
                    echo '<table class="table table-bordered table-hover">';
                    echo "<tr><td>RESERVATION_ID</td><td>CLIENT_NAME</td><td>DATE</td><td>NUMBER_GUESTS</td></tr>";
                    $db2 = connect();
                    while($stmt->fetch()){
                        $query2 = "SELECT FIRST_NAME,LAST_NAME FROM clients WHERE CLIENT_ID=?";
                        $stmt2=$db2->prepare($query2);
                        $stmt2->bind_param("s",$clientid);
                        $stmt2->execute();
                        $stmt2->bind_result($fn,$ln);  
                        $stmt2->fetch();
                        unset($stmt2);
                        echo '<tr><td>'.$id.'</td><td>'.$fn." ".$ln.'</td><td>'.$dd.'</td><td>'.$guests.'</td></tr>';
                    }
                    echo "</table>";
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