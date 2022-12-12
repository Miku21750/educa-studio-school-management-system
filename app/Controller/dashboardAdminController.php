<?php
namespace App\Controller;
use Medoo\medoo;

class DashboardAdminController
{
    public static function index($app, $req, $rsp, $args)
    {
        $app->get('renderer')->render($rsp, 'index.html', $args);
    }

    public static function getData($app, $req, $res, $args)
    {
        $totalSiswa = $app->db->count('tbl_users', [
            "id_user_type" => "1",
        ]);

        $totalSiswaMale = $app->db->count('tbl_users', [
            "id_user_type" => "1",
            "gender" => "Laki-laki",
        ]);

        $totalSiswaFemale = $app->db->count('tbl_users', [
            "id_user_type" => "1",
            "gender" => "Perempuan",
        ]);

        $totalTeacher = $app->db->count('tbl_users', [
            "id_user_type" => "2",
        ]);

        $totalParent = $app->db->count('tbl_users', [
            "id_user_type" => "4",
        ]);
        
        $totalSppSiswa = $app->db->sum("tbl_finances", "amount_payment", [
            "AND"=>[
                "id_payment_type" => "1",
                "status" => "Dibayar",
            ]
        ]);

        $totalDanaBOS = $app->db->sum("tbl_finances", "amount_payment", [
            "id_payment_type" => "2",
        ]);
    
        $danaMasuk = $app->db->sum("tbl_finances", "amount_payment", [
            "AND"=>[
            "id_payment_type" => [1, 2],
            "status" => "Dibayar",
            ]
        ]);

        $danaKeluar = $app->db->sum("tbl_finances", "amount_payment", [
            "AND"=>[
                "id_payment_type" => "3",
                "status" => "Dibayar",
            ]
        ]);
        
        $totalDana = $danaMasuk - $danaKeluar;

        // Add message for navbar
        $message = $app->db->select('tbl_messages(m)', [
            '[>]tbl_users' => 'id_user'
        ], [
            'id_message',
            'id_user',
            'receiver_email',
            'sender_email',
            'title',
            'message',
            'readed',
            'photo_sender'=>Medoo::raw('(SELECT photo_user FROM tbl_users WHERE email = m.sender_email)'),
            'first_name_sender'=>Medoo::raw('(SELECT first_name FROM tbl_users WHERE email = m.sender_email)'),
            'last_name_sender'=>Medoo::raw('(SELECT last_name FROM tbl_users WHERE email = m.sender_email)'),
            'time_sended'
        ], [
            'username' => $args['username']
        ]);
        // return var_dump($_SESSION);

        //countMessage
        $countMessage = $app->db->count('tbl_messages',[
            '[>]tbl_users' => 'id_user'
        ],'id_message', [
            'username' => $args['username']
        ]);
        // return var_dump($countMessage);

        // return $count;
        // return var_dump($args);
        return $app->view->render($res, 'dashboard/index.html', [
            'totalSiswa' => $totalSiswa,
            "totalSiswaMale" => $totalSiswaMale,
            "totalSiswaFemale" => $totalSiswaFemale,
            'totalTeacher' => $totalTeacher,
            'totalParent' => $totalParent,
            'totalDana' => $totalDana,
            // 'danaBOS' => $danaBOS,
            // 'sppSiswa' => $sppSiswa,
            'type_user' => $_SESSION['type_user'],
            'totalDanaBOS' => $totalDanaBOS,
            'totalSppSiswa' => $totalSppSiswa,
            'username' => $args['username'],
            'photo_user' => $_SESSION['photo_user'],
            'message' => $message,
            'countMessage'=> $countMessage,
            'user' => $args['user'],
            'type' => $args['type'],
        ]);
    }

    public static function apiData($app, $req, $res, $args)
    {
        // return var_dump('aaa');
        $siswa = $app->db->select("tbl_users", "*", [
            "id_user_type" => "1",
        ]);

        $teacher = $app->db->select("tbl_users", "*", [
            "id_user_type" => "2",
        ]);

        $parent = $app->db->select("tbl_users", "*", [
            "id_user_type" => "4",
        ]);

        $totalSiswaMale = $app->db->count('tbl_users', [
            "id_user_type" => "1",
            "gender" => "Laki-laki",
        ]);

        $totalSiswaFemale = $app->db->count('tbl_users', [
            "id_user_type" => "1",
            "gender" => "Perempuan",
        ]);
        // $finance = $app->db
        // $sppSiswa = $app->db->debug()->select('tbl_finances','amount_payment',
        //     // "AND"=>[
        //     //     "id_payment_type" => "1",
        //     //     "status" => "Dibayar",
        //     //     Medoo::raw('YEAR(date_payment) = 2020')
        //     // ]
        //     Medoo::raw('WHERE
        //     YEAR(date_payment) = 2020 AND <id_payment_type> = 1 AND <status> = "Dibayar"')
        // );
        $sppSiswa = $app->db->query("
        SELECT `amount_payment` FROM `tbl_finances` WHERE YEAR(date_payment) = 1973 AND `tipe_finance` = 'Pemasukan' AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        // return die(var_dump($sppSiswa));
        return $res->withJson(array(
            // "siswa" => $siswa,
            // "teacher" => $teacher,
            // "parent" => $parent,
            'sppSiswa'=>$sppSiswa,
            'tahun'=>$args['data'],
            "totalSiswaMale" => $totalSiswaMale,
            "totalSiswaFemale" => $totalSiswaFemale,
            "sppSiswa" => $sppSiswa,
        ));
    }

}
