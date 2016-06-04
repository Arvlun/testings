<?php 


    require("common.php"); 
    if(empty($_SESSION['user'])) 
    { 

        header("Location: login.php"); 
        die("Redirecting to login.php"); 
    } 
     
    // Everything below this point in the file is secured by the login system 
     
    // We can retrieve a list of members from the database using a SELECT query. 
    // In this case we do not have a WHERE clause because we want to select all 
    // of the rows from the database table.
    

    if(!empty($_POST)) 
    { 
        
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $namn = isset($_POST['namn']) ? $_POST['namn'] : '';
        $ingred = isset($_POST['ingred']) ? $_POST['ingred'] : '';
        $pris = isset($_POST['pris']) ? $_POST['pris'] : 0;
        $fampris = isset($_POST['fampris']) ? $_POST['fampris'] : 0;
        //echo $id.$namn.$ingred.$pris.$fampris;

        // Note how this is only first half of the necessary update query.  We will dynamically 
        // construct the rest of it depending on whether or not the user is changing 
        // their password. 
        $query = " 
            UPDATE lagraskit 
            SET 
                namn = :namn,
                ingred = :ingred,
                pris = :pris,
                fampris = :fampris
                WHERE 
                ID = :id
        "; 
             
        $query_params = array( 
            ':namn' => $namn, 
            ':ingred' => $ingred, 
            ':pris' => $pris, 
            ':fampris' => $fampris,
            ':id' => $id
        ); 
         
        try 
        { 
            // Execute the query 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params);  
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        echo '<td class="tidfield">'.$id."</td>";
        echo '<td class="tdatafield">'.htmlentities($namn, ENT_QUOTES, 'UTF-8')."</td>";
        echo '<td class="tdatafield">'.htmlentities($ingred, ENT_QUOTES, 'UTF-8')."</td>";
        echo '<td class="tdatafield">'.htmlentities($pris, ENT_QUOTES, 'UTF-8')."</td>";
        echo '<td class="tdatafield">'.htmlentities($fampris, ENT_QUOTES, 'UTF-8')."</td>";
        echo '<td class="tdatafield"><button type="button" class="deletedata" id="'.$id.'">Delete</button>';
        echo '<button type="button" class="updatedata" id="upd'.$id.'">Update</button></td>';  
        // Now that the user's E-Mail address has changed, the data stored in the $_SESSION 
        // array is stale; we need to update it so that it is accurate. 
        //$_SESSION['user']['email'] = $_POST['email']; 
         
        // This redirects the user back to the members-only page after they register 
        //header("Location: private.php"); 
         
        // Calling die or exit after performing a redirect using the header function 
        // is critical.  The rest of your PHP script will continue to execute and 
        // will be sent to the user if you do not die or exit. 
        //die("Redirecting to private.php"); 
    }
?> 