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
            "[><]tbl_classes"=>"id_class"
        ], '*');

        return $app->view->render($response, 'others/all-subject.html', [
            "result" => $result
        ]);
    }

    public static function view_data_subject($app, $response, $request, $args)
    {

        // $result = $app->db->debug()->select('tbl_subjects', [
        //     "[>]tbl_sections"=>["id_subject" => "id_section"],
        //     "[>]tbl_classes"=>["id_section" => "id_class"],
        //     "[>]tbl_users"=>["id_user" => "id_user"]
        // ], '*', [
        //     "id_user" => $_SESSION['id_user']
        // ]);
        $result = $app->db->select('tbl_subjects', [
            "[><]tbl_classes"=>"id_class",
            "[>]tbl_users"=>"id_class"
        ], '*', [
            "id_user" => $_SESSION['id_user']
        ]);
        return var_dump($result);
        $columns = array(
            0 => 'id',
        );

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
                'tbl_subjects.subject_name[~]' => '%' . $search . '%'

            ];
            $result = $app->db->select('tbl_subjects', [
                "[><]tbl_classes"=>"id_class"
            ], '*',
                $limit
            );
            $totaldata = count($result);
            $totalfiltered = $totaldata;
        }


        $result = $app->db->select('tbl_subjects', [
            "[><]tbl_classes"=>"id_class"
        ], '*', $conditions);

        $data = array();

        if (!empty($result)) {
            foreach ($result as $m) {

                $datas['id_subject'] = $m['id_subject'];
                $datas['subject_name'] = $m['subject_name'];
                $datas['subject_type'] = $m['subject_type'];
                $datas['class'] = $m['class'];

                $data[] = $datas;
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
}
