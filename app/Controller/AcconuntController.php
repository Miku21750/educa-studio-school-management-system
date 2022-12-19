<?php

namespace App\Controller;

use Medoo\Medoo;



class AcconuntController
{

    public static function index($app, $request, $response, $args)
    {

        // return var_dump($id_finance);
        $payment_type = $app->db->select('tbl_payment_types', '*');


        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);

        $app->view->render($response, 'acconunt/all-fees.html', [

            'type_user' => $_SESSION['type_user'],
            'berhasil' => $berhasil,
            'payment_type' => $payment_type

        ]);
    }
    public static function pengeluaran($app, $request, $response, $args)
    {

        // return var_dump($id_finance);
        $payment_type = $app->db->select('tbl_payment_types', '*');


        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);

        $app->view->render($response, 'acconunt/all-expense.html', [

            'type_user' => $_SESSION['type_user'],
            'berhasil' => $berhasil,
            'payment_type' => $payment_type

        ]);
    }


    public static function tampil_data($app, $req, $rsp, $args)
    {

        $tbl_users = 'tbl_users';
        $tbl_classes = 'tbl_classes';


        $finance = $app->db->select('tbl_finances', [
            '[><]tbl_users' => 'id_user',
            '[><]tbl_classes' => ["$tbl_users.id_class" => 'id_class'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
            '[><]tbl_payment_types' => 'id_payment_type',
        ], [
            'id_finance',
            'NISN',
            'photo_user',
            'first_name',
            'last_name',
            'gender',
            'class',
            'section',
            'payment_type_name',
            'amount_payment',
            'status_pembayaran',
            'tipe_finance',
            'email',
            'phone_user',
            'date_payment',

        ], [
            'tipe_finance' => 'Pemasukan',
        ]);

        // return var_dump($finance);
        // die();
        $columns = array(
            0 => 'id',
        );

        $totaldata = count($finance);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];


        $conditions = [
            "LIMIT" => [$start, $limit],
            'tipe_finance' => 'Pemasukan',

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];

            $conditions['OR'] = [
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                'tbl_users.NISN[~]' => '%' . $search . '%',

            ];

            $limit = [
                "LIMIT" => [$start, $limit],
                'tipe_finance' => 'Pemasukan',

            ];

            $finance = $app->db->select('tbl_finances', [
                '[><]tbl_users' => 'id_user',
                '[><]tbl_classes' => ["$tbl_users.id_class" => 'id_class'],
                '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
                '[><]tbl_payment_types' => 'id_payment_type',
            ], [
                'id_finance',
                'NISN',
                'photo_user',
                'first_name',
                'last_name',
                'gender',
                'class',
                'section',
                'payment_type_name',
                'amount_payment',
                'status_pembayaran',
                'tipe_finance',
                'email',
                'phone_user',
                'date_payment',


            ], $limit);
            $totaldata = count($finance);
            $totalfiltered = $totaldata;
            // return var_dump($totaldata);
        }

        $finance = $app->db->select('tbl_finances', [
            '[><]tbl_users' => 'id_user',
            '[><]tbl_classes' => ["$tbl_users.id_class" => 'id_class'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
            '[><]tbl_payment_types' => 'id_payment_type',
        ], [
            'id_finance',
            'NISN',
            'photo_user',
            'first_name',
            'last_name',
            'gender',
            'class',
            'section',
            'payment_type_name',
            'amount_payment',
            'status_pembayaran',
            'tipe_finance',
            'email',
            'phone_user',
            'date_payment',


        ], $conditions);

        $data = array();


        if (!empty($finance)) {
            $no = $req->getParam('start') + 1;

            foreach ($finance as $m) {

                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['NISN'];
                $datas['foto'] = '<img src="/uploads/Profile/' . $m['photo_user'] . '" style="width:30px;"  alt="student">';
                $datas['nama'] = $m['first_name'] . ' '  . $m['last_name'];
                $datas['gender'] = $m['gender'];
                $datas['kelas'] = $m['class'] . ' '  . $m['section'];
                $datas['pembayaran'] = $m['payment_type_name'];
                $datas['biaya'] = 'Rp. ' . number_format($m['amount_payment'], 0, ',', '.');

                if ($m['status_pembayaran'] == "Belum Bayar") {
                    $datas['status_pembayaran'] = '<p class="badge badge-pill badge-danger d-block my-2 py-3 px-4">' . $m['status_pembayaran'] . '</p>';
                } else {
                    $datas['status_pembayaran'] = '<p class="badge badge-pill badge-success d-block my-2 py-3 px-4">' . $m['status_pembayaran'] . '</p>';
                }

                $datas['email'] = $m['email'];
                $datas['telepon'] = $m['phone_user'];
                $datas['date'] = date('j F Y', strtotime($m['date_payment']));



                $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item btn btn-light item_hapus" data="' . $m['id_finance'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light payment_detail" data="' . $m['id_finance'] . '">
                        <i class="fas fa-solid fa-edit text-orange-peel"></i>
                        Ubah
                    </a>
                   
                </div>
            </div>';

                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($finance);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }


    public static function payment_detail($app, $request, $response, $args)
    {
        $id = $args['data'];
        $tbl_users = 'tbl_users';
        $tbl_classes = 'tbl_classes';


        $data = $app->db->select('tbl_finances', [
            '[><]tbl_users' => 'id_user',
            '[><]tbl_classes' => ["$tbl_users.id_class" => 'id_class'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
            '[><]tbl_payment_types' => 'id_payment_type',
        ], [
            'id_finance',
            'NISN',
            'photo_user',
            'first_name',
            'last_name',
            'gender',
            'class',
            'section',
            'id_payment_type',
            'payment_type_name',
            'amount_payment',
            'status_pembayaran',
            'tipe_finance',
            'email',
            'phone_user',
            'date_payment',


        ], [
            'id_finance' => $id,
        ]);
        // return var_dump($data);
        // die();

        return $response->withJson($data[0]);
    }

    public static function delete($app, $req, $rsp, $args)
    {
        $id = $args['data'];


        $del = $app->db->delete('tbl_finances', [
            "id_finance" => $id
        ]);

        // return var_dump($del);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function update_payment_detail($app, $request, $response, $args)
    {
        $data = $args['data'];




        // return var_dump($uploadedFiles);
        $update = $app->db->update('tbl_finances', [
            "id_payment_type" => $data['payment_type_name'],
            "amount_payment" => $data['amount_payment'],
            "status_pembayaran" => $data['status_pembayaran'],
            "date_payment" => $data['date_payment'],
            "tipe_finance" => $data['tipe_finance'],
        ], [

            "id_finance" => $data['id_finance'],

        ]);
        // return var_dump($update);
        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
        );

        echo json_encode($json_data);
    }
    public static function page_add_payment($app, $req, $rsp, $args)
    {


        $class = $app->db->select('tbl_classes', [
            '[><]tbl_sections' =>  'id_section',
        ], '*');        // return var_dump($class);
        $payment = $app->db->select('tbl_payment_types', '*');
        $user = $app->db->select('tbl_users', '*', [
            'id_user_type[!]' => '4'
        ]);
        $type = $app->db->select('tbl_user_types', '*');

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        $app->view->render($rsp, 'acconunt/add-expense.html', [
            'user' =>  $user,
            'typei' =>  $type,
            'class' =>  $class,
            'payment' =>  $payment,
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil
        ]);
    }





    public static function tampil_data_expense($app, $req, $rsp, $args)
    {
        $type = 2;
        $tbl_finances = 'tbl_finances';


        $finance = $app->db->select('tbl_finances', [
            '[><]tbl_users' => 'id_user',
            '[><]tbl_payment_types' =>  'id_payment_type',

        ], '*', [
            'tipe_finance' => 'Pengeluaran'
        ]);

        // return var_dump($finance);
        // die();
        $columns = array(
            0 => 'id',
        );

        $totaldata = count($finance);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];


        $conditions = [
            "LIMIT" => [$start, $limit],
            'tipe_finance' => 'Pengeluaran'
        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];

            $conditions['OR'] = [
                'tbl_finances.tipe_finance[~]' => '%' . $search . '%',
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                'tbl_payment_types.payment_type_name[~]' => '%' . $search . '%',
            ];

            $limit = [
                "LIMIT" => [$start, $limit],
                'tipe_finance' => 'Pengeluaran'

            ];

            $finance = $app->db->select('tbl_finances', [
                '[><]tbl_payment_types' =>  'id_payment_type',
                '[><]tbl_users' => 'id_user',

            ], '*', $limit);

            $totaldata = count($finance);
            $totalfiltered = $totaldata;
            // return var_dump($totaldata);
        }
        $finance = $app->db->select('tbl_finances', [
            '[><]tbl_payment_types' =>  'id_payment_type',
            '[><]tbl_users' => 'id_user',

        ], '*', $conditions);
        // return die(var_dump($conditions));

        $data = array();


        if (!empty($finance)) {
            $no = $req->getParam('start') + 1;

            foreach ($finance as $m) {

                $datas['no'] = $no . '.';
                $datas['nama'] = $m['first_name'] . '  ' .  $m['last_name'];
                $datas['tipe'] = $m['payment_type_name'];
                $datas['biaya'] = 'Rp. ' . number_format($m['amount_payment'], 0, ',', '.');


                if ($m['status_pembayaran'] == "Belum Bayar") {
                    $datas['status'] = '<p class="badge badge-pill badge-danger d-block my-2 py-3 px-4">' . $m['status_pembayaran'] . '</p>';
                } else {
                    $datas['status'] = '<p class="badge badge-pill badge-success d-block my-2 py-3 px-4">' . $m['status_pembayaran'] . '</p>';
                }

                $datas['telepon'] = $m['phone_user'];
                $datas['email'] = $m['email'];
                $datas['telepon'] = $m['phone_user'];
                $datas['date'] = date('j F Y', strtotime($m['date_payment']));
                $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item btn btn-light item_hapus" data="' . $m['id_finance'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light payment_detail" data="' . $m['id_finance'] . '">
                        <i class="fas fa-solid fa-edit text-orange-peel"></i>
                        Ubah
                    </a>
                   
                </div>
            </div>';

                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($finance);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }
    public static function add_payment($app, $req, $rsp, $args)
    {
        $data = $args['data'];
        // return var_dump($data);
        $tgl = $data['date_payment'];
        $tahun = explode('/', $tgl);
        $date = $tahun[2] . '/' . $tahun[1] . '/' . $tahun[0];
        // return var_dump($date);
        $data = $app->db->insert('tbl_finances', [
            "id_payment_type" => $data['pembayaran'],
            "id_user" => $data['id_user'],
            "amount_payment" => $data['biaya'],
            "status_pembayaran" => $data['status'],
            "date_payment" => $date,
            "tipe_finance" => $data['tipe'],
        ]);


        // return var_dump($data);
        $_SESSION['berhasil'] = true;
        return $rsp->withRedirect('/add-expense');
    }
}
