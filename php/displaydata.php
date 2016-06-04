<?php 


    require("common.php"); 
    if(empty($_SESSION['user'])) 
    { 
        $query = " 
        SELECT 
            id, 
            namn, 
            ingred, 
            pris, 
            fampris 
        FROM lagraskit 
    "; 
     
    try 
    { 
        // These two statements run the query against your database table. 
        $stmt = $db->prepare($query); 
        $stmt->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        // Note: On a production website, you should not output $ex->getMessage(). 
        // It may provide an attacker with helpful information about your code.  
        die("Failed to run query: " . $ex->getMessage()); 
    } 
         
    // Finally, we can retrieve all of the found rows into an array using fetchAll 
    $rows = $stmt->fetchAll(); 
    echo ('<h1>Datalist</h1> 
<table class="table table-condensed"> 
    <thead>
    <tr>  
        <th>Name</th> 
        <th>Ingred</th> 
        <th>Price</th> 
        <th>Fam price</th>
    </tr>
    </thead>');
    foreach($rows as $row) { 
        echo '<tr>';
        echo "<td>".htmlentities($row['namn'], ENT_QUOTES, 'UTF-8')."</td>";
        echo "<td>".htmlentities($row['ingred'], ENT_QUOTES, 'UTF-8')."</td>";
        echo "<td>".htmlentities($row['pris'], ENT_QUOTES, 'UTF-8')."</td>";
        echo "<td>".htmlentities($row['fampris'], ENT_QUOTES, 'UTF-8')."</td>";
        echo "</tr>";
    }
        echo "</table> ";
        //header("Location: login.php"); 
        //die(""); 
    } else 
    {
     
    // Everything below this point in the file is secured by the login system 
     
    // We can retrieve a list of members from the database using a SELECT query. 
    // In this case we do not have a WHERE clause because we want to select all 
    // of the rows from the database table. 
    $query = " 
        SELECT 
            id, 
            namn, 
            ingred, 
            pris, 
            fampris 
        FROM lagraskit 
    "; 
     
    try 
    { 
        // These two statements run the query against your database table. 
        $stmt = $db->prepare($query); 
        $stmt->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        // Note: On a production website, you should not output $ex->getMessage(). 
        // It may provide an attacker with helpful information about your code.  
        die("Failed to run query: " . $ex->getMessage()); 
    } 
         
    // Finally, we can retrieve all of the found rows into an array using fetchAll 
    $rows = $stmt->fetchAll(); 
    echo ('<h1>Datalist</h1>
    <table class="table table-condensed">
    <thead> 
    <tr>
              <td class="tidfield"><B>ID</B></td>
              <td class="tdatafield"><B>Name</B></td>
              <td class="tdatafield"><B>Ingredients</B></td>
              <td class="tdatafield"><B>Price</B></td>
              <td class="tdatafield"><B>Fam Price</B></td>
              <td class="tdatafield"><B>Data Options</B></td>
    </tr>
    </thead>');
    foreach($rows as $row) { 
        echo '<tr id="row'.$row['id'].'">';
        echo '<td class="tidfield">'.$row['id']."</td>";
        echo '<td class="tdatafield">'.htmlentities($row['namn'], ENT_QUOTES, 'UTF-8')."</td>";
        echo '<td class="tdatafield">'.htmlentities($row['ingred'], ENT_QUOTES, 'UTF-8')."</td>";
        echo '<td class="tdatafield">'.htmlentities($row['pris'], ENT_QUOTES, 'UTF-8')."</td>";
        echo '<td class="tdatafield">'.htmlentities($row['fampris'], ENT_QUOTES, 'UTF-8')."</td>";
        echo '<td class="tdatafield"><button type="button" class="deletedata" id="'.$row['id'].'">Delete</button>';
        echo '<button type="button" class="updatedata" id="upd'.$row['id'].'">Update</button></td>';
        echo "</tr>";
    }
    echo "</table>";
    }
?> 