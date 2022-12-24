<?php
function check(){
    echo "START SESSION <br>";
    echo "SESSION STARTED<br>";
    if(isset($_SESSION['username_restaurant_qRewacvAqzA']) && isset($_SESSION['password_restaurant_qRewacvAqzA'])){
        return true;
    }
    return false;
}
?>