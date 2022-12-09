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
        ],[
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

        ],[
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
            ],[
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
        ],[
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
                $datas['nama'] = $m['first_name'] . ' '  .$m['last_name'];
                $datas['gender'] = $m['gender'];
                $datas['kelas'] = $m['class'] . ' '  .$m['section'];
                $datas['pembayaran'] = $m['payment_type_name'];
                $datas['biaya'] = $m['amount_payment'];
                
                if($m['status_pembayaran'] == "Belum Bayar"){
                    $datas['status_pembayaran'] = '<p class="badge badge-pill badge-danger d-block my-2 py-3 px-4">'.$m['status_pembayaran'].'</p>';
                }else{
                    $datas['status_pembayaran'] = '<p class="badge badge-pill badge-success d-block my-2 py-3 px-4">'.$m['status_pembayaran'].'</p>';
                }
                
                $datas['email'] = $m['email'];
                $datas['telepon'] = $m['phone_user'];
                $datas['date'] = $m['date_payment'] ;

               

                $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item"  ><i
                            class="fas fa-trash text-orange-red"></i><button type="button" class="btn btn-light item_hapus" data="' . $m['id_finance'] . '"">
                            Hapus
                        </button></a>
                    <a class="dropdown-item " ><i
                            class="fas fa-solid fa-edit text-orange-peel"></i><button type="button" class="btn btn-light payment_detail"  data="' . $m['id_finance'] . '"" >
                            Ubah
                        </button></a>
                   
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
        ],[
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
            'tipe_finance' => 'Pemasukan'
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
    public static function page_add_teacher($app, $req, $rsp, $args)
    {

       
        $class = $app->db->select('tbl_classes', [
            '[><]tbl_sections' =>  'id_section',
        ], '*');        // return var_dump($class);
        $subject = $app->db->select('tbl_subjects', '*');

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        $app->view->render($rsp, 'teacher/add-teacher.html', [
            'class' =>  $class,
            'subject' =>  $subject,
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil
        ]);
    }
    public static function add_teacher($app, $req, $rsp, $args)
    {
        $data = $args['data'];
        // return var_dump($data);


        $directory = $app->get('upload_directory');
        $uploadedFiles = $req->getUploadedFiles();
        // handle single input with single file upload
        $uploadedFile = $uploadedFiles['imageUpload'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($directory, $uploadedFile);
            $rsp->write('uploaded ' . $filename . '<br/>');
        }
        // return var_dump(isset($filename));
        $addUpdate = $filename;
        if (!isset($filename)) {
            $addUpdate = $data['imageDefault'];
        } else {
            $fileDefault = $data['imageDefault'];
            // if default? return'
            if ($fileDefault == 'default.png') {
            } else {
                // return var_dump(file_exists('../public/uploads/Profile/'.$fileDefault));
                unlink('../public/uploads/Profile/' . $fileDefault);
            }
        }

        // return var_dump($uploadedFiles);
        $student = $app->db->insert('tbl_users', [
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "gender" => $data['gender'],
            "username" => $data['nisn'],
            "password" => $data['nisn'],
            "id_class" => $data['id_class'],
            "id_subject" => $data['id_subject'],
            "NISN" => $data['nisn'],
            "date_of_birth" => $data['date_of_birth'],
            "religion" => $data['religion'],
            "blood_group" => $data['blood_group'],
            "email" => $data['email'],
            "phone_user" => $data['phone_user'],
            "address_user" => $data['address_user'],
            "short_bio" => $data['data_short_bio'],
            "photo_user" => $addUpdate,
            "id_user_type" => 2,
            "status" => 1,
        ]);
        

        // return var_dump($tanggal);
        $_SESSION['berhasil'] = true;
        return $rsp->withRedirect('/add-teacher');
    }
    public static function student_promotion($app, $request, $response, $args)
    {
        $id = $args['data'];

        $data = $app->db->select('tbl_users', [
            '[><]tbl_sections' => 'id_section',
            '[><]tbl_classes' => 'id_class'
        ], '*', [
            'id_user' => $id

        ]);

        $class = $app->db->select('tbl_classes', [
            '[><]tbl_sections' =>  'id_section',
        ], '*');

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        // return var_dump($data);

        $app->view->render($response, 'students/student-promotion.html', [
            'data' =>  $data[0],
            'class' =>  $class,
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil


        ]);
    }
    public static function add_promotion($app, $req, $rsp, $args)
    {
        $data = $args['data'];
        // return var_dump($data);



        // return var_dump($uploadedFiles);
        $student = $app->db->update('tbl_users', [

            "session" => $data['session'],
            "id_class" => $data['id_class'],
        ], [
            "id_user" => $data['id_user']
        ]);


        // return var_dump($tanggal);
        $_SESSION['berhasil'] = true;
        return $rsp->withRedirect('/all-students');
    }
    public static function page_payment($app, $req, $rsp, $args)
    {
        $app->view->render($rsp, 'teacher/teacher-payment.html', [
            'type' => $_SESSION['type'],
        ]);
    }

    public static function tampil_data_payment($app, $req, $rsp, $args)
    {
        $type = 2;
        $tbl_classes = 'tbl_classes';


        $finance = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_finances' => ['tbl_users.id_user' => 'id_user'],
            
        ],'*',[
            'id_user_type' => $type
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
            'id_user_type' => $type,

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];

            $conditions['OR'] = [
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                'tbl_users.NISN[~]' => '%' . $search . '%',
                'tbl_users.gender[~]' => '%' . $search . '%',

            ];

            $limit = [
                "LIMIT" => [$start, $limit],
                'id_user_type' => $type,

            ];

            $finance = $app->db->select('tbl_users', [
                '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
                '[><]tbl_finances' => ['tbl_users.id_user' => 'id_user'],
               
            ],'*', $limit);
    
            $totaldata = count($finance);
            $totalfiltered = $totaldata;
            // return var_dump($totaldata);
        }

        $finance = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_finances' => ['tbl_users.id_user' => 'id_user'],
            
        ],'*',
 $conditions);

        $data = array();


        if (!empty($finance)) {
            $no = $req->getParam('start') + 1;

            foreach ($finance as $m) {

                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['NISN'];
                $datas['foto'] = '<img src="/uploads/Profile/' . $m['photo_user'] . '" style="width:30px;"  alt="student">';
                $datas['nama'] = $m['first_name'] . '  ' . $m['last_name'];
                $datas['gender'] = $m['gender'];
                $datas['subject'] = $m['subject_name'] . '(' . $m['subject_type'] . ')';
                $datas['gaji'] = $m['amount_payment'];
                
                
                if($m['status_pembayaran'] == "Belum Bayar"){
                    $datas['status'] = '<p class="badge badge-pill badge-danger d-block my-2 py-3 px-4">'.$m['status_pembayaran'].'</p>';
                }else{
                    $datas['status'] = '<p class="badge badge-pill badge-success d-block my-2 py-3 px-4">'.$m['status_pembayaran'].'</p>';
                }
                
                $datas['telepon'] = $m['phone_user'];
                $datas['email'] = $m['email'];                   
               
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
}
