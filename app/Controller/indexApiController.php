<?php

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// session_start();

class indexApiController
{

    public static function Login($app, $request, $response, $args)
    {
        // 
        // return var_dump($request->getParsedBody());
        // get the requested data
        $data = $request->getParsedBody();
        // if(isset($_COOKIE['user'])&&isset($_COOKIE['pass'])){
        //     $data =[
        //         $_COOKIE['user'],
        //         $_COOKIE['pass']
        //     ];
        // }
        // return var_dump($_COOKIE);
        // select the user db 
        $verAwal = $app->db->select('tbl_users', '*', [
            "AND" => [
                "OR" => [
                    "username" => $data["user"],
                    "email" => $data["user"]
                ],
                "password" => $data["pass"]
            ]
        ]);
        // return var_dump($verAwal);
        // if exist, login
        if ($verAwal != null) {
            // return var_dump($verAwal[0]['username']);
            $_SESSION['user'] = $verAwal[0]['first_name'] . ' ' . $verAwal[0]['last_name'];
            $_SESSION['type'] = $verAwal[0]['id_user_type'];
            $_SESSION['id_parent'] = $verAwal[0]['id_user'];

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
        // return var_dump($data);
        // if exist, can't register
        if ($verAwal != null) {
            $_SESSION['hasData'] = true;
            return $response->withJson(array('success' => true, 'hasData' => true));

        } //Else if not exist, register
        else {
            // return var_dump($verAwal);
            $insert = $app->db->insert('tbl_users', [
                "username" => $data["user"],
                "email" => $data["email"],
                "password" => $data["password"],
                "id_user_type" => $data['type'],
                "status" => 0
            ]);
            $id_inserted = $app->db->id();
            // $_SESSION['user'] = $data['user'];
            $_SESSION['hasData'] = false;
            $_SESSION['isRegister'] = true;
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
                return $response->withJson(array('success' => true));
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