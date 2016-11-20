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

    if(!empty($_POST)) {

        $query = " 
                SELECT  
                    forumsubcategories.title AS subcategory 
                FROM 
                    forumsubcategories
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
            if ($row['subcategory'] == $_POST['title']) {
                 $exists = true;
            }
        }

        if (!$exists) {

            $query = " 
                SELECT  
                    forumcategories.id AS id 
                FROM 
                    forumcategories
                WHERE 
                    forumcategories.title = :title
                ";

            $query_params = array( 
                ':title' => $_POST['category'] 
            ); 
     
            try 
            { 
                $stmt = $db->prepare($query); 
                $stmt->execute($query_params);
            } 
            catch(PDOException $ex) 
            { 
                // Note: On a production website, you should not output $ex->getMessage(). 
                // It may provide an attacker with helpful information about your code.  
                die("Failed to run query: " . $ex->getMessage()); 
            } 

            $ID = $stmt->fetchAll();

            $query2 = " 
                INSERT INTO forumsubcategories (
                    idCategory, 
                    title, 
                    description, 
                    date 
                ) VALUES (
                    :catid, 
                    :title, 
                    :desc, 
                    NOW() 
                ) 
                ";
        
            $query_params2 = array(
                ':catid' => (int)$ID[0]['id'], 
                ':title' => $_POST['title'],
                ':desc' => $_POST['description']      
            );

            try 
            { 
            // These two statements run the query against your database table. 
            $stmt2 = $db->prepare($query2); 
            $result = $stmt2->execute($query_params2);
            } 
            catch(PDOException $ex) 
            { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
                die("Failed to run query: " . $ex->getMessage()); 
            }
                
        }
    }