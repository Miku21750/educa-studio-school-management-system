<?php

namespace App\Controller;

use Medoo\Medoo;
use Midtrans;
use App\Controller\EmailController;



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
        // Required
        $transaction_details = array(
            'order_id' => rand(),
            'gross_amount' => 94000, // no decimal allowed for creditcard
        );
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
        // return die(var_dump($finance));
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
                $tanggal = AcconuntController::tgl_indo($m['date_payment']);

                // $datas['date'] = date('j F Y', strtotime($m['date_payment']));
                $datas['date'] = $tanggal;



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
                        <i class="fas fa-edit text-dark-pastel-green"></i>
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
                $tanggal = AcconuntController::tgl_indo($m['date_payment']);
                $datas['date'] = $tanggal;
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
                        <i class="fas fa-edit text-dark-pastel-green"></i>
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

    public static function get_data_midtrans($app, $request, $response, $args)
    {
        $id = $request->getParam('id');
        $getTransaction = $app->db->select('tbl_finances',[
            '[><]tbl_payment_types'=>'id_payment_type',
            '[><]tbl_users'=>'id_user',
        ],'*',[
            'id_finance'=>$id
        ]);
        // return die(var_dump($id));
        $transaction_detail= array(
            'order_id'=>rand(),
            // 'gross_amount' => $getTransaction[0]['amount_payment'],
       
        );
        $price = (int)$getTransaction[0]['amount_payment'];
        // return die(var_dump($price));
        $item_Detail = array(
            'id'=>$getTransaction[0]['id_finance'],
            'price'=>$price,
            'quantity'=>1,
            'name'=>$getTransaction[0]['payment_type_name'],
        );
        $customer_details = array(
            'first_name'=>$getTransaction[0]['first_name'],
            'last_name'=>$getTransaction[0]['last_name'],
            'email'=>$getTransaction[0]['email'],
            'phone'=>$getTransaction[0]['phone_user']

        );
        $transaction = array(
            'transaction_details'=> $transaction_detail,
            'item_details'=>$item_Detail,
            'customer_details'=>$customer_details,
        );
        $snapToken = Midtrans\Snap::getSnapToken($transaction);
        // $base = $_SERVER['requ']
        return $response->withJSON(array('token'=>$snapToken));
        
        

        // return $response->withJson($data[0]);
    }
    public static function update_data_midtrans($app, $request, $response, $args)
    {
        $data = $args['data'];
        if ($data['status_code'] == 200) {
            $status = 'Dibayar';
        }elseif ($data['status_code'] == 201) {
            $status = 'Transaksi sedang diproses';
        }else {
            $status = 'Erorr';
        }



        // return var_dump($uploadedFiles);
        $update = $app->db->update('tbl_finances', [
           
            "status_pembayaran" => $status,
            "date_payment" => $data['time'],
            "order_id" => $data['order_id'],
            
        ], [

            "id_finance" => $data['id'],

        ]);
        // return var_dump($update);
        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
        );

        echo json_encode($json_data);
    }
    public static function notice_midtrans($app, $request, $response, $args)
    {
        $notif = new Midtrans\Notification();
        

        $transaction = $notif->transaction_status;
        $snapToken = Midtrans\Snap::getSnapToken($transaction);
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;
        return die(var_dump($snapToken));
        $message = 'ok';

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    $message = "Transaction order_id: " . $order_id ." is challenged by FDS";
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    $message = "Transaction order_id: " . $order_id ." successfully captured using " . $type;
                }
            }
        } elseif ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            
            $message = "Transaction order_id: " . $order_id ." successfully transfered using " . $type;
        } elseif ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $message = "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        } elseif ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        } elseif ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is expired.";
        } elseif ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            $message = "Payment using " . $type . " for transaction order_id: " . $order_id . " is canceled.";
        }

        $filename = $order_id . ".txt";
        $dirpath = 'log';
        is_dir($dirpath) || mkdir($dirpath, 0777, true);

        $data = $args['data'];
        if ($data['status_code'] == 200) {
            $status = 'Dibayar';
        }elseif ($data['status_code'] == 201) {
            $status = 'Transaksi sedang diproses';
        }else {
            $status = 'Erorr';
        }



        // return var_dump($uploadedFiles);
        $update = $app->db->update('tbl_finances', [
           
            "status_pembayaran" => $status,
            "date_payment" => $data['time'],
            
        ], [

            "id_finance" => $data['id'],

        ]);
        // return var_dump($update);
        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
}
