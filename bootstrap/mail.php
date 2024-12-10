<?php

// Looking to send emails in production? Check out our Email API/SMTP product!
$mail = new PHPMailer\PHPMailer\PHPMailer();
$mail->isSMTP();
$mail->Host = 'sandbox.smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Port = 2525;
$mail->Username = '2c90dc25512e32';
$mail->Password = '37b8b55b641440';
$mail->setFrom('auth@7auth.php', '7Auth Project');
$mail->isHtml(true);