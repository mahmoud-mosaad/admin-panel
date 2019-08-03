<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class mail
{
    private $mail;

    public function getMail(): PHPMailer
    {
        return $this->mail;
    }

    public function setMail(PHPMailer $mail): void
    {
        $this->mail = $mail;
    }

    function __construct(){
        $this->mail = new PHPMailer(true);
        //Server settings ... Load from config.php file
        //$this->config->SMTPDebug = 2;       // Enable verbose debug output
        $this->mail->isSMTP();        // Set mailer to use SMTP
        $this->mail->Host       = SMTP;// 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
        $this->mail->SMTPAuth   = true;      // Enable SMTP authentication
        $this->mail->Username   = MAIL_USERNAME;        // SMTP username
        $this->mail->Password   = MAIL_PASSWORD;        // SMTP password
        $this->mail->SMTPSecure = 'tls';  // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port       = 587;    // TCP port to connect to
    }

    public function setContent($subject, $body, $altbody = ''){
        $this->mail->isHTML(false);
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        $this->mail->AltBody = $altbody;
    }

    public function setHTMLContent($subject, $body, $altbody = ''){
        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        $this->mail->AltBody = $altbody;
    }

    public function addAttachment($path, $newName = ''){
        if (empty($newName)){
            $this->mail->addAttachment($path);    // Optional name
        }
        else{
            $this->mail->addAttachment($path, $newName);
        }
    }

    public function setFrom($frommail, $fromname){
        $this->mail->setFrom($frommail, $fromname);
    }

    public function addAddress($mail, $name = ''){
        if (empty($name)){
            $this->mail->addAddress($mail);    // Optional name
        }
        else{
            $this->mail->addAddress($mail, $name);
        }
    }

    public function addReplyTo($frommail, $subject){
        $this->mail->addReplyTo($frommail, $subject);
    }

    public function addCC($email){
        $this->mail->addCC($email);
    }

    public function addBCC($email){
        $this->mail->addBCC($email);
    }

    public function sendMail(){
        try {
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

}