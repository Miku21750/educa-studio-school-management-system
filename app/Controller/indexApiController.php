<?php

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// session_start();

class indexApiController
{

    public static function encrypt($data, $password){
        $iv = substr(sha1(mt_rand()), 0, 16);
        $password = sha1($password);
    
        $salt = sha1(mt_rand());
        $saltWithPassword = hash('sha256', $password.$salt);
    
        // ABAIKAN NULL, TIDAK APA APA.
        $encrypted = openssl_encrypt(
          "$data", 'aes-256-cbc', "$saltWithPassword", null, $iv
        );
        $msg_encrypted_bundle = "$iv:$salt:$encrypted";
        return $msg_encrypted_bundle;
    }
    
    
    public static function decrypt($msg_encrypted_bundle, $password){
        $password = sha1($password);
    
        $components = explode( ':', $msg_encrypted_bundle );
        $iv            = $components[0];
        $salt          = hash('sha256', $password.$components[1]);
        $encrypted_msg = $components[2];
    
        // ABAIKAN NULL, TIDAK APA APA.
        $decrypted_msg = openssl_decrypt(
          $encrypted_msg, 'aes-256-cbc', $salt, null, $iv
        );
    
        if ( $decrypted_msg === false )
            return false;
        return $decrypted_msg;
    }


    public static function Login($app, $request, $response, $args)
    {
        $data = $request->getParsedBody();

        $verAwal = $app->db->select('tbl_users',[
            "[><]tbl_user_types" => "id_user_type"
        ], '*', [
                "OR" => [
                    "username" => $data["user"],
                    "email" => $data["user"]
                ],
            ]
        );

        $storedPassword = $verAwal[0]['password'];

        $decryptPassword = indexApiController::decrypt($storedPassword, $_ENV['SALT']);
        
        if ($data['pass'] == $decryptPassword) {
            // return var_dump($verAwal[0]['username']);
            $_SESSION['user'] = $verAwal[0]['first_name'] . ' ' . $verAwal[0]['last_name'];
            $_SESSION['username'] = $verAwal[0]['username'];
            $_SESSION['type'] = $verAwal[0]['id_user_type'];
            $_SESSION['type_user'] = $verAwal[0]['user_type'];
            $_SESSION['id_user'] = $verAwal[0]['id_user'];
            $_SESSION['photo_user'] = $verAwal[0]['photo_user'];
            $_SESSION['status'] = $verAwal[0]['status'];
            $_SESSION['isLogin'] = true;
            if (isset($data['remember-me'])) {
                //create cookie
                setcookie("user", $data['user'], time() + (86400 * 30), "/");
                setcookie("pass", $data['pass'], time() + (86400 * 30), "/");
            }
            
            return $response->withRedirect('/');
        } //Else if not exist, can't login
        else {
            $_SESSION['notValidate'] = true;
            return $response->withRedirect('/login');
        }
    }


    public static function register($app, $request, $response, $args)
    {
        // 
        // return var_dump($request->getParsedBody());

        // get the requested data
        $data = $request->getParsedBody();
        // select the user db 
        $verAwal = $app->db->select('tbl_users', '*', [
            "OR" => [
                "username" => $data["user"],
                "email" => $data["email"],
            ]
        ]);
        // return var_dump($verAwal);
        // if exist, can't register
        if ($verAwal != null) {
            $_SESSION['hasData'] = true;
            return $response->withJson(array('success' => true, 'hasData' => true));

        } //Else if not exist, register
        else {
            $encryptedPassword = indexApiController::encrypt($data["password"], $_ENV['SALT']);
            $insert = $app->db->insert('tbl_users', [
                "username" => $data["user"],
                "email" => $data["email"],
                "password" => $encryptedPassword,
                "id_user_type" => $data['type'],
                "photo_user"=> 'default.png',
                "status" => 0
            ]);
            $id_inserted = $app->db->id();
            // return var_dump($insert);
            // $_SESSION['user'] = $data['user'];
            
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
            $mail->Username = "rafaelfarizi1@gmail.com";
            //Password yang digunakan untuk SMTP authentication
            $mail->Password = "dqwuvxffdphlgdml";
            //Email pengirim
            $mail->setFrom('rafaelfarizi1@gmail.com', 'Miku21 Margareth');
            //  //Alamat email alternatif balasan
            //  $mail->addReplyTo('balasemailke@example.com', 'First Last');
            //Email tujuan
            $mail->addAddress($data['email']);
            //Subject email
            $mail->Subject = 'PHPMailer GMail SMTP test';
            //Membaca isi pesan HTML dari file eksternal, mengkonversi gambar yang di embed,
            //Mengubah HTML menjadi basic plain-text
            //  $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
            //Replace plain text body dengan cara manual
            $mail->Body = '<a href="http://localhost:8200/verifEmail?key=' . $id_inserted . '&email='.$data['email'].'">Klik link ini untuk verifikasi email</a>';
            $mail->AltBody = 'This is a plain-text message body';
            //Attach file gambar
            //  $mail->addAttachment('images/phpmailer_mini.png');
            //mengirim pesan, mengecek error
            if (!$mail->send()) {
                echo "Email Error: " . $mail->ErrorInfo;
            } else {
                $_SESSION['hasData'] = false;
                $_SESSION['isRegister'] = true;
                return $response->withRedirect('/login');
                // return $response->withJson(array('success' => true));
            }
            // return $response->withJson(array('success' => true));
            // return $response->withRedirect('/login');
        }
    }

    public static function logout($app, $request, $response, $args)
    {
        // session_destroy();
        $_SESSION['logout'] = true;
        return $response->withRedirect('/login');
    }
}