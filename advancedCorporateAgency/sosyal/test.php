<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
  $kime="mertusluer@gmail.com";
    $konu="MESAJ";
	$mesaj="TEST MAÝLER";
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';
    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug =2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'mail.graptik.biz';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'hesap@graptik.biz';                 // SMTP username
        $mail->Password = 'MuhammetSürücü02@';                           // SMTP password
        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
        $mail->CharSet  ="utf-8";
        $mail->Port = 587;                                    // TCP port to connect to
        //Recipients
        $mail->setFrom('hesap@graptik.biz', 'Graptik Hesap');
        $mail->addAddress("mertusluer@gmail.com");               // Name is optional
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "Þifre Yenileme";
        $mail->Body    = $mesaj;
        print_r($mail->send());
            echo 1;
    } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;

    }
?>