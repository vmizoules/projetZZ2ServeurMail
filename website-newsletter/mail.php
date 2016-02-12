<?php

if($_POST['email']) {
	
	$to = $_POST['email'];

	$from = "abcde@poste.isima.fr";

	$subject = 'Website subscription';

	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $from . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

	$message = '<html><body>';
	$message .= '<h1>Hello!</h1>';
	$message .= '<p>' . $to . '</p>';
	$message .= '</body></html>';

	mail($to, $subject, $message, $headers);

	header("Location: confirmation.html");	
} else {
	header("Location: index.html");
}
