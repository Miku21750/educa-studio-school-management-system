<?php

namespace App\Controller;

class TeacherController
{

    public static function formatTanggal($tanggal)
    {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        );

        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
    }

    public static function getTeacherData($app, $request, $response, $args, $namaKolom)
    {

        // id_user id_class id_hostel id_trans id_user_type id_parent first_name last_name
        // gender date_of_birth username password religion email NISN photo_user
        // blood_group occupation phone_user address_user class short_bio

        if ($namaKolom == null) {
            $namaKolom = '*';
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

        // id_user id_class id_hostel id_trans id_user_type id_parent first_name last_name
        // gender date_of_birth username password religion email NISN photo_user
        // blood_group occupation phone_user address_user class short_bio admission_date

        $dataGuru = TeacherController::getTeacherData($app, $request, $response, $args, null);
        $dataSubject = TeacherController::getTeacherSubject($app, $request, $response, $args);

        // $date = date_create($admissionDate[0]);
        // return var_dump( TeacherController::formatTanggal($date));

        $app->view->render($response, 'teacher/teacher-details.html', [
            'photo' => $dataGuru[0]['photo_user'],
            'namaDepanGuru' => $dataGuru[0]['first_name'],
            'namaBelakangGuru' => $dataGuru[0]['last_name'],
            'shortbioGuru' => $dataGuru[0]['short_bio'],
            'jenisKelamin' => $dataGuru[0]['gender'],
            'admissionDate' => $dataGuru[0]['admission_date'],
            'email' => $dataGuru[0]['email'],
            'NIP' => $dataGuru[0]['NISN'],
            'addressUser' => $dataGuru[0]['address_user'],
            'phoneUser' => $dataGuru[0]['phone_user'],
            'shortbioGuru' => $dataGuru[0]['short_bio'],
            'agama' => $dataGuru[0]['religion'],
            'teacherSubject' => $dataSubject[0],
            'admissionDate' => $dataGuru[0]['admission_date'],
        ]);

        // return var_dump($namaDepanGuru[0]);

    }

}
