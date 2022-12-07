<?php

namespace App\Controller;
use Medoo\medoo;



class HostelController{

    public static function index($app, $request, $response, $args)
    {
        $id_hostel = $args['id_hostel'];
        // return var_dump($id_parent);



        $data = $app->db->select('tbl_hostel', '*');

        // var_dump($data);

        $app->view->render($response, 'hostel/all-hostel.html', [
            'data' =>  $data,
            'id_hostel' => $id_hostel,
        ]);
    }


    public static function tampil_data($app, $req, $rsp, $args)
    {
        $hostel = $app->db->select(
            'tbl_hostel',
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
                'tbl_hostel.route_name[~]' => '%' . $search . '%',
                'tbl_hostel.vehicle_number[~]' => '%' . $search . '%',
                'tbl_hostel.driver_name[~]' => '%' . $search . '%',
                'tbl_hostel.license_number[~]' => '%' . $search . '%',
                'tbl_hostel.phone_number[~]' => '%' . $search . '%',

            ];
            $hostel = $app->db->select(
                'tbl_hostel',
                '*',
                $limit
            );
            $totaldata = count($hostel);
            $totalfiltered = $totaldata;
        }

        $hostel = $app->db->select('tbl_hostel', '*', $conditions);

        $data = array();

        if (!empty($hostel)) {
            $no = $req->getParam('start') + 1;
            foreach ($hostel as $m) {

                $datas['No'] = $no . '.';
                $datas['route_name'] = $m['route_name'];
                $datas['vehicle_number'] = $m['vehicle_number'];
                $datas['driver_name'] = $m['driver_name'];
                $datas['license_number'] = $m['license_number'];
                $datas['phone_number'] = $m['phone_number'];
                $datas['id_driver'] = $m['id_driver'];
                $datas['aksi'] = '<div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item hostel_remove" data="' . $m['id_hostel'] . '"><button type="button" class="btn btn-light" class="modal-trigger" data-toggle="modal"
                    data-target="#confirmation-modal"><i class="fas fa-trash text-orange-red"></i>
                            Hapus
                        </button></a>
                    <a class="btn dropdown-item hostel_detail" data="' . $m['id_hostel'] . '" ><button type="button" id="show_hostel"  class="btn btn-light"  data-toggle="modal" data-target="detail_hostel"><i
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

        $data = $app->db->get('tbl_hostel', [
            "id_hostel",
            "route_name",
            "vehicle_number",
            "driver_name",
            "license_number",
            "phone_number",
            "id_driver",
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


        $del = $app->db->delete('tbl_hostel', [
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
        
        $update = $app->db->update('tbl_hostel', [
            "route_name" => $data['route_name'],
            "vehicle_number" => $data['vehicle_number'],
            "driver_name" => $data['driver_name'],
            "license_number" => $data['license_number'],
            "phone_number" => $data['phone_number'],
            "id_driver" => $data['id_driver']
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
        
        $data = $app->db->insert('tbl_hostel', [
            "route_name" => $data['route_name'],
            "vehicle_number" => $data['vehicle_number'],
            "driver_name" => $data['driver_name'],
            "license_number" => $data['license_number'],
            "phone_number" => $data['phone_number'],
            "id_driver" => $data['id_driver'],
        ]);
        // return var_dump($data);
        // $json_data = array(
        //     "draw"            => intval($request->getParam('draw')),
        // );
        // echo json_encode($json_data);
        return $rsp->withJson(array('success'=>true));
    }
}
