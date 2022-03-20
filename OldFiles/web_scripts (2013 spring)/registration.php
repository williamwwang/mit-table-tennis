<?php

/**********************
***Write to MySql******
***********************/

$varName = $_POST['fName'];
if($_POST['fRating']==NULL) $varRating = "N/A";
else $varRating = $_POST['fRating'];
$varMember = $_POST['fMember'];
if($_POST['fClub']==NULL) $varClub = "N/A";
else $varClub = $_POST['fClub'];
$varEventsArray = $_POST['fEvents'];
$varStudent = $_POST['fStudent'];
$varTotalFee = $_POST['fTotalFee'];
$varSignature = $_POST['fSignature'];
$varDate = $_POST['fDate'];

$varMemberNumber = $_POST['fMemberNumber'];
$varExpires = $_POST['fExpires'];

$varStreet = $_POST['fStreet'];
$varCity = $_POST['fCity'];
$varState = $_POST['fState'];
$varZip = $_POST['fZip'];
$varPhone = $_POST['fPhone'];
$varEmail = $_POST['fEmail'];
$varBirthdate = $_POST['fBirthdate'];
$varMembershipFee = $_POST['fMembershipFee'];

//concatenate events into String
$varEvents="";
for($i=0; $i<count($varEventsArray);$i++){
    $varEvents=$varEvents.$varEventsArray[$i];
    if($i<count($varEventsArray)-1) $varEvents=$varEvents.", ";
}

$sql = mysql_connect("sql.mit.edu", "tabletennis", "web23dis") or die(mysql_error());
mysql_select_db("tabletennis+spring_2013_registration") or die(mysql_error());

//is member
if($varMember == "Yes") {

mysql_query("INSERT INTO Registration (Name, Rating, Member, MemberID, Expires, Email, Club, Events, Student, TotalFee, Signature, Date) VALUES ('{$varName}', $varRating, '{$varMember}', '{$varMemberNumber}', '{$varExpires}', '{$varEmail}', '{$varClub}', '{$varEvents}', '{$varStudent}', '{$varTotalFee}', '{$varSignature}', '{$varDate}')") or die(mysql_error());

}

//not member
else {

mysql_query("INSERT INTO Registration (Name, Rating, Member, Street, City, State, Zip, Phone, Email, Birthdate, Club, Events, Student, MembershipFee, TotalFee, Signature, Date) VALUES ('{$varName}', '{$varRating}', '{$varMember}','{$varStreet}', '{$varCity}', '{$varState}', '{$varZip}', '{$varPhone}','{$varEmail}', '{$varBirthdate}', '{$varClub}',  '{$varEvents}', '{$varStudent}', '{$varMembershipItem}', '{$varTotalFee}', '{$varSignature}', '{$varDate}')") or die(mysql_error());


}

mysql_close($sql);







/************************
*****Print Entry Fee*****
*************************/

function printItems($array, $membership, $student){

	$MEMBERSHIP_ITEMS = array(" ", "Adult - 1 year", "Adult - 3 years", "Household - 1 year", "Household - 3 years", "College student - 1 year", "Junior U-17 - 1 year", "Junior U-15 - 3 years", "One-time tournament pass");

  $items = "";
  for($i=0; $i<count($array); $i++){
    $items=$items.$array[$i]." Singles<br>";
    //$amount=$amount.$EVENTS_COSTS[$i]."<br>";
  }
  if($membership != 0){
    $items=$items."USATT ".$MEMBERSHIP_ITEMS[$membership]."<br>";
  }
  $items=$items."Registration and ratings fee<br>";
  if(count($array)==3){
    $items=$items."3 Events Discount<br>";
  }
  if($student == "Yes" && count($array)>1){
    $items=$items."Student Discount"."<br>";
  }
  return $items;
}

function printAmount($array, $membership, $student){

	$MEMBERSHIP_COSTS = array("$0.00", "$49.00", "$130.00", "$90.00", "$250.00", "$25.00", "$25.00", "$60.00", "$10.00");
	$EVENT_COSTS = array("$30.00", "$25.00", "$25.00", "$20.00", "$20.00", "$20.00", "$20.00", "$20.00");
	$EVENT_ITEMS = array("Open", "U2300", "U2100", "U1900", "U1700", "U1400", "U1200", "U1000");

  $amount = "";
  for($i=0; $i<count($array); $i++){
		$index = 0;
		for($j=0; $j<count($EVENT_ITEMS); $j++) {
			if($array[$i]==$EVENT_ITEMS[$j]) {
				$index = $j;
			}
		}
    $amount=$amount.$EVENT_COSTS[$index]."<br>";
  }
  if($membership != 0){
    $amount=$amount.$MEMBERSHIP_COSTS[$membership]."<br>";
  }
  $amount=$amount."$10.00<br>";
  if(count($array)==3){
    $amount=$amount."-$5.00<br>";
  }
  if($student == "Yes" && count($array)>1){
    $amount=$amount."-$5.00<br>";
  }
  return $amount;
}

/*************************
****Print Information*****
**************************/

function printConfirmation($name, $rating, $member, $memberID, $expires, $street, $city, $state, $zip, $phone, $email, $birthdate, $club, $events, $student, $membership) {

	$print="<ul style=\"list-style-type:none\">";

	if($member == "Yes") {
		$member_fields_array = array("Name", "USATT Member", "USATT Member #", "Expires", "Rating", "Email", "Home Club", "Events", "Student");
		$member_values_array = array($name, $member, $memberID, $expires, $rating, $email, $club, $events, $student);
		for($i=0; $i<count($member_fields_array); $i++) {
			$print = $print."<li>".$member_fields_array[$i].": ".$member_values_array[$i]."</li>";
		}
	}

	else {

		$MEMBERSHIP_ITEMS = array(" ", "Adult - 1 year", "Adult - 3 years", "Household - 1 year", "Household - 3 years", "College student - 1 year", "Junior U-17 - 1 year", "Junior U-15 - 3 years", "One-time tournament pass");
		$membership_choice=$MEMBERSHIP_ITEMS[$membership];
		$non_member_fields_array = array("Name", "USATT Member", "Street", "City", "State", "Zip", "Phone", "Email", "Birthdate", "Rating", "Club", "Events", "Student", "Membership Choice");
		$non_member_values_array = array($name, $member, $street, $city, $state, $zip, $phone, $email, $birthdate, $rating, $club, $events, $student, $membership_choice);
		for($i=0; $i<count($non_member_fields_array); $i++) {
			$print = $print."<li>".$non_member_fields_array[$i].": ".$non_member_values_array[$i]."</li>";
		}
	}

	$print=$print."</ul>";

	return $print;

}




/**************************
*******Email Info**********
***************************/

$Eprint='
<html>
<body>
<p>Thank you for registering for the 2013 MIT Fall Open! This is confirmation that we have received your registration information. <br>Please note however that your registration is not complete until we have received your payment, either online via Paypal or by check. Thank you! </p><hr align="left" width="60%"/><br>'.
printConfirmation($varName, $varRating, $varEmail,  $varClub, $varEvents, $varODpartner, $varU2800partner, $varStudent).'
<ul style="list-style-type:none;"><li><b>Entry Fees</b></li>
<li>
<table><tr><td>'.printItems($varEventsArray, $varMembershipFee, $varStudent).'
</td><td style="text-align:right; padding:0pt 15pt">'.
printAmount($varEventsArray, $varMembershipFee, $varStudent).'
</td></tr>
<tr><td><hr/><b>Total Fee<b><br><br>
</td><td style="text-align:right; padding:0pt 15pt">
<hr/>'.$varTotalFee.".00".'
<br><br>
</td></tr>
</table>

</form>

</td></tr></table>
</li>

</ul>
<br><hr width="60%" align="left">Please email any questions to dilmurat@mit.edu.
</body>
</html>
';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

mail("jtzhang@mit.edu", "MIT Spring Open Registration", $Eprint, $headers);
//mail("dilmurat.moldobaev@gmail.com", "MIT Spring Open Registration", $Eprint, $headers);
//mail($varEmail, "MIT Spring Open Registration", $Eprint, $headers);



//concatenate events
/*
mysql_query("INSERT INTO Registration (Name, Street, City, State, Zip, Phone, Email, Member, MemberID, Expires, Rating, Club, Birthdate, Events, Student, MembershipFee, Signature, Date) VALUES ('{$varName}', '{$varStreet}', '{$varCity}', '{$varState}', $varZip, $varPhone,'{$varEmail}', '{$varMember}', '{$varMemberNumber}', '{$varExpires}', $varRating, '{$varClub}', '{$varBirthdate}', '{$varEvents}', '{$varStudent}', '{$varMembershipItem}', '{$varSignature}', '{$varDate}')") or die(mysql_error());
*/
/*
$fields_array = array("Name", "Street", "City", "State", "Zip", "Phone", "Email", "USATT Member", "Member Number", "Expires", "Rating", "Club", "Birthdate", "Events", "Student", "Membership Fee", "Total Fee");
$var_array = array($varName, $varStreet, $varCity, $varState, $varZip, $varPhone, $varEmail, $varMember, $varMemberNumber, $varExpires, $varRating, $varClub, $varBirthdate, $varEvents, $varStudent, $varMembershipFee, $varTotalFee);

$message = "Thank you for registering for the MIT Spring 2013 Open. The following is for you records.\n\n";
$message=$message."Name: ".$varName."\n";
$message=$message."Address: ".$varStreet.", ".$varCity.", ".$varState." ".$varZip;
for($i=5; $i<count($fields_array); $i++) {
  $message=$message.$fields_array[$i].": ".$var_array[$i]."\n";
}
$message=$message."\n\nPlease note that your registration is not complete until we have received your payment. Click on the link below to pay online, or ";
*/

//mail("jtzhang@mit.edu", "MIT Spring 2013 Open Registration", $message);
/*
function membershipItem($n){

return $MEMBERSHIP_ITEMS[$n];
}
*/

?>



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
  <tr>
    <td><table width="100%"  border="0" align="right" cellpadding="0" cellspacing="0">
      <tr>
        <td width="16%"><a href="http://mit.edu/tabletennis/index.html"><img src="/IMAGES/mitlogo.gif" width="117" height="68" border="0" /></a></td>
        
        
        <td width="64%" valign="bottom" class="top"><em><strong style="font-family:verdana;font-size:30px;color:red;"><a href="http://mit.edu/tabletennis/index.html"><img src="IMAGES/MIT1.jpg" width="388" height="58" /></a> </strong></em></td>
      
       <td align="left" valign="baseline" class="top"> <blockquote>
         <p style="font-family:verdana;font-size:10
 px;color:red;">&nbsp;</p>
       </blockquote>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
<td height="309">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="middlepicture">
<tbody>
<tr>
<td width="571" valign="top"><img src="/IMAGES/Bridge3.JPG" width="581" height="214" /></td>
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

<p><a href="http://mit.edu/tabletennis/Tournament.html">Tournaments</a> > <a href="https://tabletennis.scripts.mit.edu/registration.html">Online Registration</a> > Confirmation </p>
<hr align=left width=20%></hr>

<h3>MIT Spring 2013 Open Online Registration</h3>

<p>Thank you for registering for the MIT Spring 2013 Open! A confirmation email has been sent to your address provided. Please note that your registration is not complete until we have received your payment.</p>

<?php echo printConfirmation($varName, $varRating, $varMember, $varMemberNumber, $varExpires, $varStreet, $varCity, $varState, $varZip, $varPhone, $varEmail, $varBirthdate, $varClub, $varEvents, $varStudent, $varMembershipFee); ?>

<ul style="list-style-type:none;"><li><b>Entry Fees</b></li>
<li>
<table><tr><td>
<?php
echo printItems($varEventsArray, $varMembershipFee, $varStudent);
?>
</td><td style="text-align:right; padding:0pt 15pt">
<?php
echo printAmount($varEventsArray, $varMembershipFee, $varStudent);
?>
</td></tr>
<tr><td><hr/><b>Total Fee<b><br><br>
</td><td style="text-align:right; padding:0pt 15pt">
<hr/>
<?php
echo $varTotalFee.".00";
?>
<br><br>
</td><td style="vertical-align:top">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="P839LX2P69W74">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="Entry Fee">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynowCC_LG.gif:NonHosted">
<table>
<tr><td><input type="text" style="display:none" name="amount" size="11" value=<?php echo $varTotalFee.".00";?> readonly></td></tr>
</table>
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

</td></tr></table>
</li>

</ul>
<p>
You may pay by using the paypal link above or by check through mail. Please make sure that your paypal payment goes to the account [dilmurat at mit dot edu]. Thank you!
</p>
<br><br><br>
    <hr>
     <p><font color="gray"><font size="2">MIT Table Tennis Club - Site created by Sidhant Pai and Sharang Pai. Maintained by Pramod Kandel</p>
  </tr>
</table>
</body>
</html>

