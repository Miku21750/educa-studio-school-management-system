<?php

namespace App\Controller;

use Medoo\Medoo;



class TeacherController
{

    public static function index($app, $request, $response, $args)
    {
        $user = $args['user'];
        $type = $args['type'];
        $id_user = $args['id_user'];
        // return var_dump($id_teacher);



        // $data = $app->db->select('tbl_users', '*');
        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        // var_dump($data);

        $app->view->render($response, 'teacher/all-teacher.html', [
            'user' => $user,
            'type' => $type,
            'id_user' => $id_user,
            'type_user' => $_SESSION['type_user'],
            'berhasil' => $berhasil

        ]);
    }


    public static function tampil_data($app, $req, $rsp, $args)
    {
        $type = 2;
        $tbl_classes = 'tbl_classes';

        


        $teacher = $app->db->select('tbl_users',[
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], '*', [
            'id_user_type' => $type,
        ]);


        $columns = array(
            0 => 'id',
        );

        $totaldata = count($teacher);
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

            $teacher = $app->db->select(
                'tbl_users',[
                    '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
                    '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                    '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
                ],
                '*',
                $limit
            );
            $totaldata = count($teacher);
            $totalfiltered = $totaldata;
            // return var_dump($totaldata);
        }

        $teacher = $app->db->select('tbl_users',[
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], '*', $conditions);

        $data = array();


        if (!empty($teacher)) {
            $no = $req->getParam('start') + 1;

            foreach ($teacher as $m) {

                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['NISN'];
                $datas['foto'] = '<img src="/uploads/Profile/' . $m['photo_user'] . '" style="width:30px;"  alt="student">';
                $datas['gender'] = $m['gender'];
                $datas['mapel'] = $m['subject_name'];

                $username = $app->db->select('tbl_users', 'first_name', [
                    'id_user' => $m['id_user']
                ]);
                if ($username[0] == '') {
                    $datas['nama'] = $m['username'];
                } else {
                    $datas['nama'] = $m['first_name'] . ' ' . $m['last_name'];
                }



                if ($_SESSION['type'] == '3') {
 $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" data="' . $m['id_user'] . '">
                    <a class="dropdown-item btn btn-light item_hapus"  >
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light" href="' . 'api' . '/' . 'teacher_detail' . '/' . $m['id_user']  . '">
                        <i class="fas fa-solid fa-bars text-orange-peel"></i>
                        
                        Detail
                        </a>
                   
                </div>
            </div>';                } else {
                    $datas['aksi'] = ' ';
                }


               

                   
               
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($teacher);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }


    public static function teacher_detail($app, $request, $response, $args)
    {
        $id = $args['data'];
        $tbl_subjects = 'tbl_subjects';
        $tbl_classes = 'tbl_classes';


        $data = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ],'*', [
            'tbl_users.id_user' => $id

        ]);
        // return var_dump($data);
        // die();
       
        $class = $app->db->select('tbl_classes', [
            '[><]tbl_sections' =>  'id_section',
        ], '*');
        $subject = $app->db->select('tbl_subjects', '*');

        $date = $app->db->select('tbl_users', 'date_of_birth', [
            'id_user' => $id
        ]);
        $tanggal = AcconuntController::tgl_indo($date[0]);


        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        // return var_dump($data);
// 
        $app->view->render($response, 'teacher/teacher-details.html', [
            'data' =>  $data[0],
            'tanggal' =>  $tanggal,
            'class' =>  $class,
            'subject' =>  $subject,
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil


        ]);
    }

    public static function delete($app, $req, $rsp, $args)
    {
        $id = $args['data'];


        $del = $app->db->debug()->delete('tbl_users', [
            "id_user" => $id
        ]);

        return var_dump($del);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function update_teacher_detail($app, $request, $response, $args)
    {
        $data = $args['data'];

        // return var_dump($data);
        // get image
        $directory = $app->get('upload_directory');
        $uploadedFiles = $request->getUploadedFiles();
        // handle single input with single file upload
        $uploadedFile = $uploadedFiles['profileImage'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($directory, $uploadedFile);
            $response->write('uploaded ' . $filename . '<br/>');
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
        $update = $app->db->update('tbl_users', [
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "gender" => $data['gender'],
            "id_subject" => $data['id_subject'],
            "NISN" => $data['NISN'],
            "date_of_birth" => $data['date_of_birth'],
            "religion" => $data['religion'],
            "blood_group" => $data['blood_group'],
            "occupation" => $data['occupation'],
            "phone_user" => $data['phone_user'],
            "address_user" => $data['address_user'],
            "short_bio" => $data['data_short_bio'],
            "photo_user" => $addUpdate
        ], [
            "id_user" => $data['id_user']
        ]);
        // return var_dump($update);
        $_SESSION['berhasil'] = true;
        return $response->withRedirect('/api/teacher_detail/' . $data['id_user']);
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

        $encryptedPassword = indexApiController::encrypt($data['date_of_birth'], $_ENV['SALT']);
        // return var_dump($uploadedFiles);
        $teacher = $app->db->insert('tbl_users', [
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "gender" => $data['gender'],
            "username" => $data['nisn'],
            "password" => $encryptedPassword,
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


        $teacher = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_finances' => ['tbl_users.id_user' => 'id_user'],
            
        ],'*',[
            'id_user_type' => $type
        ]);

        // return var_dump($teacher);
        // die();
        $columns = array(
            0 => 'id',
        );

        $totaldata = count($teacher);
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

            $teacher = $app->db->select('tbl_users', [
                '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
                '[><]tbl_finances' => ['tbl_users.id_user' => 'id_user'],
               
            ],'*', $limit);
    
            $totaldata = count($teacher);
            $totalfiltered = $totaldata;
            // return var_dump($totaldata);
        }

        $teacher = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_finances' => ['tbl_users.id_user' => 'id_user'],
            
        ],'*',
 $conditions);

        $data = array();


        if (!empty($teacher)) {
            $no = $req->getParam('start') + 1;

            foreach ($teacher as $m) {

                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['NISN'];
                $datas['foto'] = '<img src="/uploads/Profile/' . $m['photo_user'] . '" style="width:30px;"  alt="student">';
                $datas['nama'] = $m['first_name'] . '  ' . $m['last_name'];
                $datas['gender'] = $m['gender'];
                $datas['subject'] = $m['subject_name'] . '(' . $m['subject_type'] . ')';
                $datas['gaji'] = 'Rp. ' . number_format($m['amount_payment'],2,',','.') ;
                
                
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
        // return var_dump($teacher);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }
    public static function tampil_data_payment_teacher($app, $req, $rsp, $args)
    {
        $type = 2;
        $tbl_classes = 'tbl_classes';


        $teacher = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_finances' => ['tbl_users.id_user' => 'id_user'],
            
        ],'*',[
            'id_user_type' => $type,
            'tbl_users.id_user' => $_SESSION['id_user']
        ]);

        // return var_dump($teacher);
        // die();
        $columns = array(
            0 => 'id',
        );

        $totaldata = count($teacher);
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
            'tbl_users.id_user' => $_SESSION['id_user']
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
                'tbl_users.id_user' => $_SESSION['id_user']

            ];

            $teacher = $app->db->select('tbl_users', [
                '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
                '[><]tbl_finances' => ['tbl_users.id_user' => 'id_user'],
               
            ],'*', $limit);
    
            $totaldata = count($teacher);
            $totalfiltered = $totaldata;
            // return var_dump($totaldata);
        }

        $teacher = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_finances' => ['tbl_users.id_user' => 'id_user'],
            
        ],'*',
 $conditions);

        $data = array();


        if (!empty($teacher)) {
            $no = $req->getParam('start') + 1;

            foreach ($teacher as $m) {

                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['NISN'];
                $datas['foto'] = '<img src="/uploads/Profile/' . $m['photo_user'] . '" style="width:30px;"  alt="student">';
                $datas['nama'] = $m['first_name'] . '  ' . $m['last_name'];
                $datas['gender'] = $m['gender'];
                $datas['subject'] = $m['subject_name'] . '(' . $m['subject_type'] . ')';
                $datas['gaji'] = 'Rp. ' . number_format($m['amount_payment'],2,',','.') ;
                
                
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
        // return var_dump($teacher);

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
