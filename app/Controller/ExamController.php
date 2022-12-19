<?php

namespace App\Controller;

use Medoo\medoo;



class ExamController
{

    public static function index($app, $request, $response, $args)
    {
        $id_exam = $args['id_exam'];



        $data = $app->db->select('tbl_exams', '*');


        $app->view->render($response, 'exam/exam-schedule.html', [
            'data' =>  $data,
            'id_exam' => $id_exam,
        ]);
    }


    public static function tampil_data($app, $req, $rsp, $args)
    {
        $tbl_classes = 'tbl_classes';

        $exam = $app->db->select('tbl_exams', [
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_subjects' => 'id_subject',
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], [
            'id_exam(id_exam)',
            'exam_name(exam_name)',
            'subject_name(subject_name)',
            'class(class)',
            'section(section)',
            'exam_date(exam_date)',
            'exam_start(exam_start)',
            'exam_end(exam_end)',
        ]);


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


            ];
            $conditions['OR'] = [
                'tbl_exams.exam_name[~]' => '%' . $search . '%',
                'tbl_subjects.subject_name[~]' => '%' . $search . '%',
                'tbl_classes.class[~]' => '%' . $search . '%',
                'tbl_exams.exam_date[~]' => '%' . $search . '%',
                'tbl_exams.exam_start[~]' => '%' . $search . '%',
                'tbl_exams.exam_end[~]' => '%' . $search . '%',

            ];
            $exam = $app->db->select(
                'tbl_exams',
                [
                    '[><]tbl_classes' => 'id_class',
                    '[><]tbl_subjects' => 'id_subject',
                    '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
                ],
                [
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

        $exam = $app->db->select('tbl_exams', [
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_subjects' => 'id_subject',
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], [
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
                $datas['exam_time'] = date("H:i", $examStart) . ' - ' . date("H:i", $examEnd);
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

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        echo json_encode($json_data);
    }

    public static function tampil_dataS($app, $req, $rsp, $args)
    {
        $tbl_classes = 'tbl_classes';

        $exam = $app->db->select('tbl_exams', [
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_subjects' => 'id_subject',
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
            '[>]tbl_users' => ['id_class' => 'id_class']
        ], [
            'id_exam(id_exam)',
            'exam_name(exam_name)',
            'subject_name(subject_name)',
            'class(class)',
            'section(section)',
            'exam_date(exam_date)',
            'exam_start(exam_start)',
            'exam_end(exam_end)',
        ], [
            'id_user' => $_SESSION['id_user']
        ]);


        $totaldata = count($exam);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');


        $conditions = [
            "LIMIT" => [$start, $limit],
            'id_user' => $_SESSION['id_user']

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],


            ];
            $conditions['OR'] = [
                'tbl_exams.exam_name[~]' => '%' . $search . '%',
                'tbl_subjects.subject_name[~]' => '%' . $search . '%',
                'tbl_classes.class[~]' => '%' . $search . '%',
                'tbl_exams.exam_date[~]' => '%' . $search . '%',
                'tbl_exams.exam_start[~]' => '%' . $search . '%',
                'tbl_exams.exam_end[~]' => '%' . $search . '%',

            ];
            $exam = $app->db->select(
                'tbl_exams',
                [
                    '[><]tbl_classes' => 'id_class',
                    '[><]tbl_subjects' => 'id_subject',
                    '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
                    '[>]tbl_users' => ['id_class' => 'id_class']
                ],
                [
                    'exam_name(exam_name)',
                    'subject_name(subject_name)',
                    'class(class)',
                    'section(section)',
                    'exam_date(exam_date)',
                    'exam_start(exam_start)',
                    'exam_end(exam_end)',
                ],

                $conditions
            );
            $totaldata = count($exam);
            $totalfiltered = $totaldata;
        }

        $exam = $app->db->select('tbl_exams', [
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_subjects' => 'id_subject',
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
            '[>]tbl_users' => ['id_class' => 'id_class']
        ], [
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
                $datas['exam_time'] = date("H:i", $examStart) . ' - ' . date("H:i", $examEnd);
                $data[] = $datas;
                $no++;
            }
        }

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public static function tampil_data_grade($app, $req, $rsp, $args)
    {
        $grade = $app->db->select('tbl_exam_grades', '*');

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

            ];
            $conditions['OR'] = [
                'tbl_exam_grades.grade_name[~]' => '%' . $search . '%',
                'tbl_exam_grades.percent_from[~]' => '%' . $search . '%',
                'tbl_exam_grades.percent_upto[~]' => '%' . $search . '%',
                'tbl_exam_grades.grade_desc[~]' => '%' . $search . '%',
                'tbl_exam_grades.grade_point[~]' => '%' . $search . '%',

            ];
            $grade = $app->db->select(
                'tbl_exam_grades',
                '*',
                $limit
            );
            $totaldata = count($grade);
            $totalfiltered = $totaldata;
        }

        $grade = $app->db->select('tbl_exam_grades', '*', $conditions);

        $data = array();

        if (!empty($grade)) {
            $no = $req->getParam('start') + 1;
            foreach ($grade as $m) {
                $datas['No'] = $no . '.';
                $datas['grade_name'] = $m['grade_name'];
                $datas['percent_from'] = $m['percent_from'] . ' - ' . $m['percent_upto'] . '%';
                $datas['grade_desc'] = $m['grade_desc'];
                $datas['grade_point'] = $m['grade_point'];
                $datas['aksi'] = '
                <button type="button" id="show_book"  class="btn btn-light grade_detail" data="' . $m['id_exam_grade'] . '  data-toggle="modal" data-target="detail_book">
                <i class="fas fa-edit text-dark-pastel-green"></i>
                        Ubah
                </button>';
                $data[] = $datas;
                $no++;
            }
        }

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public static function tampil_data_gradeS($app, $req, $rsp, $args)
    {
        $grade = $app->db->select('tbl_exam_grades', '*');
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
            $grade = $app->db->select(
                'tbl_exam_grades',
                '*',
                // $limit
                $conditions
            );
            $totaldata = count($grade);
            $totalfiltered = $totaldata;
        }

        $grade = $app->db->select('tbl_exam_grades', '*', $conditions);

        $data = array();

        if (!empty($grade)) {
            $no = $req->getParam('start') + 1;
            foreach ($grade as $m) {
                $datas['No'] = $no . '.';
                $datas['grade_name'] = $m['grade_name'];
                $datas['percent_from'] = $m['percent_from'] . '%' . ' - ' . $m['percent_upto'] . '%';
                $datas['grade_desc'] = $m['grade_desc'];
                $datas['grade_point'] = $m['grade_point'];
                // $datas['aksi'] = '<a class="btn dropdown-item grade_detail" data="' . $m['id_exam_grade'] . '" ><button type="button" id="show_book"  class="btn btn-light"  data-toggle="modal" data-target="detail_book"><i
                //         class="fas fa-edit text-dark-pastel-green"></i>
                //         Ubah
                // </button></a>';
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

        $json_data = array(
            'data' => $data
        );

        return $response->withJson($data);
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

        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);
    }

    public static function add_exam($app, $req, $rsp, $args)
    {
        $data = $args['data'];

        $data = $app->db->insert('tbl_exams', [
            "exam_name" => $data['exam_name'],
            "id_class" => $data['id_class'],
            "id_subject" => $data['id_subject'],
            "exam_date" => $data['exam_date'],
            "exam_start" => $data['exam_start'],
            "exam_end" => $data['exam_end']
        ]);

        return $rsp->withJson(array('success' => true));
    }
    public static function add_exam_result($app, $req, $rsp, $args)
    {
        $data = $args['data'];

        $tanggal = date("Y-m-d ");

        $data = $app->db->insert('tbl_exam_results', [
            "id_user" => $data['id_siswa'],
            "id_exam" => $data['id_exam'],
            "id_exam_grade" => $data['id_grade'],
            "score" => $data['score'],
            "date_result" => $tanggal
        ]);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );
        echo json_encode($json_data);
    }

    public static function option_exam($app, $req, $rsp, $args)
    {
        $class = $app->db->query("SELECT * FROM tbl_classes c LEFT JOIN tbl_sections s ON c.id_section = s.id_section")->fetchAll();
        $subject = $app->db->select('tbl_subjects', '*');

        $app->view->render($rsp, 'exam/exam-schedule.html', [
            'class' => $class,
            'subject' => $subject,
        ]);
    }

    public static function exam_result($app, $req, $rsp, $args)
    {
        $user = $app->db->select('tbl_users', [
            '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
            '[>]tbl_sections' => 'id_section'
        ], '*', [
            'id_user_type' => 1
        ]);
        $exam = $app->db->select(
            'tbl_exams',
            [
                '[><]tbl_classes' => ["tbl_exams.id_class" => 'id_class'],
                '[><]tbl_subjects' => ["tbl_exams.id_subject" => 'id_subject'],
                '[>]tbl_sections' => 'id_section'
            ],
            '*'
        );
        $grade = $app->db->select(
            'tbl_exam_grades',
            '*'
        );

        $app->view->render($rsp, 'exam/exam-result.html', [
            'user' => $user,
            'exam' => $exam,
            'grade' => $grade,
        ]);
    }

    public static function delete_result($app, $req, $rsp, $args)
    {
        $id = $args['data'];


        $del = $app->db->delete('tbl_exam_results', [
            "id_result" => $id
        ]);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function tampil_data_result($app, $req, $rsp, $args)
    {

        $result = $app->db->select('tbl_exam_results', [
            '[><]tbl_exams' => 'id_exam',
            '[><]tbl_classes' => ["tbl_exams.id_class" => 'id_class'],
            '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],
            '[><]tbl_subjects' => ["tbl_exams.id_subject" => 'id_subject'],
            '[><]tbl_users' => 'id_user',
            '[><]tbl_exam_grades' => 'id_exam_grade',
        ], '*');

        $columns = array(
            0 => 'id',
        );

        $totaldata = count($result);
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

            ];
            $conditions['OR'] = [
                'tbl_users.NISN[~]' => '%' . $search . '%',
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',

            ];
            $result = $app->db->select(
                'tbl_exam_results',
                [
                    '[><]tbl_exams' => 'id_exam',
                    '[><]tbl_classes' => ["tbl_exams.id_class" => 'id_class'],
                    '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],
                    '[><]tbl_subjects' => ["tbl_exams.id_subject" => 'id_subject'],
                    '[><]tbl_users' => 'id_user',
                    '[><]tbl_exam_grades' => 'id_exam_grade',

                ],
                '*',
                // $limit
                $conditions
            );
            $totaldata = count($result);
            $totalfiltered = $totaldata;
        }

        $result = $app->db->select('tbl_exam_results', [
            '[><]tbl_exams' => 'id_exam',
            '[><]tbl_classes' => ["tbl_exams.id_class" => 'id_class'],
            '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],
            '[><]tbl_subjects' => ["tbl_exams.id_subject" => 'id_subject'],
            '[><]tbl_users' => 'id_user',
            '[><]tbl_exam_grades' => 'id_exam_grade',

        ], '*', $conditions);

        $data = array();

        if (!empty($result)) {
            foreach ($result as $m) {

                $datas['nisn'] = $m['NISN'];
                $datas['nama'] = $m['first_name'] . ' ' . $m['last_name'];
                $datas['ujian'] = $m['exam_name'];
                $datas['mapel'] = $m['subject_name'];
                $datas['kelas'] = $m['class'] . ' ' . $m['section'];
                $datas['nilai'] = $m['score'];
                $datas['grade'] = $m['grade_name'];
                $datas['tanggal'] = $m['date_result'];

                $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item"  ><i
                            class="fas fa-trash text-orange-red"></i><button type="button" class="btn btn-light hapus item_hapus" data="' . $m['id_result'] . '"">
                            Hapus
                        </button></a>
                    <a class="dropdown-item " ><i
                            class="fas fa-solid fa-edit text-orange-peel"></i><button type="button" class="btn btn-light result_detail"  data="' . $m['id_result'] . '"" >
                            Ubah
                        </button></a>
                   
                </div>
            </div>';

                $data[] = $datas;
            }
        }

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public static function tampil_data_resultS($app, $req, $rsp, $args)
    {
        $kelas = $app->db->select('tbl_users', 'id_class', [
            'id_user' => $_SESSION['id_user']
        ]);
        $bagian = $app->db->select(
            'tbl_sections',
            [
                '[><]tbl_classes' => 'id_section'
            ],
            'id_section',
            [
                'id_class' => $kelas
            ]
        );
        $result = $app->db->select(
            'tbl_exam_results',
            [
                // '[><]tbl_exams' => 'id_exam',
                // '[><]tbl_classes' => ["tbl_exams.id_class" => 'id_class'],
                // '[><]tbl_sections' => 'id_section',
                // '[><]tbl_subjects' => ["tbl_exams.id_subject" => 'id_subject'],
                // '[><]tbl_users' => 'id_user',
                // '[><]tbl_exam_grades' => 'id_exam_grade',


                '[><]tbl_exams' => 'id_exam',
                '[><]tbl_classes' => ["tbl_exams.id_class" => 'id_class'],
                '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],
                '[><]tbl_subjects' => ["tbl_exams.id_subject" => 'id_subject'],
                '[><]tbl_users' => 'id_user',
                '[><]tbl_exam_grades' => 'id_exam_grade',
            ],
            '*',
            [
                'tbl_users.id_class' => $kelas,
                'tbl_sections.id_section' => $bagian,
                'ORDER' => [
                    'first_name' => 'ASC'
                ]
            ]
        );

        // $result = $app->db->debug()->select('tbl_users', [
        //     '[><]tbl_exams' => ['id_class' => 'id_exam'],
        //     '[><]tbl_classes' => ["tbl_exams.id_class" => 'id_class'],
        //     '[><]tbl_sections' => 'id_section',
        //     '[><]tbl_subjects' => ["tbl_exams.id_subject" => 'id_subject'],
        //     '[><]tbl_exam_results' => 'id_user',
        //     '[><]tbl_exam_grades' => 'id_exam_grade',
        // ], 
        // '*'
        // , [
        //     'tbl_users.id_class' => $kelas
        // ]);

        $columns = array(
            0 => 'id',
        );

        $totaldata = count($result);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];


        $conditions = [
            "LIMIT" => [$start, $limit],
            // 'id_user' => $_SESSION['id_user'],
            'tbl_users.id_class' => $kelas,
            'tbl_sections.id_section' => $bagian,
            'ORDER' => [
                'first_name' => 'ASC'
            ]
        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],

            ];
            $conditions['OR'] = [
                'tbl_users.NISN[~]' => '%' . $search . '%',
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',

            ];
            $result = $app->db->select(
                'tbl_exam_results',
                [
                    // '[><]tbl_exams' => 'id_exam',
                    // '[><]tbl_classes' => ["tbl_exams.id_class" => 'id_class'],
                    // '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],
                    // '[><]tbl_subjects' => ["tbl_exams.id_subject" => 'id_subject'],
                    // '[><]tbl_users' => 'id_user',
                    // '[><]tbl_exam_grades' => 'id_exam_grade',


                    '[><]tbl_exams' => 'id_exam',
                    '[><]tbl_classes' => ["tbl_exams.id_class" => 'id_class'],
                    '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],
                    '[><]tbl_subjects' => ["tbl_exams.id_subject" => 'id_subject'],
                    '[><]tbl_users' => 'id_user',
                    '[><]tbl_exam_grades' => 'id_exam_grade',

                ],
                '*',
                // $limit
                $conditions
            );
            $totaldata = count($result);
            $totalfiltered = $totaldata;
        }

        $result = $app->db->select('tbl_exam_results', [
            // '[><]tbl_exams' => 'id_exam',
            // '[><]tbl_classes' => ["tbl_exams.id_class" => 'id_class'],
            // '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],
            // '[><]tbl_subjects' => ["tbl_exams.id_subject" => 'id_subject'],
            // '[><]tbl_users' => 'id_user',
            // '[><]tbl_exam_grades' => 'id_exam_grade',


            '[><]tbl_exams' => 'id_exam',
            '[><]tbl_classes' => ["tbl_exams.id_class" => 'id_class'],
            '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section'],
            '[><]tbl_subjects' => ["tbl_exams.id_subject" => 'id_subject'],
            '[><]tbl_users' => 'id_user',
            '[><]tbl_exam_grades' => 'id_exam_grade',

        ], '*', $conditions);

        $data = array();

        if (!empty($result)) {
            foreach ($result as $m) {

                $datas['nisn'] = $m['NISN'];
                $datas['nama'] = $m['first_name'] . ' ' . $m['last_name'];
                $datas['ujian'] = $m['exam_name'];
                $datas['mapel'] = $m['subject_name'];
                $datas['kelas'] = $m['class'] . ' ' . $m['section'];
                $datas['nilai'] = $m['score'];
                $datas['grade'] = $m['grade_name'];
                $datas['tanggal'] = $m['date_result'];

                //     $datas['aksi'] = '<div class="dropdown">

                //     <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                //         aria-expanded="false">
                //         <span class="flaticon-more-button-of-three-dots"></span>
                //     </a>
                //     <div class="dropdown-menu dropdown-menu-right">
                //         <a class="dropdown-item"  ><i
                //                 class="fas fa-trash text-orange-red"></i><button type="button" class="btn btn-light hapus item_hapus" data="' . $m['id_result'] . '"">
                //                 Hapus
                //             </button></a>
                //         <a class="dropdown-item " ><i
                //                 class="fas fa-solid fa-edit text-orange-peel"></i><button type="button" class="btn btn-light result_detail"  data="' . $m['id_result'] . '"" >
                //                 Ubah
                //             </button></a>

                //     </div>
                // </div>';

                $data[] = $datas;
            }
        }

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public static function grade_detail($app, $request, $response, $args)
    {
        $id_exam_grade = $args;

        $data = $app->db->get('tbl_exam_grades', '*', [
            'id_exam_grade' => $id_exam_grade
        ]);
        return $response->withJson($data);
    }

    public static function update_grade_detail($app, $request, $response, $args)
    {
        $data = $args['data'];

        $update = $app->db->update('tbl_exam_grades', [
            "grade_name" => $data['grade_name'],
            "grade_point" => $data['grade_point'],
            "percent_from" => $data['percent_from'],
            "percent_upto" => $data['percent_upto'],
            "grade_desc" => $data['grade_desc']
        ], [
            "id_exam_grade" => $data['id_exam_grade']
        ]);


        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);
    }

    public static function result_detail($app, $request, $response, $args)
    {
        $id_result = $args['data'];

        $data = $app->db->get('tbl_exam_results', [
            '[><]tbl_users' => 'id_user',

        ], '*', [
            'id_result' => $id_result
        ]);


        return $response->withJson($data);
    }
    public static function update_result_detail($app, $request, $response, $args)
    {
        $data = $args['data'];

        $update = $app->db->update('tbl_exam_results', [
            "id_user" => $data['id_user'],
            "id_exam" => $data['id_exam'],
            "id_exam_grade" => $data['id_exam_grade'],
            "score" => $data['score'],
        ], [
            "id_result" => $data['id_result']
        ]);

        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);
    }
}
