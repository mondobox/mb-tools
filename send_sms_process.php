<?php
require_once 'protect.php';
Protect\with('form.php', 'IL0veM0nd0Burrit0s!', scopeABC);
?><!DOCTYPE html>
<html>
<head>
<title>Send SMS to MondoBox Users</title>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="maindiv">
<div class="divB">
<div class="title">
<h2>Send SMS to MondoBox Users</h2>
NOTE: ONLY USE ONCE PER DAY<BR>
<img src=http://app.mondobox.com/static/media/mondobox_beta_logo.917e2853.png>
</div>

<?php
require __DIR__ . '/vendor/autoload.php';
use Twilio\Rest\Client;
date_default_timezone_set('UTC');
// echo "submit state =" . $_POST['submit'] . "<BR/>";

if ($_POST['submit'] == "submit") {
// echo "<div class='divB'>";
// echo "submit state =" . $_POST['submit'] . "<BR/>";

$_POST['submit']="";
echo "<H2>Results:</H2><HR/>";
// echo "submit state =" . $_POST['submit'] . "<BR/>";

define('DB_SERVER', 'XXX.rds.amazonaws.com');
define('DB_USERNAME', 'XXX');
define('DB_PASSWORD', 'XXX'); //TO DO: make this an environment variable
define('DB_DATABASE', 'mondobox');

// Your Account SID and Auth Token from twilio.com/console
$account_sid = 'XXX';
$auth_token = 'XXX';
$copilot_sid = 'XXX';
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]
// or use something like this to store the password:
// $access_key=getenv('AWS_ACCESS_KEY_ID');
// echo "AWS_ACCESS_KEY_ID =" . $access_key . "\n";
echo "defined database and Twilio connection parameters <br>";

// instantiate Twilio client:
$twilio = new Client($account_sid, $auth_token);

// connect to the database or die trying:
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if (!$connection) {
die('could not connect: ' . mysql_error() . '<BR>');
}  
echo "established connection to " . DB_SERVER . "<br>"; 


// Check if the form has been submitted or if it's just being called for the first time by the browser 
// retrieve the form data by using the element's name attributes value as key 
// $firstname = $_POST['firstname']; 
// $lastname = $_POST['lastname']; 
// display the results

// check to see if the form variables are set and if so, form the query
echo "beginning message send loop... <br><BR>";
$sms_message = $_POST['sms_message'];
// $sms_message = 'test message to you!';

if ($_POST['send_to'] == "all") {
   $query = mysqli_query($connection, "select sms_phone_number from users where sms_phone_number is not null and account_status IN ('FINALIZED', 'TOS_AGREE_NEEDED') and allow_sms_notifications=1 and phone_status='PHONE_VERIFIED'");
//   $query = mysqli_query($connection, "select sms_phone_number from users where sms_phone_number is not null and account_status = 'FINALIZED' and allow_sms_notifications=1");
   $num_users=$query->num_rows;
   echo "Sending to <B>" . $num_users . "</B>  users<BR/><BR>";

// loop through all the phone numbers and send the message using the Twilio client:
   $x=1;
   while ($row = mysqli_fetch_array($query)) {
    $sms_phone_number = "{$row['sms_phone_number']}";
    echo "<b> Sending to: $sms_phone_number </b><BR>";
// Code that sends the messages is here:
    $message = $twilio->messages
		   ->create($sms_phone_number, 
		      array(
			       "body" => $sms_message,
			       "messagingServiceSid" => $copilot_sid
			   )
		   );
   echo $message->sid; 
   echo "<BR>count =" . $x . "<BR>";
   $x=$x+1;
   echo "<br />";
   }
mysqli_close($connection);
echo "connection closed<br>";
}
else {
    $sms_phone_number = explode(" ", $_POST['sms_number']);
    for($i = 0; $i < count($sms_phone_number); ++$i) {
        echo "<b> Sending to number: $sms_phone_number[$i] </b><BR>";
        $message = $twilio->messages
		   ->create($sms_phone_number[$i], 
			   array(
			       "body" => $sms_message,
			       "messagingServiceSid" => $copilot_sid
			   )
		   );
       echo $message->sid; 
       echo "<br />";
    }
}
// clear the form variables
$_POST['submit']="";
$_POST = array();
}
// sleep for 15 seconds then redirect back to the form so that we don't re-post data:
?>
<BR>
All SMS messages sent!
<BR>
Sleeping for 5 seconds then clearing form...
<script type="text/javascript">
window.setTimeout(function() {
window.location.href="http://tools.mondobox.com/aws-tools/send_sms.php";
}, 15000);
</script> 
</body>
</html>     
