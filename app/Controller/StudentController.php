<?php

namespace App\Controller;

use App\Controller\AcconuntController;


use Medoo\Medoo;



class StudentController
{

    public static function index($app, $request, $response, $args)
    {
        $user = $args['user'];
        $type = $args['type'];
        $id_user = $args['id_user'];
        // return var_dump($id_student);



        // $data = $app->db->select('tbl_users', '*');
        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        // var_dump($data);

        $app->view->render($response, 'students/all-student.html', [
            'user' => $user,
            'type' => $type,
            'id_user' => $id_user,
            'type_user' => $_SESSION['type_user'],
            'berhasil' => $berhasil

        ]);
    }
    public static function index_print($app, $request, $response, $args)
    {
        $user = $args['user'];
        $type = $args['type'];
        $id_user = $args['id_user'];
        // return var_dump($id_student);



        // $data = $app->db->select('tbl_users', '*');
        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        // var_dump($data);

        $app->view->render($response, 'students/print-student.html', [
            'user' => $user,
            'type' => $type,
            'id_user' => $id_user,
            'type_user' => $_SESSION['type_user'],
            'berhasil' => $berhasil

        ]);
    }

    public static function all_alumni($app, $request, $response, $args)
    {
        $user = $args['user'];
        $type = $args['type'];
        $id_user = $args['id_user'];
        // return var_dump($id_student);



        // $data = $app->db->select('tbl_users', '*');
        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        // var_dump($data);

        $app->view->render($response, 'students/all-alumni.html', [
            'user' => $user,
            'type' => $type,
            'id_user' => $id_user,
            'type_user' => $_SESSION['type_user'],
            'berhasil' => $berhasil

        ]);
    }


    public static function tampil_data($app, $req, $rsp, $args)
    {
        $type = 1;
        $tbl_classes = 'tbl_classes';




        $student = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
            '[><]tbl_admissions' => ["tbl_users.id_user" => 'id_user'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], '*', [
            'id_user_type' => $type,
            'tbl_users.id_class[!]' => [99, 100, 101],
        ]);


        $columns = array(
            0 => 'id',
        );

        $totaldata = count($student);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];


        $conditions = [
            "LIMIT" => [$start, $limit],
            'id_user_type' => $type,
            'tbl_users.id_class[!]' => [99, 100, 101],

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];

            $conditions['OR'] = [
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                'tbl_users.NISN[~]' => '%' . $search . '%',
                'tbl_users.gender[~]' => '%' . $search . '%',

            ];

            $limit = [
                "LIMIT" => [$start, $limit],
                'id_user_type' => $type,
                'tbl_users.id_class[!]' => [99, 100, 101],

            ];

            $student = $app->db->select(
                'tbl_users',
                [
                    '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
                    '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                    '[><]tbl_admissions' => ["tbl_users.id_user" => 'id_user'],
                    '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
                ],
                '*',
                $limit
            );
            $totaldata = count($student);
            $totalfiltered = $totaldata;
            // return var_dump($totaldata);
        }

        $student = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
            '[><]tbl_admissions' => ["tbl_users.id_user" => 'id_user'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], '*', $conditions);

        $data = array();


        if (!empty($student)) {
            $no = $req->getParam('start') + 1;

            foreach ($student as $m) {

                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['NISN'];
                $datas['foto'] = '<img src="/uploads/Profile/' . $m['photo_user'] . '" style="width:30px;"  alt="student">';
                $datas['gender'] = $m['gender'];
                $datas['class'] = $m['class'] . ' ' . $m['section'];

                $username = $app->db->select('tbl_users', 'first_name', [
                    'id_user' => $m['id_user']
                ]);
                if ($username[0] == '') {
                    $datas['nama'] = $m['username'];
                } else {
                    $datas['nama'] = $m['first_name'] . ' ' . $m['last_name'];
                }


                $admission = $app->db->select('tbl_admissions', '*', [
                    'id_user' => $m['id_user']
                ]);



                if ($admission != null && $_SESSION['type'] == 3) {

                    $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3">
                    <a class="dropdown-item btn btn-light item_hapus" data="' . $m['id_user'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light" href="' . 'api' . '/' . 'student-detail' . '/' . $m['id_user']  . '">
                        <i class="fas fa-solid fa-bars text-orange-peel"></i>
                        Detail
                    </a>
                    <a class="dropdown-item btn btn-light" href="' . 'student-promotion' . '/' . $m['id_user']  . '">
                        <i class="fas fa-sharp fa-solid fa-graduation-cap text-success"></i>
                        Student Promotion
                    </a>   
                </div>
            </div>';
                } else if ($_SESSION['type'] != 3) {
                    $datas['aksi'] = ' ';
                } else {
                    $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3">
                    <a class="dropdown-item btn btn-light item_hapus" data="' . $m['id_user'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light" href="' . 'api' . '/' . 'student-detail' . '/' . $m['id_user']  . '">
                        <i class="fas fa-solid fa-bars text-orange-peel"></i>
                        Detail
                    </a>
                    <a class="dropdown-item btn btn-light"  data="' . $m['id_user'] . '" href="' . 'student-promotion' . '/' . $m['id_user']  . '">
                        <i class="fas fa-sharp fa-solid fa-graduation-cap text-success"></i>
                        Student Promotion
                    </a>
                    <a class="dropdown-item btn btn-light btn_terima_siswa" id="btn_terima_siswa" data="' . $m['id_user'] . '">
                        <i class="fas fa-sharp fa-solid fa-school text-primary"></i>
                        Terima Siswa
                    </a>

                </div>
            </div>';
                }
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($student);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }
    public static function tampil_data_print($app, $req, $rsp, $args)
    {
        $type = 1;
        $tbl_classes = 'tbl_classes';




        $student = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
            '[><]tbl_admissions' => ["tbl_users.id_user" => 'id_user'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], '*', [
            'id_user_type' => $type,
            'tbl_users.id_class[!]' => [99, 100, 101],
        ]);


        $columns = array(
            0 => 'id',
        );

        $totaldata = count($student);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];


        $conditions = [
            // "LIMIT" => [$start, $limit],
            'id_user_type' => $type,
            'tbl_users.id_class[!]' => [99, 100, 101],

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];

            $conditions['OR'] = [
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                'tbl_users.NISN[~]' => '%' . $search . '%',
                'tbl_users.gender[~]' => '%' . $search . '%',

            ];

            $limit = [
                // "LIMIT" => [$start, $limit],
                'id_user_type' => $type,
                'tbl_users.id_class[!]' => [99, 100, 101],

            ];

            $student = $app->db->select(
                'tbl_users',
                [
                    '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
                    '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                    '[><]tbl_admissions' => ["tbl_users.id_user" => 'id_user'],
                    '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
                ],
                '*',
                $limit
            );
            $totaldata = count($student);
            $totalfiltered = $totaldata;
            // return var_dump($totaldata);
        }

        $student = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
            '[><]tbl_admissions' => ["tbl_users.id_user" => 'id_user'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], '*', $conditions);

        $data = array();


        if (!empty($student)) {
            $no = $req->getParam('start') + 1;

            foreach ($student as $m) {

                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['NISN'];
                $datas['foto'] = '<img src="/uploads/Profile/' . $m['photo_user'] . '" style="width:30px;"  alt="student">';
                $datas['gender'] = $m['gender'];
                $datas['class'] = $m['class'] . ' ' . $m['section'];

                $username = $app->db->select('tbl_users', 'first_name', [
                    'id_user' => $m['id_user']
                ]);
                if ($username[0] == '') {
                    $datas['nama'] = $m['username'];
                } else {
                    $datas['nama'] = $m['first_name'] . ' ' . $m['last_name'];
                }


                $admission = $app->db->select('tbl_admissions', '*', [
                    'id_user' => $m['id_user']
                ]);



                if ($admission != null && $_SESSION['type'] == 3) {

                    $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3">
                    <a class="dropdown-item btn btn-light item_hapus" data="' . $m['id_user'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light" href="' . 'api' . '/' . 'student-detail' . '/' . $m['id_user']  . '">
                        <i class="fas fa-solid fa-bars text-orange-peel"></i>
                        Detail
                    </a>
                    <a class="dropdown-item btn btn-light" href="' . 'student-promotion' . '/' . $m['id_user']  . '">
                        <i class="fas fa-sharp fa-solid fa-graduation-cap text-success"></i>
                        Student Promotion
                    </a>   
                </div>
            </div>';
                } else if ($_SESSION['type'] != 3) {
                    $datas['aksi'] = ' ';
                } else {
                    $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3">
                    <a class="dropdown-item btn btn-light item_hapus" data="' . $m['id_user'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light" href="' . 'api' . '/' . 'student-detail' . '/' . $m['id_user']  . '">
                        <i class="fas fa-solid fa-bars text-orange-peel"></i>
                        Detail
                    </a>
                    <a class="dropdown-item btn btn-light"  data="' . $m['id_user'] . '" href="' . 'student-promotion' . '/' . $m['id_user']  . '">
                        <i class="fas fa-sharp fa-solid fa-graduation-cap text-success"></i>
                        Student Promotion
                    </a>
                    <a class="dropdown-item btn btn-light btn_terima_siswa" id="btn_terima_siswa" data="' . $m['id_user'] . '">
                        <i class="fas fa-sharp fa-solid fa-school text-primary"></i>
                        Terima Siswa
                    </a>

                </div>
            </div>';
                }
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($student);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }
    public static function tampil_alumni($app, $req, $rsp, $args)
    {
        $type = 1;
        $tbl_classes = 'tbl_classes';




        $student = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], '*', [
            'id_user_type' => $type,
            'tbl_users.id_class' => [99, 100, 101],
        ]);


        $columns = array(
            0 => 'id',
        );

        $totaldata = count($student);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];


        $conditions = [
            "LIMIT" => [$start, $limit],
            'id_user_type' => $type,
            'tbl_users.id_class' => [99, 100, 101],

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];

            $conditions['OR'] = [
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                'tbl_users.NISN[~]' => '%' . $search . '%',
                'tbl_users.gender[~]' => '%' . $search . '%',

            ];

            $limit = [
                "LIMIT" => [$start, $limit],
                'id_user_type' => $type,
                'tbl_users.id_class' => [99, 100, 101],

            ];

            $student = $app->db->select(
                'tbl_users',
                [
                    '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
                    '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                    '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
                ],
                '*',
                $limit
            );
            $totaldata = count($student);
            $totalfiltered = $totaldata;
            // return var_dump($totaldata);
        }

        $student = $app->db->select('tbl_users', [
            '[><]tbl_subjects' => ['tbl_users.id_subject' => 'id_subject'],
            '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], '*', $conditions);

        $data = array();


        if (!empty($student)) {
            $no = $req->getParam('start') + 1;

            foreach ($student as $m) {

                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['NISN'];
                $datas['foto'] = '<img src="/uploads/Profile/' . $m['photo_user'] . '" style="width:30px;"  alt="student">';
                $datas['gender'] = $m['gender'];
                $datas['session'] = $m['session'];
                $datas['class'] = $m['class'];
                $datas['occupation'] = $m['occupation'];

                $username = $app->db->select('tbl_users', 'first_name', [
                    'id_user' => $m['id_user']
                ]);
                if ($username[0] == '') {
                    $datas['nama'] = $m['username'];
                } else {
                    $datas['nama'] = $m['first_name'] . ' ' . $m['last_name'];
                }


                $admission = $app->db->select('tbl_admissions', '*', [
                    'id_user' => $m['id_user']
                ]);



                if ($admission != null && $_SESSION['type'] == 3) {

                    $datas['aksi'] = '<div class="dropdown p-3">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3">
                    <a class="dropdown-item btn btn-light item_hapus" data="' . $m['id_user'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light" href="' . 'api' . '/' . 'student-detail' . '/' . $m['id_user']  . '">
                        <i class="fas fa-solid fa-bars text-orange-peel"></i>
                        Detail
                    </a>
                </div>
            </div>';
                } else if ($_SESSION['type'] != 3) {
                    $datas['aksi'] = ' ';
                } else {
                    $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3">
                    <a class="dropdown-item btn btn-light item_hapus" data="' . $m['id_user'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light" href="' . 'api' . '/' . 'student-detail' . '/' . $m['id_user']  . '">
                        <i class="fas fa-solid fa-bars text-orange-peel"></i>
                        Detail
                    </a>
                    <a class="dropdown-item btn btn-light" href="' . 'student-promotion' . '/' . $m['id_user']  . '">
                        <i class="fas fa-sharp fa-solid fa-graduation-cap text-success"></i>
                        Student Promotion
                    </a>
                    <a class="dropdown-item" href="' . 'api' . '/'  . 'admission' . '/' . $m['id_user']  . '">
                        <i class="fas fa-sharp fa-solid fa-school text-primary"></i>
                        Terima Siswa
                    </a>

                </div>
            </div>';
                }
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($student);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }
    public static function tampil_acc($app, $req, $rsp, $args)
    {
        $type = 1;
        $tbl_classes = 'tbl_classes';
        // $type_user = $SESSION['type'];


        if ($_SESSION['type'] == 3) {
            $student = $app->db->select('tbl_users', [
                '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
            ], '*', [
                'id_user_type' => $type,
                'tbl_users.id_class' => 0,
            ]);        
        }else{
            $student = $app->db->select('tbl_users', [
                '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
            ], '*', [
                'id_user_type' => $type,
                'tbl_users.id_class' => 0,
                'id_parent' => $_SESSION['id_user'],
            ]);  
        }

       


        $columns = array(
            0 => 'id',
        );

        $totaldata = count($student);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];

        if ($_SESSION['type'] == 3) {
            $conditions = [
                "LIMIT" => [$start, $limit],
                'id_user_type' => $type,
                'tbl_users.id_class' => 0,
    
            ];
        }else {
            $conditions = [
                "LIMIT" => [$start, $limit],
                'id_user_type' => $type,
                'tbl_users.id_class' => 0,
                'id_parent' => $_SESSION['id_user'],
            ];
        }

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];

            $conditions['OR'] = [
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                'tbl_users.NISN[~]' => '%' . $search . '%',
                'tbl_users.gender[~]' => '%' . $search . '%',

            ];
            if ($_SESSION['type'] == 3) {
                $limit = [
                    "LIMIT" => [$start, $limit],
                    'id_user_type' => $type,
                    'tbl_users.id_class' => 0,
    
                ];            
            }else {
                $limit = [
                    "LIMIT" => [$start, $limit],
                    'id_user_type' => $type,
                    'tbl_users.id_class' => 0,
                    'id_parent' => $_SESSION['id_user'],
                ];            
            }
           
            
            $student = $app->db->select(
                'tbl_users',
                [
                    '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
                    '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
                ],
                '*',
                $limit
            );
            $totaldata = count($student);
            $totalfiltered = $totaldata;
            // return var_dump($totaldata);
        }

        $student = $app->db->select('tbl_users', [
            '[><]tbl_classes' => ["tbl_users.id_class" => 'id_class'],
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], '*', $conditions);

        // return var_dump($student)

        $data = array();


        if (!empty($student)) {
            $no = $req->getParam('start') + 1;

            foreach ($student as $m) {
                $admission = $app->db->select('tbl_admissions', '*', [
                    'id_user' => $m['id_user']
                ]);
                if ($admission == null) {
               

                $datas['no'] = $no . '.';
                $datas['nisn'] = $m['NISN'];
                $datas['foto'] = '<img src="/uploads/Profile/' . $m['photo_user'] . '" style="width:30px;"  alt="student">';
                $datas['gender'] = $m['gender'];
                $datas['session'] = $m['session'];

                $username = $app->db->select('tbl_users', 'first_name', [
                    'id_user' => $m['id_user']
                ]);
                if ($username[0] == '') {
                    $datas['nama'] = $m['username'];
                } else {
                    $datas['nama'] = $m['first_name'] . ' ' . $m['last_name'];
                }


              



                if ($admission == null && $_SESSION['type'] == 3) {

                    $datas['aksi'] = '<div class="dropdown p-3">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3">
                    <a class="dropdown-item btn btn-light item_hapus" data="' . $m['id_user'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light" href="' . 'api' . '/' . 'student-detail' . '/' . $m['id_user']  . '">
                        <i class="fas fa-solid fa-bars text-orange-peel"></i>
                        Detail
                    </a>
                    <a class="dropdown-item btn btn-light btn_terima_siswa" id="btn_terima_siswa" data="' . $m['id_user'] . '">
                    <i class="fas fa-sharp fa-solid fa-school text-primary"></i>
                    Terima Siswa
                </a>
                  
                </div>
            </div>';
                } else if ($_SESSION['type'] != 3) {
                    $datas['aksi'] = '<div class="dropdown p-3">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                        <span class="flaticon-more-button-of-three-dots"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right p-3">
                        <a class="dropdown-item btn btn-light item_hapus" data="' . $m['id_user'] . '">
                            <i class="fas fa-trash text-orange-red"></i>
                            Hapus
                        </a>
                        <a class="dropdown-item btn btn-light" href="' . 'api' . '/' . 'student-detail' . '/' . $m['id_user']  . '">
                            <i class="fas fa-solid fa-bars text-orange-peel"></i>
                            Detail
                        </a>
                       
                      
                    </div>
                </div>';                }
                $data[] = $datas;
                $no++;
            }
        }
        }
        // return var_dump($student);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }


    public static function student_detail($app, $request, $response, $args)
    {
        $id = $args['data'];
        $tbl_classes = 'tbl_classes';

        // return var_dump($id);
        $data = $app->db->select('tbl_users(a)', [
            '[>]tbl_classes' => ['a.id_class' => 'id_class'],
            '[>]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
            '[>]tbl_users(b)' => ['a.id_parent' => 'id_user'],
        ], [
            'a.id_user(id_user)',
            'a.NISN(nisn)',
            'a.photo_user(foto)',
            'a.first_name(first_name_student)',
            'a.last_name(last_name_student)',
            'a.gender(gender)',
            'a.id_class(kelas)',
            'a.id_parent(parent)',
            'a.session(session)',
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
            'b.first_name(first_name_ortu)',
            'b.last_name(last_name_ortu)',
            'a.occupation',
            // 'a.occupation_place'
        ], [
            'a.id_user' => $id

        ]);
        // return die(var_dump($data));
        $all = $app->db->select('tbl_users', '*', [
            'id_user_type' => 4
        ]);
        $class = $app->db->select('tbl_classes', [
            '[><]tbl_sections' =>  'id_section',
        ], '*');


        $date = $app->db->select('tbl_users', 'date_of_birth', [
            'id_user' => $id
        ]);
        $tanggal = AcconuntController::tgl_indo($date[0]);

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        // return var_dump($tanggal);
        // die();

        $app->view->render($response, 'students/student-details.html', [
            'data' =>  $data[0],
            'tanggal' =>  $tanggal,
            'all' =>  $all,
            'class' =>  $class,
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
        if (!isset($filename)) {
            $addUpdate = $data['imageDefault'];
        } else {
            $fileDefault = $data['imageDefault'];
            // if default? return'
            if ($fileDefault == 'default.png') {
            } else {
                // return var_dump(file_exists('../public/uploads/Profile/'.$fileDefault));
                unlink('../public/uploads/Profile/' . $fileDefault);
            }
        }



        // return var_dump($uploadedFiles);

        $update = $app->db->update('tbl_users', [
            "first_name" => $data['first_name'],
            "last_name" => $data['last_name'],
            "gender" => $data['gender'],
            "id_class" => $data['id_class'],
            "id_parent" => $data['id_parent'],
            "NISN" => $data['NISN'],
            "date_of_birth" => $data['date_of_birth'],
            "religion" => $data['religion'],
            "blood_group" => $data['blood_group'],
            "phone_user" => $data['phone_user'],
            "address_user" => $data['address_user'],
            "short_bio" => $data['data_short_bio'],
            "photo_user" => $addUpdate,
            "occupation" => $data['occupation'],
            // "occupation_place" => $data['occupation_place'],
        ], [
            "id_user" => $data['id_user']
        ]);
        // return die(var_dump($update));
        $_SESSION['berhasil'] = true;
        return $response->withRedirect('/api/student-detail/' . $data['id_user']);
    }
    public static function page_add_student($app, $req, $rsp, $args)
    {

        $type = 4;
        $student = $app->db->select('tbl_users', '*', [
            'id_user_type' => $type,

        ]);
        $class = $app->db->select('tbl_classes', [
            '[><]tbl_sections' =>  'id_section',
        ], '*');        // return var_dump($class);

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        $email = isset($_SESSION['email']);
        unset($_SESSION['email']);
        $app->view->render($rsp, 'students/admit-form.html', [
            'student' =>  $student,
            'class' =>  $class,
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil,
            'email' => $email,
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
        if (!isset($filename)) {
            $addUpdate = $data['imageDefault'];
        } else {
            $fileDefault = $data['imageDefault'];
            // if default? return'
            if ($fileDefault == 'default.png') {
            } else {
                // return var_dump(file_exists('../public/uploads/Profile/'.$fileDefault));
                unlink('../public/uploads/Profile/' . $fileDefault);
            }
        }
        $cek = $app->db->select('tbl_users', '*', [
            'email' => $data['email']
        ]);


        $encryptedPassword = indexApiController::encrypt($data['date_of_birth'], $_ENV['SALT']);
        
        if ($cek == null) {
            // return var_dump($uploadedFiles);
            $student = $app->db->insert('tbl_users', [
                "first_name" => $data['first_name'],
                "last_name" => $data['last_name'],
                "gender" => $data['gender'],
                "password" => $encryptedPassword,
                "id_class" => $data['id_class'],
                "id_parent" => $data['id_parent'],
                "NISN" => $data['nisn'],
                "date_of_birth" => $data['date_of_birth'],
                "religion" => $data['religion'],
                "blood_group" => $data['blood_group'],
                "session" => $data['session'],
                "email" => $data['email'],
                "phone_user" => $data['phone_user'],
                "address_user" => $data['address_user'],
                "photo_user" => $addUpdate,
                "id_user_type" => 1,
                "status" => 1,

            ]);
            if ($_SESSION['type'] == 3) {
                $last_id = $app->db->id();
                $tanggal = date("Y-m-d ");
    
                $id_masuk = $app->db->insert('tbl_admissions', [
                    "id_user" => $last_id,
                    "admission_date" => $tanggal
                ]);            }
           
            $_SESSION['berhasil'] = true;
        } else {
            $_SESSION['email'] = true;
        }




        // return var_dump($tanggal);
        return $rsp->withRedirect('/admit-form');
    }
    public static function student_promotion($app, $request, $response, $args)
    {
        $id = $args['data'];

        $data = $app->db->select('tbl_users', [
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_sections' => ["tbl_classes.id_section" => 'id_section']
        ], '*', [
            'id_user' => $id

        ]);
        // return die(var_dump($data));
        $class = $app->db->select('tbl_classes', [
            '[><]tbl_sections' =>  'id_section',
        ], '*');

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        // return var_dump($data);

        $app->view->render($response, 'students/student-promotion.html', [
            'data' =>  $data[0],
            'class' =>  $class,
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil


        ]);
    }
    public static function student_acc($app, $request, $response, $args)
    {
        $id = $args['data'];

       

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        // return var_dump($data);

        $app->view->render($response, 'students/acc-student.html', [
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil
        ]);
    }
    public static function add_promotion($app, $req, $rsp, $args)
    {
        $data = $args['data'];
        // return var_dump($data);



        // return var_dump($uploadedFiles);
        $student = $app->db->update('tbl_users', [

            "session" => $data['session'],
            "id_class" => $data['id_class'],
        ], [
            "id_user" => $data['id_user']
        ]);


        // return var_dump($tanggal);
        $_SESSION['berhasil'] = true;
        return $rsp->withRedirect('/all-students');
    }
    public static function add_admission($app, $req, $rsp, $args)
    {
        $data = $args['data'];
        // return var_dump($data);
        // die(var_dump($data));

        $tanggal = date("Y-m-d ");

        // return var_dump($uploadedFiles);
        $admission = $app->db->INSERT('tbl_admissions', [

            "id_user" => $data,
            "admission_date" => $tanggal
        ]);


        $json_data = array(
            "draw" => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }
    public static function get_data_ortu($app, $request, $response, $id_class_routine)
    {

        $param = $request->getParams();
        // return die(var_dump($param));
        $condition = [
            "id_user_type" => 4,
            "id_user[!]" => 0,
            "LIMIT" => 5
        ];
        if (isset($param['q'])) {
            $search = $param['q'];
            $condition['OR'] = [
                'first_name[~]' => '%' . $search . '%',
                'last_name[~]' => '%' . $search . '%',
            ];
        }
        $data = $app->db->select(
            'tbl_users',
            [
                'id_user',
                'NISN',
                'first_name',
                'last_name'
            ],
            $condition
        );

        return $response->withJson($data);
    }
    public static function get_data_siswa($app, $request, $response, $id_class_routine)
    {

        $param = $request->getParams();
        // return die(var_dump($param));
        $condition = [
            "id_user_type" => 1,
            "id_user[!]" => 0,
            "LIMIT" => 5
        ];
        if (isset($param['q'])) {
            $search = $param['q'];
            $condition['OR'] = [
                'first_name[~]' => '%' . $search . '%',
                'last_name[~]' => '%' . $search . '%',
            ];
        }
        $data = $app->db->select(
            'tbl_users',
            [
                'id_user',
                'NISN',
                'first_name',
                'last_name'
            ],
            $condition
        );

        return $response->withJson($data);
    }
    public static function get_data_all($app, $request, $response, $id_class_routine)
    {

        $param = $request->getParams();
        // return die(var_dump($param));
        $condition = [
            "id_user[!]" => 0,
            "LIMIT" => 5
        ];
        if (isset($param['q'])) {
            $search = $param['q'];
            $condition['OR'] = [
                'first_name[~]' => '%' . $search . '%',
                'last_name[~]' => '%' . $search . '%',
            ];
        }
        $data = $app->db->select(
            'tbl_users',
            [
                'id_user',
                'NISN',
                'first_name',
                'last_name'
            ],
            $condition
        );

        return $response->withJson($data);
    }
}
