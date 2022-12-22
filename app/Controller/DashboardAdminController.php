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
            "AND" => [
                "id_payment_type" => "1",
                "status_pembayaran" => "Dibayar",
            ],
        ]);

        $totalDanaBOS = $app->db->sum("tbl_finances", "amount_payment", [
            "id_payment_type" => "2",
        ]);

        $danaMasuk = $app->db->sum("tbl_finances", "amount_payment", [
            "AND" => [
                "tipe_finance" => 'Pemasukan',
                "status_pembayaran" => "Dibayar",
            ],
        ]);

        $danaKeluar = $app->db->sum("tbl_finances", "amount_payment", [
            "AND" => [
                "tipe_finance" => 'Pengeluaran',
                "status_pembayaran" => "Dibayar",
            ],
        ]);

        $totalDana = $danaMasuk - $danaKeluar;

        $year = $app->db->query("
        SELECT YEAR(date_payment) AS tahun FROM `tbl_finances` WHERE YEAR(date_payment) GROUP BY YEAR(date_payment) DESC")->fetchAll();

        // Add message for navbar
        $message = $app->db->select('tbl_messages(m)', [
            '[>]tbl_users' => 'id_user',
        ], [
            'id_message',
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
            'username' => $args['username'],
        ]);
        
        $countMessage = $app->db->count('tbl_messages', [
            '[>]tbl_users' => 'id_user',
        ], 'id_message', [
            'username' => $args['username'],
        ]);

        return $app->view->render($res, 'dashboard/index.html', [
            'totalSiswa' => $totalSiswa,
            "totalSiswaMale" => $totalSiswaMale,
            "totalSiswaFemale" => $totalSiswaFemale,
            'totalTeacher' => $totalTeacher,
            'totalParent' => $totalParent,
            'totalDana' => $totalDana,
            'danaMasuk' => number_format($danaMasuk,0,',','.'),
            'danaKeluar' => number_format($danaKeluar,0,',','.'),
            'totalDanaShow' => 'Rp ' . number_format($totalDana,0,',','.'),
            'type_user' => $_SESSION['type_user'],
            'totalDanaBOS' => $totalDanaBOS,
            'totalSppSiswa' => $totalSppSiswa,
            'username' => $args['username'],
            'photo_user' => $_SESSION['photo_user'],
            'message' => $message,
            'countMessage' => $countMessage,
            'year' => $year,
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

        $year = $app->db->query("
        SELECT YEAR(date_payment) FROM `tbl_finances` WHERE YEAR(date_payment) GROUP BY YEAR(date_payment)")->fetchAll();

        // $totalTahun = count($year);

        return $res->withJson(array(
            'tahun' => $year,
            "totalSiswaMale" => $totalSiswaMale,
            "totalSiswaFemale" => $totalSiswaFemale,
            // "totalTahun" => $totalTahun,
        ));
    }

    public static function lineChart($app, $req, $res, $args)
    {
        $year = $req->getParam('year');
        $in = [];
        $out = [];
        for ($x = 1; $x <= 12; $x++) {
            // if(){
                
            // }
            //dana masuk
            array_push($in, $app->db->sum('tbl_finances', 'amount_payment', Medoo::raw("WHERE MONTH(date_payment) = " . $x . " AND `tipe_finance` = 'Pemasukan' AND `status_pembayaran` = 'Dibayar' AND YEAR(date_payment) = " . $year)));
            //dana keluar
            array_push($out, $app->db->sum('tbl_finances', 'amount_payment', Medoo::raw("WHERE MONTH(date_payment) = " . $x . " AND `tipe_finance` = 'Pengeluaran' AND `status_pembayaran` = 'Dibayar' AND YEAR(date_payment) = " . $year)));
        }
        
        return $res->withJson([
            'in' => $in,
            'out' => $out,
        ]);
    }
}
