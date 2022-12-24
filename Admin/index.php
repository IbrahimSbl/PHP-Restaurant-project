<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href=".\CSS\viewStyle.css"> 
    <link rel="stylesheet" href=".\CSS\navbarStyle.css">
    <link rel="stylesheet" href=".\CSS\headerbar.css">
    <title>Log in</title>
</head>

<body class="container-sm w-50">
    
<?php 
include(".\\Includes\\functions\\database-connection.php");
?>
    <?php
        session_start();
        if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA']))
        {
            header('Location: ./PHP/dashboard.php');
        }
    ?>

    <?php
        if(isset($_POST['username']) && isset($_POST['password']))
        {       //if the user submit his user name and his password 
                //check if found in database
                //if not show an alert
                $username = $_POST['username'];
                $pass = $_POST['password'];
                $db = connect();
                $query = "SELECT COUNT(*) FROM users WHERE USER_NAME=? AND PASSWORD = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param("ss",$username,$pass);
                $stmt->execute();
                $stmt->bind_result($count);
                $stmt->fetch();
                if($count>0){
                    //in this case the username and password are correct
                    $_SESSION['username_restaurant_qRewacvAqzA'] = $username;
                    $_SESSION['password_restaurant_qRewacvAqzA'] = $pass;
                    header('Location: ./PHP/dashboard.php');
                }else{
                    //username or password are wrong
                    echo '<div class="alert alert-warning alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <p>You have entered a wrong username or password.<br>Please try again. 
                </p></div>';
                
                }
            }

    ?>

    <!-- LOGIN FORM -->
    <script>
        /* =========== VALIDATE ADMIN LOGIN FORM ======== */

        function validateLoginForm() 
        {
            var username_input = document.forms["login-form"]["username"].value;
            var password_input = document.forms["login-form"]["password"].value;
            
            if (username_input == "" && password_input == "") 
            {
                document.getElementById('username_required').style.display = 'block';
                document.getElementById('password_required').style.display = 'block';
            return false;
            }
            
            if (username_input == "") 
            {
                document.getElementById('username_required').style.display = 'block';
                return false;
            }
            
            if(password_input == "")
            {
                document.getElementById('password_required').style.display = 'block';
                return false;
            }
        }
    </script>
	<div class="login">
			<form class="login-container " name="login-form" action="index.php" method="POST" onsubmit="return validateLoginForm()">
					<span class="login100-form-title p-b-32">
							Admin Login
						</span>

				<!-- USERNAME INPUT -->

					<div class="form-input">
							<span class="txt1">Username</span>
								<input type="text" name="username" class = "form-control username" oninput='document.getElementById("username_required").style.display="none"' id="user" autocomplete="off" >
							<div class="invalid-feedback" id="username_required">Username is required!</div>
					</div>

					<!-- PASSWORD INPUT -->
			
					<div class="form-input">
							<span class="txt1">Password</span>
							<input type="password" name="password" class="form-control" id="password" oninput='document.getElementById("password_required").style.display="none"' autocomplete="new-password" >
							<div class="invalid-feedback" id="password_required">Password is required!</div>
					</div>

					<!-- SIGNIN BUTTON -->
			
					<p>
							<button type="submit" name="admin_login" >Sign In</button>
					</p>

					<!-- FORGOT PASSWORD PART -->

					<span class="forgotPW">Forgot your password ? <a href="resetPassword.php">Reset it here.</a></span>

				</form>
		</div>
</body>

</html>