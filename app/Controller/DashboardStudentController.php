<?php

namespace App\Controller;

use App\Controller\DashboardStudentController as ControllerDashboardStudentController;

// session_start();

class DashboardStudentController {

    // public static function tableSiswa($app, $request, $response, $args)
    // {

    //     $response = $app->db->query("select distinct a.id_parent,b.id_user,a.photo_user as photo,CONCAT(a.first_name,' ',a.last_name) as nama ,gender as jenis_kelamin, tc.class as kelas, tc.id_section as bagian, CONCAT(b.first_name,' ',b.last_name) As ortu ,a.address_user as alamat,a.date_of_birth as tanggal_lahir,a.phone_user as no_hp,a.email from tbl_users a left join (select b.id_user,b.first_name,b.last_name  from tbl_users b where id_user_type = 4) b on a.id_parent = b.id_user left join tbl_classes tc on a.id_class = tc.id_class left join tbl_sections ts on tc.id_section = tc.id_section where a.id_user_type =1;")->fetchAll();

    //     return $response;

    // }

    public static function view_data_student($app, $request, $response, $args) {
        $user = $args['user'];
        // $username = $args['username'];
        $type = $args['type'];
        // $id_student = $args['id_student'];

        // $data_student = $app->db->select('tbl_users', '*', [
        //     // "id_user_type" => $args["type"]
        //     "username" => $args["user"]
        // ]);  
        
        // $data2 = DashboardStudentController::tableSiswa($app, $request, $response, $args);

        // $data_parent = $app->db->debug()->select('tbl_users', [
        //     "id_parent",
        //     "id_parent",
        //     "photo_user",
        //     "#[first_name, last_name](nama)",
        //     "gender",
        //     "class",
        //     "#[first_name, last_name](ortu)",
        //     "address_user"
        // ]);
        
        $data_student = $app->db->select('tbl_users', [
            "[>]tbl_admissions" => ["id_user" => "id_user"]
        ], '*', [
            "username" => $args["username"]
        ]);
        // return var_dump($data_student);
        $student_array = $data_student[0];

        $querry = "select distinct a.occupation,a.NISN,a.id_parent,b.id_user,a.photo_user as photo,CONCAT(a.first_name,' ',a.last_name) as nama ,gender as jenis_kelamin, tc.class as kelas, ts.section as bagian, CONCAT(b.first_name,' ',b.last_name) As ortu ,a.address_user as alamat,a.date_of_birth as tanggal_lahir,a.phone_user as no_hp,a.email 
        from tbl_users a 
        left join (select b.id_user,b.first_name,b.last_name  from tbl_users b where id_user_type = 4) b on a.id_parent = b.id_user 
        left join tbl_classes tc
        on a.id_class = tc.id_class 
        left join tbl_sections ts on tc.id_section = tc.id_section where a.id_user_type = '1' AND a.username='".$args['username']."';";

        $data_parentS = $app->db->query($querry)->fetch();        
        // return var_dump($data_parentS);

        $result = "select * from tbl_users tu
        left join tbl_exam_results ter on tu.id_user = ter.id_user
        left join tbl_exams te on ter.id_exam = te.id_exam
        where tu.username = '".$args['username']."';";
        $dataExam = $app->db->query($result)->fetch();
        // return var_dump($dataExam);

        $data_student_notification = $app->db->count('tbl_notifications', [
            "id_user" => $student_array['id_user']
        ]);

        // $view_student_notification = $app->db->select('tbl_notifications', '*', [
        //     "id_user" => $student_array['id_user']
        // ]);

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

        $data_student_exam = $app->db->select('tbl_exams', [
            "[><]tbl_exam_results" => ["id_exam" => "id_exam"]
        ], [
            "tbl_exams.id_exam",
            "tbl_exams.exam_name",
            "tbl_exams.exam_date",
            "tbl_exam_results.id_subject",
            "tbl_exam_results.score"
        ],[
            "id_user[><]" => $student_array['id_user'], $args['username']
        ]);

        $data_student_exam_result = $app->db->select('tbl_users', [
            "[>]tbl_exam_results" => ["tbl_users.id_user" => "id_user"],
        ],'*', [
            "username" => $args["username"]
        ]);

        return $app->get('view')->render($response, 'dashboard/student.html', array(
            // "data2" => $data2,
            "data_student" => $data_student,
            "data_parentS" => $data_parentS,
            "data_student_notification" => $data_student_notification,
            "view_student_notification" => $view_student_notification,
            "data_student_attendance" => $data_student_attendance,
            "dataExam" => $dataExam,
            "data_student_exam" => $data_student_exam,
            "data_student_examR" => $data_student_exam_result,
            "user" => $user,
            "type" => $type,
            "id_user" => $student_array['id_user']
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
