<?php
    include 'header.php';
    include 'forum_nav.php';
    require_once 'db_query.php';
    connectToDB();
    /*
    echo '<tr>';
    echo '<td class="leftpart">';
    echo '<h3><a href="category.php?id=">Category name</a></h3> Category description goes here';
    echo '</td>';
    echo '<td class="rightpart">';
    echo '<a href="topic.php?id=' . '">Topic subject</a> at 10-10';
    echo '</td>';
    echo '</tr>';*/
    echo '<h2>Create a category</h2>';
    
        
        if($_SERVER['REQUEST_METHOD'] != 'POST')
        {
            //the form hasn't been posted yet, display it
            echo '<form method="post" action="">
            Category name: <input type="text" name="cat_name" /><br/>
            Category description: <br/><textarea name="cat_description" /></textarea><br/>
            <input type="submit" value="Add category" />
            </form>';
        }
        else
        {
            //the form has been posted, so save it
            $sql = "INSERT INTO categories(cat_name, cat_description)
            VALUES('" . mysql_real_escape_string($_POST['cat_name']) . "',
                   '" . mysql_real_escape_string($_POST['cat_description']) . "')";
                   
            $result = mysql_query($sql);
               if(!$result)
               {
               //something went wrong, display the error
               echo 'Error' . mysql_error();
               }
               else
               {
                   $catid = mysql_insert_id();
               echo 'New category successfully added. <a href="category.php?id=' . $catid . '">Your new category</a>.';
               }
        }
                   
    include 'footer.php';
    closeDB();
?>