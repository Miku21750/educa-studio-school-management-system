<?php

namespace App\Controller;



class ParentController
{

    public static function index($app, $request, $response, $args)
    {
        $user = $args['user'];
        $type = $args['type'];
        $id_parent = $args['id_parent'];
        // return var_dump($id_parent);



        $data = $app->db->select('tbl_users', '*');

        // var_dump($data);

        $app->view->render($response, 'parents/all-parents.html', [
            'data' =>  $data,
            'user' => $user,
            'type' => $type,
            'id_parent' => $id_parent,
            'type_user' => $_SESSION['type_user'],
        ]);
    }


    public static function tampil_data($app, $req, $rsp, $args)
    {
        $type = 4;
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
            "id_user_type" => $type

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                'id_user_type' => $type,

            ];
            $conditions['OR'] = [
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',

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
                $datas['foto'] = '<img src="/uploads/Profile/'.$m['photo_user'].'" style="width:30px;"  alt="student">';
                $datas['nama'] = $m['first_name'] . ' ' . $m['last_name'];
                $datas['gender'] = $m['gender'];
                $datas['pekerjaan'] = $m['occupation'];
                $datas['alamat'] = $m['address_user'];
                $datas['telepon'] = $m['phone_user'];
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
                    <a class="dropdown-item"  ><i
                            class="fas fa-edit text-dark-pastel-green"></i><button type="button"  class="btn btn-light item_detail"  data="' . $m['id_user'] . '"">
                            Ubah
                        </button></a>
                    <a class="dropdown-item" href="' . 'api' . '/' . 'parent-detail' . '/' . $m['id_user']  . '"><i
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
    public static function parent_detail($app, $request, $response, $args)
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

        $app->view->render($response, 'parents/parents-details.html', [
            'data' =>  $data[0],
            'type' => $_SESSION['type']
           
        ]);
        // // return var_dump($data);
        // $json_data = array(
        //     'data' => $data[0]
        // );

        // return $response->withJson($data);

        // return var_dump($json_data);
        // echo json_encode($json_data);
    }

    public static function delete($app, $req, $rsp, $args)
    {
        $id = $args['data'];


        $del = $app->db->delete('tbl_users', [
            "id_user" => $id
        ]);

        // return $rsp->withJson($del);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function update_parent_detail($app, $request, $response, $args)
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
            }
            
            // return var_dump($uploadedFiles);
            $update = $app->db->update('tbl_users', [
                "first_name" => $data['first_name'],
                "last_name" => $data['last_name'],
                "gender" => $data['gender'],
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
            return $response->withRedirect('/api/parent-detail/'. $data['id_user']);
    }
    public static function page_add_parent($app, $req, $rsp, $args)
    {
        
        $type = 1;
        $student = $app->db->select('tbl_users', '*', [
            'id_user_type' => $type,
            'NISN[!]' => 0,
        ]);
        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        // return var_dump($berhasil);
        $app->view->render($rsp, 'parents/add-parents.html', [
            'student' =>  $student,
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil
        ]);
    }
    public static function add_parent($app, $req, $rsp, $args)
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
            $addUpdate = '20221205040116-20220929-133008.jpg';
        }
        
        // return var_dump($uploadedFiles);
        $data = $app->db->insert('tbl_users', [
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "gender" => $data['gender'],
            "username" => $data['nisn_student'],
            "password" => $data['nisn_student'],
            "date_of_birth" => $data['date_of_birth'],
            "religion" => $data['religion'],
            "blood_group" => $data['blood_group'],
            "email" => $data['email'],
            "occupation" => $data['occupation'],
            "phone_user" => $data['phone_user'],
            "address_user" => $data['address_user'],
            "short_bio" => $data['data_short_bio'],
            "photo_user" => $addUpdate,
            "id_user_type" => 4,
            "status" => 1,
        ]);
        // return var_dump($data);
        $_SESSION['berhasil'] = true;
        return $rsp->withRedirect('/add-parents');
    }



}
