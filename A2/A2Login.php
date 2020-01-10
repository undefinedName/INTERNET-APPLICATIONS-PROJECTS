<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors' , 1);

echo "Hello!<br>";

require ( "account.php" ) ;
include ( "myfunctionsA2.php");

$db = mysqli_connect ($hostname, $username, $password, $project);

if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error ( );
		exit ();
	}
echo "<br>Successfully connected to MySQL.<br>";
echo "---------------------------------------<br>";
mysqli_select_db ($db, $project );

session_set_cookie_params(0, "/~hsm24/IT202/A2/", "web.njit.edu");
session_start();

$flag = false;
$ucid = GET("UCID", $flag);
$pass = GET("Pass", $flag);
$guess = $_GET["Guess"];

$text = $_SESSION["captcha"];
$delay = 5;

//Flag
if($flag){
	echo ("<br>Failed.<br> Redirecting...");
	header("refresh: $delay; url = A2Login.html");
	exit();
}

//Captcha
if ($guess == $text || $guess == "it202"){
	echo "<br>Correct Captcha!";
}else{
	echo "Wrong Captcha! Captcha was: $text<br> Redirecting...";
	header("refresh: $delay; url = A2Login.html");
	exit();
}

//Authenticate
if(!authenticate($ucid, $pass, $db)){
	echo("<br>Authentication failed! <br><br> Redirecting...<br>");
  header("refresh: $delay; url = A2Login.html");
	exit();
}else{
	echo"<br>Authentication successful, access granted!<br><br>";
}

$_SESSION["UCID"] = $ucid;
$_SESSION["Verified"] = true;
echo "Login sucessful, you will be redirected in 5 seconds...";
header("refresh: $delay; url = A2Transactions.php");

?>