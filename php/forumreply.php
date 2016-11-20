<?php 

    require("common.php"); 
     
    if(empty($_SESSION['user'])) 
    { 
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    } 
    
     if(!empty($_POST))
     {

        //$today = date("D M j G:i:s T Y");
        //$today = strtotime($today);

        $query = " 
            INSERT INTO forumposts ( 
                idSubcategory, 
                idUser, 
                parentPost, 
                title,
                content,
                date 
            ) VALUES ( 
                :sub, 
                :user, 
                :pp, 
                :title,
                :content,
                NOW() 
            ) 
        ";
        
        $query_params = array( 
            ':sub' => 1, 
            ':user' => htmlentities($_SESSION['user']['id'], ENT_QUOTES, 'UTF-8'), 
            ':pp' => $_POST['postid'], 
            ':title' => $_POST['title'], 
            ':content' => $_POST['content'] 
        );

        try 
        { 
            // These two statements run the query against your database table. 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        }
    }