<?php

namespace App\Controller;
use Medoo\medoo;



class HostelController{

    public static function index($app, $request, $response, $args)
    {
        $id_hostel = $args['id_hostel'];
        // return var_dump($id_parent);



        $data = $app->db->select('tbl_hostels', '*');

        // var_dump($data);

        $app->view->render($response, 'hostel/hostel.html', [
            'data' =>  $data,
            'id_hostel' => $id_hostel,
        ]);
    }


    public static function tampil_data($app, $req, $rsp, $args)
    {
        $hostel = $app->db->select(
            'tbl_hostels',
            '*'
        );
        // return var_dump($hostel);

     

        $totaldata = count($hostel);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
      


        $conditions = [
            "LIMIT" => [$start, $limit],

        ];

        if (!empty($req->getParam('search')['value'])) {
            $search = $req->getParam('search')['value'];
            $limit = [
                "LIMIT" => [$start, $limit],
                // 'id_hostel_type' => $type,

            ];
            $conditions['OR'] = [
                'tbl_hostels.hostel_name[~]' => '%' . $search . '%',
                'tbl_hostels.room_number[~]' => '%' . $search . '%',
                'tbl_hostels.room_type[~]' => '%' . $search . '%',
                'tbl_hostels.number_of_bed[~]' => '%' . $search . '%',
                'tbl_hostels.cost_per_bed[~]' => '%' . $search . '%',

            ];
            $hostel = $app->db->select(
                'tbl_hostels',
                '*',
                $limit
            );
            $totaldata = count($hostel);
            $totalfiltered = $totaldata;
        }

        $hostel = $app->db->select('tbl_hostels', '*', $conditions);

        $data = array();

        if (!empty($hostel)) {
            $no = $req->getParam('start') + 1;
            foreach ($hostel as $m) {

                $datas['No'] = $no . '.';
                $datas['hostel_name'] = $m['hostel_name'];
                $datas['room_number'] = $m['room_number'];
                $datas['room_type'] = $m['room_type'];
                $datas['number_of_bed'] = $m['number_of_bed'];
                $datas['cost_per_bed'] = $m['cost_per_bed'];
                $datas['aksi'] =  '<div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item hostel_remove" data="' . $m['id_hostel'] . '"><button type="button" class="btn btn-light" class="modal-trigger" data-toggle="modal"
                    data-target="#confirmation-modal"><i class="fas fa-trash text-orange-red"></i>
                            Hapus
                        </button></a>
                    <a class="btn dropdown-item hostel_detail" data="' . $m['id_hostel'] . '" ><button type="button" id="show_book"  class="btn btn-light"  data-toggle="modal" data-target="detail_book"><i
                            class="fas fa-edit text-dark-pastel-green"></i>
                            Ubah
                        </button></a>
                </div>
            </div>';
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($hostel);
        // return var_dump($hostel);

        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
            "recordsTotal"    => intval($totaldata),
            "recordsFiltered" => intval($totalfiltered),
            "data"            => $data
        );
        // return var_dump($data);
        // return var_dump($json_data);
        echo json_encode($json_data);
    }

    public static function detail($app, $request, $response, $id_hostel)
    {
        // $id_hostel = $data;
        // var_dump($id_hostel);

        $data = $app->db->get('tbl_hostels', [
            "id_hostel",
            "hostel_name",
            "room_number",
            "room_type",
            "number_of_bed",
            "cost_per_bed",
        ], [
            'id_hostel' => $id_hostel
        ]);
        // return var_dump($data);
        $json_data = array(
            'data' => $data
        );

        return $response->withJson($data);

        // return var_dump($json_data);
        // echo json_encode($json_data);
    }

    public static function delete($app, $req, $rsp, $args)
    {
        $id = $args['data'];


        $del = $app->db->delete('tbl_hostels', [
            "id_hostel" => $id
        ]);

        // return $rsp->withJson($del);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function update_hostel_detail($app, $request, $response, $args)
    {
        $data = $args['data'];
        
        $update = $app->db->update('tbl_hostels', [
            "hostel_name" => $data['hostel_name'],
            "room_number" => $data['room_number'],
            "room_type" => $data['room_type'],
            "number_of_bed" => $data['number_of_bed'],
            "cost_per_bed" => $data['cost_per_bed']
        ], [
            "id_hostel" => $data['id_hostel']
        ]);
        // return var_dump($update);

        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);

        // return var_dump($update);
    }

    public static function add_hostel($app, $req, $rsp, $args)
    {
        $data = $args['data'];
        // return var_dump($data);
        
        $data = $app->db->insert('tbl_hostels', [
            "hostel_name" => $data['hostel_name'],
            "room_number" => $data['room_number'],
            "room_type" => $data['room_type'],
            "number_of_bed" => $data['number_of_bed'],
            "cost_per_bed" => $data['cost_per_bed']
        ]);
        // return var_dump($data);
        // $json_data = array(
        //     "draw"            => intval($request->getParam('draw')),
        // );
        // echo json_encode($json_data);
        return $rsp->withJson(array('success'=>true));
    }
}
