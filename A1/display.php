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
$number = GET("Number", $flag);
$mail = GET("Mail", $flag);

$to = "";
$subject = "Display Transactions Output";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

if ($flag){
	exit("<br>Failed.");
}

// Authenticate
if(!authenticate($ucid, $pass, $db)){
	exit("<br>Invalid credentials!");
}else{
	echo"Account verified, access granted!<br><br>";
}

// Display Transactions
displayTT($ucid, $number, $output, $db);

if($mail == "Y"){
	mail($to, $subject, $output, $headers);
	echo "<br>Email sent with the following: <br>$output";
}else{
	echo "<br>No Email sent. Generated table: <br>$output";
}

date_default_timezone_set ("America/New_York");
$date = date("l jS \of F Y h:i:s A");

mysqli_free_result($t);
mysqli_close($db);
?>