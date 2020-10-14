<?php
require_once 'vendor/autoload.php';
require_once 'email-settings.php';
  
try {
  // Create the Transport
  $transport = (new Swift_SmtpTransport($emailSmtp, $emailPort, $emailProtocol))
  ->setUsername($emailUsername)
  ->setPassword($emailPassword)
  ;

  // Create the Mailer using your created Transport
  $mailer = new Swift_Mailer($transport);

  // Create a message
  $message = (new Swift_Message('Contact Form Submission: ' . $siteName))
    ->setFrom([$fromAddress => $fromName])
    ->setTo([$toAddress])
    ->setBody("You have a new submission on your contact form.\r\n\r\n
    Form: ".$_POST['form']."\r\n\r\n
    First Name: ".$_POST['fname']."\r\n\r\n
    Last Name: ".$_POST['lname']."\r\n\r\n
    Company: ".$_POST['company']."\r\n\r\n
    Job Title: ".$_POST['jobtitle']."\r\n\r\n
    Email Address: ".$_POST['email']."\r\n\r\n
    Phone Number: ".$_POST['phone']."\r\n\r\n
    Country: ".$_POST['country']."\r\n\r\n
    GDPR (Contact): ".$_POST['gdpr']."\r\n\r\n
    ");

  // Send the message
  $result = $mailer->send($message);
  if ($_POST['form'] == "Call Back Form"){
    header("Location: ../../?success=true");
  } else {
    header("Location: ../../?success=true&download=true");
  }
} catch (Exception $e) {
  echo $e->getMessage();
}
