<?php
    include 'header.php';
    
    if(!$uid_isset || !$uid_isvalid) {
        // access database and posted data
        $link = <<<EOD
        <a href="/ztea/login.php">Please first log in :)</a>
EOD;
        echo $link;
    }
    else {
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            $form_reg = <<<EOD
            <div class="body-title-font">
            <h3 class="body-title-font">Update your password</h3>
            <form method="post" action="">
            <input class="type-in" name="user_pass" type="password" size="50" placeholder="Old password"/><br/>
            <input class="type-in" name="user_pass_new" type="password" size="50" placeholder="New password"/><br/>
            <input class="type-in" name="user_pass_check" type="password" size="50" placeholder="New password"/><br/>
            <input id="submit-form" type="submit" value="Update"/>
            </form>
            </div>
EOD;
            echo $form_reg;
        }
        else {
            /* so, the form has been posted, we'll process the data in three steps:
             1.  Check the data
             2.  Let the user refill the wrong fields (if necessary)
             3.  Varify if the data is correct and return the correct response
             */
            $errors = array(); /* declare the array for later use */
            if(!isset($_POST['user_pass'])) {
                $errors[] = 'The old password field must not be empty';
            }
            if(!isset($_POST['user_pass_new'])) {
                $errors[] = 'The new password field must not be empty';
            }
            else {
                if($_POST['user_pass_new'] != $_POST['user_pass_check']) {
                    $errors[] = 'The two passwords did not match.';
                }
            }
            
            if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
            {
                echo 'Uh-oh.. a couple of fields are not filled in correctly..';
                echo '<ul>';
                foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
                {
                    echo '<li>' . $value . '</li>'; /* this generates a nice error list */
                }
                echo '</ul>';
            }
            else {
                // the form has been posted without errors, so save it
                require_once 'db_query.php';
                connectToDB();
                $result = checkUsersWithNamePassPair($user_name, $_POST['user_pass']);
                if(!$result) {
                    //something went wrong, display the error
                    echo 'Something went wrong while verifying your account. Please try again later.';
                    //echo mysql_error(); //debugging purposes, uncomment when needed
                }
                else {
                    if(mysql_num_rows($result) == 0) {
                        echo 'You have supplied a wrong password. Please try again.';
                    }
                    else {
                        $result = updateUserPass($user_id, $_POST['user_pass_new']);
                        if(!$result)
                        {
                            //something went wrong, display the error
                            echo 'Something went wrong while updating your password. Please try again later.';
                            //echo mysql_error(); //debugging purposes, uncomment when needed
                        }
                        else
                        {
                            //the query was successfully executed
                            echo 'Your new password has been set!';
                        }
                    }
                }
                closeDB();
            }
        }
    }


    require 'footer.php';
?>



