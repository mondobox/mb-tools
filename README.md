# mb-tools
useful tools developed at MondoBox

These tools are used to send SMS messages to those users in the AWS RDS DB who have agreed to receive messages, and who have completed registration. This app uses Copilot by Twilio, which allows the message to be sent using a short code, if possible, falling back to a long code if short code is not supported.

send_sms.php - initial form to compose the message
send_sms_process.php - uses the Twilio API to send the messages
