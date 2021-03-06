<?php
require ( "account.php" );
include ( "myfunctionsA2.php" );

session_set_cookie_params(0, "", "");
session_start();

if (!isset($_SESSION["Verified"])){
	echo "<br> You are not logged in! You will be redirected in 5 seconds...<br><br>";
	header("refresh: 5; url = A2Login.html");
	exit();
}

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors' , 1);

$db = mysqli_connect ($hostname, $username, $password, $project);

if (mysqli_connect_errno())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error ( );
		exit ();
	}
echo "Successfully connected to MySQL.<br>";
echo "---------------------------------------<br><br>";
mysqli_select_db ($db, $project );

$flag = false;

$ucid = $_SESSION["UCID"];

echo "Welcome! <br><br> Processing the display.php page for $ucid. <br><br>";

$account = GET("Account", $flag);

if($flag){
	echo ("<br>Failed.<br> Redirecting you back to display.php...");
	header("refresh: 3; url = A2Display.php");
	exit();
}
displayAA($ucid, $account, $output, $db);
echo $output;

displayTT($ucid, $account, $output, $db);
echo $output;
echo "<br><br>";
?>

<!DOCTYPE html>
<meta charset = "UTF-8">
<style>
td {color: #e50b16;}
tr:nth-child(odd){background-color: lightgrey}
</style>
<a href="A2Display.php">Display Page</a><br><br>

<a href="Logout.php">
<input type=button value="Logout" id="Logout"></a><br><br>
<input type=checkbox checked="checked" id="stopLogout">Stop inactivity timer<br><br>

<script type="text/javascript">

"use strict";
var timer1;
var ptrbox = document.getElementById("stopLogout");

document.onload = resetTimer;
document.onmousemove = resetTimer;
document.onclick = resetTimer;
document.onkeypress = resetTimer;
document.onscroll = resetTimer;
document.onwheel = resetTimer;

function resetTimer(){
	clearTimeout(timer1);
	timer1 = setTimeout(logout, 4000);
}


function logout(){
	if (!ptrbox.checked){ 
		if (!confirm("You have been inactive for 4 seconds. Stay logged in?")){
			window.location.href = "Logout.php";
		}
	}
}

</script>