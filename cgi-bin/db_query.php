<?PHP
    function connectToDB($db_name) {
        $servername = "localhost";
        $username = "jiongliu";
        $password = "Jon528240@b";
        
        // Create connection
        global $conn;
        $conn = new mysqli($servername, $username, $password, $db_name);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        return $conn;
    }
    
    function showTable($conn, $table_name) {
        $sql = "SELECT * FROM " . $table_name;
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "username: " . $row["username"]. " ------ email: " . $row["email"]. " ------ password: " . $row["password"]. "<br>";
            }
        } else {
            echo "0 results";
        }
    }
    
    function checkTable($conn, $table_name, $item_name, $item_value) {
        $sql = "SELECT * FROM $table_name WHERE $item_name = '$item_value'";
        $result = $conn->query($sql) or die('fail<br/>');
        if($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function checkTable2($conn, $table_name, $item_name1, $item_value1, $item_name2, $item_value2) {
        $sql = "SELECT * FROM $table_name WHERE $item_name1 = '$item_value1' AND $item_name2 = '$item_value2'";
        $result = $conn->query($sql) or die('fail<br/>');
        if($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }

    function insertIntoTable($conn, $table_name, $username, $email, $password) {
        $sql = "INSERT INTO " . $table_name . " (username, email, password) VALUES ('" . $username . "', '" . $email . "', '" . $password . "')";
        
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    

    function updateTable($conn, $table_name, $up_name, $up_value, $id_key, $id_value) {
	    $sql = "UPDATE $table_name SET $up_name = '$up_value' WHERE $id_key = '$id_value'";
	    if ($conn->query($sql) === FALSE) {
		    echo "Error updating record: " . $conn->error;
	    }
    } 
    
    function closeDB($conn) {
        mysql_close($conn);
    }
?>
