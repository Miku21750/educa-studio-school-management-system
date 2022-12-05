<?php

namespace App\Controller;

class TeacherController
{

    public static function getTeacherData($app, $request, $response, $args, $namaKolom)
    {

        // id_user id_class id_hostel id_trans id_user_type id_parent first_name last_name
        // gender date_of_birth username password religion email NISN photo_user
        // blood_group occupation phone_user address_user class short_bio

        if ($namaKolom == null) {
            $namaKolom = "'*'";
        } else {
            $namaKolom = $namaKolom;
        }

        $response = $app->db->select("tbl_users", $namaKolom, [
            "id_user_type" => 2, 'id_user' => $_SESSION['id_user'],
        ]);

        return $response;
    }

    public static function getTeacherSubject($app, $request, $response, $args)
    {
        $response = $app->db->query('select distinct tc.class as kelas, ts2.section, ts.subject_name as subject from tbl_users tu
        left join tbl_classes tc on tu.id_class = tc.id_class
        left join tbl_subjects ts on tc.id_section = ts.id_subject
        left join tbl_sections ts2 on tc.id_section = ts2.id_section
        where id_user_type = 2 and id_user = 23;')->fetchAll();

        return $response;
    }

    public static function viewTeacherDetails($app, $request, $response, $args)
    {

        // Steven Johnson
        // Aliquam erat volutpat. Curabiene natis massa sedde lacu stiquen sodale
        // word moun taiery.Aliquam erat volutpaturabiene natis massa sedde sodale word moun taiery.

        // Nama :    Steven Johnson
        // Jenis Kelamin :    Male
        // Agama :    Islam
        // Tanggal Bergabung :    07.08.2016
        // E-mail :    stevenjohnson@gmail.com
        // Mata Pelajaran :    English
        // Kelas :    2
        // Bagian :    Pink
        // NIP :    10005
        // Alamat :    House #10, Road #6, Australia
        // No. Handpone :    + 88 98568888418

        $namaDepanGuru = TeacherController::getTeacherData($app, $request, $response, $args, "first_name");
        $namaBelakangGuru = TeacherController::getTeacherData($app, $request, $response, $args, "last_name");
        $shortbioGuru = TeacherController::getTeacherData($app, $request, $response, $args, "gender");
        $jenisKelamin = TeacherController::getTeacherData($app, $request, $response, $args, "gender");
        $agama = TeacherController::getTeacherData($app, $request, $response, $args, "religion");
        $admissionDate = TeacherController::getTeacherData($app, $request, $response, $args, "admission_date");
        $email = TeacherController::getTeacherData($app, $request, $response, $args, "email");
        $NIP = TeacherController::getTeacherData($app, $request, $response, $args, "NISN");
        $addressUser = TeacherController::getTeacherData($app, $request, $response, $args, "address_user");
        $phoneUser = TeacherController::getTeacherData($app, $request, $response, $args, "phone_user");
        $shortbioGuru = TeacherController::getTeacherData($app, $request, $response, $args, "short_bio");
        $kelas = TeacherController::getTeacherSubject($app, $request, $response, $args);

        // return var_dump($kelas);

        $app->view->render($response, 'teacher/teacher-details.html', [
            'namaDepanGuru' => $namaDepanGuru[0],
            'namaBelakangGuru' => $namaBelakangGuru[0],
            'shortbioGuru' => $shortbioGuru[0],
            'jenisKelamin' => $jenisKelamin[0],
            'admissionDate' => $admissionDate[0],
            'email' => $email[0],
            'NIP' => $NIP[0],
            'addressUser' => $addressUser[0],
            'phoneUser' => $phoneUser[0],
            'shortbioGuru' => $shortbioGuru[0],
            'agama' => $agama[0],
            'kelas' => $kelas,
        ]);

        // return var_dump($namaDepanGuru[0]);

    }

}
