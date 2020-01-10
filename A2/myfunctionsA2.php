<?php
function authenticate ($ucid, $pass, $db){
	global $t;
	$s = "select * from AA where UCID = '$ucid'";
	echo "<br><br>SQL statement is: $s<br><br>";
	($t = mysqli_query($db, $s)) or die(mysqli_error($db));
	$r = mysqli_fetch_array($t, MYSQLI_ASSOC);
	
	$num = mysqli_num_rows($t);
	//echo "The number of rows retrieved for $ucid is $num. <br><br>";
	
	$hash = $r['PHash'];
	//echo "The stored hashed password for $ucid is $hash. <br><br>";
	
	if (password_verify($pass, $hash)){
		echo "Valid password!";
		return true;
	}else{
		echo "Invalid password!";
		return false;
	}
}

function GET($fieldname, &$flag){
	global $db ;
	$v = $_GET [$fieldname];
	$v = trim ( $v );
	if ($v == "") 
	  { $flag = true ; echo "<br><br>$fieldname is empty." ; return  ;} ;
	$v = mysqli_real_escape_string ($db, $v );
	//echo "<br>$fieldname is $v."  ;
	return $v; 
}

function displayAA ($ucid, $account, &$output, $db){
	global $t;
	
	$output = "";
	$s = "select * from AA where UCID = '$ucid' and Account = '$account'";
	$output .= "<br>SQL statement is: $s<br>";
	($t = mysqli_query($db, $s)) or die(mysqli_error($db));
	$num = mysqli_num_rows($t);
	if($num == 0){
		$output .= "<br>There are no rows for $ucid with account: $account.<br>";
		return;
	}
	
	$output .= "<table border = 2 width = 30%> ";
	$output .= "<th>UCID</th><th>Account</th><th>PHash</th><th>Name</th><th>Email</th><th>Initial</th>
				<th>Current</th><th>Recent</th><th>Plaintext</th>";
		while ($r = mysqli_fetch_array ($t, MYSQLI_ASSOC)){
			$output .= "<tr>";
			
			$ucid = $r["UCID"];
			$account = $r["Account"];
			$phash = $r["PHash"];
			$name = $r["Name"];
			$mail = $r["Email"];
			$initial = $r["Initial"];
			$current = $r["Current"];
			$recent = $r["Recent"];
			$pass = $r["Plaintext"];
			
			$output .= "<td>$ucid</td><td>$account</td><td>$phash</td><td>$name</td><td>$mail</td>
						<td>$initial</td><td>$current</td><td>$recent</td><td>$pass</td>";
			
			$output .= "</tr>";
		};
	$output .= "</table>";
}

function displayTT ($ucid, $account, &$output, $db){
	global $t;
	
	$output = "";
	$s = "select * from TT where UCID = '$ucid' and Account = '$account' ORDER BY Date DESC";
	$output .= "<br>SQL statement is: $s<br>";
	($t = mysqli_query($db, $s)) or die(mysqli_error($db));
	$num = mysqli_num_rows($t);
	if($num == 0){
		$output .= "<br>There are no rows for $ucid with account: $account.<br>";
		return;
	}
	
	$output .= "<table border = 2 width = 30%>";
	$output .= "<th>UCID</th><th>Account</th><th>Type</th><th>Amount</th><th>Date</th><th>Mail</th>";
		while ($r = mysqli_fetch_array ($t, MYSQLI_ASSOC)){
			$output .= "<tr>";
			
			$ucid = $r["UCID"];
			$account = $r["Account"];
			$type = $r["Type"];
			$amount = $r["Amount"];
			$date = $r["Date"];
			$mail = $r["Mail"];
			
			$output .= "<td>$ucid</td><td>$account</td><td>$type</td><td>$amount</td><td>$date</td><td>$mail</td>";
			
			$output .= "</tr>";
		};
	$output .= "</table>";
}
?>