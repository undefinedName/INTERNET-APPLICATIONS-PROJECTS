<?php
function authenticate ($ucid, $pass, $db){
	global $t;
	$s = "select * from AA where UCID = '$ucid' and Pass = '$pass'";
	echo "<br><br>SQL statement is: $s<br><br>";
	($t = mysqli_query($db, $s)) or die(mysqli_error($db));
	
	$num = mysqli_num_rows($t);
	if ($num == 0){
		return false;
	}else{
		return true;
	}
}

function GET($fieldname, &$flag){
	global $db ;
	$v = $_GET [$fieldname];
	$v = trim ( $v );
	if ($v == "") 
	  { $flag = true ; echo "<br><br>$fieldname is empty." ; return  ;} ;
	$v = mysqli_real_escape_string ($db, $v );
	echo "<br>$fieldname is $v."  ;
	return $v; 
}

function deposit ($ucid, $type, $amount, $mail, &$output, $db){
	global $t;
	
	$output = "";
	$s = "insert into TT values ('$ucid', '$type', '$amount', NOW(), '$mail')";
	$output .= "<br>SQL statement is: $s"; 	
	($t = mysqli_query ( $db, $s ))  or die( mysqli_error($db) );
	$output .= "<br>Successfully deposited $$amount in account.";
	
	$s = "update AA SET Current = '$amount' + Current, Recent = NOW() where UCID = '$ucid' ";
	$output .= "<br><br>SQL statement is: $s"; 
	($t = mysqli_query ( $db, $s ))  or die( mysqli_error($db) );
	$output .= "<br>Account updated with recent deposit.<br><br>";
}

function withdraw ($ucid, $type, $amount, $mail, &$output, $db){
	global $t;
	
	$output = "";
	$s = "insert into TT values ('$ucid', '$type', '$amount', NOW(), '$mail')";
	$output .= "<br>SQL statement is: $s"; 	
	($t = mysqli_query ( $db, $s ))  or die( mysqli_error($db) );
	$output .= "<br>Successfully withdrew $$amount from account.";
	
	$s = "update AA SET Current = Current - '$amount', Recent = NOW() where UCID = '$ucid' ";
	$output .= "<br><br>SQL statement is: $s"; 
	($t = mysqli_query ( $db, $s ))  or die( mysqli_error($db) );
	$output .= "<br>Account updated with recent withdraw.<br><br>";
}

function displayTT ($ucid, $number, &$output, $db){
	global $t;
	
	$output = "";
	$s = "select * from TT where UCID = '$ucid' ORDER BY Date DESC limit $number";
	$output .= "<br>SQL statement is: $s<br>";
	($t = mysqli_query($db, $s)) or die(mysqli_error($db));
	$num = mysqli_num_rows($t);
	if($number > $num){
		$output .= "<br>There were only $num rows retrieved from table TT.<br>";
	}else{
		$output .= "<br>$number rows retrieved from table TT.<br>";
	}
	
	if($number == 0){
		$output .= "<br>There are no rows for $ucid.<br>";
		return;
	}
	
	$output .= "<table border = 2 width = 30%>";
	$output .= "<th>UCID</th> <th>Type</th><th>Amount</th><th>Date</th><th>Mail</th>";
		while ($r = mysqli_fetch_array ($t, MYSQLI_ASSOC)){
			$output .= "<tr>";
			
			$ucid = $r["UCID"];
			$type = $r["Type"];
			$amount = $r["Amount"];
			$date = $r["Date"];
			$mail = $r["Mail"];
			
			$output .= "<td>$ucid</td><td>$type</td><td>$amount</td><td>$date</td><td>$mail</td>";
			
			$output .= "</tr>";
		};
	$output .= "</table>";
}

function enough ($ucid, $amount, $db){
	global $t;
	$s = "select * from AA where UCID = '$ucid' and Current >= '$amount'";
	echo "SQL statement is: $s<br><br>";
	($t = mysqli_query($db, $s)) or die(mysqli_error($db));
	
	$num = mysqli_num_rows($t);
	if ($num > 0){
		return true;
	}else{
		return false;
	}
}

function createUser($ucid, $pass, $name, $email, $initial, $repass, $db){
	global $t;
	$s = "insert into AA values ('$ucid', '$pass', '$name', '$email', '$initial', '$initial', NOW(), '$repass')";
	echo "<br><br>SQL statement is: $s";
	($t = mysqli_query ( $db, $s ))  or die( mysqli_error($db) );
}
?>