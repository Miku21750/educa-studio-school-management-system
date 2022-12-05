<?php

namespace App\Controller;

class TeacherController
{

    public static function dataTeacher($app, $request, $response, $args, $namaKolom)
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

        $namaDepanGuru = TeacherController::dataTeacher($app, $request, $response, $args, "first_name");
        $namaBelakangGuru = TeacherController::dataTeacher($app, $request, $response, $args, "last_name");
        $shortbioGuru = TeacherController::dataTeacher($app, $request, $response, $args, "gender");
        $jenisKelamin = TeacherController::dataTeacher($app, $request, $response, $args, "religion");
        $admissionDate = TeacherController::dataTeacher($app, $request, $response, $args, "admission_date");
        $email = TeacherController::dataTeacher($app, $request, $response, $args, "email");
        $NIP = TeacherController::dataTeacher($app, $request, $response, $args, "NISN");
        $addressUser = TeacherController::dataTeacher($app, $request, $response, $args, "address_user");
        $phoneUser = TeacherController::dataTeacher($app, $request, $response, $args, "phone_user");
        $shortbioGuru = TeacherController::dataTeacher($app, $request, $response, $args, "short_bio");

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
        ]);

        // return var_dump($namaDepanGuru[0]);

    }

}
