<?php 

    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        //header("Location: login.php"); 
        echo '<li class="active">';
        echo '<li><a href="#" id="display">Display data</a></li>';
        echo '<li><a href="#" id="register">Register</a></li>';
        echo '<li><a href="#" id="login">Log in</a></li>';
    } else {
        
        echo '<li class="active">';
        echo '<li><a href="#" id="display">Display data</a></li>';
        echo '<li><a href="#" id="adddata">Add data</a></li>';
        echo '<li><a href="#" id="member">Memberlist</a></li>';
        echo '<li><a href="#" id="editacc">Edit Account</a></li>';
        echo '<li><a href="php/logout.php" id="logout">Log out <font color="white">('.htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8').')</font></a></li>';
    }
     
    // Everything below this point in the file is secured by the login system 
     
    // We can display the user's username to them by reading it from the session array.  Remember that because 
    // a username is user submitted content we must use htmlentities on it before displaying it to the user. 
    
?> 