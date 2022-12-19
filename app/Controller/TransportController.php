<?php

namespace App\Controller;

use Medoo\medoo;



class TransportController
{

    public static function index($app, $request, $response, $args)
    {
        $id_transport = $args['id_transport'];
        // return var_dump($id_parent);



        $data = $app->db->select('tbl_transports', '*');

        // var_dump($data);

        $app->view->render($response, 'transport/all-transport.html', [
            'data' =>  $data,
            'id_transport' => $id_transport,
        ]);
    }


    public static function tampil_data($app, $req, $rsp, $args)
    {
        $transport = $app->db->select(
            'tbl_transports',
            '*'
        );
        // return var_dump($transport);



        $totaldata = count($transport);
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
                // 'id_transport_type' => $type,

            ];
            $conditions['OR'] = [
                'tbl_transports.route_name[~]' => '%' . $search . '%',
                'tbl_transports.vehicle_number[~]' => '%' . $search . '%',
                'tbl_transports.driver_name[~]' => '%' . $search . '%',
                'tbl_transports.license_number[~]' => '%' . $search . '%',
                'tbl_transports.phone_number[~]' => '%' . $search . '%',

            ];
            $transport = $app->db->select(
                'tbl_transports',
                '*',
                $limit
            );
            $totaldata = count($transport);
            $totalfiltered = $totaldata;
        }

        $transport = $app->db->select('tbl_transports', '*', $conditions);

        $data = array();

        if (!empty($transport)) {
            $no = $req->getParam('start') + 1;
            foreach ($transport as $m) {

                $datas['No'] = $no . '.';
                $datas['route_name'] = $m['route_name'];
                $datas['vehicle_number'] = $m['vehicle_number'];
                $datas['driver_name'] = $m['driver_name'];
                $datas['phone_number'] = $m['phone_number'];
                $datas['id_driver'] = $m['id_driver'];
                $datas['aksi'] = '<div class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right p-3">
                    <a class="dropdown-item transport_remove btn btn-light" class="modal-trigger" data-toggle="modal"
                    data-target="#confirmation-modal" data="' . $m['id_transport'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a id="show_transport" class="btn dropdown-item transport_detail btn btn-light"  data-toggle="modal" data-target="detail_transport" data="' . $m['id_transport'] . '" >
                        <i class="fas fa-edit text-dark-pastel-green"></i>
                        Ubah
                    </a>
                </div>
            </div>';
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($transport);
        // return var_dump($transport);

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

    public static function tampil_dataS($app, $req, $rsp, $args)
    {
        $transport = $app->db->select(
            'tbl_transports',
            '*'
        );
        // return var_dump($transport);



        $totaldata = count($transport);
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
                // 'id_transport_type' => $type,

            ];
            $conditions['OR'] = [
                'tbl_transports.route_name[~]' => '%' . $search . '%',
                'tbl_transports.vehicle_number[~]' => '%' . $search . '%',
                'tbl_transports.driver_name[~]' => '%' . $search . '%',
                'tbl_transports.license_number[~]' => '%' . $search . '%',
                'tbl_transports.phone_number[~]' => '%' . $search . '%',

            ];
            $transport = $app->db->select(
                'tbl_transports',
                '*',
                // $limit
                $conditions
            );
            $totaldata = count($transport);
            $totalfiltered = $totaldata;
        }

        $transport = $app->db->select('tbl_transports', '*', $conditions);

        $data = array();

        if (!empty($transport)) {
            $no = $req->getParam('start') + 1;
            foreach ($transport as $m) {

                $datas['No'] = $no . '.';
                $datas['route_name'] = $m['route_name'];
                $datas['vehicle_number'] = $m['vehicle_number'];
                $datas['driver_name'] = $m['driver_name'];
                $datas['license_number'] = $m['license_number'];
                $datas['phone_number'] = $m['phone_number'];
                $datas['id_driver'] = $m['id_driver'];
            //     $datas['aksi'] = '<div class="dropdown">
            //     <a href="#" class="dropdown-toggle" data-toggle="dropdown"
            //         aria-expanded="false">
            //         <span class="flaticon-more-button-of-three-dots"></span>
            //     </a>
            //     <div class="dropdown-menu dropdown-menu-right">
            //         <a class="dropdown-item transport_remove" data="' . $m['id_transport'] . '"><button type="button" class="btn btn-light" class="modal-trigger" data-toggle="modal"
            //         data-target="#confirmation-modal"><i class="fas fa-trash text-orange-red"></i>
            //                 Hapus
            //             </button></a>
            //         <a class="btn dropdown-item transport_detail" data="' . $m['id_transport'] . '" ><button type="button" id="show_transport"  class="btn btn-light"  data-toggle="modal" data-target="detail_transport"><i
            //                 class="fas fa-edit text-dark-pastel-green"></i>
            //                 Ubah
            //             </button></a>
            //     </div>
            // </div>';
                $data[] = $datas;
                $no++;
            }
        }
        // return var_dump($transport);
        // return var_dump($transport);

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


    public static function detail($app, $request, $response, $id_transport)
    {
        // $id_transport = $data;
        // var_dump($id_transport);

        $data = $app->db->get('tbl_transports', [
            "id_transport",
            "route_name",
            "vehicle_number",
            "driver_name",
            "license_number",
            "phone_number",
            "id_driver",
        ], [
            'id_transport' => $id_transport
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


        $del = $app->db->delete('tbl_transports', [
            "id_transport" => $id
        ]);

        // return $rsp->withJson($del);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }

    public static function update_transport_detail($app, $request, $response, $args)
    {
        $data = $args['data'];

        $update = $app->db->update('tbl_transports', [
            "route_name" => $data['route_name'],
            "vehicle_number" => $data['vehicle_number'],
            "driver_name" => $data['driver_name'],
            "license_number" => $data['license_number'],
            "phone_number" => $data['phone_number'],
            "id_driver" => $data['id_driver']
        ], [
            "id_transport" => $data['id_transport']
        ]);
        // return var_dump($update);

        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);

        // return var_dump($update);
    }

    public static function add_transport($app, $req, $rsp, $args)
    {
        $data = $args['data'];
        // return var_dump($data);

        $data = $app->db->insert('tbl_transports', [
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
        return $rsp->withJson(array('success' => true));
    }
}
