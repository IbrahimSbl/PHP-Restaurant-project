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
    <title>Users</title>
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
        nav.getElementsByClassName("users")[0].classList.add("active-link");
    </script>
    <div style="margin-left: 250px;padding:20px;height: -webkit-fill-available;" class="shadow">
        <div class="display-1">Users:</div>
        <div class="card">
            <div class="card-header">Users</div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <tr><td>USER_NAME</td><td>NAME</td><td>PHONE</td><td>BIRTHDAY</td><td>EMAIL</td><td>PASSWORD</td></tr>
                    <?php
                        $db = connect();
                        $query = "SELECT * FROM users";
                        $stmt = $db->prepare($query);
                        $stmt->execute();
                        $stmt->bind_result($id,$username,$fn,$ln,$phone,$birth,$email,$pass);
                        while($stmt->fetch()){
                            echo "<tr><td>".$username."</td><td>".$fn." ".$ln."</td><td>".$phone."</td><td>".$birth."</td><td>".$email."</td><td>".$pass."</td></tr>";
                        }
                    ?>
                </table>
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