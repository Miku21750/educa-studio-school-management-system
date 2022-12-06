<?php

namespace App\Controller;
use Medoo\Medoo;



class StudentController
{

    public static function index($app, $request, $response, $args)
    {
        $user = $args['user'];
        $type = $args['type'];
        $id_user = $args['id_user'];
        // return var_dump($id_parent);



        $data = $app->db->select('tbl_users', '*');

        // var_dump($data);

        $app->view->render($response, 'students/all-student.html', [
            'data' =>  $data,
            'user' => $user,
            'type' => $type,
            'id_user' => $id_user,
            'type_user' => $_SESSION['type_user'],
        ]);
    }


    public static function tampil_data($app, $req, $rsp, $args)
    {
        $type = 1;
        $parent = $app->db->select('tbl_users(a)',[
            '[><]tbl_sections' => 'id_section',
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_users(b)'=> ['a.id_parent'=>'id_user']
        ],[
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
        ]);
            // return var_dump($parent);
            // die();
        // $parent = $app->db->select('tbl_users', '*', [
        //     'id_user_type' => $type,
        // ]);


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

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                'id_user_type' => $type,

            ];
            $conditions['OR'] = [
                'a.first_name[~]' => '%' . $search . '%',
                'a.last_name[~]' => '%' . $search . '%',

            ];
            $parent = $app->db->select('tbl_users(a)',[
                '[><]tbl_sections' => 'id_section',
                '[><]tbl_classes' => 'id_class',
                '[><]tbl_users(b)'=> ['a.id_parent'=>'id_user']
            ],[
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

        $parent = $app->db->select('tbl_users(a)',[
            '[><]tbl_sections' => 'id_section',
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_users(b)'=> ['a.id_parent'=>'id_user']
        ],[
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
                $datas['foto'] = '<img src="/uploads/Profile/'.$m['foto'].'" style="width:30px;"  alt="student">';
                $datas['nama'] = $m['first_name_student'] . ' ' . $m['last_name_student'];
                $datas['gender'] = $m['gender'];
                $datas['class'] = $m['class'];
                $datas['section'] = $m['section'];
                $datas['parent'] = $m['first_name_parent'] . ' ' . $m['last_name_parent'];
                $datas['alamat'] = $m['alamat'];
                $datas['tanggal_lahir'] = $m['tanggal_lahir'];
                $datas['telepon'] = $m['telepon'];
                $datas['email'] = $m['email'];
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
                    <a class="dropdown-item" href="' . 'api' . '/' . 'student-detail' . '/' . $m['id_user']  . '"><i
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

    public static function detail($app, $request, $response, $args)
    {
        $id_parent = $args['data'];

        $data = $app->db->select('tbl_users', [
            "[>]tbl_classes" => "id_class",
            "[>]tbl_hostels" => "id_hostel",
            "[>]tbl_transports" => ["id_trans" => "id_transport"],
            "[>]tbl_user_types" => "id_user_type"
        ], [
            "tbl_users.id_user",
            "tbl_classes.class",
            "tbl_hostels.hostel_name",
            "id_user_type",
            "first_name",
            "last_name",
            "gender",
            "date_of_birth",
            "religion",
            "username",
            "email",
            "password",
            "photo_user",
            "blood_group",
            "occupation",
            "phone_user",
            "address_user",
            "short_bio"
        ], [
            'id_user' => $id_parent
        ]);
        // return var_dump($data);
        $json_data = array(
            'data' => $data[0]
        );

        return $response->withJson($data);

        // return var_dump($json_data);
        // echo json_encode($json_data);
    }
    public static function student_detail($app, $request, $response, $args)
    {
        $id = $args['data'];

        $data = $app->db->select('tbl_users(a)',[
            '[><]tbl_sections' => 'id_section',
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_users(b)'=> ['a.id_parent'=>'id_user']
        ],[
            'a.id_user(id_user)',
            'a.NISN(nisn)',
            'a.photo_user(foto)',
            'a.first_name(first_name_student)',
            'a.last_name(last_name_student)',
            'a.gender(gender)',
            'class(class)',
            'section(section)',
            'a.address_user(alamat)',
            'a.blood_group(blood_group)',
            'a.username(username)',
            'a.email(email)',
            'a.religion(religion)',
            'a.short_bio(short_bio)',
            'a.date_of_birth(tanggal_lahir)',
            'a.phone_user(telepon)',
            'a.email(email)',
            'b.first_name(first_name_parent)',
            'b.last_name(last_name_parent)',
        ],[
            'a.id_user' => $id

        ]);

        $all = $app->db->select('tbl_users', '*',[
            'id_user_type' => 4
        ]);
        $class = $app->db->select('tbl_classes', '*');
        $section = $app->db->select('tbl_sections', '*');
        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        // return var_dump($data);

        $app->view->render($response, 'students/student-details.html', [
            'data' =>  $data[0],
            'all' =>  $all,
            'class' =>  $class,
            'section' =>  $section,
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
            if(!isset($filename)){
                $addUpdate = $data['imageDefault'];
            }else{
                $fileDefault = $data['imageDefault'];
                // if default? return'
                if($fileDefault == 'default.png'){
                    
                }else{   
                    // return var_dump(file_exists('../public/uploads/Profile/'.$fileDefault));
                    unlink('../public/uploads/Profile/'.$fileDefault);
                }
            }
            
            // return var_dump($uploadedFiles);
            $update = $app->db->update('tbl_users', [
                "first_name" => $data['first_name'],
                "last_name" => $data['last_name'],
                "gender" => $data['gender'],
                "id_class" => $data['id_class'],
                "id_section" => $data['id_section'],
                "id_parent" => $data['id_parent'],
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
            return $response->withRedirect('/api/student-detail/'. $data['id_user']);
    }
    public static function page_add_student($app, $req, $rsp, $args)
    {
        
        $type = 4;
        $parent = $app->db->select('tbl_users', '*', [
            'id_user_type' => $type,
            
        ]);
        $class = $app->db->select('tbl_classes', '*');
        $section = $app->db->select('tbl_sections', '*');
        // return var_dump($class);

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        $app->view->render($rsp, 'students/admit-form.html', [
            'parent' =>  $parent,
            'class' =>  $class,
            'section' =>  $section,
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
        if(!isset($filename)){
            $addUpdate = $data['imageDefault'];
        }else{
            $fileDefault = $data['imageDefault'];
            // if default? return'
            if($fileDefault == 'default.png'){
                
            }else{   
                // return var_dump(file_exists('../public/uploads/Profile/'.$fileDefault));
                unlink('../public/uploads/Profile/'.$fileDefault);
            }
        }
        
        // return var_dump($uploadedFiles);
        $data = $app->db->insert('tbl_users', [
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "gender" => $data['gender'],
            "username" => $data['first_name'],
            "password" => $data['last_name'],
            "id_section" => $data['id_section'],
            "id_class" => $data['id_class'],
            "id_parent" => $data['id_parent'],
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
        // $last_id = $app->db->id();
        
        // $student = $app->db->update('tbl_users', [
        //     "id_parent" => $id_parent,
        // ],[
        //     'id_user' => $last_id
        // ]);

        // return var_dump($data);
        $_SESSION['berhasil'] = true;
        return $rsp->withRedirect('/add-parents');
    }



}
