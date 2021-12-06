<?php
require_once 'protect.php';
Protect\with('form.php', 'XXX', scopeABC);
?>
<!DOCTYPE html>
<html>
<head>
<title>Send SMS to MondoBox Users</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
			function disableButton(btn){
				document.getElementById(btn.id).disabled = true;
				alert("Button has been disabled.");
			}
		</script>
</head>
<body>
<div class="maindiv">
<div class="divB">
<div class="title">
<h2>Send SMS to MondoBox Users</h2>
NOTE: ONLY USE ONCE PER DAY<BR>
<img src=http://app.mondobox.com/static/media/mondobox_beta_logo.917e2853.png>
</div>
<form class="form" method="POST" action="/aws-tools/send_sms_process.php"/>
<HR/>
<label>Compose SMS Message Here:</label><BR/>
<input class="input" type="text" name="sms_message"/>
<BR>
<input type="radio" name="send_to" value="" checked />Send text to a space-separated list of international SMS numbers
&nbsp;&nbsp;
<input class="input2" type="text" name="sms_number" />
<BR>
<input type="radio" name="send_to" value="all">Send to ALL MondoBox Players (DANGER WILL ROBINSON!)
<BR>
<input class="submit" type="submit" name="submit" value="submit" onclick="disableButton(this)"/>
</form>
</body>
</html>
