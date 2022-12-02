<?php

namespace App\Controller;
// session_start();

class DashboardStudentController {

    public static function view_data_student($app, $request, $response, $args) {
        $user = $args['user'];
        $type = $args['type'];
        // $id_student = $args['id_student'];

        // $data_student = $app->db->select('tbl_users', '*', [
        //     // "id_user_type" => $args["type"]
        //     "username" => $args["user"]
        // ]);
        $data_student = $app->db->select('tbl_users', [
            "[><]tbl_admissions" => ["id_user" => "id_user"]
        ], '*', [
            "username" => $args["username"]
        ]);
        // return var_dump($data_student);
        $student_array = $data_student[0];

        $data_student_notification = $app->db->count('tbl_notifications', [
            "id_user" => $student_array['id_user']
        ]);

        $view_student_notification = $app->db->select('tbl_notifications', '*', [
            "id_user" => $student_array['id_user']
        ]);

        $data_student_admission = $app->db->count('tbl_admissions', [
            "id_user" => $student_array['id_user']
        ]);

        $data_student_exam = $app->db->select('tbl_exams', [
            "[><]tbl_exam_results" => ["id_exam" => "id_exam"]
        ], [
            "tbl_exams.id_exam",
            "tbl_exams.exam_name",
            "tbl_exams.exam_date",
            "tbl_exam_results.id_subject",
            "tbl_exam_results.score"
        ],["id_user" => $student_array['id_user']]);

        return $app->get('view')->render($response, 'dashboard/student.html', array(
            "data_student" => $data_student,
            "data_student_notification" => $data_student_notification,
            "view_student_notification" => $view_student_notification,
            "data_student_admission" => $data_student_admission,
            "data_student_exam" => $data_student_exam,
            "user" => $user,
            "type" => $type,
            "id_user" => $student_array['id_user'],
            'type_user' => $_SESSION['type_user']

        ));
        
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



?>