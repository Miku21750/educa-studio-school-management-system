<?php

namespace App\Controller;

use Medoo\Medoo;


class MessageController
{


  public static function sendMessage($app, $request, $response, $args)
  {
    // Render index view
    $data = $request->getParsedBody();
    // return var_dump($data);
    $dataSender = $app->db->select('tbl_users', [
      'email',
      'first_name',
      'last_name',
      'username',
    ], [
      'id_user' => $data['id_sender'],
    ]);
    $dataReceipent = $app->db->select('tbl_users', 'email', [
      'id_user' => $data['id_user'],
    ]);
    // return die(var_dump($dataSender[0]['email']));
    // return die(var_dump($dataSender[0]));
    $insert = $app->db->insert('tbl_messages', [
      'id_user' => $data['id_user'],
      'receiver_email' => $dataReceipent[0],
      'sender_email' => $dataSender[0]['email'],
      'title' => $data['title'],
      'message' => $data['message'],
      'readed' => 0,
    ]);
    $addressSender = $dataSender[0]['email'];
    //$mail->addAddress($dataSender[0]['email']);
    ////Subject email
    $subject = $data['title'];
    //$mail->Subject = 'PHPMailer GMail SMTP test';
    $dataName = '';
    if ($dataSender[0]['first_name'] == '') {
      $dataName = $dataSender[0]['username'];
    } else {
      $dataName = $dataSender[0]['first_name'] . ' ' . $dataSender[0]['last_name'];
    };
    ////Replace plain text body dengan cara manual
    $bodyEmail = '<h3>You got message from ' . $dataName . '</h3><br><h1>' . $data['title'] . '</h1><br><br><p>' . $data['message'] . '</p>';
    //$mail->Body = '<h3>You got message from ' . $dataName . '</h3><br><h1>' . $data['title'] . '</h1><br><br><p>' . $data['message'] . '</p>';
    $altBody = 'This is a plain-text message body';
    ////mengirim pesan, mengecek error
    return EmailController::emailConfig($app, $request, $response, [
      'addressEmail' => $addressSender,
      'subjectEmail' => $subject,
      'bodyEmail' => $bodyEmail,
      'altBody' => $altBody,
    ]);
    //if (!$mail->send()) {
    //    echo "Email Error: " . $mail->ErrorInfo;
    //}
    //return;
    // kirim email end here
    // $container->view->render($response, 'others/messaging.html', $args);
  }

  // membaca pesan
  public static function readMessage($app, $request, $response, $args)
  {
    // Render index view
    $data = $request->getParsedBody();
    // return var_dump($data);
    $dataSender = $app->db->update('tbl_messages', [
      'readed' => 1,
    ], [
      'id_message' => $data['id_message'],
    ]);
    // return var_dump($dataSender);
    // $container->view->render($response, 'others/messaging.html', $args);
    return $response->withJson(array('success' => true));
  }

  // mendapatkan detail pesan
  public static function getMessageDetail($app, $request, $response, $args)
  {
    // Render index view'
    // return var_dump($request->getParam('id'));
    $id = $request->getParam('id_message');
    $dataNotice = $app->db->select('tbl_messages(m)', [
      '[>]tbl_users' => 'id_user',
    ], [
      'id_message',
      'totalMessage' => Medoo::raw("(SELECT COUNT(id_message) FROM `tbl_messages` AS `m` LEFT JOIN `tbl_users` USING (`id_user`) WHERE username = '" . $_SESSION['username'] . "')"),
      'id_user',
      'receiver_email',
      'sender_email',
      'title',
      'message',
      'readed',
      'photo_sender' => Medoo::raw('(SELECT photo_user FROM tbl_users WHERE email = m.sender_email)'),
      'first_name_sender' => Medoo::raw('(SELECT first_name FROM tbl_users WHERE email = m.sender_email)'),
      'last_name_sender' => Medoo::raw('(SELECT last_name FROM tbl_users WHERE email = m.sender_email)'),
      'time_sended',
    ], [
      'username' => $_SESSION['username'],
      'id_message' => $id,
    ]);
    //return var_dump($dataNotice);
    return $response->withJson($dataNotice);
  }


  public static function getMessageReply($app, $request, $response, $args)
  {
    // Render index view'
    // return var_dump($request->getParam('id'));
    $id = $request->getParam('id_message');
    // return die(var_dump($request->getParams()));
    $dataNotice = $app->db->select('tbl_messages(m)', [
      '[>]tbl_users' => 'id_user',
    ], [
      'id_message',
      'totalMessage' => Medoo::raw("(SELECT COUNT(id_message) FROM `tbl_messages` AS `m` LEFT JOIN `tbl_users` USING (`id_user`) WHERE username = '" . $_SESSION['username'] . "')"),
      'id_user',
      'receiver_email',
      'sender_email',
      'title',
      'message',
      'readed',
      'photo_sender' => Medoo::raw('(SELECT photo_user FROM tbl_users WHERE email = m.sender_email)'),
      'first_name_sender' => Medoo::raw('(SELECT first_name FROM tbl_users WHERE email = m.sender_email)'),
      'last_name_sender' => Medoo::raw('(SELECT last_name FROM tbl_users WHERE email = m.sender_email)'),
      'time_sended',
    ], [
      'username' => $_SESSION['username'],
      'id_message' => $id,
    ]);
    // return var_dump($dataNotice);
    // return $response->withJson($dataNotice);
    $_SESSION['dataMessage'] = $dataNotice;
    // return die(var_dump($_SESSION));
    return $response->withJson(array('success' => true));
    // return array(Success);
    // return $response->withRedirect('/messaging');
  }
}
