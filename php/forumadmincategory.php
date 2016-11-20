<?php 

    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
     
    // At the top of the page we check to see whether the user is logged in or not 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: login.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in.
        echo "herpderpherpderpherdep"; 
        die("Redirecting to login.php"); 
    }

    if(!empty($_POST))  {

        $query = " 
            SELECT  
                forumcategories.title AS category 
            FROM 
                forumcategories
            "; 
     
        try 
            { 
                $stmt = $db->prepare($query); 
                $stmt->execute(); 
            } 
            catch(PDOException $ex) 
            { 
                // Note: On a production website, you should not output $ex->getMessage(). 
                // It may provide an attacker with helpful information about your code.  
                die("Failed to run query: " . $ex->getMessage()); 
            } 

            $rows = $stmt->fetchAll();

        $exists = false;
        foreach ($rows as $row) {
                if ($row['category'] == $_POST['title']) {
                    $exists = true;
                }
            }

        if (!$exists) {
            $query = " 
                INSERT INTO forumcategories ( 
                    title, 
                    description, 
                    date 
                ) VALUES ( 
                    :title, 
                    :desc, 
                    NOW() 
                ) 
                ";
        
            $query_params = array( 
                ':title' => $_POST['title'],
                ':desc' => $_POST['description']      
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

            $query = " 
                SELECT  
                    forumcategories.title AS category 
                FROM 
                    forumcategories
                "; 
     
            try 
            { 
                $stmt = $db->prepare($query); 
                $stmt->execute(); 
            } 
            catch(PDOException $ex) 
            { 
                 // Note: On a production website, you should not output $ex->getMessage(). 
                // It may provide an attacker with helpful information about your code.  
                    die("Failed to run query: " . $ex->getMessage()); 
            } 

            $response = $stmt->fetchAll();

            $jsondata = array();

            foreach ($response as $row) {
                $jsondata[] = $row;
            }

            echo json_encode($jsondata);

        }      
    } 
?> 