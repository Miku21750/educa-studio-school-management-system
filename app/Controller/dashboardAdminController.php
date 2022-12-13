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
                "status_pembayaran" => "Dibayar",
            ]
        ]);

        $totalDanaBOS = $app->db->sum("tbl_finances", "amount_payment", [
            "id_payment_type" => "2",
        ]);
    
        $danaMasuk = $app->db->sum("tbl_finances", "amount_payment", [
            "AND"=>[
            "id_payment_type" => [1, 2],
            "status_pembayaran" => "Dibayar",
            ]
        ]);

        $danaKeluar = $app->db->sum("tbl_finances", "amount_payment", [
            "AND"=>[
                "id_payment_type" => [3,4],
                "status_pembayaran" => "Dibayar",
            ]
        ]);
        
        $totalDana = $danaMasuk - $danaKeluar;

        $year = $app->db->query("SELECT DISTINCT YEAR(date_payment) as tahun FROM tbl_finances")->fetchAll();
        
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
            'danaMasuk' => $danaMasuk,
            'danaKeluar' => $danaKeluar,
            // 'danaBOS' => $danaBOS,
            // 'sppSiswa' => $sppSiswa,
            'type_user' => $_SESSION['type_user'],
            'totalDanaBOS' => $totalDanaBOS,
            'totalSppSiswa' => $totalSppSiswa,
            'username' => $args['username'],
            'photo_user' => $_SESSION['photo_user'],
            'message' => $message,
            'countMessage'=> $countMessage,
            'year'=> $year,
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

        $sppSiswa = $app->db->query("
        SELECT `amount_payment` FROM `tbl_finances` WHERE MONTH(date_payment) = 2020 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();

        $year = $app->db->query("
        SELECT DISTINCT `year` FROM `tbl_finances` WHERE YEAR(date_payment)")->fetchAll();

        // $app->view->render($rsp, 'dashboard/index.html', [
        //     'year' => $year,
        // ]);
            // return die(var_dump($totalSiswaMale));
        return $res->withJson(array(
            // "siswa" => $siswa,
            // "teacher" => $teacher,
            // "parent" => $parent,
            'sppSiswa'=>$sppSiswa,
            'tahun'=>$year,
            "totalSiswaMale" => $totalSiswaMale,
            "totalSiswaFemale" => $totalSiswaFemale,
            "sppSiswa" => $sppSiswa,
        ));
    }

    public static function lineChart($app, $req, $res, $args){
        //dana masuk
        $inJan = $app->db->query("
        SELECT SUM(amount_payment) as in_jan FROM `tbl_finances` WHERE MONTH(date_payment) = 1 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();

        $inFeb = $app->db->query("
        SELECT SUM(amount_payment) as in_feb FROM `tbl_finances` WHERE MONTH(date_payment) = 2 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $inMar = $app->db->query("
        SELECT SUM(amount_payment) as in_mar FROM `tbl_finances` WHERE MONTH(date_payment) = 3 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $inApr = $app->db->query("
        SELECT SUM(amount_payment) as in_apr FROM `tbl_finances` WHERE MONTH(date_payment) = 4 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $inMei = $app->db->query("
        SELECT SUM(amount_payment) as in_mei FROM `tbl_finances` WHERE MONTH(date_payment) = 5 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $inJun = $app->db->query("
        SELECT SUM(amount_payment) as in_jun FROM `tbl_finances` WHERE MONTH(date_payment) = 6 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $inJul = $app->db->query("
        SELECT SUM(amount_payment) as in_jul FROM `tbl_finances` WHERE MONTH(date_payment) = 7 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $inAug = $app->db->query("
        SELECT SUM(amount_payment) as in_aug FROM `tbl_finances` WHERE MONTH(date_payment) = 8 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $inSep = $app->db->query("
        SELECT SUM(amount_payment) as in_sep FROM `tbl_finances` WHERE MONTH(date_payment) = 9 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $inOkt = $app->db->query("
        SELECT SUM(amount_payment) as in_okt FROM `tbl_finances` WHERE MONTH(date_payment) = 10 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $inNov = $app->db->query("
        SELECT SUM(amount_payment) as in_nov FROM `tbl_finances` WHERE MONTH(date_payment) = 11 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $inDes = $app->db->query("
        SELECT SUM(amount_payment) as in_des FROM `tbl_finances` WHERE MONTH(date_payment) = 12 AND `id_payment_type` = 1 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        //dana keluar
        $outJan = $app->db->query("
        SELECT SUM(amount_payment) as out_jan FROM `tbl_finances` WHERE MONTH(date_payment) = 1 AND `id_payment_type` = 3 AND `status_pembayaran` = 'Dibayar'")->fetchAll();

        $outFeb = $app->db->query("
        SELECT SUM(amount_payment) as out_feb FROM `tbl_finances` WHERE MONTH(date_payment) = 2 AND `id_payment_type` = 3 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $outMar = $app->db->query("
        SELECT SUM(amount_payment) as out_mar FROM `tbl_finances` WHERE MONTH(date_payment) = 3 AND `id_payment_type` = 3 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $outApr = $app->db->query("
        SELECT SUM(amount_payment) as out_apr FROM `tbl_finances` WHERE MONTH(date_payment) = 4 AND `id_payment_type` = 3 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $outMei = $app->db->query("
        SELECT SUM(amount_payment) as out_mei FROM `tbl_finances` WHERE MONTH(date_payment) = 5 AND `id_payment_type` = 3 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $outJun = $app->db->query("
        SELECT SUM(amount_payment) as out_jun FROM `tbl_finances` WHERE MONTH(date_payment) = 6 AND `id_payment_type` = 3 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $outJul = $app->db->query("
        SELECT SUM(amount_payment) as out_jul FROM `tbl_finances` WHERE MONTH(date_payment) = 7 AND `id_payment_type` = 3 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $outAug = $app->db->query("
        SELECT SUM(amount_payment) as out_aug FROM `tbl_finances` WHERE MONTH(date_payment) = 8 AND `id_payment_type` = 3 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $outSep = $app->db->query("
        SELECT SUM(amount_payment) as out_sep FROM `tbl_finances` WHERE MONTH(date_payment) = 9 AND `id_payment_type` = 3 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $outOkt = $app->db->query("
        SELECT SUM(amount_payment) as out_okt FROM `tbl_finances` WHERE MONTH(date_payment) = 10 AND `id_payment_type` = 3 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $outNov = $app->db->query("
        SELECT SUM(amount_payment) as out_nov FROM `tbl_finances` WHERE MONTH(date_payment) = 11 AND `id_payment_type` = 3 AND `status_pembayaran` = 'Dibayar'")->fetchAll();
        
        $outDes = $app->db->query("
        SELECT SUM(amount_payment) as out_des FROM `tbl_finances` WHERE MONTH(date_payment) = 12 AND `id_payment_type` = 3 AND `status_pembayaran` = 'Dibayar'")->fetchAll();

        return $res->withJson(array(
            "inJan" => $inJan,
            "inFeb" => $inFeb,
            "inMar" => $inMar,
            "inApr" => $inApr,
            "inMei" => $inMei,
            "inJun" => $inJun,
            "inJul" => $inJul,
            "inAug" => $inAug,
            "inSep" => $inSep,
            "inOkt" => $inOkt,
            "inNov" => $inNov,
            "inDes" => $inDes,
            "outJan" => $outJan,
            "outFeb" => $outFeb,
            "outMar" => $outMar,
            "outApr" => $outApr,
            "outMei" => $outMei,
            "outJun" => $outJun,
            "outJul" => $outJul,
            "outAug" => $outAug,
            "outSep" => $outSep,
            "outOkt" => $outOkt,
            "outNov" => $outNov,
            "outDes" => $outDes,
        ));
    }
}
