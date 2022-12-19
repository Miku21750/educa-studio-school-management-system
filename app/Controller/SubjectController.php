<?php

namespace App\Controller;

use Medoo\Medoo;
use App\Controller\SubjectController as ControllerSubjectController;

// session_start();

class SubjectController
{

    public static function index($app, $response, $request, $args)
    {

        $result = $app->db->select('tbl_subjects', [
            "[><]tbl_classes" => "id_class"
        ], '*');

        // $section = $app->db->select('tbl_sections', '*');

        $teacher = $app->db->select('tbl_users', '*', [
            "id_user_type" => 2
        ]);

        return $app->view->render($response, 'others/all-subject.html', [
            "result" => $result,
            // "section" => $section,
            "teacher" => $teacher
        ]);
    }

    public static function view_data_subject($app, $request, $response, $args)
    {

        $result = $app->db->select('tbl_subjects', '*');
        // return var_dump($result);

        $columns = array(
            0 => 'id',
        );
        // return var_dump($columns);

        $totaldata = count($result);
        $totalfiltered = $totaldata;
        $limit = $request->getParam('length');
        $start = $request->getParam('start');
        $order = $request->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $request->getParam('order');
        $dir = $dir[0]['dir'];


        $conditions = [
            "LIMIT" => [$start, $limit]
        ];


        if (!empty($request->getParam('search')['value'])) {
            $search = $request->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit]

            ];
            $conditions['OR'] = [
                'tbl_subjects.subject_name[~]' => '%' . $search . '%',
                'tbl_subjects.subject_type[~]' => '%' . $search . '%'

            ];
            $result = $app->db->select(
                'tbl_subjects',
                [
                    "[><]tbl_classes" => "id_class"
                ],
                '*',
                // $limit
                $conditions
            );
            $totaldata = count($result);
            $totalfiltered = $totaldata;
        }


        $result = $app->db->select('tbl_subjects', '*', $conditions);

        $data = array();

        if (!empty($result)) {
            $no = $request->getParam('start') + 1;
            foreach ($result as $m) {

                $datas['ID'] = $no . '.';
                $datas['subject_name'] = $m['subject_name'];
                $datas['subject_type'] = $m['subject_type'];
                $datas[''] = '<div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3">
                    <a class="dropdown-item btn btn-light btn-lg subject_remove my-2" data="' . $m['id_subject'] . '" data-target="#confirmation-modalS">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="btn dropdown-item btn btn-light btn-lg subject_detail my-2" data="' . $m['id_subject'] . '" data-target="#detail_subject">
                        <i class="fas fa-edit text-dark-pastel-green"></i>
                        Ubah
                    </a>
                </div>
            </div>';

                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($result);
        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }

    public static function add_subject($app, $request, $response, $args)
    {

        $data = $args['tambah'];

        $app->db->insert('tbl_subjects', [
            'subject_name' => $data['subject_name'],
            'subject_type' => $data['subject_type']
        ]);

        $json_data = array(
            "draw" => intval($request->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function detail($app, $request, $response, $id_subject)
    {
        $data = $app->db->get('tbl_subjects', [
            "id_subject",
            "subject_name",
            "subject_type"
        ], [
            "id_subject" => $id_subject
        ]);
        $json_data = array(
            'data' => $data
        );
        return $response->withJson($data);
    }

    public static function update_subject($app, $request, $response, $args)
    {

        $data = $args['data'];
        // return var_dump($data);

        $app->db->update('tbl_subjects', [
            'subject_name' => $data['subject_name'],
            'subject_type' => $data['subject_type']
        ], [
            "id_subject" => $data['id_subject']
        ]);

        $json_data = array(
            "draw" => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);
    }

    public static function delete_subject($app, $request, $response, $args)
    {
        $id = $args['data'];
        // return var_dump($id);

        $app->db->delete('tbl_subjects', [
            "id_subject" => $id
        ]);

        $json_data = array(
            "draw" => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);
    }
}
