<?php

namespace App\Controller;

use Medoo\Medoo;

class ClassRoutineController
{
    public static function index($app, $response, $request, $args)
    {

        $result = $app->db->select(
            'tbl_subjects',
            [
                "[>]tbl_users" => ["id_subject" => "id_user"],
                "[>]tbl_sections" => ["id_subject" => "id_section"],
                "[>]tbl_classes" => ["id_subject" => "id_class"]
            ],
            [
                'id_subject',
                'subject_name',
                'subject_type',
                'tbl_classes.id_class',
                'id_user',
                'first_name',
                'last_name',
                'NISN',
                'section',
                'tbl_classes.class'
            ],
            [
                "id_user_type" => 2
            ]
        );

        // $coba = $app->db->debug()->select(
        //     'tbl_class_routines',
        //     [
        //         "[>]tbl_subjects" => ["id_subject" => "id_subject"],
        //         "[>]tbl_classes" => ["id_class" => "id_class"],
        //         "[>]tbl_users" => ["id_user" => "id_user"],
        //         "[>]tbl_sections" => ["id_class" => "id_section"]
        //     ], [
        //     // '*'
        //     'id_class_routine',
        //     'tbl_class_routines.id_class',
        //     'tbl_class_routines.id_subject',
        //     'tbl_class_routines.id_user',
        //     'school_day',
        //     'start_time',
        //     'end_time',
        //     'tbl_subjects.id_subject',
        //     'subject_name',
        //     'subject_type',
        //     'tbl_classes.id_class',
        //     'tbl_classes.id_section',
        //     'tbl_classes.class',
        //     'tbl_users.id_user',
        //     'tbl_users.id_class',
        //     'tbl_users.id_user_type',
        //     'tbl_users.id_parent',
        //     'tbl_users.first_name',
        //     'tbl_users.last_name',
        //     'tbl_users.NISN',
        //     'tbl_sections.id_section',
        //     'tbl_sections.section']
        // );

        $cr = $app->db->select(
            'tbl_class_routines',
            [
                "[>]tbl_subjects" => ["id_subject" => "id_subject"],
                "[>]tbl_classes" => ["id_class" => "id_class"],
                "[>]tbl_users" => ["id_user" => "id_user"],
                "[>]tbl_sections" => ["id_class" => "id_section"]
            ],
            '*'
        );

        $subject = $app->db->select('tbl_subjects', '*');

        $class = $app->db->select(
            'tbl_classes',
            [
                "[>]tbl_sections" => "id_section"
            ],
            '*'
        );

        $section = $app->db->select('tbl_sections', '*');

        $teacher = $app->db->select('tbl_users', '*', [
            "id_user_type" => 2
        ]);

        return $app->view->render($response, 'others/class-routine.html', [
            'result' => $result,
            'subject' => $subject,
            'class' => $class,
            'section' => $section,
            'teacher' => $teacher,
            'cr' => $cr
        ]);
    }

    public static function view_data_classroutine($app, $request, $response, $args)
    {
        $result = $app->db->select(
            'tbl_class_routines',
            [
                "[>]tbl_classes" => ["id_class" => "id_class"],
                "[>]tbl_subjects" => ["id_subject" => "id_subject"],
                "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"],
                "[>]tbl_users" => ["id_user" => "id_user"],
            ],
            '*'
        );
        // return var_dump($result);

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
            "LIMIT" => [$start, $limit],
            "ORDER" => [
                "school_day" => "ASC",
                "start_time" => "ASC"
            ]
        ];

        if (!empty($request->getParam('search')['value'])) {
            $search = $request->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit]

            ];
            $conditions['OR'] = [
                'subject_name[~]' => '%' . $search . '%',
                'first_name[~]' => '%' . $search . '%',
                'school_day[~]' => '%' . $search . '%',
                'class[~]' => '%' . $search . '%',
                'start_time[~]' => '%' . $search . '%',

            ];
            $result = $app->db->select(
                'tbl_class_routines',
                [
                    "[>]tbl_classes" => ["id_class" => "id_class"],
                    "[>]tbl_subjects" => ["id_subject" => "id_subject"],
                    "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"],
                    "[>]tbl_users" => ["id_user" => "id_user"],
                ],
                [
                    // '*'
                    'id_class_routine',
                    'school_day',
                    'tbl_classes.class',
                    'tbl_sections.section',
                    'subject_name',
                    'tbl_users.first_name',
                    'tbl_users.last_name',
                    'start_time',
                    'end_time',
                ],
                // $limit,
                $conditions
            );
            $totaldata = count($result);
            $totalfiltered = $totaldata;
        }
        $result = $app->db->select(
            'tbl_class_routines',
            [
                "[>]tbl_classes" => ["id_class" => "id_class"],
                "[>]tbl_subjects" => ["id_subject" => "id_subject"],
                "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"],
                "[>]tbl_users" => ["id_user" => "id_user"],
            ],
            [
                // '*'
                'id_class_routine',
                'school_day',
                'tbl_classes.class',
                'tbl_sections.section',
                'subject_name',
                'tbl_users.first_name',
                'tbl_users.last_name',
                'start_time',
                'end_time',
            ],
            $conditions
        );


        $data = array();

        if (!empty($result)) {
            // $no = $request->getParam('start') + 1;
            foreach ($result as $m) {
                $rawStartTime = strtotime($m['start_time']);
                $rawEndTime = strtotime($m['end_time']);

                // $datas['ID'] = $no. '.';
                $datas['school_day'] = $m['school_day'];
                $datas['class'] = $m['class'];
                $datas['subject_name'] = $m['subject_name'];
                $datas['section'] = $m['section'];
                $datas['teacher_name'] = $m['first_name'] . " " . $m['last_name'];
                $datas['time'] = date("H:i", $rawStartTime) . " - " . date("H:i", $rawEndTime);
                // $datas['time'] = $m['start_time'] - $m['end_time'];
                $datas[''] = '<div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item class_routine_remove" data="' . $m['id_class_routine'] . '"><button type="button" class="btn btn-light btn-lg" class="modal-trigger" data-toggle="modal"
                    data-target="#confirmation-modalC"><i class="fas fa-trash text-orange-red"></i>
                            Hapus
                        </button></a>
                    <a class="btn dropdown-item class_routine_detail" data="' . $m['id_class_routine'] . '" ><button type="button" id="show_class_routine"  class="btn btn-light btn-lg"  data-toggle="modal" data-target="#detail_class_routine"><i
                            class="fas fa-edit text-dark-pastel-green"></i>
                            Ubah
                        </button></a>
                </div>
            </div>';

                $data[] = $datas;
                // $no++;
            }
        }
        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        return $json_data;
    }

    public static function view_data_classroutine1($app, $request, $response, $args)
    {

        $class = $app->db->select('tbl_users', 'id_class', [
            "id_user" => $_SESSION['id_user']
        ]);

        $result = $app->db->select(
            'tbl_class_routines',
            [
                "[>]tbl_classes" => ["id_class" => "id_class"],
                "[>]tbl_subjects" => ["id_subject" => "id_subject"],
                "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"],
                "[>]tbl_users" => ["id_user" => "id_user"],
            ],
            '*',
            [
                "tbl_classes.id_class" => $class
            ]
        );
        // return var_dump($result);

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
            "LIMIT" => [$start, $limit],
            "ORDER" => [
                "school_day" => "ASC",
                "start_time" => "ASC"
            ],
            "tbl_classes.id_class" => $class

        ];

        // return var_dump($conditions);

        if (!empty($request->getParam('search')['value'])) {
            $search = $request->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit]

            ];
            $conditions['OR'] = [
                'subject_name[~]' => '%' . $search . '%',
                'first_name[~]' => '%' . $search . '%',
                'school_day[~]' => '%' . $search . '%',
                'class[~]' => '%' . $search . '%',
                'start_time[~]' => '%' . $search . '%',

            ];
            $result = $app->db->select(
                'tbl_class_routines',
                [
                    "[>]tbl_classes" => ["id_class" => "id_class"],
                    "[>]tbl_subjects" => ["id_subject" => "id_subject"],
                    "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"],
                    "[>]tbl_users" => ["id_user" => "id_user"],
                ],
                [
                    // '*'
                    'id_class_routine',
                    'school_day',
                    'tbl_classes.class',
                    'tbl_sections.section',
                    'subject_name',
                    'tbl_users.first_name',
                    'tbl_users.last_name',
                    'start_time',
                    'end_time',
                ],
                // $limit,
                // [
                //     "tbl_classes.id_class" => $class
                // ],
                $conditions
            );
            $totaldata = count($result);
            $totalfiltered = $totaldata;
        }
        $result = $app->db->select(
            'tbl_class_routines',
            [
                "[>]tbl_classes" => ["id_class" => "id_class"],
                "[>]tbl_subjects" => ["id_subject" => "id_subject"],
                "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"],
                "[>]tbl_users" => ["id_user" => "id_user"],
            ],
            [
                // '*'
                'id_class_routine',
                'school_day',
                'tbl_classes.class',
                'tbl_sections.section',
                'subject_name',
                'tbl_users.first_name',
                'tbl_users.last_name',
                'start_time',
                'end_time',
            ],
            // [
            //     "tbl_classes.id_class" => $class
            // ],
            $conditions
        );


        $data = array();

        if (!empty($result)) {
            // $no = $request->getParam('start') + 1;
            foreach ($result as $m) {
                $rawStartTime = strtotime($m['start_time']);
                $rawEndTime = strtotime($m['end_time']);

                // $datas['ID'] = $no. '.';
                $datas['school_day'] = $m['school_day'];
                $datas['class'] = $m['class'];
                $datas['subject_name'] = $m['subject_name'];
                $datas['section'] = $m['section'];
                $datas['teacher_name'] = $m['first_name'] . " " . $m['last_name'];
                $datas['time'] = date("H:i", $rawStartTime) . " - " . date("H:i", $rawEndTime);

                $data[] = $datas;
                // $no++;
            }
        }
        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        return $json_data;
    }
    public static function view_data_classroutineguru($app, $request, $response, $args)
    {

        $result = $app->db->select(
            'tbl_class_routines',
            [
                "[>]tbl_classes" => ["id_class" => "id_class"],
                "[>]tbl_subjects" => ["id_subject" => "id_subject"],
                "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"],
                "[>]tbl_users" =>  "id_user",
            ],
            '*',
            [
                "id_user" => $_SESSION['id_user']
                ]
        );
        // return var_dump($result);

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
            "LIMIT" => [$start, $limit],
            "ORDER" => [
                "school_day" => "ASC",
                "start_time" => "ASC"
            ],
            "id_user" => $_SESSION['id_user']

        ];

        // return var_dump($conditions);

        if (!empty($request->getParam('search')['value'])) {
            $search = $request->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                "id_user" => $_SESSION['id_user']

            ];
            $conditions['OR'] = [
                'subject_name[~]' => '%' . $search . '%',
                'first_name[~]' => '%' . $search . '%',
                'school_day[~]' => '%' . $search . '%',
                'class[~]' => '%' . $search . '%',
                'start_time[~]' => '%' . $search . '%',

            ];
            $result = $app->db->select(
                'tbl_class_routines',
                [
                    "[>]tbl_classes" => ["id_class" => "id_class"],
                    "[>]tbl_subjects" => ["id_subject" => "id_subject"],
                    "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"],
                    "[>]tbl_users" =>  "id_user",
                ],
                [
                    // '*'
                    'id_class_routine',
                    'school_day',
                    'tbl_classes.class',
                    'tbl_sections.section',
                    'subject_name',
                    'tbl_users.first_name',
                    'tbl_users.last_name',
                    'start_time',
                    'end_time',
                ],
               
                $conditions
            );
            $totaldata = count($result);
            $totalfiltered = $totaldata;
        }
        $result = $app->db->select(
            'tbl_class_routines',
            [
                "[>]tbl_classes" => ["id_class" => "id_class"],
                "[>]tbl_subjects" => ["id_subject" => "id_subject"],
                "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"],
                "[>]tbl_users" =>  "id_user",
            ],
            [
                // '*'
                'id_class_routine',
                'school_day',
                'tbl_classes.class',
                'tbl_sections.section',
                'subject_name',
                'tbl_users.first_name',
                'tbl_users.last_name',
                'start_time',
                'end_time',
            ],
            $conditions
        );


        $data = array();

        if (!empty($result)) {
            // $no = $request->getParam('start') + 1;
            foreach ($result as $m) {
                $rawStartTime = strtotime($m['start_time']);
                $rawEndTime = strtotime($m['end_time']);

                // $datas['ID'] = $no. '.';
                $datas['school_day'] = $m['school_day'];
                $datas['class'] = $m['class'];
                $datas['subject_name'] = $m['subject_name'];
                $datas['section'] = $m['section'];
                $datas['teacher_name'] = $m['first_name'] . " " . $m['last_name'];
                $datas['time'] = date("H:i", $rawStartTime) . " - " . date("H:i", $rawEndTime);

                $data[] = $datas;
                // $no++;
            }
        }
        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        return $json_data;
    }

    public static function add_class_routine($app, $request, $response, $args)
    {

        $data = $args['tambah'];

        $app->db->insert('tbl_class_routines', [
            'id_class' => $data['id_class'],
            'id_subject' => $data['subject_name'],
            'id_user' => $data['id_user'],
            'school_day' => $data['school_day'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time']
        ]);
        $json_data = array(
            "draw" => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);
    }

    public static function detail($app, $request, $response, $id_class_routine)
    {
        // $data = $app->db->select(
        //     'tbl_class_routines', '*',
        //     [
        //         "id_class_routine" => $id_class_routine
        //     ]
        // );

        // $data = $app->db->select(
        //     'tbl_class_routines',
        //     [
        //         "[>]tbl_classes" => ["id_class" => "id_class"],
        //         "[>]tbl_subjects" => ["id_subject" => "id_subject"],
        //         "[>]tbl_sections" => ["id_class" => "id_section"],
        //         "[>]tbl_users" => ["id_user" => "id_user"],
        //     ],
        //     // '*',
        //     [
        //         // '*'
        //         'id_class_routine',
        //         'tbl_class_routines.id_class',
        //         'tbl_class_routines.id_subject',
        //         'tbl_class_routines.id_user',
        //         'school_day',
        //         'start_time',
        //         'end_time',
        //         'tbl_classes.class',
        //         'tbl_subjects.id_subject',
        //         'subject_name',
        //         'subject_type',
        //         'tbl_users.first_name',
        //         'tbl_users.last_name',
        //         'tbl_users.NISN',
        //         'tbl_sections.id_section',
        //         'tbl_sections.section'
        //     ],
        //     [
        //         "id_class_routine" => $id_class_routine
        //     ]
        // );

        $data = $app->db->get(
            'tbl_class_routines',
            [
                "[>]tbl_classes" => ["id_class" => "id_class"],
                "[>]tbl_subjects" => ["id_subject" => "id_subject"],
                "[>]tbl_sections" => ["tbl_classes.id_section" => "id_section"],
                "[>]tbl_users" => ["id_user" => "id_user"],
            ],
            [
                // '*'
                'id_class_routine',
                'school_day',
                'tbl_classes.id_class',
                'tbl_classes.class',
                'tbl_sections.section',
                'tbl_subjects.id_subject',
                'subject_name',
                'subject_type',
                'tbl_users.id_user',
                'tbl_users.first_name',
                'tbl_users.last_name',
                'start_time',
                'end_time',
            ],
            [
                "id_class_routine" => $id_class_routine
            ]
        );


        $json_data = array(
            'data' => $data
        );
        return $response->withJson($data);
    }

    public static function update_class_routine($app, $request, $response, $args)
    {

        $data = $args['data'];
        // return var_dump($data);

        $app->db->update('tbl_class_routines', [
            'id_class' => $data['id_class'],
            'id_subject' => $data['subject_name'],
            'id_user' => $data['id_user'],
            'school_day' => $data['school_day'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time']
        ], [
            "id_class_routine" => $data['id_class_routine']
        ]);

        $json_data = array(
            "draw" => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);
    }

    public static function delete_class_routine($app, $request, $response, $args)
    {
        $id = $args['data'];
        // return var_dump($id);

        $app->db->delete('tbl_class_routines', [
            "id_class_routine" => $id
        ]);

        $json_data = array(
            "draw" => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);
    }
}
