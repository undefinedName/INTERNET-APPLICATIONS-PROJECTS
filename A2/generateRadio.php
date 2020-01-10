<?php
$s = "select * from AA where UCID = '$ucid'";
($t = mysqli_query($db, $s)) or die(mysqli_error($db));

while ($r = mysqli_fetch_array($t, MYSQLI_ASSOC)){
	$account = $r['Account'];
	$current = $r['Current'];
	echo "UCID $ucid Account $account Current $current <input type=radio name=\"Account\" id=\"$account\" value=\"$account\"> <br>";
}
?>