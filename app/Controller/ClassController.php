<?php

namespace App\Controller;

class ClassController
{

    public function getTeacherModel($app, $request, $response, $args)
    {
        $response = $app->db->select("tbl_users", [
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

    public function getClassModel($app, $request, $response, $args)
    {
        $response = $app->db->select("tbl_classes", "*" );

        return $response;

    }

    public function getSectionModel($app, $request, $response, $args)
    {
        $response = $app->db->select("tbl_sections", "*" );

        return $response;

    }

    public static function getClass($app, $request, $response, $args)
    {
        $response = $app->db->select("tbl_users", [
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

    public static function insertClass($app, $request, $response, $args)
    {

    }

    public static function viewAddClass($app, $request, $response, $args)
    {

        return var_dump(ClassController::getSectionModel($app, $request, $response, $args));

        $app->view->render($response, 'class/add-class.html', [
            'test' => 'test',

        ]);

    }

}
