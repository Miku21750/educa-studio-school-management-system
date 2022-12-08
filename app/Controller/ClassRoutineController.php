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
                "[>]tbl_users" => ["id_teacher" => "id_user"],
                "[>]tbl_sections" => ["id_class" => "id_section"],
                "[>]tbl_classes" => ["id_class" => "id_class"]
            ], [
            'id_subject',
            'subject_name',
            'subject_type',
            'tbl_subjects.id_class',
            'id_teacher',
            'first_name',
            'last_name',
            'NISN',
            'section',
            'tbl_classes.class'
        ]);

        return $app->view->render($response, 'others/class-routine.html', [
            'result' => $result
        ]);
    }
}
