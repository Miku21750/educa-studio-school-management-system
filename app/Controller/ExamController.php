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
            'section(section)',
            'exam_date(exam_date)',
            'exam_start(exam_start)',
            'exam_end(exam_end)',
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
                'tbl_exams.exam_start[~]' => '%' . $search . '%',
                'tbl_exams.exam_end[~]' => '%' . $search . '%',

            ];
            $exam = $app->db->select('tbl_exams',[
                '[><]tbl_classes' => 'id_class',
                '[><]tbl_subjects' => 'id_subject',
                '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
            ],[
                'exam_name(exam_name)',
                'subject_name(subject_name)',
                'class(class)',
                'section(section)',
                'exam_date(exam_date)',
                'exam_start(exam_start)',
                'exam_end(exam_end)',
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
            'section(section)',
            'exam_date(exam_date)',
            'exam_start(exam_start)',
            'exam_end(exam_end)',
        ], $conditions);

        $data = array();

        if (!empty($exam)) {
            $no = $req->getParam('start') + 1;
            foreach ($exam as $m) {
                $examStart = strtotime($m['exam_start']);
                $examEnd = strtotime($m['exam_end']);
                $datas['No'] = $no . '.';
                $datas['exam_name'] = $m['exam_name'];
                $datas['subject_name'] = $m['subject_name'];
                $datas['class'] = $m['class'] . ' ' . $m['section'];
                $datas['exam_date'] = $m['exam_date'];
                $datas['exam_time'] = date("H:i",$examStart).' - '.date("H:i",$examEnd);
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
    
    public static function tampil_data_grade($app, $req, $rsp, $args)
    {
        $grade = $app->db->select('tbl_exam_grades','*');
        // return var_dump($exam);
        // die();
     

        $totaldata = count($grade);
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
                'tbl_exam_grades.grade_name[~]' => '%' . $search . '%',
                'tbl_exam_grades.percent_from[~]' => '%' . $search . '%',
                'tbl_exam_grades.percent_upto[~]' => '%' . $search . '%',
                'tbl_exam_grades.grade_desc[~]' => '%' . $search . '%',
                'tbl_exam_grades.grade_point[~]' => '%' . $search . '%',

            ];
            $grade = $app->db->select('tbl_exam_grades','*',
                $limit
            );
            $totaldata = count($grade);
            $totalfiltered = $totaldata;
        }

        $grade = $app->db->select('tbl_exam_grades','*', $conditions);

        $data = array();

        if (!empty($grade)) {
            $no = $req->getParam('start') + 1;
            foreach ($grade as $m) {
                $datas['No'] = $no . '.';
                $datas['grade_name'] = $m['grade_name'];
                $datas['percent_from'] = $m['percent_from'];
                $datas['percent_upto'] = $m['percent_upto'];
                $datas['grade_desc'] = $m['grade_desc'];
                $datas['grade_point'] = $m['grade_point'];
            //     $datas['aksi'] =  '<div class="dropdown">
            //     <a href="#" class="dropdown-toggle" data-toggle="dropdown"
            //         aria-expanded="false">
            //         <span class="flaticon-more-button-of-three-dots"></span>
            //     </a>
            //     <div class="dropdown-menu dropdown-menu-right">
            //         <a class="dropdown-item grade_remove" data="' . $m['id_exam_grade'] . '"><button type="button" class="btn btn-light" class="modal-trigger" data-toggle="modal"
            //         data-target="#confirmation-modal"><i class="fas fa-trash text-orange-red"></i>
            //                 Hapus
            //             </button></a>
            //         <a class="btn dropdown-item grade_detail" data="' . $m['id_exam_grade'] . '" ><button type="button" id="show_book"  class="btn btn-light"  data-toggle="modal" data-target="detail_book"><i
            //                 class="fas fa-edit text-dark-pastel-green"></i>
            //                 Ubah
            //             </button></a>
            //     </div>
            // </div>';
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($grade);
        // return var_dump($grade);

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
            "exam_start",
            "exam_end"
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
            "id_class" => $data['id_class'],
            "id_subject" => $data['id_subject'],
            "exam_date" => $data['exam_date'],
            "exam_start" => $data['exam_start'],
            "exam_end" => $data['exam_end']
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
            "id_class" => $data['id_class'],
            "id_subject" => $data['id_subject'],
            "exam_date" => $data['exam_date'],
            "exam_start" => $data['exam_start'],
            "exam_end" => $data['exam_end']
        ]);
        // return var_dump($data);
        // $json_data = array(
        //     "draw"            => intval($request->getParam('draw')),
        // );
        // echo json_encode($json_data);
        return $rsp->withJson(array('success'=>true));
    }

    public static function option_exam($app, $req, $rsp, $args)
    {
        $class = $app->db->query("SELECT * FROM tbl_classes c LEFT JOIN tbl_sections s ON c.id_section = s.id_section")->fetchAll();
        $subject = $app->db->select('tbl_subjects', '*');
        // return var_dump($subject);

        $app->view->render($rsp, 'exam/exam-schedule.html', [
            'class' => $class,
            'subject' => $subject,
        ]);
    }
}
