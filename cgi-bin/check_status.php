<?PHP
    require_once __DIR__ . "/../global.php";
    $cookie_name = "uid";
    $uid_isset = false;
    $uid_isvalid = false;
    if(!isset($_COOKIE[$cookie_name])) {
        $uid_isset = false;
    } else {
        $uid_isset = true;
        $db_name = 'users';
        $table_name = 'users';
        $conn = connectToDB($db_name);
        $uid = $_COOKIE[$cookie_name];
        $uid_isvalid = checkTable($conn, $table_name, 'username', $uid);
        $closeDB($conn);
    }
?>