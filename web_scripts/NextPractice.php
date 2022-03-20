<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<title>MIT - TABLE TENNIS CLUB </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="formatting.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="755" border="0" align="center" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td>
<table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
<tbody>
<tr>
<td width="16%"><a href="index.html"><img src="../IMAGES/mitlogo.gif" width="117" height="68" border="0" /></a></td>
<td width="64%" valign="bottom" class="top"><em><strong><a href="index.html"><img src="../IMAGES/MIT1.jpg" width="388" height="58" /></a> </strong></em></td>
<td align="left" valign="baseline" class="top">
<blockquote>
<p style="font-family:verdana;font-size:10
 px;color:red;">&nbsp;</p>
</blockquote>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
<tr>
<td height="309">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="middlepicture">
<tbody>
<tr>
<td width="571" valign="top"><img src="http://mit.edu/tabletennis/IMAGES/BridgeRoadMap.JPG" width="581" height="214" /></td>
<td width="10" valign="top">&nbsp;</td>
<td width="174" valign="top">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="rightbar">
<tbody>
<tr>
<td height="35" bgcolor="#3C73BA" class="bottomwhiteborder"><a href="http://mit.edu/tabletennis/AboutUs.html">About Us</a></td>
</tr>
<tr>
<td height="35" bgcolor="#4A7DC0" class="bottomwhiteborder"><a href="http://mit.edu/tabletennis/PracticeSchedule.html">Club Hours</a></td>
</tr>
<tr>
<td height="35" bgcolor="#588AC9" class="bottomwhiteborder"><a href="http://mit.edu/tabletennis/TeamNews.html">Team News</a></td>
</tr>
<tr>
<td height="35" bgcolor="#6997D2" class="bottomwhiteborder"><a href="http://mit.edu/tabletennis/Tournament.html">Tournaments</a></td>
</tr>
<tr>
<td height="35" bgcolor="79A4DA" class="bottomwhiteborder"><a href="http://mit.edu/tabletennis/Gallery_Club.html">Photo Gallery</a></td>
</tr>
<tr>
<td height="36" bgcolor="#8BB2E3" style="padding-left:10px"><a href="http://mit.edu/tabletennis/ContactUs.html">Join / Contact Us</a></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

<p>
<b>Next practice: </b><br><br>
<?php 
// find next practice time
$handle = fopen("dates.txt","r");
if ($handle) {
   $n = 0;
   while (($line = fgets($handle)) !== false) {
   	if (!($n % 2)) {
	    $line_date = strtotime($line);
	    $now = strtotime("now");
	    if ($now < $line_date) { // first line later than today
	       $NEXT_PRACTICE_INFO = $line."<br>".fgets($handle);
               $TABLE = "t".date('ymd',$line_date);
	       break;	       
	    }
	 }
   	 $n = $n+1;
   }
   fclose($handle);
   echo $NEXT_PRACTICE_INFO;
} else {
  echo "";
}

?>
<br><br>
<b>Attending:</b><br><br>
<?php

/* I do not remember how this code works because I did not comment it when I was writing =P.
But it works.
Somehow a mini state machine that does different things whether you have a certificate or not, and if you've joined already etc.
*/

$JOIN = 1;
$CANCEL = -1;
$NEUTRAL = 0;

// for some reason this code does not work in Safari -- might add code to check
// !preg_match('Safari', $_SERVER['HTTP_USER_AGENT'])
  
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
        $varName = htmlspecialchars($_GET['fName_j']);
     } else { $state = $NEUTRAL; }
   } elseif ($_GET['button']=="Delete") {
     $state = $CANCEL;
     if(!$_GET['fName_c']==NULL) {
        $varName = htmlspecialchars($_GET['fName_c']);
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
      $varname = mysql_real_escape_string($varName);
      mysql_query("INSERT INTO " . $TABLE . " (Name, Email) VALUES ('{$varName}', '{$varEmail}')") or die(mysql_error());
   } elseif ($registered && $state==$CANCEL) {
      $varName = mysql_real_escape_string($varName);
      mysql_query("DELETE FROM " .$TABLE . " WHERE `Name` = '{$varName}'") or die(mysql_error());
   }

   $results = mysql_query("SELECT * FROM " . $TABLE) or die(mysql_error());
//   $results = mysql_real_escape_string($results);
   $registered = 0;
   while($row = mysql_fetch_array($results)) {
   	/* print $row['Name'] . " " . $row['Email'];
	print "<br>";*/
        print $row['Name'] . "<br>";
	if ($varName === $row['Name']) {
	   $registered = 1;
	}
   }

print "<br>";

if ($has_cert) {
   if (!$registered) { ?>
      <form method='GET'><input type="hidden" name="state" value=1><input type="submit" value="Join!"></form>
   <?php } else { ?>
      <form method='GET'><input type="hidden" name="state" value=-1> <input type="submit" value="Cancel sign up"></form>
   <?php }
} else {

  ?>
     <form method='GET'>
     <label>Name: </label>  <input type="text" size="30" autofocus="autofocus" name="fName_j">&nbsp
     <input type="submit" name="button" value="Join!">
     <br>
     <form method='GET'>
     <label>Cancel sign up: </label><input type="text" size="20" autofocus="autofocus" name="fName_c">
     <input type="submit" name="button" value="Delete"></form>
  <?php
}


mysql_close($sql);
?>




</td>
</tr>
</tbody>
</table>
</body>
</html>

