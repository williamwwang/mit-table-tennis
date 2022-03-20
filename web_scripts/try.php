<html>
<head><title>dd</title></head>
<body>
<p>

<?php 
echo $_SESSION['name'];
if (@$_SERVER['SSL_CLIENT_S_DN_CN']){
$varName = $_SERVER['SSL_CLIENT_S_DN_CN'];
$varEmail = $_SERVER['SSL_CLIENT_S_DN_EMAIL'];
} else {
print 'no certificate';
} 

$sql = mysql_connect("sql.mit.edu", "tabletennis", "web23dis") or die(mysql_error());
mysql_select_db("tabletennis+club_hours_registration") or die(mysql_error());

$results = mysql_query("SELECT * FROM test") or die(mysql_error());

$bool = 1;
while($row = mysql_fetch_array($results)) {
   if ($row['Name'] === $varName) {
   $bool = 0;
   break;
   }
}

if ($bool == 1) {
   mysql_query("INSERT INTO test (Name, Email) VALUES ('{$varName}', '{$varEmail}')") or die(mysql_error());
}

include('list.php');


print "hello";


mysql_close($sql);

?>

</p>
</body>
</html>
