<?php

namespace App\Controller;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// session_start();

class indexApiController
{

    // fungsi untuk mengenkripsi password
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
    
    // fungsi untuk mendekripsi password
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


    // digunakan di route /all-account
    public static function getAllAccount($app, $request, $response, $args) {
        $search = $request->getParam('search') ?? '';
        $account = $app->db->select('tbl_users', '*');
        // return var_dump($search);
        // die();

        $totaldata = count($account);
        $totalfiltered = $totaldata;
        $conditions = [
            'id_user[!]' => 0,
        ];
        if (!empty($request->getParam('search'))) {
            $search = $request->getParam('search');
            $conditions['OR'] = [
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                'tbl_users.username[~]' => '%' . $search . '%',
                'tbl_user_types.user_type[~]' => '%' . $search . '%',

            ];
            $account = $app->db->select(
                'tbl_users',
                [
                    '[><]tbl_user_types' => 'id_user_type',
                ],
                '*',
                $conditions
            );
            $totaldata = count($account);
            $totalfiltered = $totaldata;
        }

        $account = $app->db->select('tbl_users', [
            '[><]tbl_user_types' => 'id_user_type',
        ], '*', $conditions);
        $data = array();
        // return var_dump($account);
        if (!empty($account)) {

            return $response->withJson(array('account' => $account, 'totalData' => $totalfiltered));
        }
        // return var_dump($data);
    }

    // digunakan di route /all-account
    public static function editAccount($app, $request,  $response,  $args) {
        $data = $request->getParsedBody();
        // return var_dump($data);
        // get image
        $directory = $app->get('upload_directory');
        $uploadedFiles = $request->getUploadedFiles();
        $filename = '';
        // handle single input with single file upload
        $uploadedFile = $uploadedFiles['profileImage'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($directory, $uploadedFile);
            $response->write('uploaded ' . $filename . '<br/>');
        }
        // return var_dump(isset($filename));
        $addUpdate = $filename;
        $a = $app->db->select('tbl_users', '*', [
            'id_user' => $data['id_user'],
        ]);
        // return var_dump($filename == '' && $a[0]['photo_user'] == 'default.png');
        if ($filename == '') {
            if($a[0]['photo_user'] != 'default.png'){
                $addUpdate = $a[0]['photo_user'];
            }else{
                $addUpdate = 'default.png';
            }
        }

        // return var_dump($uploadedFiles);
        $update = $app->db->update('tbl_users', [
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "gender" => $data['gender'],
            "date_of_birth" => $data['date_of_birth'],
            "religion" => $data['religion'],
            "phone_user" => $data['phone_user'],
            "address_user" => $data['address_user'],
            "short_bio" => $data['data_short_bio'],
            "photo_user" => $addUpdate,
        ], [
            "id_user" => $data['id_user'],
        ]);
        // return var_dump($update);
        return $response->withRedirect('/all-account');
    }

    // fungsi login
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

        // medapatkan input password
        $storedPassword = $verAwal[0]['password'];
        // mendapatkan password tersimpan
        $decryptPassword = indexApiController::decrypt($storedPassword, $_ENV['SALT']);
        // membandingkan input password dengan password yang tersimpan 
        if ($data['pass'] == $decryptPassword) {
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
            $mail->Host = $_ENV['SMTP_HOST'];
            // gunakan
            // $mail->Host = gethostbyname('smtp.gmail.com');
            // jika jaringan Anda tidak mendukung SMTP melalui IPv6
            //Atur SMTP port - 587 untuk dikonfirmasi TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = $_ENV['SMTP_PORT'];
            //Set sistem enkripsi untuk menggunakan - ssl (deprecated) atau tls
            $mail->SMTPSecure = $_ENV['SMTP_ENCRYPTION'];
            //SMTP authentication
            $mail->SMTPAuth = $_ENV['SMTP_AUTH'];
            //Username yang digunakan untuk SMTP authentication - gunakan email gmail
            $mail->Username = $_ENV['EMAIL_SENDER'];
            //Password yang digunakan untuk SMTP authentication
            $mail->Password = $_ENV['PASSWORD_OAUTH2'];
            //Email pengirim
            $mail->setFrom($_ENV['EMAIL_SENDER'], 'Educa Vertif - Noreply');
            //  //Alamat email alternatif balasan
            //  $mail->addReplyTo('balasemailke@example.com', 'First Last');
            //  Email tujuan
            $mail->addAddress($data['email']);
            //Subject email
            $mail->Subject = 'Educa Email Vertification';
            //Membaca isi pesan HTML dari file eksternal, mengkonversi gambar yang di embed,
            //Mengubah HTML menjadi basic plain-text
            //  $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
            //Replace plain text body dengan cara manual
            $mail->Body = '<a href="'.$_ENV['HOST_PROTOCOL'].'://'.$_ENV['HOSTNAME'].'/verifEmail?key=' . $id_inserted . '&email='.$data['email'].'">Klik link ini untuk verifikasi email</a>';
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