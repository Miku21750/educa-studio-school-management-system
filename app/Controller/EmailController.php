<?php
namespace App\Controller;
use PHPMailer\PHPMailer\PHPMailer;

class EmailController{
    public static function emailConfig($app, $request, $response, $args){
        // return die(var_dump($args));
            $mail = new PHPMailer;
            //Memberi tahu PHPMailer untuk menggunakan SMTP
            $mail->isSMTP();
            //Mengaktifkan SMTP debugging
            // 0 = off (digunakan untuk production)
            // 1 = pesan client
            // 2 = pesan client dan server
            $mail->SMTPDebug = 2;
            //HTML-friendly debug output
            $mail->Debugoutput = 'html';
            //hostname dari mail server
            $mail->Host = 'smtp.gmail.com';
            // gunakan
            // $mail->Host = gethostbyname('smtp.gmail.com');
            // jika jaringan Anda tidak mendukung SMTP melalui IPv6
            //Atur SMTP port - 587 untuk dikonfirmasi TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 587;
            //Set sistem enkripsi untuk menggunakan - ssl (deprecated) atau tls
            $mail->SMTPSecure = 'tls';
            //SMTP authentication
            $mail->SMTPAuth = true;
            //Username yang digunakan untuk SMTP authentication - gunakan email gmail
            $mail->Username = $_ENV['EMAIL_SENDER'];
            //Password yang digunakan untuk SMTP authentication
            $mail->Password = $_ENV['PASSWORD_OAUTH2'];
            //Email pengirim
            $mail->setFrom($_ENV['EMAIL_SENDER']);
            //  //Alamat email alternatif balasan
            //  $mail->addReplyTo('balasemailke@example.com', 'First Last');
            //Email tujuan
            $mail->addAddress($args['addressEmail']);
            //Subject email
            $mail->Subject = $args['subjectEmail'];
            //Membaca isi pesan HTML dari file eksternal, mengkonversi gambar yang di embed,
            //Mengubah HTML menjadi basic plain-text
            //  $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
            //Replace plain text body dengan cara manual
            $mail->Body = $args['bodyEmail'];
            $mail->AltBody = $args['altBody'];
            //Attach file gambar
            //  $mail->addAttachment('images/phpmailer_mini.png');
            if (!$mail->send()) {
                echo "Email Error: " . $mail->ErrorInfo;
            }
            return;
    }
}

?>