<?php

namespace App\Controller;

use Slim\Http\Response;

class ClassController
{
    // untuk penambahan tambah vertifikasi input
    // supaya input kelas yang sudah ada tidak terjadi doble input
    // jika kelas section dan nama guru sudah ada, jangan di tambah.

    public static function index($app, $request, $response, $args)
    {

        // return var_dump($id_finance);
        $section = $app->db->select('tbl_sections', '*');
        $guru = $app->db->select('tbl_users', '*', [
            "id_user_type" => 2
        ]);


        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);

        $app->view->render($response, 'class/all-class.html', [

            'type_user' => $_SESSION['type_user'],
            'berhasil' => $berhasil,
            'guru' => $guru,
            'section' => $section

        ]);
    }

    public static function deleteClassMod($app, $request, $response, $args)
    {
        $id_class = $args['data'];
        // return die(var_dump($id_class));
        $delete = $app->db->delete("tbl_classes", ["id_class" => $id_class]);

        $update = $app->db->update("tbl_users", ["id_class" => "0",], ["id_class" => $id_class,]);

        // $getLastUpdate = $app->db->query("select id_user from tbl_users order by update_at desc limit 1")->fetch();

        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function getAllClassDt($app, $request, $response, $args)
    {

        $data = $app->db->select(
            'tbl_classes',
            [
                "[><]tbl_sections" =>  "id_section",
                "[><]tbl_users" => "id_class",

            ],
            '*',
            [
                "id_user_type" => 2,
                "id_class[!]" => 0,
            ]
        );
        // return die(var_dump($data));
        $columns = array(
            0 => 'id',
        );

        $totaldata = count($data);
        $totalfiltered = $totaldata;
        $limit = $request->getParam('length');
        $start = $request->getParam('start');
        $order = $request->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $request->getParam('order');
        $dir = $dir[0]['dir'];

        $conditions = [
            "LIMIT" => [$start, $limit],
            "id_user_type" => 2,
            "id_class[!]" => 0,


        ];

        if (!empty($request->getParam('search')['value'])) {
            $search = $request->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                "id_user_type" => 2,
                "id_class[!]" => 0,
            ];
            $conditions['OR'] = [
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',

            ];
            $data = $app->db->select(
                'tbl_classes',
                [
                    "[><]tbl_sections" =>  "id_section",
                    "[><]tbl_users" => "id_class",

                ],
                '*',
                // $limit,
                $conditions
            );
            // return die(var_dump($data));
            $totaldata = count($data);
            $totalfiltered = $totaldata;
        }

        $list = $app->db->select(
            'tbl_classes',
            [
                "[><]tbl_sections" =>  "id_section",
                "[><]tbl_users" => "id_class",

            ],
            '*',
            $conditions
        );

        $data = array();


        if (!empty($list)) {
            $no = $request->getParam('start') + 1;
            foreach ($list as $i) {

                $datas['no'] = $no . '.';
                $datas['Nip'] = $i['NISN'];
                $datas['WaliKelas'] = $i['first_name'] . " " . $i['last_name'];
                $datas['gender'] = $i['gender'];
                $datas['kelas'] = $i['class'];
                $datas['bagian'] = $i['section'];
                $datas['phone_user'] = $i['phone_user'];
                $datas['email'] = $i['email'];
                $datas[' '] = '<div class="dropdown">
                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">

                    <a class="dropdown-item btn btn-light btn-lg item_hapus" data="' . $i['id_class'] . '"> 
                        <i class="fas fa-trash text-orange-red" ></i>
                        Hapus
                    </a>
                    <a class="btn dropdown-item btn btn-light btn-lg kelas_detail" data="' . $i['id_user'] . '">
                        <i class="fas fa-edit text-dark-pastel-green"></i>
                        Ubah
                    </a>
                </div>
            </div>';

                $data[] = $datas;
                $no++;
            }
        }

        // $totaldata = count($data);
        // $totalfiltered = $totaldata;


        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }

    public static function getAllClassS($app, $request, $response, $args)
    {
        $kelas = $app->db->select('tbl_users', 'id_class', [
            "id_user" => $_SESSION['id_user']
        ]);

        $data = $app->db->select(
            'tbl_classes',
            [
                "[><]tbl_sections" =>  "id_section",
                "[><]tbl_users" => "id_class",

            ],
            '*',
            [
                "id_user_type" => 1,
                "id_class" => $kelas
            ]
        );
        // return die(var_dump($data));
        $columns = array(
            0 => 'id',
        );

        $totaldata = count($data);
        $totalfiltered = $totaldata;
        $limit = $request->getParam('length');
        $start = $request->getParam('start');
        $order = $request->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $request->getParam('order');
        $dir = $dir[0]['dir'];

        $conditions = [
            "LIMIT" => [$start, $limit],
            "id_user_type" => 1,
            "id_class" => $kelas,
            "ORDER" => ['first_name' => 'ASC']

        ];

        if (!empty($request->getParam('search')['value'])) {
            $search = $request->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit]
            ];
            $conditions['OR'] = [
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',

            ];
            $data = $app->db->select(
                'tbl_classes',
                [
                    "[><]tbl_sections" =>  "id_section",
                    "[><]tbl_users" => "id_class",

                ],
                '*',
                // $limit,
                $conditions
            );
            // return die(var_dump($data));
            $totaldata = count($data);
            $totalfiltered = $totaldata;
        }

        $list = $app->db->select(
            'tbl_classes',
            [
                "[><]tbl_sections" =>  "id_section",
                "[><]tbl_users" => "id_class",

            ],
            '*',
            $conditions
        );

        $data = array();


        if (!empty($list)) {
            $no = $request->getParam('start') + 1;
            foreach ($list as $i) {

                $datas['no'] = $no . '.';
                $datas['Nisn'] = $i['NISN'];
                $datas['Nama'] = $i['first_name'] . " " . $i['last_name'];
                $datas['gender'] = $i['gender'];
                $datas['kelas'] = $i['class'];
                $datas['bagian'] = $i['section'];
                // $datas['phone_user'] = $i['phone_user'];
                // $datas['email'] = $i['email'];


                $data[] = $datas;
                $no++;
            }
        }

        // $totaldata = count($data);
        // $totalfiltered = $totaldata;


        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }


    public static function getTeacherMod($app, $request, $response, $args)
    {
        $response = $app->db->select("tbl_users", [
            "id_user",
            "first_name",
            "last_name",
            "NISN",
            "gender",
            "phone_user",
            "email",

        ], [
            "id_user_type" => 2,
        ]);
        return $response;
    }

    public static function getSectionMod($app, $request, $response, $args)
    {
        $response = $app->db->select("tbl_sections", [
            "id_section",
            "section",
        ]);

        return $response;
    }

    public static function getSubjectMod($app, $request, $response, $args)
    {
        $response = $app->db->select("tbl_subjects", [
            "id_subject",
            "subject_name",

        ]);

        return $response;
    }

    public static function insertClassMod($app, $request, $response, $args)
    {
        $kelas = $request->getParam('kelas');
        $bagian = $request->getParam('bagian');
        $idTeacher = $request->getParam('idTeacher');
        // $testUpate = $request->getParam('test');

        $app->db->insert("tbl_classes", [
            "id_section" => $bagian,
            "class" => $kelas,
        ]);

        $lastid = $app->db->id();

        $app->db->update("tbl_users", [
            "id_class" => $lastid,
        ], [
            "id_user" => $idTeacher,
        ]);

        $getLastInsertedUsers = $app->db->query("select id_user from tbl_users order by update_at desc limit 1")->fetch();

        $response = [
            'status' => 'success',
            'details' => [
                'inserted to class' => $lastid,
                'updated to users' => $getLastInsertedUsers[0],
            ],
        ];

        return $response;
    }
    public static function modal_detail($app, $request, $response, $args)
    {
        $id = $args['data'];



        $data = $app->db->select(
            'tbl_users(a)',
            [
                "[>]tbl_classes" => "id_class",
                "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"]

            ],
            '*',
            [
                "id_user" => $id,
                "id_user_type" => 2,
                "a.id_class[!]" => 0,
            ]
        );

        // return var_dump($data);
        // die();

        return $response->withJson($data[0]);
    }

    public static function update_kelas_detail($app, $request, $response, $args)
    {
        $data = $args['data'];

        // return var_dump($uploadedFiles);
        $update = $app->db->update('tbl_classes', [
            "id_section" => $data['id_section'],
            "class" => $data['class'],
        ], [

            "id_class" => $data['id_class'],

        ]);

        if ($data['id_user'] != $data['old_id_user']) {
            $user = $app->db->update("tbl_users", [
                "id_class" => 0,
            ], [
                "id_user" => $data['old_id_user'],
            ]);
        } else {
        }
        $user = $app->db->update("tbl_users", [
            "id_class" => $data['id_class'],
        ], [
            "id_user" => $data['id_user'],
        ]);





        // return var_dump($update);
        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function viewAddClass($app, $request, $response, $args)
    {
        $dataGuru = ClassController::getTeacherMod($app, $request, $response, $args);
        $dataSection = ClassController::getSectionMod($app, $request, $response, $args);
        $dataSubject = ClassController::getSubjectMod($app, $request, $response, $args);

        // return var_dump($dataSection);

        $app->view->render($response, 'class/add-class.html', [
            'dataguru' => $dataGuru,
            'dataSection' => $dataSection,
            'dataSubject' => $dataSubject,
        ]);
    }
}
