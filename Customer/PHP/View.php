<?php
/*if(isset($_GET['user'])){
$x=$_GET['user'];
echo "<h1 align='center'>Hello $x !</h1> 
<h1 align='center'>I3302 Grades </h1>";*/
//$x = "Ramadan's Menu";
$server="localhost";
$username="Ibrahim";
$pass="bob1234";
$db="restaurant";

$mysqli_connect= new mysqli($server,$username,$pass,$db);

if($mysqli_connect->connect_error){
	exit('Error in connection');
}

$sql="SELECT name, sprice, mprice,lprice FROM meals as m, menus WHERE menus.menu_id=m.menu_id AND menus.menu_id= '1'";
$stmt=$mysqli_connect->prepare($sql);
//$stmt->bind_param("s",$x);
$stmt->execute();
$arr=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//print_r($arr);

echo "<table align='center' border='1'><tr><th>Name</th><th>Small Price</th><th>Medium Price</th><th>Large Price</th></tr>";

foreach ($arr as $k => $v){
	echo "<tr>";
	foreach($v as $k1=>$v1){
		echo "<td> $v1 </td>";
	}
	echo "</tr>";
}
echo "</table>";

echo "<br><p align='center'><a href='Login.php'>logout</a></p>";
//}
?>
<html>
<head>
<link rel="stylesheet" href="../CSS/menu.css">
</head>
<body>
<div id="menu">
	<h1 id="section">Menu</h1>
	<div id="menu_row">
		<div id="menu_col">
			<h2>Breakfast</h2>
			<div class="box">
				<div id="image">
					<img src="../images/meal.png">
				</div>
				<div>
					<h3>Tasty Dish 01</h3>
					<h4>10$</h4>
				</div>
			</div>
			<div class="box">
				<div id="image">
					<img src="../images/meal.png">
				</div>
				<div>
					<h3>Tasty Dish 01</h3>
					<h4>10$</h4>
				</div>
			</div>
			<div class="box">
				<div id="image">
					<img src="../images/meal.png">
				</div>
				<div>
					<h3>Tasty Dish 01</h3>
					<h4>10$</h4>
				</div>
			</div>
		</div>	
		
		<div id="menu_col">
			<h2>Breakfast</h2>
			<div class="box">
				<div id="image">
					<img src="../images/meal.png">
				</div>
				<div>
					<h3>Tasty Dish 01</h3>
					<h4>10$</h4>
				</div>
			</div>
			<div class="box">
				<div id="image">
					<img src="../images/meal.png">
				</div>
				<div>
					<h3>Tasty Dish 01</h3>
					<h4>10$</h4>
				</div>
			</div>
			<div class="box">
				<div id="image">
					<img src="../images/meal.png">
				</div>
				<div>
					<h3>Tasty Dish 01</h3>
					<h4>10$</h4>
				</div>
			</div>
		</div>
		
		<div id="menu_col">
			<h2>Breakfast</h2>
			<div class="box">
				<div id="image">
					<img src="../images/meal.png">
				</div>
				<div>
					<h3>Tasty Dish 01</h3>
					<h4>10$</h4>
				</div>
			</div>
			<div class="box">
				<div id="image">
					<img src="../images/meal.png">
				</div>
				<div>
					<h3>Tasty Dish 01</h3>
					<h4>10$</h4>
				</div>
			</div>
			<div class="box">
				<div id="image">
					<img src="../images/meal.png">
				</div>
				<div>
					<h3>Tasty Dish 01</h3>
					<h4>10$</h4>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>