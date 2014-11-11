<?PHP
    function connectToDB() {
        /*// for bluehost
        $servername = "localhost";
        $username = "jon";
        $password = "jon";
        $db_name = "jiongliu_users";
         */
        // for mamp
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $db_name = "users";
        
        // Create connection
        if(!mysql_connect($servername, $username,  $password))
        {
            exit('Error: could not establish database connection');
        }
        if(!mysql_select_db($db_name))
        {
            exit('Error: could not select the database');
        }
    }
    
    function showTable($table_name) {
        $sql = "SELECT * FROM " . $table_name;
        $result = mysql_query($sql);
        
        if (!$result) {
            echo "0 results";
        } else {
            // output data of each row
            while($row = mysql_fetch_assoc($result)) {
                echo "user_id: " . $row["user_id"]. " ------ user_name: " . $row["user_name"]. " ------ user_pass: " . $row["user_pass"]. " ------ user_email: " . $row["user_email"]. " ------ user_level: " . $row["user_level"]. "<br>";
            }
        }
    }
    
    function checkUsersWithID($user_id) {
        $sql = "SELECT user_id, user_name, user_level FROM users
        WHERE user_id = '" . mysql_real_escape_string($user_id) . "'";
        $result = mysql_query($sql);
        
        if(!$result) {
            return false;
        }
        if(mysql_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function checkUsersWithNamePassPair($user_name, $user_pass) {
        $sql = "SELECT user_id, user_name, user_level FROM users WHERE
        user_name = '" . mysql_real_escape_string($user_name) . "'
        AND
        user_pass = '" . sha1($user_pass) . "'";
        
        $result = mysql_query($sql);
        
        return $result;
    }
    
    function insertNewUser($user_name, $user_pass, $user_email) {
        $sql = "INSERT INTO
        users(user_name, user_pass, user_email ,user_date, user_level)
        VALUES('" . mysql_real_escape_string($user_name) . "',
               '" . sha1($user_pass) . "',
               '" . mysql_real_escape_string($user_email) . "',
               NOW(),
               0)";
        
        $result = mysql_query($sql);

        return $result;
    }
    
    function updateUserPass($user_id, $new_pass) {
        $sql = "UPDATE users SET user_pass = '" . sha1($new_pass ). "' WHERE user_id = '" . mysql_real_escape_string($user_id) . "'";
        
        $result = mysql_query($sql);
        
        return $result;
    }
    
    function closeDB() {
        mysql_close();
    }
?>