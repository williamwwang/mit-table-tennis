<?php
  
if ($_SERVER['SSL_CLIENT_S_DN_CN']) {

   // check if has certificate
   $has_cert = 1;
   $varName = $_SERVER['SSL_CLIENT_S_DN_CN'];

   // check if is Jessie
   if ($varName == "Jessie T Zhang") {

   // table named by date
   $TABLE = 't'.date('ymd');

   $sql = mysql_connect("sql.mit.edu", "tabletennis", "web23dis") or die(mysql_error());
   mysql_select_db("tabletennis+club_hours_registration") or die(mysql_error());

   $create = "CREATE TABLE ".$TABLE." (Name VARCHAR(50), Email VARCHAR(30))";

   if (mysql_query($create)) {
      echo "done!";
   } else {
      echo "error querying ";
      echo $create;
   }

   $next_practice = fopen("NextPractie.php", "r+") or die("failed");

   // line 68 and line 72
   $time_and_location = date('F j, o,');
   if(strpos($time_and_location,'Tuesday') !== false || strpos($time_and_location, 'Thursday') !== false) {
   $time_and_location = $time_and_location.' T-club lounge';
} else {
  $time_and_location = $time_and_location.' duPont gym';
}


   }
}
?>