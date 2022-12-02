<?php

namespace App\Controller;



class DashbordParentController
{

    public static function index($app, $request, $response, $args)
    {
        $user = $args['user'];
        $type = $args['type'];
        $id_parent = $args['id_parent'];
        // return var_dump($id_parent);

        
        $data = $app->db->query("SELECT * FROM (tbl_users INNER JOIN tbl_admissions USING(id_user)) INNER JOIN (tbl_classes INNER JOIN tbl_sections USING(id_section)) USING(id_class) WHERE id_parent=".$id_parent)->fetchAll();
        $totalexam = $app->db->count('tbl_users', [
            "[><]tbl_exam_results" => "id_user"
        ],'*', [
            "id_parent" => $id_parent,
        ]);
        $totalnotif = $app->db->count('tbl_users', [
            "[><]tbl_notifications" => "id_user"
        ],'*', [
            "id_user" => $id_parent,
        ]);
        $notif = $app->db->select('tbl_users', [
            "[><]tbl_notifications" => "id_user"
        ],'*', [
            "id_user" => $id_parent,
        ]);
        $totaltagihan = $app->db->sum('tbl_users', [
            "[><]tbl_finances" => "id_user"
        ], 'amount_payment',[
            "id_parent" => $id_parent,
            'status' => "BELUM BAYAR"
        ]);
        $totalpembayaran = $app->db->sum('tbl_users', [
            "[><]tbl_finances" => "id_user"
        ], 'amount_payment',[
            "id_parent" => $id_parent,
            'status' => "DIBAYAR"
        ]);
        // var_dump($data);

        $app->view->render($response, 'dashboard/parent.html', [
            'data' =>  $data,
            'notif' =>  $notif,
            'totalexam' =>  $totalexam,
            'totalnotif' =>  $totalnotif,
            'totaltagihan' => $totaltagihan,
            'totalpembayaran' => $totalpembayaran,
            'user' => $user,
            'type' => $type,
            'id_parent' => $id_parent,
            'type_user' => $_SESSION['type_user'],


        ]);
    }


    public static function tampil_data($app, $req, $rsp, $args)
    {
        $id_parent = $args['data'];
//  var_dump($id_parent);

        $payment = $app->db->select('tbl_users', [
            "[><]tbl_finances" => "id_user"
        ],'*', [
            "id_parent" => $id_parent,
        ]);


        $columns = array(
            0 => 'id',
        );

        $totaldata = count($payment);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];

        $req->getParam('jurusan');

        $conditions = [
            "LIMIT" => [$start, $limit],
            'id_parent' => $id_parent
        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                'id_parent' => $id_parent
            ];
            $conditions['OR'] = [
                'tbl_users.NISN[~]' => '%' . $search . '%',
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                
            ];
            $payment = $app->db->select('tbl_finances',[
                '[><]tbl_users' => 'id_user',
                '[><]tbl_payment_types' => 'id_payment_type'
            ],'*',
                $limit
            );
            $totaldata = count($payment);
            $totalfiltered = $totaldata;
        }

        $payment = $app->db->select('tbl_finances',[
            '[><]tbl_users' => 'id_user',
            '[><]tbl_payment_types' => 'id_payment_type'
        ],'*', $conditions);

        $data = array();

        if (!empty($payment)) {
            foreach ($payment as $m) {

                $datas['NISN'] = $m['NISN'];
                $datas['Nama'] = $m['first_name'].' '.$m['last_name'];
                $datas['payment_type_name'] = $m['payment_type_name'];
                $datas['amount_payment'] = $m['amount_payment'];
                // $datas['status'] = $m['status'];
                if($m['status'] == "Belum Bayar"){
                    $datas['status'] = '<p class="badge badge-pill badge-danger d-block my-2 py-3 px-4">'.$m['status'].'</p>';
                }else{
                    $datas['status'] = '<p class="badge badge-pill badge-success d-block my-2 py-3 px-4">'.$m['status'].'</p>';
                }
                $datas['email'] = $m['email'];
                $datas['date_payment'] = $m['date_payment'];


                $data[] = $datas;
            }
        }

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }    

    public static function tampil_data_result($app, $req, $rsp, $args)
    {
        $id_parent = $args['data'];
//  var_dump($id_parent);

        $result = $app->db->select('tbl_exam_results', [
            '[><]tbl_classes' => 'id_class',
            '[><]tbl_users' => 'id_user',
            '[><]tbl_subjects' => 'id_subject'
        ],'*', [
            "id_parent" => $id_parent,
        ]);
        // return var_dump($result);


        $columns = array(
            0 => 'id',
        );

        $totaldata = count($result);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];


        $conditions = [
            "LIMIT" => [$start, $limit],
            'id_parent' => $id_parent
        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                "id_parent" => $id_parent

            ];
            $conditions['OR'] = [
                'tbl_users.NISN[~]' => '%' . $search . '%',
                'tbl_users.first_name[~]' => '%' . $search . '%',
                'tbl_users.last_name[~]' => '%' . $search . '%',
                
            ];
            $result = $app->db->select('tbl_exam_results', [
                '[><]tbl_classes' => 'id_class',
                '[><]tbl_users' => 'id_user',
                '[><]tbl_subjects' => 'id_subject',
                '[><]tbl_exams' => 'id_exam'

            ],'*',
                $limit
            );
            $totaldata = count($result);
            $totalfiltered = $totaldata;
        }

        $result = $app->db->select('tbl_exam_results',[
                '[><]tbl_sections' => 'id_section',
                '[><]tbl_classes' => 'id_class',
                '[><]tbl_users' => 'id_user',
                '[><]tbl_subjects' => 'id_subject',
                '[><]tbl_exams' => 'id_exam'

        ],'*', $conditions);

        $data = array();

        if (!empty($result)) {
            foreach ($result as $m) {

                $datas['nisn'] = $m['NISN'];
                $datas['nama'] = $m['first_name'].' '.$m['last_name'];
                $datas['ujian'] = $m['exam_name'];
                $datas['mapel'] = $m['subject_name'];
                $datas['kelas'] = $m['class'].' '.$m['section'];
                $datas['nilai'] = $m['score'];
                $datas['tanggal'] = $m['date_result'];
                


                $data[] = $datas;
            }
        }
        // return var_dump($result);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        echo json_encode($json_data);
    }       


}

?>
