<?php
$to = "destinatario@gmail.com"; // Substitua pelo e-mail do destinatário
$subject = "Teste de E-mail";
$message = "Este é um teste de envio de e-mail usando SMTP configurado no php.ini.";
$headers = "From: your_email@gmail.com"; // Substitua pelo seu e-mail

if (mail($to, $subject, $message, $headers)) {
    echo "E-mail enviado com sucesso!";
} else {
    echo "Falha no envio do e-mail.";
}
?>
