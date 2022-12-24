<?php
    //Set page title
    $pageTitle = 'Table Reservation';

    /*include "connect.php";
    include 'Includes/functions/functions.php';
    include "Includes/templates/header.php";
    include "Includes/templates/navbar.php";*/


?>
<head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="../CSS/reserve.css">
</head>
<body>
	<section id="book">
		<nav id="main_nav">
			<a href="../HTML/Main.html#header_div">Home</a>
			<a href="../HTML/Main.html#feature">Service</a>
			<a href="">Menu</a>
			<a href="">Order</a>
			<a href="../HTML/Main.html#footer">About</a>  
		</nav> 
	
        <div class="layer">
             <h1>Reserve a Table</h1>
        </div>
        
    </section>
	
	<section id="form">
		<div class="container">
		<?php

            if(isset($_POST['reservation_form']))
            {
				$server="localhost";
				$username="Ibrahim";
				$pass="bob1234";
				$db="restaurant";

				$mysqli_connect= new mysqli($server,$username,$pass,$db);

				if($mysqli_connect->connect_error){
					exit('Error in connection');
				}

                // Selected Date and Time

                $date = $_POST['date'];
                $time = $_POST['time'];

                $selected_time = $date." ".$time;

                //Nbr of Guests
                $nb_guests = $_POST['guestNumber'];

                //Table Type
                //$table_type = $_POST['table_type'];

                //Client Details
                $user_first_name = $_POST['firstName'];
				$user_last_name = $_POST['lastName'];
                $user_phone_number = $_POST['phone'];
                $user_email = $_POST['email'];

                
                try
                {
					
					$sqlUser = "insert into clients(FIRST_NAME, LAST_NAME, PHONE, EMAIL) values(?,?,?,?)";
                    $stmtUser = $mysqli_connect->prepare($sqlUser);
					$stmtUser->bind_param("ssss",$user_first_name,$user_last_name,$user_phone_number,$user_email);
                    $stmtUser->execute();

					//echo "$user_first_name";
					//echo "$user_first_name";
					
					/*$sql = "SELECT USER_ID FROM users WHERE users.email=?";
					$stmt = $mysqli_connect->prepare($sql);
					$stmt->bind_param("s",$user_email);
					$stmt->execute();
                    $user_id = $stmt->fetch();
					echo "$user_id";
					echo "$user_email";*/
					
                    $sqlReservation = "insert into reservation(selected_time, nb_guests) values(?, ?)";
                    $stmt_reservation = $mysqli_connect->prepare($sqlReservation);
					$stmt_reservation->bind_param("si",$selected_time,$nb_guests);
                    $stmt_reservation->execute();
                    
                    echo "<div class = 'alert alert-success p-3'>";
                        echo "Great! Your Reservation has been created successfully.";
                    echo "</div>";

                    $mysqli_connect->commit();
                }
                catch(Exception $e)
                {
                    $con->rollBack();
                    echo "<div class = 'alert alert-danger'>"; 
                        echo $e->getMessage();
                    echo "</div>";
                }
            }

        ?>
			<div class="form-wrapper">
				<form method="POST" action="Reservation.php">
					<div class="form-group">
						<label for="firstName">First Name</label>
						<input type="text" id="firstName" name="firstName" required="required">
					</div>
					<div class="form-group">
						<label for="lastName">Last Name</label>
						<input type="text" id="lastName" name="lastName" required="required">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" id="email" name="email" required="required">
					</div>
					<div class="form-group">
						<label for="phone">Telephone Number</label>
						<input type="tel" id="phone" name="phone" required="required">
					</div>					
					<div class="form-group">
						<label for="tableType">Table Type</label>
						<select name="tableType" id="tableType" required="required">
							<option selected disabled>Choose</option>
							<option value="small">Small (2 persons)</option>
							<option value="medium">Medium (4 persons)</option>
							<option value="large">Large (6 persons)</option>
						</select>
					</div>
					<div class="form-group">
						<label for="guestNumber">Guest Number</label>
						<select name="guestNumber" required="required">
							<option selected disabled>Choose</option>
							<option value="1" <?php echo (isset($_POST['guestNumber']))?"selected":"";  ?>>One person</option>
							<option value="2" <?php echo (isset($_POST['guestNumber']))?"selected":"";  ?>>Two people</option>
							<option value="3" <?php echo (isset($_POST['guestNumber']))?"selected":"";  ?>>Three people</option>
							<option value="4" <?php echo (isset($_POST['guestNumber']))?"selected":"";  ?>>Four people</option>
                        </select>
					</div>

					<div class="form-group">
						<label for="date">Date</label>
						<input type="date" id="date" value=<?php echo (isset($_POST['date']))?$_POST['date']:date('Y-m-d',strtotime("+1day"));  ?> name="date" required="required">
					</div>
					<div class="form-group">
						<label for="time">Time</label>
						<input type="time" value=<?php echo (isset($_POST['time']))?$_POST['time']:date('H:i');  ?> id="time" name="time" required="required">
					</div>
					<div class="form-group form-group-full">
						<label for="note">Note</label>
						<textarea type="note" id="note" rows="3"></textarea>
					</div>
					<button type="submit" name="reservation_form" class="btn"> Make a Reservation </button>
				</form>
			</div>
		</div>		
	</section>
</body>