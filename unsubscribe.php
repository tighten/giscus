<?php
$formMessage = "";
$senderName = "";
$senderEmail = "";
$senderMessage = "";
if (isset($_POST['cusername']))
{
   
    $senderName = $_POST['cusername'];
    $senderEmail = $_POST['cemail'];
    $senderMessage = $_POST['msg'];
   
    if (!$senderName || !$senderEmail )
    {
       $formMessage = "The form is incomplete, please fill in all fields.";
    }
   else
   { 
        $senderName = strip_tags($senderName);
        $senderName = stripslashes($senderName);
        $senderEmail = strip_tags($senderEmail);
        $senderEmail = stripslashes($senderEmail);
        $senderMessage = strip_tags($senderMessage);
        $senderMessage = stripslashes($senderMessage);
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
    } // 
} 
?>
