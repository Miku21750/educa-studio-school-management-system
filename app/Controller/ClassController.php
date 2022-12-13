<?php

namespace App\Controller;

use Slim\Http\Response;

class ClassController
{
    // untuk penambahan tambah vertifikasi input
    // supaya input kelas yang sudah ada tidak terjadi doble input
    // jika kelas section dan nama guru sudah ada, jangan di tambah.

    public static function deleteClassMod($app, $request, $response, $args)
    {
        $id_class = $args['id_class'];

        $delete = $app->db->delete("tbl_classes", ["id_class" => $id_class]);

        $update = $app->db->update("tbl_users", ["id_class" => "",], ["id_class" => $id_class,]);

        $getLastUpdate = $app->db->query("select id_user from tbl_users order by update_at desc limit 1")->fetch();

        $response = [
            "response" => 'success',
            "Last Delete" => $id_class,
            "Last Update" => $getLastUpdate,
        ];

        return $response;
    }

    public static function getAllClassDt($app, $request, $response, $args)
    {

        $data = $app->db->select(
            'tbl_users',
            [
                "[>]tbl_classes" => ["id_class" => "id_class"],
                "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"]

            ],
            [
                'id_user',
            ],
            [
                "id_user_type" => 2
            ]
        );

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
            "id_user_type" => 2

        ];

        if (!empty($request->getParam('search')['value'])) {
            $search = $request->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                "id_user_type" => 2

            ];
            $conditions['OR'] = [
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',

            ];
            $data = $app->db->select(
                'tbl_users',
                [
                    "[>]tbl_classes" => ["id_class" => "id_class"],
                    "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"]

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
            'tbl_users',
            [
                "[>]tbl_classes" => ["id_class" => "id_class"],
                "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"]
            ],
            [
                'tbl_classes.id_class',
                'NISN',
                'first_name',
                'last_name',
                'gender',
                'tbl_classes.id_class',
                'tbl_classes.class',
                'tbl_sections.section',
                'phone_user',
                'email',
            ],
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
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item subject_remove" data="' . $i['id_class'] . '"><button type="button" class="btn btn-light btn-lg" class="modal-trigger" data-toggle="modal"
                    data-target="#confirmation-modalS"><i class="fas fa-trash text-orange-red"></i> Hapus </button></a>
                    <a class="btn dropdown-item subject_detail" data="' . $i['id_class'] . '" ><button type="button" id="show_subject"  class="btn btn-light btn-lg"  data-toggle="modal" 
                    data-target="#detail_subject"><i class="fas fa-edit text-dark-pastel-green"></i> Ubah
                        </button></a>
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


    public function getTeacherMod($app, $request, $response, $args)
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

    public function getSectionMod($app, $request, $response, $args)
    {
        $response = $app->db->select("tbl_sections", [
            "id_section",
            "section",
        ]);

        return $response;
    }

    public function getSubjectMod($app, $request, $response, $args)
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
