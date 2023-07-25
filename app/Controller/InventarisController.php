<?php 
namespace App\Controller;

use Medoo\Medoo;
use Midtrans;
use App\Controller\EmailController;

class InventarisController{
    public static function index($app, $request, $response, $args)
    {

        // return var_dump($id_finance);
        $payment_type = $app->db->select('tbl_inventorys', '*');


        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        
        $app->view->render($response, 'inventory/all-inventory.html', [

            'type_user' => $_SESSION['type_user'],
            'berhasil' => $berhasil,
            'payment_type' => $payment_type

        ]);
    }
    public static function tampil_data($app, $req, $rsp, $args)
    {
        $inventory = $app->db->select('tbl_inventorys','*');
        $columns = array(
            0 => 'id',
        );
        $totaldata = count($inventory);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];
        $conditions = [
            "LIMIT" => [$start, $limit],
        ];
        if (!empty($req->getParam('search')['value'])){
            $search = $req->getParam('search')['value'];

            $conditions['OR'] = [
                'kode_produk[~]' => '%' . $search . '%',
                'nama_produk[~]' => '%' . $search . '%',
                'kondisi[~]' => '%' . $search . '%',
                'jumlah[~]' => '%' . $search . '%',
                'ket[~]' => '%' . $search . '%',
            ];
            $limit = [
                "LIMIT" => [$start, $limit],
            ];
            $inventory = $app->db->select('tbl_inventorys','*',$limit);
            $totaldata = count($inventory);
            $totalfiltered = $totaldata;
        }
        $inventory = $app->db->select('tbl_inventorys','*',$conditions);
        $data = array();
        if(!empty($inventory)){
            $no = $req->getParam('start') + 1;
            foreach ($inventory as $inv){
                $datas['kode'] = $inv['kode_produk'];
                $datas['nama'] = $inv['nama_produk'];
                if ($inv['kondisi'] == "sangatbaik") {
                    $datas['kondisi'] = '<p class="badge badge-pill badge-primary d-block my-2 mx-auto py-3 px-4 w-25">Sangat Baik</p>';
                }elseif ($inv['kondisi'] == "baik") {
                    $datas['kondisi'] = '<p class="badge badge-pill badge-info d-block my-2 mx-auto py-3 px-4 w-25">Baik</p>';
                }elseif ($inv['kondisi'] == "cukup") {
                    $datas['kondisi'] = '<p class="badge badge-pill badge-success d-block my-2 mx-auto py-3 px-4 w-25">Cukup</p>';
                }elseif ($inv['kondisi'] == "buruk") {
                    $datas['kondisi'] = '<p class="badge badge-pill badge-warning d-block my-2 mx-auto py-3 px-4 w-25">Buruk</p>';
                }elseif ($inv['kondisi'] == "sangatburuk") {
                    $datas['kondisi'] = '<p class="badge badge-pill badge-danger d-block my-2 mx-auto py-3 px-4 w-25">Sangat Buruk</p>';
                } else {
                    $datas['kondisi'] = '<p class="badge badge-pill badge-secondary d-block my-2 mx-auto py-3 px-4 w-25">' . $inv['kondisi'] . '</p>';
                }
                // $datas['kondisi'] = $inv['kondisi'];
                $datas['jumlah'] = $inv['jumlah'];
                $datas['ket'] = $inv['ket'];
                $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right item_cek" data-idInventory="' . $inv['id_inventory'] . '">
                    <a class="dropdown-item btn btn-light item_hapus" data="' . $inv['id_inventory'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light inventory_detail" data="' . $inv['id_inventory'] . '">
                        <i class="fas fa-edit text-dark-pastel-green"></i>
                        Ubah
                    </a>
                   
                </div>
                </div>';

                $data[] = $datas;
                $no++;
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
    public static function viewAddInventory($app, $req, $rsp, $args)
    {
        $user = $app->db->select('tbl_users', '*', [
            'id_user_type[!]' => '4'
        ]);
        $type = $app->db->select('tbl_user_types', '*');

        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        $app->view->render($rsp, 'inventory/add-inventory.html', [
            'user' =>  $user,
            'typei' =>  $type,
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil
        ]);
    }
    public static function add_inventory($app, $req, $rsp, $args)
    {
        $data = $args['data'];
        // return var_dump($data);
        // $tgl = $data['date_payment'];
        // $tahun = explode('/', $tgl);
        // $date = $tahun[2] . '/' . $tahun[1] . '/' . $tahun[0];
        // return var_dump($date);
        $data = $app->db->insert('tbl_inventorys', [
            "kode_produk" => $data['kode'],
            "nama_produk" => $data['nama'],
            "kondisi" => $data['kondisi'],
            "jumlah" => $data['jumlah'],
            "ket" => $data['ket'],
        ]);


        // return var_dump($data);
        $_SESSION['berhasil'] = true;
        return $rsp->withRedirect('/add-inventory');
    }
    public static function inventory_detail($app, $req, $rsp, $args)
    {
        $id = $args['data'];
        $data = $app->db->select('tbl_inventorys','*',[
            'id_inventory' => $id
        ]);
        return $rsp->withJson($data[0]);
    }
    public static function update_inventory_detail($app, $request, $response, $args)
    {
        $data = $args['data'];
        // return var_dump($data);




        // return var_dump($uploadedFiles);
        $update = $app->db->update('tbl_inventorys', [
            "kode_produk" => $data['kode_produk'],
            "nama_produk" => $data['nama_produk'],
            "kondisi" => $data['kondisi'],
            "jumlah" => $data['jumlah'],
            "ket" => $data['ket'],
        ], [

            "id_inventory" => $data['id'],

        ]);
        // return var_dump($update);
        $json_data = array(
            "draw"            => intval($request->getParam('draw')),
        );

        echo json_encode($json_data);
    }
    public static function delete($app, $req, $rsp, $args)
    {
        $id = $args['data'];


        $del = $app->db->delete('tbl_inventorys', [
            "id_inventory" => $id
        ]);

        // return var_dump($del);
        $json_data = array(
            "draw"            => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }
    public static function add_inv_in($app, $req, $rsp, $args){
        $user = $app->db->select('tbl_users', '*', [
            'id_user_type[!]' => '4'
        ]);
        $type = $app->db->select('tbl_user_types', '*');

        $data_barang = $app->db->select('tbl_inventorys','*');
        $data_barang_masuk = $app->db->select('tbl_inv_ins','*');
        // return var_dump($data_barang);
        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        $app->view->render($rsp, 'inventory/inv-in.html', [
            'user' =>  $user,
            'typei' =>  $type,
            'data_barang' =>  $data_barang,
            'data_barang_masuk' =>  $data_barang_masuk,
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil
        ]);
    }
    public static function add_inv_out($app, $req, $rsp, $args){
        $user = $app->db->select('tbl_users', '*', [
            'id_user_type[!]' => '4'
        ]);
        $type = $app->db->select('tbl_user_types', '*');

        $data_barang = $app->db->select('tbl_inventorys','*');
        $data_barang_masuk = $app->db->select('tbl_inv_outs','*');
        // return var_dump($data_barang);
        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        $app->view->render($rsp, 'inventory/inv-out.html', [
            'user' =>  $user,
            'typei' =>  $type,
            'data_barang' =>  $data_barang,
            'data_barang_masuk' =>  $data_barang_masuk,
            'type' => $_SESSION['type'],
            'berhasil' => $berhasil
        ]);
    }
    public static function get_data_inventory($app, $req, $rsp, $args)
    {
        $param = $req->getParams();
        $condition = [
            "LIMIT" => 5
        ];
        if(isset($param['q'])){
            $search = $param['q'];
            $condition['OR'] = [
                'nama_produk[~]' => '%' . $search . '%',
                'kode_produk[~]' => '%' . $search . '%',            
            ];
        }
        $data = $app->db->select(
            'tbl_inventorys','*',$condition
        );
        // die(var_dump($param));



        
        return $rsp->withJson($data);
    }
    public static function add_invin($app, $req, $rsp, $args)
    {
        // return var_dump($args);
        $data = $args['tambah'];

        $app->db->insert('tbl_inv_ins',[
            'id_inventory'=>$data['id_inventory'],
            'jumlah'=>$data ['jumlah'],
            'tanggal'=>$data['date'],
            'ket'=>$data['ket']
        ]);
        $juml_db = $app->db->select('tbl_inventorys','jumlah',[
            'id_inventory' =>$data['id_inventory']
        ]);
        $jumlah = $juml_db[0] + (int)$data['jumlah'];
        // return var_dump($jumlah);
        $app->db->update('tbl_inventorys',[
            'jumlah' => $jumlah
        ],[
            'id_inventory' =>$data['id_inventory']
        ]);
        $json_data = array(
            "draw" => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }
    public static function add_invout($app, $req, $rsp, $args)
    {
        // return var_dump($args);
        $data = $args['tambah'];

        $app->db->insert('tbl_inv_outs',[
            'id_inventory'=>$data['id_inventory'],
            'jumlah'=>$data ['jumlah'],
            'tanggal'=>$data['date'],
            'ket'=>$data['ket']
        ]);
        $juml_db = $app->db->select('tbl_inventorys','jumlah',[
            'id_inventory' =>$data['id_inventory']
        ]);
        $jumlah = $juml_db[0] - (int)$data['jumlah'];
        // return var_dump($jumlah);
        $app->db->update('tbl_inventorys',[
            'jumlah' => $jumlah
        ],[
            'id_inventory' =>$data['id_inventory']
        ]);
        $json_data = array(
            "draw" => intval($req->getParam('draw')),
        );

        echo json_encode($json_data);
    }
    public static function tampil_data_inv_in($app, $req, $rsp, $args)
    {
        $inventory = $app->db->select('tbl_inv_ins',[
            '[><]tbl_inventorys'=>'id_inventory'
        ],[
            'tbl_inv_ins.tanggal',
            'tbl_inv_ins.id_inv_in',
            'tbl_inventorys.kode_produk',
            'tbl_inventorys.nama_produk',
            'tbl_inv_ins.jumlah',
            'tbl_inv_ins.ket'
        ]);
        // return var_dump($inventory);
        $columns = array(
            0 => 'id',
        );
        $totaldata = count($inventory);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];
        $conditions = [
            "LIMIT" => [$start, $limit],
        ];
        if (!empty($req->getParam('search')['value'])){
            $search = $req->getParam('search')['value'];

            $conditions['OR'] = [
                'kode_produk[~]' => '%' . $search . '%',
                'nama_produk[~]' => '%' . $search . '%',
                'jumlah[~]' => '%' . $search . '%',
                'ket[~]' => '%' . $search . '%',
            ];
            $limit = [
                "LIMIT" => [$start, $limit],
            ];
            $inventory = $app->db->select('tbl_inv_ins',[
                '[><]tbl_inventorys'=>'id_inventory'
            ],[
                'tbl_inv_ins.tanggal',
                'tbl_inv_ins.id_inv_in',
                'tbl_inventorys.kode_produk',
                'tbl_inventorys.nama_produk',
                'tbl_inv_ins.jumlah',
                'tbl_inv_ins.ket'
            ],$limit);
            $totaldata = count($inventory);
            $totalfiltered = $totaldata;
        }
        $inventory = $app->db->select('tbl_inv_ins',[
            '[><]tbl_inventorys'=>'id_inventory'
        ],[
            'tbl_inv_ins.tanggal',
            'tbl_inv_ins.id_inv_in',
            'tbl_inventorys.kode_produk',
            'tbl_inventorys.nama_produk',
            'tbl_inv_ins.jumlah',
            'tbl_inv_ins.ket'
        ],$conditions);
        $data = array();
        if(!empty($inventory)){
            $no = $req->getParam('start') + 1;
            foreach ($inventory as $inv){
                $datas['no'] = $no;
                $datas['tgl'] = $inv['tanggal'];
                $datas['kode'] = $inv['kode_produk'];
                $datas['nama'] = $inv['nama_produk'];
                $datas['jumlah'] = $inv['jumlah'];
                $datas['ket'] = $inv['ket'];
                $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right item_cek" data-idInvIn="' . $inv['id_inv_in'] . '">
                    <a class="dropdown-item btn btn-light item_hapus" data="' . $inv['id_inv_in'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light inv_in_detail" data="' . $inv['id_inv_in'] . '">
                        <i class="fas fa-edit text-dark-pastel-green"></i>
                        Ubah
                    </a>
                   
                </div>
                </div>';

                $data[] = $datas;
                $no++;
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
    public static function tampil_data_inv_out($app, $req, $rsp, $args)
    {
        $inventory = $app->db->select('tbl_inv_outs',[
            '[><]tbl_inventorys'=>'id_inventory'
        ],[
            'tbl_inv_outs.tanggal',
            'tbl_inv_outs.id_inv_out',
            'tbl_inventorys.kode_produk',
            'tbl_inventorys.nama_produk',
            'tbl_inv_outs.jumlah',
            'tbl_inv_outs.ket'
        ]);
        // return var_dump($inventory);
        $columns = array(
            0 => 'id',
        );
        $totaldata = count($inventory);
        $totalfiltered = $totaldata;
        $limit = $req->getParam('length');
        $start = $req->getParam('start');
        $order = $req->getParam('order');
        $order = $columns[$order[0]['column']];
        $dir = $req->getParam('order');
        $dir = $dir[0]['dir'];
        $conditions = [
            "LIMIT" => [$start, $limit],
        ];
        if (!empty($req->getParam('search')['value'])){
            $search = $req->getParam('search')['value'];

            $conditions['OR'] = [
                'kode_produk[~]' => '%' . $search . '%',
                'nama_produk[~]' => '%' . $search . '%',
                'jumlah[~]' => '%' . $search . '%',
                'ket[~]' => '%' . $search . '%',
            ];
            $limit = [
                "LIMIT" => [$start, $limit],
            ];
            $inventory = $app->db->select('tbl_inv_outs',[
                '[><]tbl_inventorys'=>'id_inventory'
            ],[
                'tbl_inv_outs.tanggal',
                'tbl_inv_outs.id_inv_out',
                'tbl_inventorys.kode_produk',
                'tbl_inventorys.nama_produk',
                'tbl_inv_outs.jumlah',
                'tbl_inv_outs.ket'
            ],$limit);
            $totaldata = count($inventory);
            $totalfiltered = $totaldata;
        }
        $inventory = $app->db->select('tbl_inv_outs',[
            '[><]tbl_inventorys'=>'id_inventory'
        ],[
            'tbl_inv_outs.tanggal',
            'tbl_inv_outs.id_inv_out',
            'tbl_inventorys.kode_produk',
            'tbl_inventorys.nama_produk',
            'tbl_inv_outs.jumlah',
            'tbl_inv_outs.ket'
        ],$conditions);
        $data = array();
        if(!empty($inventory)){
            $no = $req->getParam('start') + 1;
            foreach ($inventory as $inv){
                $datas['no'] = $no;
                $datas['tgl'] = $inv['tanggal'];
                $datas['kode'] = $inv['kode_produk'];
                $datas['nama'] = $inv['nama_produk'];
                $datas['jumlah'] = $inv['jumlah'];
                $datas['ket'] = $inv['ket'];
                $datas['aksi'] = '<div class="dropdown">

                <a href="#" class="dropdown-toggle p-3" data-toggle="dropdown"
                    aria-expanded="false">
                    <span class="flaticon-more-button-of-three-dots"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right item_cek" data-idInvIn="' . $inv['id_inv_out'] . '">
                    <a class="dropdown-item btn btn-light item_hapus" data="' . $inv['id_inv_out'] . '">
                        <i class="fas fa-trash text-orange-red"></i>
                        Hapus
                    </a>
                    <a class="dropdown-item btn btn-light inv_out_detail" data="' . $inv['id_inv_out'] . '">
                        <i class="fas fa-edit text-dark-pastel-green"></i>
                        Ubah
                    </a>
                   
                </div>
                </div>';

                $data[] = $datas;
                $no++;
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
    public static function detail_inv_in($app, $request, $response, $id_inventory_in)
    {
        $data = $app->db->get('tbl_inv_ins','*', [
            "id_inv_in" => $id_inventory_in
        ]);
        $json_data = array(
            'data' => $data
        );
        // return var_dump($data);
        return $response->withJson($data);
    }
    public static function detail_inv_out($app, $request, $response, $id_inventory_out)
    {
        $data = $app->db->get('tbl_inv_outs','*', [
            "id_inv_out" => $id_inventory_out
        ]);
        $json_data = array(
            'data' => $data
        );
        // return var_dump($data);
        return $response->withJson($data);
    }

    public static function update_inv_in($app, $request, $response, $args)
    {

        //get args
        $data = $args['data'];
        //get based value inv in
        $inv_in_based = $app->db->select('tbl_inv_ins','jumlah',[
            'id_inv_in'=>$data['id']
        ]);
        //check if current value != value based
        if($inv_in_based[0] != (int)$data['jumlah']){
            //get data inventory value
            $inv = $app->db->select('tbl_inventorys','jumlah',[
                'id_inventory'=>$data['id_inventory']
            ]);
            $jumlah = $inv[0];
            //if based more small than input value, add
            if($jumlah < (int)$data['jumlah']){
                $jumlah = $jumlah + ((int)$data['jumlah'] - $inv_in_based[0]);
            }
            //if based more big than input value, sub
            else if($jumlah > (int)$data['jumlah']){
                $jumlah = $jumlah - ($inv_in_based[0] - (int)$data['jumlah']);
            }
            
            //update inventory
            $app->db->update('tbl_inventorys', [
                'jumlah' => $jumlah,
            ], [
                "id_inventory" => $data['id_inventory']
            ]);
            // return die (var_dump($jumlah));
        }
        //update inv in
        $app->db->update('tbl_inv_ins', [
            'id_inventory' => $data['id_inventory'],
            'jumlah' => $data['jumlah'],
            'tanggal' => $data['date'],
            'ket' => $data['ket'],
        ], [
            "id_inv_in" => $data['id']
        ]);

        $json_data = array(
            "draw" => intval($request->getParam('draw')),
        );

        //get back to json
        echo json_encode($json_data);
    }
    public static function update_inv_out($app, $request, $response, $args)
    {

        //get args
        $data = $args['data'];
        //get based value inv in
        $inv_out_based = $app->db->select('tbl_inv_outs','jumlah',[
            'id_inv_out'=>$data['id']
        ]);
        //check if current value != value based
        if($inv_out_based[0] != (int)$data['jumlah']){
            //get data inventory value
            $inv = $app->db->select('tbl_inventorys','jumlah',[
                'id_inventory'=>$data['id_inventory']
            ]);
            $jumlah = $inv[0];
            //if based more small than input value, add
            if($jumlah < (int)$data['jumlah']){
                $jumlah = $jumlah - ((int)$data['jumlah'] - $inv_out_based[0]);
            }
            //if based more big than input value, sub
            else if($jumlah > (int)$data['jumlah']){
                $jumlah = $jumlah + ($inv_out_based[0] - (int)$data['jumlah']);
            }
            
            //update inventory
            $app->db->update('tbl_inventorys', [
                'jumlah' => $jumlah,
            ], [
                "id_inventory" => $data['id_inventory']
            ]);
            // return die (var_dump($jumlah));
        }
        //update inv in
        $app->db->update('tbl_inv_outs', [
            'id_inventory' => $data['id_inventory'],
            'jumlah' => $data['jumlah'],
            'tanggal' => $data['date'],
            'ket' => $data['ket'],
        ], [
            "id_inv_out" => $data['id']
        ]);

        $json_data = array(
            "draw" => intval($request->getParam('draw')),
        );

        //get back to json
        echo json_encode($json_data);
    }
    public static function delete_inv_in($app, $request, $response, $args)
    {
        //Get value id inventory in
        $id = $args['data'];

        //get inventory in for getting id inventory
        $inv_ins = $app->db->select('tbl_inv_ins',['id_inventory','jumlah'],[
            "id_inv_in" => $id
        ]);

        // set value
        $id_inv = $inv_ins[0]['id_inventory'];
        $jumlah = $inv_ins[0]['jumlah'];

        //get value in id inventory
        $inv = $app->db->select('tbl_inventorys','jumlah',[
            'id_inventory'=>$id_inv
        ]);
        $jumlah_inv = $inv[0];
        
        //remove data in tbl inventory in
        $app->db->delete('tbl_inv_ins', [
            "id_inv_in" => $id
        ]);
        
        //sub the current value with deleted value
        $jumlah_fix = $jumlah_inv - $jumlah;
        // return var_dump($jumlah_fix);
        $app->db->update('tbl_inventorys',[
            'jumlah' => $jumlah_fix
        ],[
            'id_inventory'=>$id_inv
        ]);

        $json_data = array(
            "draw" => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);
    }
    public static function delete_inv_out($app, $request, $response, $args)
    {
        //Get value id inventory in
        $id = $args['data'];

        //get inventory in for getting id inventory
        $inv_ins = $app->db->select('tbl_inv_outs',['id_inventory','jumlah'],[
            "id_inv_out" => $id
        ]);

        // set value
        $id_inv = $inv_ins[0]['id_inventory'];
        $jumlah = $inv_ins[0]['jumlah'];

        //get value in id inventory
        $inv = $app->db->select('tbl_inventorys','jumlah',[
            'id_inventory'=>$id_inv
        ]);
        $jumlah_inv = $inv[0];
        
        //remove data in tbl inventory in
        $app->db->delete('tbl_inv_outs', [
            "id_inv_out" => $id
        ]);
        
        //sub the current value with deleted value
        $jumlah_fix = $jumlah_inv + $jumlah;
        // return var_dump($jumlah_fix);
        $app->db->update('tbl_inventorys',[
            'jumlah' => $jumlah_fix
        ],[
            'id_inventory'=>$id_inv
        ]);

        $json_data = array(
            "draw" => intval($request->getParam('draw')),
        );
        echo json_encode($json_data);
    }
}
?>