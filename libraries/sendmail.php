<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function send_mail($send_to_email, $send_to_fullname, $subject, $content, $option = array()){
    global $config;
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = (0);                      //Enable verbose debug output  SMTP::DEBUG_SERVER
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $config['email']['smtp_host'];                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $config['email']['smtp_user'];                     //SMTP username
        $mail->Password   = $config['email']['smtp_pass'];                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = $config['email']['smtp_port'];                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail -> CharSet = $config['email']['charset'];
        //Recipients
        $mail->setFrom($config['email']['smtp_user'], $config['email']['fullname']);
        $mail->addAddress($send_to_email, $send_to_fullname);     //Add a recipient
        // $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo($config['email']['smtp_user'], $config['email']['fullname']);
        if(!empty($option['addCC']))
            $mail->addCC($option['addCC']);
        if(!empty($option['addBCC']))
            $mail->addBCC($option['addBCC']);

        // Attachments
        if(!empty($option['addAttachment']) && empty($option['addAttachmentName']))
            $mail->addAttachment($option['addAttachment']);         //Add attachments
        if(!empty($option['addAttachment']) && !empty($option['addAttachmentName']))
            $mail->addAttachment($option['addAttachment'], $option['addAttachmentName']);    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $content;
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}