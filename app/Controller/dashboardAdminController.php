<?php
namespace App\Controller;

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
        
        $sppSiswa = $app->db->sum("tbl_finances", "amount_payment", [
            "id_payment_type" => "1",
        ]);

        $danaBOS = $app->db->sum("tbl_finances", "amount_payment", [
            "id_payment_type" => "2",
        ]);
    
        $danaMasuk = $app->db->sum("tbl_finances", "amount_payment", [
            "AND"=>[
            "id_payment_type" => [1, 2],
            "status" => "Dibayar",
            ]
        ]);

        $danaKeluar = $app->db->sum("tbl_finances", "amount_payment", [
            "id_payment_type" => "3",
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
            'danaBOS' => $danaBOS,
            'sppSiswa' => $sppSiswa,
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

        return $res->withJson(array(
            // "siswa" => $siswa,
            // "teacher" => $teacher,
            // "parent" => $parent,
            "totalSiswaMale" => $totalSiswaMale,
            "totalSiswaFemale" => $totalSiswaFemale,
        ));
    }

}
