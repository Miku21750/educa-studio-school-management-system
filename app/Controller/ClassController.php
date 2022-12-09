<?php

namespace App\Controller;

class ClassController
{
    // untuk penambahan tambah vertifikasi input
    // supaya input kelas yang sudah ada tidak terjadi doble input
    // jika kelas section dan nama guru sudah ada, jangan di tambah.

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

    public function getSectionMod($app, $request, $response, $args)
    {
        $response = $app->db->select("tbl_sections", [
            "id_section",
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

    public static function insertClassMod($app, $request, $response, $args)
    {
        $kelas = $request->getParam('kelas');
        $bagian = $request->getParam('bagian');
        $idTeacher = $request->getParam('idTeacher');
        // $testUpate = $request->getParam('test');

        $app->db->insert("tbl_classes", [
            "id_section" => $bagian,
            "class" => $kelas,
        ]);

        $lastid = $app->db->id();
   
        $app->db->update("tbl_users", [
            "id_class" => $lastid,
        ], [
            "id_user" => $idTeacher,
        ]);

        $getLastInsertedUsers = $app->db->query("select id_user from tbl_users order by update_at desc limit 1")->fetch();

        $response = [
            'status' => 'success',
            'details' => [
                            'inserted to class' => $lastid,
                            'updated to users' => $getLastInsertedUsers[0],
                         ],
        ];

        return $response;
    }

    public static function viewAddClass($app, $request, $response, $args)
    {
        $dataGuru = ClassController::getTeacherMod($app, $request, $response, $args);
        $dataSection = ClassController::getSectionMod($app, $request, $response, $args);
        $dataSubject = ClassController::getSubjectMod($app, $request, $response, $args);

        // return var_dump($dataSection);

        $app->view->render($response, 'class/add-class.html', [
            'dataguru' => $dataGuru,
            'dataSection' => $dataSection,
            'dataSubject' => $dataSubject,
        ]);

    }

}
