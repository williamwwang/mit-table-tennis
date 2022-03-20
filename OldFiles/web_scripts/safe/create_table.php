<?php

/* determine next practice date */

/* dates.txt is file containing dates copied and pasted from Sandy's confirmation email */

$handle = fopen("../dates.txt","r");
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
} else {
  echo "cannot find next practice date!";
  exit();
}

/* create table */

$sql = mysql_connect("sql.mit.edu", "tabletennis", "web23dis") or die(mysql_error());
mysql_select_db("tabletennis+club_hours_registration") or die(mysql_error());

$create = "CREATE TABLE ".$TABLE." (Name VARCHAR(50), Email VARCHAR(30))";

if (mysql_query($create)) {
   echo "created table ".$TABLE;
} else {
  echo "table probably exists already...";
}


/* old code - without .htaccess
if ($_SERVER['SSL_CLIENT_S_DN_CN']) {
   $has_cert = 1;
   $varName = $_SERVER['SSL_CLIENT_S_DN_CN'];
   $varEmail = $_SERVER['SSL_CLIENT_S_DN_Email'];

   // check certificates
   if ($varName == "Jessie T Zhang" || $varName == "Sherry (Mengjiao) Yang" || $varName == "Artem Timoshenko") {
      
      // create table for next practice
      $sql = mysql_connect("sql.mit.edu", "tabletennis", "web23dis") or die(mysql_error());
      mysql_select_db("tabletennis+club_hours_registration") or die(mysql_error());

      $create = "CREATE TABLE ".$TABLE." (Name VARCHAR(50), Email VARCHAR(30))";

      if (mysql_query($create)) {
      	 echo "created table ".$TABLE;
      } else {
      	 echo "table probably exists already...";
      }


      // send email
      $email = $NEXT_PRACTICE_INFO.'<br><br>Hope to see you there!<br><br>-Jessie';

      $headers  = 'MIME-Version: 1.0' . "\r\n";
      $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

      mail("mit-tt-open@mit.edu", "TT club hours", $email, $headers);

   }
}

*/









?>
