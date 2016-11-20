<?php 
    require("common.php"); 
    if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: login.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to login.php"); 
    } 
     
    $query = " 
        SELECT 
            forumposts.title AS title,
            forumposts.id AS id,  
            forumposts.content AS content, 
            forumposts.date AS date,
            forumposts.parentpost AS respto, 
            users.username AS username, 
            forumsubcategories.title AS category, 
            forumcategories.title AS subcategory 
        FROM 
            forumposts, 
            forumsubcategories, 
            forumcategories, 
            users 
        WHERE
            (forumposts.id = :id OR
            forumposts.parentpost = :id) AND
            idSubcategory=forumsubcategories.id AND 
            idUser=users.id AND 
            idCategory=forumcategories.id
        ORDER BY forumposts.date ASC;
    ";

    $query_params = array( 
                ':id' => $_POST['id'] 
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
         
    // Finally, we can retrieve all of the found rows into an array using fetchAll 
    $rows = $stmt->fetchAll();
?>
<?php foreach($rows as $row) {?>
    <table class="table"> 
        <thead>
        <tr>  
            <th><?php echo "Title: ".htmlentities($row['title'], ENT_QUOTES, 'UTF-8')." -- Written by: ".htmlentities($row['username'], ENT_QUOTES, 'UTF-8')." -- At: ".htmlentities($row['date'], ENT_QUOTES, 'UTF-8');?></th>
        </tr>
        </thead>
    
        <tr>
            <td><?php echo htmlentities($row['content'], ENT_QUOTES, 'UTF-8');?></td>
        </tr>
    </table>
<?php } ?>
<form>
    <label for="replytitlefield">Create a post:</label>
    <input type="text" class="form-control" name="replytitlefield" id="replytitlefield" placeholder="Title">
    <textarea name="replyfield" id="replyfield" class="form-control status-box" rows="5" style="resize:none" placeholder="Write a reply"></textarea>
    <input type="hidden" class="form-control" name="replypostid" id="replypostid" value="<?php echo htmlentities($rows[0]['id'], ENT_QUOTES, 'UTF-8');?>">
    <button type="button" class="btn btn-primary" id="submitreply">Reply</button>
</form>