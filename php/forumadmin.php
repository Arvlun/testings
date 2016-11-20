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
?> 
<div>
<form>
    <label for="catfield">Create category</label>
    <input type="text" class="form-control" name="catfield" id="catfield" placeholder="Title">
    <textarea name="catdescfield" id="catdescfield" class="form-control status-box" rows="5" style="resize:none" placeholder="Description"></textarea>
    <button type="button" class="btn btn-primary" id="savecat">Add</button>
</form><br>
<hr><br>
<form>
    <label for="subcatfield">Create subcategory:</label>
    <input type="text" class="form-control" name="subcatfield" id="subcatfield" placeholder="Title">
    <label for="categoryselect">Parent category:</label><br>
    <select name="categorySelect" id="categorySelect" style="width: 253px;">
        <?php foreach($rows as $row) {?> 
        <option value="<?php echo htmlentities($row['category'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlentities($row['category'], ENT_QUOTES, 'UTF-8');?></option>
        <?php } ?>
    </select>
    <textarea name="subcatdescfield" id="subcatdescfield" class="form-control status-box" rows="5" style="resize:none" placeholder="Description"></textarea>
    <button type="button" class="btn btn-primary" id="savesubcat">Add</button>
</form>
