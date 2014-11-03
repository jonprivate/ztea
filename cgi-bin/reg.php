<?php
    require 'global.php';
    require 'cgi-bin/check_status.php';
    ?>

<!DOCTYPE html>
<html lang="en">
<!--
Header part
-->
<?php
    require 'parts/head.php';
    ?>

<!--
Body part
-->
<body>
<?php
    require 'parts/header.php';
    ?>

	<section>
	<?php
	if(!$uid_isset || !$uid_isvalid) {
		// access database and posted data
		$db = new SQLite3('users.db') or die('Unable to open database');
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		
		// check if the user already registered
		$check = "SELECT * FROM users WHERE username = '$username'";
		$result = $db->query($check);
		if($row = $result->fetchArray())
		{
			echo "Sorry, but you already exist<br/>";
			$link = <<<EOD
			<a href="../login.php">You can login here</a>
EOD;
			echo $link;
		} else
		{
			// insert the new user
			$query = <<<EOD
			INSERT INTO users VALUES ('$username', '$email', '$password');
EOD;
			$db->exec($query) or die("Unable to add user $username");

			echo "Welcome, $username!";
			$cookie_name = "uid";
			$cookie_value = $username; 
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
		}
		$db->close();
		echo "<br/>";
		/* Redirect browser */
		header("Location: http://jiong-liu.rochestercs.org/");

		/* Make sure that code below does not get executed when we redirect. */
		exit;
	}
	?>
	</section>

	<footer>
		<p>&copy; 2014 Jiong Liu and Juncheng Feng.</p>
	</footer>

</body>
</html>


