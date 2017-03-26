<?php
 include_once('class.phpmailer.php');//incluimos la libreria phpmailer

 class sendmail {
      var $mail;
      var $Body;
      var $From;
      var $FromName;
      var $Subject;
      var $Email;
      var $Language;

    function sendmail($Body,$From,$FromName,$Subject,$Email,$Language)
    {
      $this->mail = new PHPMailer();
      $this->Body = $Body;
      $this->From = $From;
      $this->FromName = $FromName;
      $this->Subject = $Subject;
      $this->Email = $Email;
      $this->Language = $Language;
    }

    function  Send()
    {
     //$this->mail->IsSMTP();// send via SMTP
     //$this->mail->SMTPAuth = true; // turn on SMTP authentication
     //$this->mail->SMTPSecure = "ssl";
     $this->mail->Host = 'smtp.gmail.com';
     $this->mail->Port = 465; //465 587
     $this->mail->Username = 'fmendoza06@gmail.com'; // SMTP username
     $this->mail->Password = 'nita1234';// SMTP password
     $this->mail->IsHTML(true); // send as HTML
     $this->mail->SetLanguage($this->Language); 

     $this->mail->Body=$this->Body;

     // Introducimos la información del remitente del mensaje
     $this->mail->From       = $this->From;
     $this->mail->FromName   = $this->FromName;
     //Asunto
     $this->mail->Subject    = $this->Subject;
  
     // y los destinatarios del mensaje. Podemos especificar más de un destinatario
     $this->mail->AddAddress($this->Email);
     //$mail->AddAttachment("images/phpmailer.gif");// adjuntamos un imagen o un file
     
     if(!$this->mail->Send()) {
       //echo "Mailer Error: " . $this->mail->ErrorInfo;
       //Intento enviarlo por phpmail
       $header = "Content-type: text/html\r\n" ;
	   $header  = 'MIME-Version: 1.0' . "\r\n";
	   $header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	   $header .= "From: " . $this->From . "\r\n";

       $result=mail($this->Email,$this->Subject, $this->Body, $header);
     } 
     /*
     else 
     {
       echo "Message sent!";
     }
     */


    } // End Send fucntion

 }  // End Class
?>

