<html>

<head><title>aa</title></head>

<body>
<p>
<b>Next practice: XXXX</b><br>
<b>Attending:</b><br>
<?php

$TABLE = "test";

$JOIN = 1;
$CANCEL = -1;
$NEUTRAL = 0;

/*
if (!$_GET['state']==NULL) {
   $state = $_GET['state'];
} elseif (!$_GET['state_c']==NULL) {
   $state = $CANCEL;
} elseif (!$_GET['state_j']==NULL) {
   $state = $JOIN;
} else {
   $state = $NEUTRAL;
}
print $state;*/
/*
if ($_GET['state']==NULL) {
   $state = $NEUTRAL;
   print "bye";
} else {
  $state = $_GET['state'];
}*/
  


if ($_SERVER['SSL_CLIENT_S_DN_CN']) {
   $has_cert = 1;
   $varName = $_SERVER['SSL_CLIENT_S_DN_CN'];
   $varEmail = $_SERVER['SSL_CLIENT_S_DN_Email'];

   if ($_GET['state']==NULL) {
     $state = $NEUTRAL;
   } else {
     $state = $_GET['state'];
   }
} else { 
   $has_cert = 0; 
//   if (!$_GET['fName_j']==NULL) $varName = $_GET['fName_j'];
//   if (!$_GET['fName_c']==NULL) $varName = $_GET['fName_c'];
//   $varEmail = "";

   if ($_GET['button']=="Join!") {
     $state = $JOIN;
     if (!$_GET['fName_j']==NULL) {
        $varName = $_GET['fName_j'];
     } else { $state = $NEUTRAL; }
   } elseif ($_GET['button']=="Delete") {
     $state = $CANCEL;
     if(!$_GET['fName_c']==NULL) {
        $varName = $_GET['fName_c'];
     } else { $state = $NEUTRAL; }
   } else {
     $state = $NEUTRAL;
   }

   $varEmail = "";
}

   $sql = mysql_connect("sql.mit.edu", "tabletennis", "web23dis") or die(mysql_error());
   mysql_select_db("tabletennis+club_hours_registration") or die(mysql_error());

   $results = mysql_query("SELECT * FROM " . $TABLE) or die(mysql_error());
   $registered = 0;
   while($row = mysql_fetch_array($results)) {
	if ($varName === $row['Name']) {
	   $registered = 1;
	}
   }

   if (!$registered && $state==$JOIN) { 
      mysql_query("INSERT INTO " . $TABLE . " (Name, Email) VALUES ('{$varName}', '{$varEmail}')") or die(mysql_error());
   } elseif ($registered && $state==$CANCEL) {
      mysql_query("DELETE FROM " .$TABLE . " WHERE `Name` = '{$varName}'") or die(mysql_error());
   }

   $results = mysql_query("SELECT * FROM " . $TABLE) or die(mysql_error());
   $registered = 0;
   while($row = mysql_fetch_array($results)) {
   	/* print $row['Name'] . " " . $row['Email'];
	print "<br>";*/
        print $row['Name'] . "; ";
	if ($varName === $row['Name']) {
	   $registered = 1;
	}
   }


if ($has_cert) {
   if (!$registered) { ?>
      <form method='GET'><input type="hidden" name="state" value=1><input type="submit" value="Join!"></form>
   <?php } else { ?>
      <form method='GET'><input type="hidden" name="state" value=-1> <input type="submit" value="Cancel sign up"></form>
   <?php }
} else {

  ?>
     <form method='GET'>
     <label>Name: </label>  <input type="text" size="20" autofocus="autofocus" name="fName_j">
     <input type="submit" name="button" value="Join!">
     <br>
     <form method='GET'>
     <label>Cancel sign up: </label><input type="text" size="20" autofocus="autofocus" name="fName_c">
     <input type="submit" name="button" value="Delete"></form>
  <?php
}


mysql_close($sql);
?>

</p>

</body>

</html>
