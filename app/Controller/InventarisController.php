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
        return var_dump($args);
        
    }
    public static function tampil_data_inv_in($app, $req, $rsp, $args)
    {
        $inventory = $app->db->select('tbl_inv_ins',[
            '[><]tbl_inventorys'=>'id_inventory'
        ],'*');
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
            ],'*',$limit);
            $totaldata = count($inventory);
            $totalfiltered = $totaldata;
        }
        $inventory = $app->db->select('tbl_inv_ins',[
            '[><]tbl_inventorys'=>'id_inventory'
        ],'*',$conditions);
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
}
?>