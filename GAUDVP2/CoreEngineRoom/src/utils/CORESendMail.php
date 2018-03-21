<?php

/*
  Project                     : Oriole
  Module                      : Utils
  File name                   : CORESendMail.php
  Description                 : Utils Class used for sending emails 
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class CORESendMail
{

    public  $mail;
    private $subject;
    private $message;
    private $header;
    const mail_success     = 0;
    const mail_send_failed = 3;

    public function __construct()
    {
        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = EMAIL_SMTP_USERNAME;
        $this->mail->Password   = EMAIL_SMTP_PASSWORD;
        $this->mail->Host       = EMAIL_SMTP_SERVER;
        $this->mail->Port       = 465;
        $this->mail->SMTPDebug  = 0;
        $this->mail->CharSet    = 'UTF-8';
        $this->mail->SMTPSecure = 'ssl';
        $this->mail->From       = EMAIL_FROM_ADDRESS;
        $this->mail->FromName   = EMAIL_FROM_NAME;
        $this->mail->isHTML(false);
        $this->mail->ContentType = 'text/plain';
        $this->mail->addReplyTo('no-reply@thebusinessjournalsedge.com');
    }

    public function sendEmail($to, $subject, $message, $header)
    {
        $this->mail->Subject = $subject;
        $this->mail->Body    = $message;
        $this->mail->addAddress($to);

        if(!$this->mail->send())
        {
            $status = $this::mail_send_failed;
        }
        else
        {
            $status = $this::mail_success;
        }

        return $status;
    }
}

?>
