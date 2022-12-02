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
            'user' => $args['user'],
            'type' => $args['type'],
        ]);
    }

    public static function apiData($app, $req, $res, $args)
    {
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
        SELECT `amount_payment` FROM `tbl_finances` WHERE YEAR(date_payment) = 2020 AND `id_payment_type` = 1 AND `status` = 'Dibayar'")->fetchAll();

        return $res->withJson(array(
            // "siswa" => $siswa,
            // "teacher" => $teacher,
            // "parent" => $parent,
            "totalSiswaMale" => $totalSiswaMale,
            "totalSiswaFemale" => $totalSiswaFemale,
            "sppSiswa" => $sppSiswa,
        ));
    }

}
