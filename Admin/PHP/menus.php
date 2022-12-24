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
    <title>Menus</title>
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
        nav.getElementsByClassName("menus")[0].classList.add("active-link");
    </script>
    
    <!-- if there isset($_POST['email']) then we have to add the menu to database -->
    <?php
        //to add a menu
        if(isset($_POST['name'])){
            $db = connect();
            $query = "INSERT INTO menus (`MENU_ID`, `MNAME`) VALUES (NULL,'".$_POST['name']."')";
            $stmt=$db->prepare($query);
            //echo '<span style="margin-left:250px;">'.$query.'</span>';
            $stmt->execute();
        }
        //if we want to delete the menu and there is an elements inside it
        //we ask the user if he want to delete all the elements in the menu 
        //if he answers by yes so a post message will arrives to here from the 
        //form at line 119 by $_POST['delete_all']
        //so we delete all elements in the menu and let the next if statement
        //delete the menu
        if(isset($_POST['delete_all'])){
            $arr = explode("_",$_POST['menu']);
            $db = connect();
            //query to return all the items id and the name of the table
            $query = '
            SELECT d.ID , "drinks" AS TABLE_NAME
            FROM drinks AS d
            WHERE d.MENU_ID = ?
            UNION
            SELECT m.ID , "meals" AS TABLE_NAME
            FROM meals AS m
            WHERE m.MENU_ID = ?
            UNION
            SELECT p.ID , "pizzas" AS TABLE_NAME
            FROM pizzas AS P
            WHERE p.MENU_ID = ?
            UNION
            SELECT sa.ID  , "salads" AS TABLE_NAME
            FROM salads AS sa
            WHERE sa.MENU_ID = ?
            UNION
            SELECT s.ID  , "sandwiches" AS TABLE_NAME
            FROM sandwiches AS s
            WHERE s.MENU_ID = ?
            UNION
            SELECT sw.ID  , "sweets" AS TABLE_NAME
            FROM sweets AS sw
            WHERE sw.MENU_ID = ?
             ';
            $stmt=$db->prepare($query);
            $stmt->bind_param("iiiiii",$arr[0],$arr[0],$arr[0],$arr[0],$arr[0],$arr[0]);
            $stmt->execute();
            $stmt->bind_result($id,$table);
            $db2 = connect();
            
            while($stmt->fetch()){
                $nquery ="DELETE FROM ".$table." WHERE ID=?";
                $nstmt=$db2->prepare($nquery);
                $nstmt->bind_param('i',$id);
                $nstmt->execute();
            }
            //so we don't enter to the next condition 
            unset($_POST['menu']);
            //or we can easily use DELETE FROM table WHERE MENU_ID = $menuid
            //then continue to the next step which is deletion of the menu
            
            $db = connect();
            $query = "DELETE FROM menus WHERE MENU_ID = ? ";
            $stmt=$db->prepare($query);
            $stmt->bind_param("s",$arr[0]);
            $stmt->execute();
            
        } 
        //to delete a menu using $_POST['menu']
        if(isset($_POST['menu'])){
            //first get the post values
            //then explode them into 2 pieces with delimeter '_' 
            //so we obtain in the 1st part the menu id and in the 2nd the number of products in this menu
            //if the number of products > 0 then through an error saying that you need to free the menu first
            $arr = explode("_",$_POST['menu']);
            if($arr[1]>0){
                echo '<div style="margin-left:240px;" class="d-flex justify-content-center">
                <div class="toast show">
                <div class="toast-header">
                  Delete confirmation
                  <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                </div>
                <div class="toast-body">
                <p>You have multiple products in your menu are you sure you want to delete them?</p>
                <form action="./menus.php" method="post">
                    <input type="submit" name="delete_all" value="Yes" class="btn btn-outline-success"  data-bs-dismiss="toast">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="toast">Cancel</button>
                    <!-- to store the menu-id in it-->
                    <input type="hidden" name="menu" value="'.$arr[0].'_'.$arr[1].'" >
                </form>
                </div>
              </div>
              </div>';
            }else{
                $db = connect();
                $query = "DELETE FROM menus WHERE MENU_ID = ? ";
                $stmt=$db->prepare($query);
                $stmt->bind_param("s",$arr[0]);
                $stmt->execute();              
            }

        }

    ?>
    <div style="margin-left: 250px;">
    <div class="d-flex justify-content-between">
        <p class="display-1">Menus:</p>
        <a href='addmenu.php' data-bs-toggle="modal" data-bs-target="#mymodal" title="New menu"><img src='../images/add.png' style="margin-top: 50%;"></a>

    </div>
    <div id="mymodal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Menu addition</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter menu name">
                            <label for="name">Name</label>
                        </div>
                        <input type="submit" value="Add" class="btn btn-success">
                    </form>
                </div>
                <!-- Modal footer --> 
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <?php
        //connect to the database
        /*
        $db = new mysqli("localhost","Ibrahim","bob1234","restaurant");
        if(mysqli_connect_errno()){
            die("Can't connect to database");
        }*/
        //the same of the above but done using function we have written
        $db = connect();
        $query = "SELECT * FROM menus";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->bind_result($menuid,$menuname);
        while($stmt->fetch()){
            $nquery ="
            SELECT SUM(TBL.COUNT) AS COUNT
            FROM(
                SELECT COUNT(*) AS COUNT 
                FROM drinks AS D
                WHERE D.MENU_ID=".$menuid."
                UNION ALL
                SELECT COUNT(*) AS COUNT 
                FROM meals AS M
                WHERE M.MENU_ID=".$menuid."
                UNION ALL
                SELECT COUNT(*) AS COUNT 
                FROM pizzas AS P
                WHERE P.MENU_ID=".$menuid."
                UNION ALL
                SELECT COUNT(*) AS COUNT 
                FROM salads AS S
                WHERE S.MENU_ID=".$menuid."
                UNION ALL
                SELECT COUNT(*) AS COUNT 
                FROM sandwiches AS SA
                WHERE SA.MENU_ID=".$menuid."
                UNION ALL
                SELECT COUNT(*) AS COUNT 
                FROM sweets AS SW
                WHERE SW.MENU_ID=".$menuid."
                )TBL
            ";
            //connect to the database
            $db2 = connect();
            $nstmt=$db2->prepare($nquery);
           // $nstmt->bind_param('i',$menuid);
            $nstmt->execute();
            $nstmt->bind_result($count);
            $nstmt->fetch();
            echo "<div class=\"col-6\">";
            echo "<div class=\"card\" style=\"position:inherit;\">";
            echo "<div style=\"display: flex;
            justify-content: center;\"><img src=\"..\\images\\menu.png\"></div>";
            echo "<div class=\"card-body \">";
            echo "<div style=\"display:flex;justify-content:space-between;font-size: larger;\"><p>".$menuname."</p><span class=\"badge bg-success\" style=\"height:25px;\">".$count."</span></div>";
            //card-link
            echo "<br><div class=\"d-flex justify-content-between\" style=\"height: 40px;\"><a href = \"..\\PHP\\view.php?menuid=".$menuid."&menuname=".$menuname."\" class=\"card-link btn btn-primary\">Expand";
            //form to send the menu id and the number of elements in this menu to server by $_POST['menu'] 
            echo "</a><form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\"><input type=\"submit\" name=\"menu\" value=\"".$menuid."_".$count."\" class=\"btn btn-danger\" style=\"height:35px;width: 35px;background-image: url(../images/delete.png);background-size: cover;color: transparent;\"></form></div>";
            echo "";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    ?>
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