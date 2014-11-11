<?php
    include 'header.php';
    
    // already signed in
    if ($uid_isset && $uid_isvalid) {
        echo "Hi $user_name! You are already signed in. To register for a new user, please first sign out";
        //header("Location: localhost:8888/ztea");
    }
    else {
        // form not posted
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            $form_signup = <<<EOD
            <div class="body-title-font">
            <h3 class="body-title-font">Register</h3>
            <form method="post" action="">
            <input class="type-in" name="user_name" type="text" size=50 placeholder="Username"/><br/>
            <input class="type-in" name="user_pass" type="password" size=50 placeholder="Password"/><br/>
            <input class="type-in" name="user_pass_check" type="password" size=50 placeholder="Password"/><br/>
            <input class="type-in" name="user_email" type="email" size=50 placeholder="Email"/><br/>
            <input id="submit-form" type="submit" value="Sign up"/>
            </form>
            </div>
EOD;
            echo $form_signup;
        }
        // form has been posted
        else {
            /* so, the form has been posted, we'll process the data in three steps:
             1.  Check the data
             2.  Let the user refill the wrong fields (if necessary)
             3.  Varify if the data is correct and return the correct response
             */
            $errors = array(); /* declare the array for later use */
            
            if(isset($_POST['user_name']))
            {
                //the user name exists
                if(!ctype_alnum($_POST['user_name']))
                {
                    $errors[] = 'The username can only contain letters and digits.';
                }
                if(strlen($_POST['user_name']) > 30)
                {
                    $errors[] = 'The username cannot be longer than 30 characters.';
                }
            }
            else
            {
                $errors[] = 'The username field must not be empty.';
            }
            
            
            if(isset($_POST['user_pass']))
            {
                if($_POST['user_pass'] != $_POST['user_pass_check'])
                {
                    $errors[] = 'The two passwords did not match.';
                }
            }
            else
            {
                $errors[] = 'The password field cannot be empty.';
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
                $result = insertNewUser($_POST['user_name'], $_POST['user_pass'], $_POST['user_email']);
                if(!$result)
                {
                    //something went wrong, display the error
                    echo 'Something went wrong while registering. Please try again later.';
                    //echo mysql_error(); //debugging purposes, uncomment when needed
                }
                else
                {
                    //the query was successfully executed
                    $user_id = mysql_insert_id();
                    setcookie('user_id', $user_id, time() + (86400), "/"); // 86400 = 1 day
                    setcookie('user_name', $_POST['user_name'], time() + (86400), "/"); // 86400 = 1 day
                    setcookie('user_level', $_POST['user_level'], time() + (86400), "/"); // 86400 = 1 day
                    $user_name = $_POST['user_name'];
                    echo 'Hello ' . $user_name . ', thank you for joining us!';
                }
                closeDB();
            }
            
        }
    }
    
    require 'footer.php';
?>