<?php

namespace App\Controller;

class DashboardTeacherController
{

    public static function hitungTotalSiswa($app, $request, $response, $args)
    {
        $response = $app->db->count("tbl_users", ["id_user_type" => "1"]);
        return $response;
    }

    public static function tableSiswa($app, $request, $response, $args)
    {
        $response = $app->db->query("select distinct a.id_parent,b.id_user,a.photo_user as photo,CONCAT(a.first_name,' ',a.last_name) as nama ,gender as jenis_kelamin, tc.class as kelas, tc.id_section as bagian, CONCAT(b.first_name,' ',b.last_name) As ortu ,a.address_user as alamat,a.date_of_birth as tanggal_lahir,a.phone_user as no_hp,a.email from tbl_users a left join (select b.id_user,b.first_name,b.last_name  from tbl_users b where id_user_type = 4) b on a.id_parent = b.id_user left join tbl_classes tc on a.id_class = tc.id_class left join tbl_sections ts on tc.id_section = tc.id_section where a.id_user_type =1;")->fetchAll();

        return $response;

    }

    public static function dtSiswa($app, $request, $response, $args)
    {
        

        return 0;
    }

    public static function index($app, $request, $response, $args)
    {
        $type = "Teacher";
        $totalSiswa = DashboardTeacherController::hitungTotalSiswa($app, $request, $response, $args);
        $app->view->render($response, 'dashboard/teacher.html', [
            'user' => $_SESSION['user'],
            'type' => $type,
            'totalSiswa' => $totalSiswa,
        ]);
    }

    public static function dashboardTeacherData($app, $request, $response, $args)
    {
        $totalSiswa = DashboardTeacherController::hitungTotalSiswa($app, $request, $response, $args);
        $response = [
            'totalSiswa' => $totalSiswa,
            '',
        ];
    }

}
