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
        $data = $data = DashboardTeacherController::tableSiswa($app, $request, $response, $args);

        $columns = array(
            0 => 'id',
        );

        $totaldata = count($data);
        $totalfiltered = $totaldata;
        $limit = $request->getParam('length');
        $start = $request->getParam('start');
        $getOrder = $request->getParam('order');
        $order = $columns[$getOrder[0]['column']];
        $dir = $request->getParam('order');
        $dir = $dir[0]['dir'];

        $conditions = [
            "LIMIT" => [$start, $limit],
        ];

        if (!empty($request->getParam('search')['value'])) {
            $search = $request->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
            ];
            $conditions['OR'] = [
                'tbl_handphone.nama_barang[~]' => '%' . $search . '%',
            ];
            $data = $app->db->select(
                'tbl_handphone',
                [
                    "[><]tbl_barja" => ["id_barja" => "id_barja"],
                ],
                [
                    'id_barang',
                    'nama_barang',
                    'nama_barja',
                    'soc',
                    'ram',
                    'rom',
                    'kamera',
                    'battre',
                    'harga',
                ],
                $limit
            );
            $totaldata = count($data);
            $totalfiltered = $totaldata;
        }

        $phone = $app->db->select('tbl_handphone', [
            "[><]tbl_barja" => ["id_barja" => "id_barja"],
        ], [
            'id_barang',
            'nama_barang',
            'nama_barja',
            'soc',
            'ram',
            'rom',
            'kamera',
            'battre',
            'harga',
        ], $conditions);

        $data = array();

        if (!empty($phone)) {
            $no = $request->getParam('start') + 1;
            foreach ($phone as $m) {

                $datas['no'] = $no . '.';
                $datas['nama_barang'] = $m['nama_barang'];
                $datas['nama_barja'] = $m['nama_barja'];
                $datas['soc'] = $m['soc'];
                $datas['ram'] = $m['ram'];
                $datas['rom'] = $m['rom'];
                $datas['kamera'] = $m['kamera'];
                $datas['battre'] = $m['battre'];
                $datas['harga'] = $m['harga'];
                $datas['ubah'] = '<button type="button" class="btn btn-warning item_edit" data="' . $m['id_barang'] . '"><span class="fa fa-pencil-square-o"></span> Ubah</button>';
                $datas['hapus'] = '<button type="button" class="btn btn-danger item_hapus " data="' . $m['id_barang'] . '"><span class="fa fa-trash-o"></span> Delete</button>';
                $data[] = $datas;
                $no++;
            }
        }

        $response = array(
            "draw" => intval($request->getParam('draw')),
            "recordsTotal" => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data" => $data,
        );

        // echo json_encode($response);

        return $response;
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
