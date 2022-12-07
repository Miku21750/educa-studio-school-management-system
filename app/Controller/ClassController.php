<?php

namespace App\Controller;

class ClassController
{

    public function getTeacherMod($app, $request, $response, $args)
    {
        $response = $app->db->select("tbl_users", [
            "id_user",
            "first_name",
            "last_name",
            "NISN",
            "gender",
            "phone_user",
            "email",

        ], [
            "id_user_type" => 2,
        ]);
        return $response;

    }

    public function getClassAndSectionsMod($app, $request, $response, $args)
    {
        $response = $app->db->select('tbl_classes', [
            "[>]tbl_sections" => "id_section",
        ], [
            "id_class",
            "class",
            "section",
        ]);

        return $response;
    }

    public function getSubjectMod($app, $request, $response, $args)
    {
        $response = $app->db->select("tbl_subjects", [
            "id_subject",
            "subject_name",

        ]);

        return $response;

    }

    public static function insertClassRoutine($app, $request, $response, $args)
    {

    }

    public static function viewAddClass($app, $request, $response, $args)
    {
        $dataGuru = ClassController::getTeacherMod($app, $request, $response, $args);
        $dataKelasSection = ClassController::getClassAndSectionsMod($app, $request, $response, $args);
        $dataSubject = ClassController::getSubjectMod($app, $request, $response, $args);

        $app->view->render($response, 'class/add-class.html', [
            'test' => 'test',
            'dataguru' => $dataGuru,
            'dataKelasSection' => $dataKelasSection,
            'dataSubject' => $dataSubject,

        ]);

    }

}
