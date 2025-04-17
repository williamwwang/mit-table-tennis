<?php

/**********************************************
**  THINGS TO BE CHANGED FOR EACH TOURNAMENT **
**********************************************/

/* Name of the tournament */
$TOURNAMENT_NAME = "MIT 2016 Fall Open";

/* Subject for the email to be sent to player */
$EMAIL_SUBJECT_TITLE = "MIT Fall Open Registration";

/* Email address to send the record emails to */
$EMAIL_ADDRESS = "mengjiao@mit.edu";

/* Table name for mysql database table */
$MYSQL_TABLE_NAME = "2016_fall";

/* also need to change paypal item name */


/**********************
***Write to MySql******
***********************/

// get variables
$varName = htmlspecialchars($_POST['fName']);
$varRating = htmlspecialchars($_POST['fRating']);
$varEmail = htmlspecialchars($_POST['fEmail']);
if($_POST['fClub']==NULL) $varClub = "N/A";
else $varClub = htmlspecialchars($_POST['fClub']);
$varEventsArray = $_POST['fEvents'];
if($_POST['fODpartner']==NULL) $varODpartner="";
else $varODpartner = htmlspecialchars($_POST['fODpartner']);
if($_POST['fU2800partner']==NULL) $varU2800partner="";
else $varU2800partner = htmlspecialchars($_POST['fU2800partner']);
$varStudent = $_POST['fStudent'];

$varTotalFee = $_POST['fTotalFee'];
$varFeeItemListing = $_POST['fFeeItemListing'];
$varFeeListing = $_POST['fFeeListing'];

//concatenate events into String
$varEvents="";
for($i=0; $i<count($varEventsArray);$i++){
    $varEvents=$varEvents.$varEventsArray[$i];
    if($i<count($varEventsArray)-1) $varEvents=$varEvents.", ";
}

$sql = mysql_connect("sql.mit.edu", "tabletennis", "web23dis") or die(mysql_error());
mysql_select_db("tabletennis+tournaments") or die(mysql_error());


mysql_query("INSERT INTO ".$MYSQL_TABLE_NAME." (Name, Rating, Email, Club, Events, DoublesPartnerOPEN, DoublesPartnerU2800, Student, TotalFee) VALUES ('{$varName}', '{$varRating}', '{$varEmail}', '{$varClub}', '{$varEvents}', '{$varODpartner}', '{$varU2800partner}', '{$varStudent}', '{$varTotalFee}')") or die(mysql_error());


mysql_close($sql);


/*************************
****Print Information*****
**************************/

function printConfirmation($name, $rating, $email, $club, $events, $student, $ODpartner, $U2800partner) {

	$print="<ul style=\"list-style-type:none\">";

	$fields_array = array("Name", "Rating", "Email", "Club", "Events", "Student");
	$values_array = array($name, $rating, $email, $club, $events, $student);

		for($i=0; $i<count($fields_array); $i++) {
			$print = $print."<li>".$fields_array[$i].": ".$values_array[$i]."</li>";
		}

	if($ODpartner!=NULL)
			$print = $print."<li>Open Doubles partner: ".$ODpartner."</li>";

	if($U2800partner!=NULL)
		$print = $print."<li>U2800 Doubles partner: ".$U2800partner."</li>";

	$print=$print."</ul>";

	return $print;

}


/**************************
*******Email Info**********
***************************/

$Eprint='
<html>
<body>
<p>Thank you for registering for the '.$TOURNAMENT_NAME.'! This is confirmation that we have received your registration information. <br>Please note however that your registration is not complete until we have received your payment, either online via Paypal or by check. Thank you! </p><hr align="left" width="60%"/><br>'.printConfirmation($varName, $varRating, $varEmail, $varClub, $varEvents, $varStudent, $varODpartner, $varU2800partner).'
<ul style="list-style-type:none;"><li><b>Entry Fees</b></li>
<li>
<table><tr><td>'.$varFeeItemListing.'
</td><td style="text-align:right; padding:0pt 15pt">'.
$varFeeListing.'
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
<br><hr width="60%" align="left">Please email any questions to mit-tt-open@mit.edu.
</body>
</html>
';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

mail($EMAIL_ADDRESS, $EMAIL_SUBJECT_TITLE, $Eprint, $headers);
//mail("dilmurat.moldobaev@gmail.com", "MIT Fall Open Registration", $Eprint, $headers);
mail($varEmail, $EMAIL_SUBJECT_TITLE, $Eprint, $headers);


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
<td height="36" bgcolor="#8BB2E3" style="padding-left:10px"><a href="http://mit.edu/tabletennis/JoinUs.html">Join / Contact Us</a></td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

<p><a href="http://mit.edu/tabletennis/Tournament.html">Tournaments</a> > <a href="https://tabletennis.scripts.mit.edu/registration.html">Online Registration</a> > Confirmation </p>
<hr align=left width=20%></hr>

<h3><?php echo $TOURNAMENT_NAME ?> Online Registration</h3>

<p>Thank you for registering for the <?php echo $TOURNAMENT_NAME ?>! A confirmation email has been sent to your email address provided. Please note that your registration is not complete until we have received your payment.</p>

<?php echo printConfirmation($varName, $varRating, $varEmail, $varClub, $varEvents, $varStudent, $varODpartner, $varU2800partner); ?>

<ul style="list-style-type:none;"><li><b>Entry Fees</b></li>
<li>
<table><tr><td>
<?php
echo $varFeeItemListing;
?>
</td><td style="text-align:right; padding:0pt 15pt">
<?php
echo $varFeeListing;
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

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="tt-officers@mit.edu">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="MIT Fall Open Registration">
<input type="hidden" name="button_subtype" value="services">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_paynowCC_LG.gif:NonHostedGuest">
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
You may pay through the Paypal link above, or by check. Checks orders payable to &#34MIT Table Tennis
Club&#34. If paying by PayPal, please include the name(s) of the player(s) for which the payment is made. PayPal email: [tt-officers at mit dot edu].
</p>
<br><br><br>
    <hr>
     <p><font color="gray"><font size="2">MIT Table Tennis Club - Site created by Sidhant Pai and Sharang Pai. Maintained by Pramod Kandel</p>
  </tr>
</table>
</body>
</html>

