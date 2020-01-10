<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors' , 1);

echo "Hello!<br>";

require ( "account.php" ) ;
include ( "myfunctions.php");

$db = mysqli_connect ($hostname, $username, $password, $project);

if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error ( );
		exit ();
	}
echo "<br>Successfully connected to MySQL.<br>";
echo "---------------------------------------<br>";
mysqli_select_db ($db, $project );

$flag = false;

$ucid = GET("UCID", $flag);
$pass = GET("Pass", $flag);
$name = GET("Name", $flag);
$email = Get("Email", $flag);
$initial = GET("Initial", $flag);
$repass = GET("RePass", $flag);

if ($flag){
	exit("<br>Failed.");
}

// Create Account
createUser($ucid, $pass, $name, $email, $initial, $repass, $db);

date_default_timezone_set ("America/New_York");
$date = date("l jS \of F Y h:i:s A");

echo "<br><br>Account created for $name at $date!";

mysqli_close($db);
?>