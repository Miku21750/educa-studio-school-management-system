<?php

namespace App\Controller;
use Medoo\medoo;



class ExamController{

    public static function index($app, $request, $response, $args)
    {
        $id_exam = $args['id_exam'];
        // return var_dump($id_parent);



        $data = $app->db->select('tbl_exams', '*');

        // var_dump($data);

        $app->view->render($response, 'exam/exam-schedule.html', [
            'data' =>  $data,
            'id_exam' => $id_exam,
        ]);
    }


    public static function tampil_data($app, $req, $rsp, $args)
    {
        $tbl_classes = 'tbl_classes';

        $exam = $app->db->select('tbl_exams',[
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_subjects' => 'id_subject',
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ],[
            'id_exam(id_exam)',
            'exam_name(exam_name)',
            'subject_name(subject_name)',
            'class(class)',
            'exam_date(exam_date)',
            'exam_time(exam_time)',
        ]);
        // return var_dump($exam);
        // die();
     

        $totaldata = count($exam);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');


        $conditions = [
            "LIMIT" => [$start, $limit],

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                // 'id_exam_type' => $type,

            ];
            $conditions['OR'] = [
                'tbl_exams.exam_name[~]' => '%' . $search . '%',
                'tbl_subjects.subject_name[~]' => '%' . $search . '%',
                'tbl_classes.class[~]' => '%' . $search . '%',
                'tbl_exams.exam_date[~]' => '%' . $search . '%',
                'tbl_exams.exam_time[~]' => '%' . $search . '%',

            ];
            $exam = $app->db->select('tbl_exams',[
                '[><]tbl_classes' => 'id_class',
                '[><]tbl_subjects' => 'id_subject',
                '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
            ],[
                'exam_name(exam_name)',
                'subject_name(subject_name)',
                'class(class)',
                'exam_date(exam_date)',
                'exam_time(exam_time)',
            ],
                $limit
            );
            $totaldata = count($exam);
            $totalfiltered = $totaldata;
        }

        $exam = $app->db->select('tbl_exams',[
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_subjects' => 'id_subject',
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ],[
            'id_exam(id_exam)',
            'exam_name(exam_name)',
            'subject_name(subject_name)',
            'class(class)',
            'exam_date(exam_date)',
            'exam_time(exam_time)',
        ], $conditions);

        $data = array();

        if (!empty($exam)) {
            $no = $req->getParam('start') + 1;
            foreach ($exam as $m) {

                $datas['No'] = $no . '.';
                $datas['exam_name'] = $m['exam_name'];
                $datas['subject_name'] = $m['subject_name'];
                $datas['Class'] = $m['class'];
                $datas['exam_date'] = $m['exam_date'];
                $datas['exam_time'] = $m['exam_time'];
                $datas['aksi'] =  '<div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item exam_remove" data="' . $m['id_exam'] . '"><button type="button" class="btn btn-light" class="modal-trigger" data-toggle="modal"
                    data-target="#confirmation-modal"><i class="fas fa-trash text-orange-red"></i>
                            Hapus
                        </button></a>
                    <a class="btn dropdown-item exam_detail" data="' . $m['id_exam'] . '" ><button type="button" id="show_book"  class="btn btn-light"  data-toggle="modal" data-target="detail_book"><i
                            class="fas fa-edit text-dark-pastel-green"></i>
                            Ubah
                        </button></a>
                </div>
            </div>';
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($exam);
        // return var_dump($exam);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        // return var_dump($json_data);
        echo json_encode($json_data);
    }

    public static function detail($app, $request, $response, $id_exam)
    {
        // $id_exam = $data;
        // var_dump($id_exam);

        $data = $app->db->get('tbl_exams', [
            "id_exam",
            "id_class",
            "id_subject",
            "exam_name",
            "exam_date",
            "exam_time",
        ], [
            'id_exam' => $id_exam
        ]);
        // return var_dump($data);
        $json_data = array(
            'data' => $data
        );

        return $response->withJson($data);

        // return var_dump($json_data);
        // echo json_encode($json_data);
    }

    public static function delete($app, $req, $rsp, $args)
    {
        $id = $args['data'];


        $del = $app->db->delete('tbl_exams', [
            "id_exam" => $id
        ]);

        // return $rsp->withJson($del);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function update_exam_detail($app, $request, $response, $args)
    {
        $data = $args['data'];
        
        $update = $app->db->update('tbl_exams', [
            "exam_name" => $data['exam_name'],
            "room_number" => $data['room_number'],
            "room_type" => $data['room_type'],
            "number_of_bed" => $data['number_of_bed'],
            "cost_per_bed" => $data['cost_per_bed']
        ], [
            "id_exam" => $data['id_exam']
        ]);
        // return var_dump($update);

        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);

        // return var_dump($update);
    }

    public static function add_exam($app, $req, $rsp, $args)
    {
        $data = $args['data'];
        // return var_dump($data);
        
        $data = $app->db->insert('tbl_exams', [
            "exam_name" => $data['exam_name'],
            "room_number" => $data['room_number'],
            "room_type" => $data['room_type'],
            "number_of_bed" => $data['number_of_bed'],
            "cost_per_bed" => $data['cost_per_bed']
        ]);
        // return var_dump($data);
        // $json_data = array(
        //     "draw"            => intval($request->getParam('draw')),
        // );
        // echo json_encode($json_data);
        return $rsp->withJson(array('success'=>true));
    }
}
