<?php

namespace App\Controller;

use Medoo\Medoo;
use App\Controller\DashboardStudentController as ControllerDashboardStudentController;

// session_start();

class DashboardStudentController
{

    public static function view_data_student($app, $request, $response, $args)
    {
        $user = $args['user'];
        // $username = $args['username'];
        $type = $args['type'];
        // $id_student = $args['id_student'];

        $data_student = $app->db->select('tbl_users', [
            "[>]tbl_admissions" => ["id_user" => "id_user"]
        ], '*', [
            "username" => $args["username"]
        ]);
        // return var_dump($data_student);
        $student_array = $data_student[0];
        // return var_dump($student_array);

        $querry = "select distinct a.occupation,a.NISN,a.id_parent,b.id_user,a.photo_user as photo,CONCAT(a.first_name,' ',a.last_name) as nama ,gender as jenis_kelamin, tc.class as kelas, ts.section as bagian, CONCAT(b.first_name,' ',b.last_name) As ortu ,a.address_user as alamat,a.date_of_birth as tanggal_lahir,a.phone_user as no_hp,a.email 
        from tbl_users a 
        left join (select b.id_user,b.first_name,b.last_name  from tbl_users b where id_user_type = 4) b on a.id_parent = b.id_user 
        left join tbl_classes tc
        on a.id_class = tc.id_class 
        left join tbl_sections ts on tc.id_section = tc.id_section where a.id_user_type = '1' AND a.username='" . $args['username'] . "';";

        $data_parentS = $app->db->query($querry)->fetch();
        // return var_dump($data_parentS);

        $data_student_notification = $app->db->count('tbl_notifications', [
            "id_user" => $student_array['id_user']
        ]);

        // JOIN
        $view_student_notification = $app->db->select('tbl_users', [
            "[><]tbl_notifications" => ["id_user" => "id_user"]
        ], '*', [
            // "id_user" => $student_array['id_user'],
            "username" => $args["username"]
        ]);

        $data_student_attendance = $app->db->count('tbl_attendances', [
            "id_user" => $student_array['id_user']
        ]);
        // return var_dump($data_student_attendance);
        $data_student_absent = 120 - $data_student_attendance;

        $presentaseKehadiran1 = floor($data_student_attendance / 120 * 100);

        $presentaseKehadiran = number_format((float) $data_student_attendance / 120 * 100, 1, '.', '');
        // return var_dump($presentaseKehadiran);
        $presentaseAbsen = number_format((float) $data_student_absent / 120 * 100, 1, '.', '');
        // return var_dump($presentaseAbsen);

        $data_student_exam = $app->db->select('tbl_exams', [
            "[><]tbl_exam_results" => ["id_exam" => "id_exam"]
        ], [
            "tbl_exams.id_exam",
            "tbl_exams.exam_name",
            "tbl_exams.exam_date",
            "tbl_exam_results.id_subject",
            "tbl_exam_results.score"
        ], [
            "id_user" => $student_array['id_user']
        ]);

        return $app->get('view')->render($response, 'dashboard/student.html', array(
            // "data2" => $data2,
            "data_student" => $data_student,
            "data_parentS" => $data_parentS,
            "data_student_notification" => $data_student_notification,
            "view_student_notification" => $view_student_notification,
            "data_student_attendance" => $data_student_attendance,
            "presentaseKehadiran1" => $presentaseKehadiran1,
            "presentaseKehadiran" => $presentaseKehadiran,
            "presentaseAbsen" => $presentaseAbsen,
            // "dataExam" => $dataExam,
            "data_student_exam" => $data_student_exam,
            // "data_student_examR" => $data_student_exam_result,
            "user" => $user,
            "type" => $type,
            "id_user" => $student_array['id_user'],
            'type_user' => $_SESSION['type_user'],
            'username' => $_SESSION['username']

        ));
    }

    public static function apiDataM($app, $request, $response, $args)
    {

        $idUser = $request->getParam('id_user');

        $data_student_attendance = $app->db->count('tbl_attendances', [
            "id_user" => $idUser,
        ]);
        // return var_dump($data_student_attendance);
        $data_student_absent = 120 - $data_student_attendance;

        $presentaseKehadiran = number_format((float) $data_student_attendance / 120 * 100, 1, '.', '');

        $presentaseAbsen = number_format((float) $data_student_absent / 120 * 100, 1, '.', '');
        // return var_dump($presentaseAbsen);

        return $response->withJson([
            "presentaseKehadiranM" => $presentaseKehadiran,
            "presentaseAbsenM" => $presentaseAbsen
        ]);
    }

    public static function view_data_exam($app, $req, $rsp, $args)
    {

        $result = $app->db->select('tbl_exam_results', [
            '[>]tbl_classes' => ['id_class' => 'id_class'],
            '[>]tbl_users' => ['id_user' => 'id_user'],
            '[>]tbl_subjects' => ['id_subject' => 'id_subject']
        ], '*', [
            "tbl_exam_results.id_user" => $_SESSION['id_user'],
        ]);
        // return var_dump($result);


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
            'tbl_exam_results.id_user' => $_SESSION['id_user']
        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                "id_user" => $_SESSION['id_user']

            ];
            $conditions['OR'] = [
                'tbl_users.NISN[~]' => '%' . $search . '%',
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                'tbl_subjects.subject_name[~]' => '%' . $search . '%',

            ];
            $result = $app->db->select(
                'tbl_exam_results',
                [
                    // '[>]tbl_classes' => 'id_class',
                    // '[>]tbl_users' => 'id_user',
                    // '[>]tbl_subjects' => 'id_subject',
                    // '[>]tbl_exams' => 'id_exam'
                    '[>]tbl_classes' => ['id_class' => 'id_class'],
                    '[>]tbl_users' => ['id_user' => 'id_user'],
                    '[>]tbl_subjects' => ['id_subject' => 'id_subject']

                ],
                '*',
                // $limit
                $conditions
            );
            $totaldata = count($result);
            $totalfiltered = $totaldata;
        }

        $result = $app->db->select('tbl_exam_results', [
            '[>]tbl_sections' => 'id_section',
            // '[>]tbl_classes' => 'id_class',
            // '[>]tbl_users' => 'id_user',
            // '[>]tbl_subjects' => 'id_subject',
            '[>]tbl_exams' => 'id_exam',
            '[>]tbl_classes' => ['id_class' => 'id_class'],
            '[>]tbl_users' => ['id_user' => 'id_user'],
            '[>]tbl_subjects' => ['id_subject' => 'id_subject']

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
                $datas['tanggal'] = $m['date_result'];



                $data[] = $datas;
            }
        }
        // return var_dump($result);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }




    public static function dashboard($app, $request, $response, $args)
    {
        $app->view->render($response, 'dashboard/student.html', $args);
    }

    public static function allStudent($app, $request, $response, $args)
    {
        $app->view->render($response, 'students/all-student.html', $args);
    }

    public static function studentDetails($app, $request, $response, $args)
    {
        $app->view->render($response, 'students/student-details.html', $args);
    }

    public static function admitForm($app, $request, $response, $args)
    {
        $app->view->render($response, 'students/admit-form.html', $args);
    }

    public static function studentPromotion($app, $request, $response, $args)
    {
        $app->view->render($response, 'students/student-promotion.html', $args);
    }
}
