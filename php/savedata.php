<?php 

    require("common.php"); 
     
    if(empty($_SESSION['user'])) 
    { 
        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    } 
    
     if(!empty($_POST))
    { 
    // Everything below this point in the file is secured by the login system 
     
    // We can retrieve a list of members from the database using a SELECT query. 
    // In this case we do not have a WHERE clause because we want to select all 
    // of the rows from the database table. 
        $query = " 
            INSERT INTO lagraskit ( 
                namn, 
                ingred, 
                pris, 
                fampris 
            ) VALUES ( 
                :namn, 
                :ingred, 
                :pris, 
                :fampris 
            ) 
        ";
        
        $query_params = array( 
            ':namn' => $_POST['namn'], 
            ':ingred' => $_POST['ingred'], 
            ':pris' => $_POST['pris'], 
            ':fampris' => $_POST['fampris'] 
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
    header("Location: ../index.html");
    echo "<br><b>added</b>";

