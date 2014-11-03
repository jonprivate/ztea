<?PHP
    function connectToDB($db_name) {
        $servername = "localhost";
        $username = "jon";
        $password = "jon";
        
        // Create connection
        global $conn;
        $conn = new mysqli($servername, $username, $password, $db_name);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        echo "Connected successfully";
        echo "<br/>";
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
    
    function checkTale($conn, $table_name, $item_name, $item_value) {
        $sql = "SELECT * FROM $table_name WHERE $item_name = '$item_value'";
        $result = $conn->query($sql) or die('fail<br/>');
        if($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function insertIntoTable($conn, $table_name, $username, $email, $password) {
        $sql = "INSERT INTO " . $table_name . " (username, email, password) VALUES ('" . $username . "', '" . $email . "', '" . $password . "')";
        
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully<br/>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    function closeDB($conn) {
        $conn->close();
    }
?>