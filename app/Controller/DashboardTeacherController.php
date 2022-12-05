<?php

namespace App\Controller;

class DashboardTeacherController
{



    public static function hitungUjian($app, $request, $response, $args, $Pelajaran)
    {
        // Pelajaran Lihat di daftar mata pekajaran
        $response = $app->db->count("tbl_exams");
        return $response;
    }

    public static function hitungSiswa($app, $request, $response, $args, $gender)
    {
        if ($gender == "Laki-laki") {
            $response = $app->db->count('tbl_users', ["id_user_type" => "1", "gender" => "Laki-laki"]);
        } elseif ($gender == "Perempuan") {
            $response = $app->db->count('tbl_users', ["id_user_type" => "1", "gender" => "Perempuan"]);
        } else {
            $response = $app->db->count('tbl_users', ["id_user_type" => "1"]);
        }

        return $response;
    }

    public static function hitungSiswaLulus($app, $request, $response, $args)
    {
        // SELECT COUNT(admission_status) from tbl_users WHERE id_user_type = 1;
        $response = $app->db->count("tbl_users", ["admission_status" => "graduate", "AND" => ["id_user_type" => "1"]]);
        return $response;
    }

    public static function hitungPendapatanTotal($app, $request, $response, $args)
    {
        $response = $app->db->sum("tbl_finances", "amount_payment", ["id_payment_type" => "6", "AND" => ["id_user" => $_SESSION['id_user']]]);
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

    public static function view($app, $request, $response, $args)
    {
        $siswaLulus = DashboardTeacherController::hitungSiswaLulus($app, $request, $response, $args);
        $siswaTotal = DashboardTeacherController::hitungSiswa($app, $request, $response, $args, null);
        $siswaLakiLaki = $siswaTotal = DashboardTeacherController::hitungSiswa($app, $request, $response, $args, "Laki-laki");
        $siswaPerempuan = $siswaTotal = DashboardTeacherController::hitungSiswa($app, $request, $response, $args, "Perempuan");
        $totalUjian = DashboardTeacherController::hitungUjian($app, $request, $response, $args, null);
        $pendapatanTotal = DashboardTeacherController::hitungPendapatanTotal($app, $request, $response, $args);
        $app->view->render($response, 'dashboard/teacher.html', [
            'id_teacher' => $_SESSION['id_user'],
            'user' => $_SESSION['user'],
            'type' => $_SESSION['type'],
            'type_user' => $_SESSION['type_user'],
            'nama_user' => $_SESSION['type'],
            'username' => $_SESSION['username'],
            'siswaTotal' => $siswaTotal,
            'siswaLulus' => $siswaLulus,
            'ujianTotal' => $totalUjian,
            'pendapatanTotal' => $pendapatanTotal,
            'siswaLakiLaki' => $siswaLakiLaki,
            'siswaPerempuan' => $siswaPerempuan,
        ]);
    }
    
}
