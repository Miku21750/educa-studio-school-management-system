<?php

namespace App\Controller;

use Slim\Http\Response;
use PHPMailer\PHPMailer\PHPMailer;

class UserCredentialController
{


  public static function additionalSetting($app, $request, $response, $args)
  {
    // Sementara Fungsi ini enggak aku pakai 
    // aku pakai additionalSettingNew

    $data = $request->getParsedBody();
    // return var_dump($data);
    $updated = [];
    $selectAvaliable = $app->db->select('tbl_users', [
      'username',
      'email',
      'password'
    ], [
      'id_user' => $data['id_user']
    ]);
    if ($data['password'] != '') {
      array_push($updated, array('password' => $data['password']));
      // return var_dump($selectAvaliable[0]['password'] == $data['password']);
      if ($selectAvaliable[0]['password'] == $data['password']) {
        $_SESSION['passSame'] = true;
        return $response->withRedirect('/profile-setting');
      }
    }
    // if($data['password'] == $selectAvaliable[0]){

    // }
    // $delete = $container->db->delete('tbl_users', [
    //     'id_user' => $data['id'],
    // ]);

    return $response->withJson(array("success"));

    // return var_dump($data);

  }

  public static function ubahPassword($app, $request, $response, $args)
  {
    $username =  $request->getParam('username');
    $password = $request->getParam('password');

    $encryptedPassword = indexApiController::encrypt($password, $_ENV['SALT']);

    $app->db->update("tbl_users", [
      "password" => $encryptedPassword,
    ], [
      "username" => $username,
    ]);

    $getLastUpdatedUsers = $app->db->query("select username from tbl_users order by update_at desc limit 1")->fetch();

    $response = [
      'status' => 'success',
      'details' => ['last update username' => $getLastUpdatedUsers]
    ];

    return $response;
  }


  public static function ubahUsername($app, $request, $response, $args)
  {
    $username =  $request->getParam('username');
    $email = $request->getParam('email');
    $validation = $app->db->select("tbl_users", [
      "username",
    ], [
      "username" => $username,
    ]);
    // return die(var_dump(isset($validation[0]['username'])));
    if (isset($validation[0]['username'])){
      $response = ['status' => 'failed',
      'details' => ['messege' => "Username Terdaftar"]];
    }
    else {
      $app->db->update("tbl_users", [
        "username" => $username,
      ], [
        "email" => $email,
      ]);
      $getLastUpdatedUsers = $app->db->query("select username from tbl_users order by update_at desc limit 1")->fetch();

      $response = [
        'status' => 'success',
        'details' => ['last update username' => $getLastUpdatedUsers]
      ];
      
    }
    return $response;
  }

  public static function ubahEmail($app, $request, $response, $args)
  {
    // return die(var_dump($args));
    $username =  $args['key'];
    $email = $args['email'];
    $email .= '.com';
    
    $app->db->update("tbl_users", [
      "email" => $email,
    ], [
      "username" => $username,
    ]);

    $_SESSION['emailChangeSuccess'] = true;
    return $response->withRedirect('/profile-setting');
  }
  
  public static function sendEmailVerification($app, $request, $response, $args){
      $username =  $request->getParam('username');
      $email = $request->getParam('email');
      $id_user = $request->getParam('id_user');
      // return die(var_dump($id_user));
      $validation = $app->db->select("tbl_users", [
        "email",
      ], [
        "email" => $email,
      ]);
  
      if (isset($validation[0]['email'])){
        $response = ['status' => 'failed',
        'details' => ['messege' => "email Terdaftar"]];
      }else{
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
            $mail->addAddress($email);
            //Subject email
            $mail->Subject = 'PHPMailer GMail SMTP test';
            //Membaca isi pesan HTML dari file eksternal, mengkonversi gambar yang di embed,
            //Mengubah HTML menjadi basic plain-text
            //  $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
            //Replace plain text body dengan cara manual
            $mail->Body = '<a href="http://localhost:8200/verifEmailChange?key=' . $username . '&email=' . $email . '">Klik link ini untuk ganti Email</a>';
            $mail->AltBody = 'This is a plain-text message body';
            //Attach file gambar
            //  $mail->addAttachment('images/phpmailer_mini.png');
            //mengirim pesan, mengecek error

            if (!$mail->send()) {
                echo "Email Error: " . $mail->ErrorInfo;
            } else {
                $_SESSION['changeEmailSuccess'] = true;
                // $response = ['status'=>'success'];
                return $response->withRedirect('/profile-setting');
            }

      }
      return $response;
  }


  public static function profilesetting($app, $request, $response, $args)
  {
    // Render index view
    // $_SESSION['myProfile'] = true;
    $emailChangeSuccess = isset($_SESSION['emailChangeSuccess']);
    unset($_SESSION['emailChangeSuccess']);
    // return var_dump($emailChangeSuccess);
    $data = $app->db->select('tbl_users', [
      "[>]tbl_classes" => "id_class",
      "[>]tbl_hostels" => "id_hostel",
      "[>]tbl_transports" => ["id_trans" => "id_transport"],
      "[>]tbl_user_types" => "id_user_type",
    ], [
      "tbl_users.id_user",
      "tbl_classes.class",
      "tbl_hostels.hostel_name",
      "id_user_type",
      "first_name",
      "last_name",
      "gender",
      "date_of_birth",
      "religion",
      "username",
      "email",
      "password",
      "photo_user",
      "blood_group",
      "occupation",
      "phone_user",
      "address_user",
      "short_bio",
    ], [
      'id_user' => $_SESSION['id_user'],
    ]);
    // return var_dump($response);
    $changeEmailSuccess = isset($_SESSION['changeEmailSuccess']);
    unset($_SESSION['changeEmailSuccess']);
    
    $app->view->render($response, 'others/profile-setting.html', [
      'data' => $data[0],
      'myProfile' => true,
      'changeEmailSuccess' => $changeEmailSuccess,
      'emailChangeSuccess' => $emailChangeSuccess
    ]);
  }
}
