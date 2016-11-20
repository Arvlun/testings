<?php 
    require("common.php"); 
    if(empty($_SESSION['user'])) 
    { 
        $query = " 
        SELECT 
            forumposts.title AS title,
            forumposts.id AS id, 
            forumposts.content AS content, 
            forumposts.date AS date, 
            users.username AS username, 
            forumsubcategories.title AS category, 
            forumcategories.title AS subcategory 
        FROM 
            forumposts, 
            forumsubcategories, 
            forumcategories, 
            users 
        WHERE 
            idSubcategory=forumsubcategories.id AND 
            idUser=users.id AND 
            idCategory=forumcategories.id
        ORDER BY forumposts.date
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
        <th>Title</th> 
        <th>Category</th> 
        <th>SubCategory</th> 
        <th>User</th>
        <th>Content</th> 
        <th>Time</th>
    </tr>
    </thead>');
    foreach($rows as $row) { 
        echo '<tr>';
        echo "<td>".htmlentities($row['title'], ENT_QUOTES, 'UTF-8')."</td>";
        echo "<td>".htmlentities($row['category'], ENT_QUOTES, 'UTF-8')."</td>";
        echo "<td>".htmlentities($row['subcategory'], ENT_QUOTES, 'UTF-8')."</td>";
        echo "<td>".htmlentities($row['username'], ENT_QUOTES, 'UTF-8')."</td>";
        echo "<td>".htmlentities($row['content'], ENT_QUOTES, 'UTF-8')."</td>";
        echo "<td>".htmlentities($row['date'], ENT_QUOTES, 'UTF-8')."</td>";
        echo "</tr>";
    }
        echo "</table> ";
        //header("Location: login.php"); 
        //die(""); 
    } else 
    {
     
    $query = " 
        SELECT 
            forumposts.title AS title,
            forumposts.id AS id,  
            forumposts.content AS content, 
            forumposts.date AS date, 
            users.username AS username, 
            forumsubcategories.title AS subcategory, 
            forumcategories.title AS category 
        FROM 
            forumposts, 
            forumsubcategories, 
            forumcategories, 
            users 
        WHERE 
            forumposts.idSubcategory=forumsubcategories.id AND
            forumposts.parentpost = 0 AND 
            forumposts.idUser=users.id AND 
            forumsubcategories.idCategory=forumcategories.id
        ORDER BY forumposts.date DESC;
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

     $query2 = " 
        SELECT  
            forumcategories.title AS category,
            forumsubcategories.title AS subcategory,
            forumsubcategories.id AS subcatid
        FROM 
            forumcategories,
            forumsubcategories
        WHERE
            forumsubcategories.idCategory = forumcategories.id
    "; 

    /*
        SELECT  
            forumcategories.title AS category,
            forumsubcategories.title AS subcategory
            forumsubcategories.id AS subcatid
        FROM 
            forumcategories,
            forumsubcategories
        WHERE
            forumsubcategories.idCategory = forumcategories.id
        GROUP BY category
        ORDER BY subcategory
    */
     
    try 
    { 
        $stmt2 = $db->prepare($query2); 
        $stmt2->execute(); 
    } 
    catch(PDOException $ex) 
    { 
        // Note: On a production website, you should not output $ex->getMessage(). 
        // It may provide an attacker with helpful information about your code.  
        die("Failed to run query: " . $ex->getMessage()); 
    } 

    $categories = $stmt2->fetchAll(); 

    } 
?>
<table class="table table-condensed table-hover forumtable"> 
    <thead>
    <tr>  
        <th>Title</th>
        <th>User</th>
        <th>Category</th>
        <th>Time</th>
    </tr>
    </thead>
    <?php foreach($rows as $row) {?>
        <tr class="clickable-row" id="<?php echo 'tid'.htmlentities($row['id'], ENT_QUOTES, 'UTF-8');?>">
            <td><?php echo htmlentities($row['title'], ENT_QUOTES, 'UTF-8');?></td>
            <td class="tForumTimeField"><?php echo htmlentities($row['username'], ENT_QUOTES, 'UTF-8');?></td>
            <td class="tForumTimeField"><?php echo htmlentities($row['category'], ENT_QUOTES, 'UTF-8')."/".htmlentities($row['subcategory'], ENT_QUOTES, 'UTF-8');?></td>
            <td class="tForumTimeField"><?php echo htmlentities($row['date'], ENT_QUOTES, 'UTF-8');?></td>
        </tr>
    <?php } ?>
</table>
<form>
    <label for="titlefield">Create a post:</label>
     <select name="categorySelectPost" id="categorySelectPost" style="width: 253px;" required>
        <option value="" disabled selected>Select a category</option>
        <?php foreach($categories as $row) {?> 
        <option value="<?php echo htmlentities($row['subcatid'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlentities($row['category'], ENT_QUOTES, 'UTF-8')."/".htmlentities($row['subcategory'], ENT_QUOTES, 'UTF-8');?></option>
        <?php } ?>
    </select>
    <input type="text" class="form-control" name="titlefield" id="titlefield" placeholder="Title">
    <textarea name="postfield" id="postfield" class="form-control status-box" rows="5" style="resize:none" placeholder="Write a post"></textarea>
    <button type="button" class="btn btn-primary" id="submitpost">Post</button>
</form>
