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
        // return var_dump($id_parent);



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

        


        $parent = $app->db->select('tbl_users', '*', [
            'id_user_type' => $type,
        ]);


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

            $parent = $app->db->select(
                'tbl_users',
                '*',
                $limit
            );
            $totaldata = count($parent);
            $totalfiltered = $totaldata;
            // return var_dump($totaldata);
        }

        $parent = $app->db->select('tbl_users', '*', $conditions);

        $data = array();


        if (!empty($parent)) {
            $no = $req->getParam('start') + 1;

            foreach ($parent as $m) {

                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['NISN'];
                $datas['foto'] = '<img src="/uploads/Profile/' . $m['photo_user'] . '" style="width:30px;"  alt="student">';
                $datas['gender'] = $m['gender'];

                $username = $app->db->select('tbl_users', 'first_name', [
                    'id_user' => $m['id_user']
                ]);
                if ($username[0] == '') {
                    $datas['nama'] = $m['username'];
                } else {
                    $datas['nama'] = $m['first_name'] . ' ' . $m['last_name'];
                }


               

                    $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item"  ><i
                            class="fas fa-trash text-orange-red"></i><button type="button" class="btn btn-light item_hapus" data="' . $m['id_user'] . '"">
                            Hapus
                        </button></a>
                    <a class="dropdown-item" href="' . 'api' . '/' . 'teacher_detail' . '/' . $m['id_user']  . '"><i
                            class="fas fa-solid fa-bars text-orange-peel"></i><button type="button" class="btn btn-light" class="modal-trigger" data-toggle="modal"
                            data-target="#large-modal" data="' . $m['id_user'] . '"">
                            Detail
                        </button></a>
                   
                </div>
            </div>';
               
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


    public static function teacher_detail($app, $request, $response, $args)
    {
        $id = $args['data'];
        $tbl_subjects = 'tbl_subjects';
        $tbl_classes = 'tbl_classes';


        $data = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_classes' => ["$tbl_subjects.id_class" => 'id_class'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ],'*', [
            'tbl_users.id_user' => $id

        ]);
        // return var_dump($data);
        // die();
       
        $class = $app->db->select('tbl_classes', [
            '[><]tbl_sections' =>  'id_section',
        ], '*');

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        // return var_dump($data);
// 
        $app->view->render($response, 'teacher/teacher-details.html', [
            'data' =>  $data[0],
            'class' =>  $class,
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil


        ]);
    }

    public static function delete($app, $req, $rsp, $args)
    {
        $id = $args['data'];


        $del = $app->db->delete('tbl_users', [
            "id_user" => $id
        ]);

        // return var_dump($del);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function update_student_detail($app, $request, $response, $args)
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
            "id_class" => $data['id_class'],
            "id_parent" => $data['id_parent'],
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
        return $response->withRedirect('/api/student-detail/' . $data['id_user']);
    }
    public static function page_add_student($app, $req, $rsp, $args)
    {

        $type = 4;
        $parent = $app->db->select('tbl_users', '*', [
            'id_user_type' => $type,

        ]);
        $class = $app->db->select('tbl_classes', [
            '[><]tbl_sections' =>  'id_section',
        ], '*');        // return var_dump($class);

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        $app->view->render($rsp, 'students/admit-form.html', [
            'parent' =>  $parent,
            'class' =>  $class,
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil
        ]);
    }
    public static function add_student($app, $req, $rsp, $args)
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
            "username" => $data['first_name'],
            "password" => $data['last_name'],
            "id_section" => $data['id_section'],
            "id_class" => $data['id_class'],
            "id_parent" => $data['id_parent'],
            "NISN" => $data['nisn'],
            "date_of_birth" => $data['date_of_birth'],
            "religion" => $data['religion'],
            "blood_group" => $data['blood_group'],
            "email" => $data['email'],
            "phone_user" => $data['phone_user'],
            "address_user" => $data['address_user'],
            "short_bio" => $data['data_short_bio'],
            "photo_user" => $addUpdate,
            "id_user_type" => 1,
            "status" => 1,
        ]);
        $last_id = $app->db->id();
        $tanggal = date("Y-m-d ");

        $id_masuk = $app->db->insert('tbl_admissions', [
            "id_user" => $last_id,
            "admission_date" => $tanggal
        ]);

        // return var_dump($tanggal);
        $_SESSION['berhasil'] = true;
        return $rsp->withRedirect('/admit-form');
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
    public static function add_admission($app, $req, $rsp, $args)
    {
        $data = $args['data'];
        // return var_dump($data);


        $tanggal = date("Y-m-d ");

        // return var_dump($uploadedFiles);
        $admission = $app->db->INSERT('tbl_admissions', [

            "id_user" => $data,
            "admission_date" => $tanggal
        ]);


        // return var_dump($tanggal);
        $_SESSION['berhasil'] = true;
        return $rsp->withRedirect('/all-students');
    }
}
