<?php
function connect(){
    $db = new mysqli("localhost","Ibrahim","bob1234","restaurant");
    if(mysqli_connect_errno()){
        die("can't connect to database");
    }
    return $db;
}
?>