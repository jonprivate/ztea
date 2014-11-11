<?php
    include 'header.php';

    // already signed in
    if ($uid_isset && $uid_isvalid) {
        echo "Hi $user_name! You are already signed in.";
        //header("Location: localhost:8888/ztea");
    }
    else {
    // form not posted
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            $form_login = <<<EOD
            <div class="body-title-font">
            <h3 class="body-title-font">Log in</h3>
            <form method="post" action="">
            <input class="type-in" name="user_name" type="text" size=50 placeholder="Username"/><br/>
            <input class="type-in" name="user_pass" type="password" size=50 placeholder="Password"/><br/>
            <input id="submit-form" type="submit" value="Sign in"/>
            </form>
            </div>
EOD;
            echo $form_login;
        }
    // form has been posted
        else {
            /* so, the form has been posted, we'll process the data in three steps:
             1.  Check the data
             2.  Let the user refill the wrong fields (if necessary)
             3.  Varify if the data is correct and return the correct response
             */
            $errors = array(); /* declare the array for later use */
            
            if(!isset($_POST['user_name']))
            {
                $errors[] = 'The username field must not be empty.';
            }
            
            if(!isset($_POST['user_pass']))
            {
                $errors[] = 'The password field must not be empty.';
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
                //the form has been posted without errors, so save it
                require_once 'db_query.php';
                connectToDB();
                $result = checkUsersWithNamePassPair($_POST['user_name'], $_POST['user_pass']);
                closeDB();
                if(!$result)
                {
                    //something went wrong, display the error
                    echo 'Something went wrong while signing in. Please try again later.';
                    //echo mysql_error(); //debugging purposes, uncomment when needed
                }
                else
                {
                    //the query was successfully executed, there are 2 possibilities
                    //1. the query returned data, the user can be signed in
                    //2. the query returned an empty result set, the credentials were wrong
                    if(mysql_num_rows($result) == 0)
                    {
                        echo 'You have supplied a wrong user/password combination. Please try again.';
                    }
                    else
                    {
                        while($row = mysql_fetch_assoc($result)){
                            setcookie('user_id', $row['user_id'], time() + (86400), "/"); // 86400 = 1 day
                            setcookie('user_name', $row['user_name'], time() + (86400), "/"); // 86400 = 1 day
                            setcookie('user_level', $row['user_level'], time() + (86400), "/"); // 86400 = 1 day
                            $user_name = $row['user_name'];
                        }
                        echo 'Hello ' . $user_name . ', welcome back!';
                    }
                }
            }
            
        }
    }

    require 'footer.php';
?>