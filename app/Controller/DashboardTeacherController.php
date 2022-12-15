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

   
    public static function hitungPendapatanTotal($app, $request, $response, $args)
    {
        $response = $app->db->sum("tbl_finances", "amount_payment", [
            "id_user" => $_SESSION['id_user']
        ]);
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
        $siswaTotal = DashboardTeacherController::hitungSiswa($app, $request, $response, $args, null);
        $siswaLakiLaki = $siswaTotal = DashboardTeacherController::hitungSiswa($app, $request, $response, $args, "Laki-laki");
        $siswaPerempuan = $siswaTotal = DashboardTeacherController::hitungSiswa($app, $request, $response, $args, "Perempuan");
        $totalUjian = DashboardTeacherController::hitungUjian($app, $request, $response, $args, null);
        $pendapatanTotal = DashboardTeacherController::hitungPendapatanTotal($app, $request, $response, $args);
        $id = $_SESSION['id_user'];

        $notif = $app->db->select('tbl_notifications','*',[
            'category' => 'Pengumuman_Sekolah'
        ]);

        $totallulus = $app->db->count('tbl_users', [
            "[><]tbl_classes" => "id_class"
        ],'*', [
            "class" => 'Lulus',
        ]);

        $app->view->render($response, 'dashboard/teacher.html', [
            'notif' =>  $notif,
            'id_teacher' => $_SESSION['id_user'],
            'user' => $_SESSION['user'],
            'type' => $_SESSION['type'],
            'type_user' => $_SESSION['type_user'],
            'nama_user' => $_SESSION['type'],
            'username' => $_SESSION['username'],
            'siswaTotal' => $siswaTotal,
            'siswaLulus' => $totallulus,
            'ujianTotal' => $totalUjian,
            'pendapatanTotal' => $pendapatanTotal,
            'siswaLakiLaki' => $siswaLakiLaki,
            'siswaPerempuan' => $siswaPerempuan,
        ]);
    }

    public static function tampil_data($app, $req, $rsp, $args)
    {
        $type = 1;
        $tbl_classes = 'tbl_classes';

        $parent = $app->db->select('tbl_users(a)', [
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_admissions' => 'id_user',
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
            '[><]tbl_users(b)' => ['a.id_parent' => 'id_user']
        ], [
            'a.id_user(id_user)',
            'a.NISN(nisn)',
            'a.photo_user(foto)',
            'a.first_name(first_name_student)',
            'a.last_name(last_name_student)',
            'a.gender(gender)',
            'class(class)',
            'section(section)',
            'a.address_user(alamat)',
            'a.date_of_birth(tanggal_lahir)',
            'a.phone_user(telepon)',
            'a.email(email)',
            'b.first_name(first_name_parent)',
            'b.last_name(last_name_parent)',
        ],[
            "a.id_class[!]" => 99
        ]);
        // return var_dump($parent);
        // die();
      

        $columns = array(
            0 => 'id',
        );

        $totaldata = count($parent);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];


        $conditions = [
            "LIMIT" => [$start, $limit],
            "a.id_class[!]" => 99

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                'id_user_type' => $type,
                "a.id_class[!]" => 99

            ];
            $conditions['OR'] = [
                'a.first_name[~]' => '%' . $search . '%',
                'a.last_name[~]' => '%' . $search . '%',

            ];
            $parent = $app->db->select(
                'tbl_users(a)',
                [
                    '[><]tbl_classes' => 'id_class',
                    '[><]tbl_admissions' => 'id_user',
                    '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
                    '[><]tbl_users(b)' => ['a.id_parent' => 'id_user']
                ],
                [
                    'a.id_user(id_user)',
                    'a.NISN(nisn)',
                    'a.photo_user(foto)',
                    'a.first_name(first_name_student)',
                    'a.last_name(last_name_student)',
                    'a.gender(gender)',
                    'class(class)',
                    'section(section)',
                    'a.address_user(alamat)',
                    'a.date_of_birth(tanggal_lahir)',
                    'a.phone_user(telepon)',
                    'a.email(email)',
                    'b.first_name(first_name_parent)',
                    'b.last_name(last_name_parent)',
                ],
                $limit
            );
            $totaldata = count($parent);
            $totalfiltered = $totaldata;
            // return var_dump($totaldata);
        }

        $parent = $app->db->select('tbl_users(a)', [
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_admissions' => 'id_user',
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
            '[><]tbl_users(b)' => ['a.id_parent' => 'id_user']
        ], [
            'a.id_user(id_user)',
            'a.NISN(nisn)',
            'a.photo_user(foto)',
            'a.first_name(first_name_student)',
            'a.last_name(last_name_student)',
            'a.gender(gender)',
            'class(class)',
            'section(section)',
            'a.address_user(alamat)',
            'a.date_of_birth(tanggal_lahir)',
            'a.phone_user(telepon)',
            'a.email(email)',
            'b.first_name(first_name_parent)',
            'b.last_name(last_name_parent)',
        ], $conditions);

        $data = array();

        if (!empty($parent)) {
            $no = $req->getParam('start') + 1;
            foreach ($parent as $m) {

                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['nisn'];
                $datas['foto'] = '<img src="/uploads/Profile/' . $m['foto'] . '" style="width:30px;"  alt="student">';
                $datas['nama'] = $m['first_name_student'] . ' ' . $m['last_name_student'];
                $datas['gender'] = $m['gender'];
                $datas['class'] = $m['class'];
                $datas['section'] = $m['section'];
                $datas['parent'] = $m['first_name_parent'] . ' ' . $m['last_name_parent'];
                $datas['alamat'] = $m['alamat'];
                $datas['tanggal_lahir'] = $m['tanggal_lahir'];
                $datas['telepon'] = $m['telepon'];
                $datas['email'] = $m['email'];
               
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($parent);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }
    
    
}
