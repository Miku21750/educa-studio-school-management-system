<?php

namespace App\Controller;

use Medoo\medoo;


class PrintPDFController
{

    public static function index($app, $request, $response, $args)
    {
        $id_final_score = $args['id_final_score'];



        $data = $app->db->select('tbl_exams', '*');


        $app->view->render($response, 'others/printPdf.html', [
            'data' =>  $data,
            'id_final_score' => $id_final_score,
        ]);
    }


    public static function tampil_data($app, $req, $rsp, $args)
    {
        
        $tbl_classes = 'tbl_classes';

        $rapor = $app->db->select('tbl_final_scores', [
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_subjects' => 'id_subject',
            '[><]tbl_users' => 'id_user',
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], [
            'first_name(first_name)',
            'last_name(last_name)',
            'nisn(nisn)',
            'session(session)',
            'class(class)',
            'section(section)',
            'subject_name(subject_name)',
            'nilai_abs(nilai_abs)',
            'nilai_1(nilai_1)',
            'nilai_2(nilai_2)',
            'nilai_3(nilai_3)',
            'nilai_akhir(nilai_akhir)',
        ],[
            'id_user' => '4'
        ]);
        
        $app->view->render($rsp, 'others/printPdf.html', [
            'rapor' => $rapor,
            'nama' => $rapor[0]['first_name'] . ' ' . $rapor[0]['last_name'],
            'nisn' => $rapor[0]['nisn'],
            'kelas' => $rapor[0]['class']. ' ' . $rapor[0]['section'],
            'scyear' => $rapor[0]['session'],
        ]);
    }
    
    public static function printPDF($app, $req, $rsp, $args)
    {
        $id = $args['data'];
        $tbl_classes = 'tbl_classes';
        
        $rapor = $app->db->select('tbl_final_scores', [
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_subjects' => 'id_subject',
            // '[><]tbl_exam_grades' => 'id_exam_grade',
            '[><]tbl_users' => 'id_user',
            '[><]tbl_sections' => ["$tbl_classes.id_section" => 'id_section'],
        ], [
            'first_name(first_name)',
            'last_name(last_name)',
            'nisn(nisn)',
            'photo_user(photo_user)',
            'session(session)',
            'class(class)',
            'section(section)',
            'subject_name(subject_name)',
            'nilai_abs(nilai_abs)',
            'nilai_1(nilai_1)',
            'nilai_2(nilai_2)',
            'nilai_3(nilai_3)',
            'nilai_akhir(nilai_akhir)',
            // 'grade_name(grade_name)',
        ],[
            'id_user' => $id
        ]);
        
        // die(var_dump($id));
        // if (!empty($rapor)) {
            $jumlahData = count($rapor);
            $jumlahNilai = 0;
    
            // $no = $req->getParam('start') + 1;
            foreach ($rapor as $r) {
                $jumlahNilai += $r['nilai_akhir'];

                // $no++;
            }
    
            $rata2 = round($jumlahNilai/$jumlahData, 2);
        // }
        // else{
        //     $jumlahNilai = 0;
        //     $rata2 = 0;
        // }

        // return $rsp->withJson($jumlahNilai);


        $app->view->render($rsp, 'others/printPdf.html', [
            'rapor' => $rapor,
            'nama' => $rapor[0]['first_name'] . ' ' . $rapor[0]['last_name'],
            'nisn' => $rapor[0]['nisn'],
            'kelas' => $rapor[0]['class']. ' ' . $rapor[0]['section'],
            'scyear' => $rapor[0]['session'],
            'foto' => $rapor[0]['photo_user'],
            'jmlNilai' => $jumlahNilai,
            'average' => $rata2,
            // 'nomer' => $no,
        ]);
    }
}