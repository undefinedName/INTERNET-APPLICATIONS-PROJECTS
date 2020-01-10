<?php

session_set_cookie_params(0, "", "");
session_start();

$sidval = session_id();
echo "The session ID was: " . $sidval . "<br><br>";

$_SESSION = array();
session_destroy();

setcookie("PHPSESSID", "", time()-3600, "", "", 0, 0);

echo "Session has been terminated. <br><br>";
?>

<!DOCTYPE html>
<meta charset = "UTF-8">

<a href="A2Login.html">Login Page</a><br><br>