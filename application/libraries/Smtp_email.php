<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Smtp_email{

    var $host       = 'outthinkcoders.com', //server hostname
    $user_name      = 'no-reply@outthinkcoders.com', 
    $from_mail      = 'no-reply@outthinkcoders.com', //email a/c username
    $pwd            = 'EsEyCb7Tii2K', // email a/c password
    $port           = 465, //or 25(depends or server email configuration)
    $from_name      = SITE_NAME;
    public function send_mail($to,$subject,$message){

        $mail = new PHPMailer(true); // Passing `true` enables exceptions
        try {
            //Server settings
            // $mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host         = $this->host;; // Specify main and backup SMTP servers
            $mail->SMTPAuth     = true; // Enable SMTP authentication
            $mail->Username     = $this->user_name; // SMTP username
            $mail->Password     = $this->pwd; // SMTP password
            $mail->SMTPSecure   = 'ssl'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port         = $this->port; // TCP port to connect to
            $mail->SMTPOptions  = array(
                'ssl' => array(
                    'verify_peer'           => false,
                    'verify_peer_name'      => false,
                    'allow_self_signed'     => true
                )
            );
            //Recipients
            $mail->setFrom($this->from_mail, $this->from_name);
            $mail->addAddress($to); // Name is optional
            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject  = $subject;
            $mail->Body     = $message;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send(); 
            return TRUE;
        } catch (Exception $e) {
            return 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
        }
    }//end function

    public function send_mail_multiple($to,$subject,$message){

        $mail               = new PHPMailer(true); // Passing `true` enables exceptions
        try {
            //Server settings
            // $mail->SMTPDebug = 2; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host         = $this->host;; // Specify main and backup SMTP servers
            $mail->SMTPAuth     = true; // Enable SMTP authentication
            $mail->Username     = $this->user_name; // SMTP username
            $mail->Password     = $this->pwd; // SMTP password
            $mail->SMTPSecure   = 'ssl'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port         = $this->port; // TCP port to connect to
            $mail->SMTPOptions  = array(
                'ssl' => array(
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true
                )
            );
            //Recipients
            $mail->setFrom($this->from_mail, $this->from_name);
            for ($i=0; $i <sizeof($to) ; $i++) { 
               $mail->addAddress($to[$i]); // Name is optional
            }
            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject  = $subject;
            $mail->Body     = $message;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
            $mail->send(); 
            return TRUE;
        } catch (Exception $e) {
            return 'Message could not be sent. Mailer Error: '. $mail->ErrorInfo;
        }
    }//end function
}//end class