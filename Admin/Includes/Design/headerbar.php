<header class="contianer d-flex justify-content-between p-3 bg-info t-0" style="width: -webkit-fill-available;">
    <div id="title" class="navbar-brand border-top">
        <p>Admin Panel</p>
    </div>
    <div id="buttons">
        <!--put ul in a form to handle the logout request which will destroy the session-->
    <ul class="nav">
        <li>
            <a role="button" class="btn btn-secondary m-2" href="#" terget="_blank">
                <span><img src="../images/binoculars.png" alt=""></span>
                View website
            </a>
        </li>
        <li>
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
            <a role="button" class="btn btn-primary m-2" href="./logout.php">
                    <span><img src="../images/logout.png" alt="" style="width:30px;height:30px;"></span>
                    Logout
                </a>   
                
            </form>
            
        </li>
    </ul>
    </div>
    
</header>