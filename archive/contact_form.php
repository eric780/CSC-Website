<?php
	$name = $_POST["name1"];
	$email = $_POST["email1"];
	$subject = $_POST["subject1"];
	$message = $_POST["message1"];

	$clubemail = "cornellstrategicconsulting@gmail.com"; //CHANGE THIS TO CLUB EMAIL

	$email = filter_var($email, FILTER_SANITIZE_EMAIL);//sanitize email

	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
		$confirmation = "Dear " . $name . ", \r\n \r\n This is a confirmation email, thanks for contacting us.";
		$confirmation .= "We will get back to you as soon as possible. \r\n";
		$confirmation .= "\r\n Best, \r\n";
		$confirmation .= "\r\n Cornell Strategic Consuting";
		mail($email, "Message sent to CSC", $confirmation);

		mail($clubemail, $subject, "Message from: " . $email . ": \r\n" . $message);
/*
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From:' . $email. "\r\n"; // Sender's Email
		$headers .= 'Cc:' . $email. "\r\n"; // Carbon copy to Sender
		$template = '<div style="color:black;">Hello ' . $name . ',<br/>'
		. '<br/>Thank you for contacting us.<br/><br/>'
		. 'Name: ' . $name . '<br/>'
		. 'Email: ' . $email . '<br/>'
		. 'Subject: ' . $subject . '<br/>'
		. 'Message: ' . $message . '<br/><br/>'
		. 'This is a confirmation email.'
		. '<br/>'
		. 'We will get back to you as soon as possible.'
		. '<br/><br/>Cornell Strategic Consulting</div>';

		$sendmessage = "<div>" . $template . "</div>";
	   // Message lines should not exceed 70 characters (PHP rule), so wrap it.
		$sendmessage = wordwrap($sendmessage, 70);

		mail($clubemail, $subject, $sendmessage, $headers); */

		echo "Thanks for contacting us! We'll get back to you shortly.";

	}
	else{
		echo "Invalid email address.";
	}

?>