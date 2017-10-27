<?php
$formMessage = "";
$senderName = "";
$senderEmail = "";
$senderMessage = "";
if (isset($_POST['cusername']))
{

	// Gather the posted form variables into local PHP variables
    $senderName = $_POST['cusername'];
    $senderEmail = $_POST['cemail'];
    $senderMessage = $_POST['msg'];
    // Make sure certain vars are present or else we do not send email yet
    if (!$senderName || !$senderEmail ) {

         $formMessage = "The form is incomplete, please fill in all fields.";
} else { // Here is the section in which the email actually gets sent

        // Run any filtering here
        $senderName = strip_tags($senderName);
        $senderName = stripslashes($senderName);
        $senderEmail = strip_tags($senderEmail);
        $senderEmail = stripslashes($senderEmail);
        $senderMessage = strip_tags($senderMessage);
        $senderMessage = stripslashes($senderMessage);
        // End Filtering


        // Begin Email Message Body
      $message = 'THE MESSAGE


';

$message .= "</body></html>";
        // Set headers configurations
	 $to= 'you';
	
     $bcc = "$contacts";
	 $subject = "bret";
	
	$headers = "MIME-Version: 1.0\\r\
";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\\r\
";
	$headers .= "Bcc: $bcc\\r\
";
	$headers .= "From: no-reply@optiontradepit.com\\r\
";
	mail( $to, $subject, $message, $headers );


        $formMessage = "Thanks, your message has been sent.";
        $senderName = "";
        $senderEmail = "";
        $senderMessage = "";
    } // close the else condition
} // close if (POST condition
?>
