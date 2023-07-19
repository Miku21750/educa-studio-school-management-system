<?php
namespace App\Controller;

use Medoo\Medoo;
use Midtrans;
use App\Controller\EmailController;

class InventarisController2{
    public static function index($app, $request, $response, $args)
    {

        // return var_dump($id_finance);
        $payment_type = $app->db->select('tbl_inventorys', '*');


        $berhasil = isset($_SESSION['berhasil']);
        unset($_SESSION['berhasil']);
        
        $app->view->render($response, 'inventory/all-inventory-second.html', [

            'type_user' => $_SESSION['type_user'],
            'berhasil' => $berhasil,
            'payment_type' => $payment_type

        ]);
    }
    public static function getFile($app, $request, $response, $args)
    {
        //get sended data from post method
        $data = $request->getParsedBody();
        return die(var_dump($data));
        //get directory upload
        $directory = $app->get('upload_directory');

        // return var_dump('Inventaris_'.$data['dateInvIn'] . '.xls');
        //check if date excel exist
        if(file_exists('../public/uploads/Profile/' . 'Inventaris_'.$data['dateInvIn'] . '.xls')){
            $file = '../public/uploads/Profile/' . 'Inventaris_'.$data['dateInvIn'] . '.xls';
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            ob_clean();
            flush();
            readfile($file);
            exit;
        }else{
            header("Content-Type: application/vnd.ms-excel");
            echo 'Kode Produk' . "\t" . 'Nama Produk' . "\t" . 'Kondisi' . "\t" . 'Jumlah' . "\t" . 'Keterangan' . "\n";
            echo 'K000001' . "\t" . 'Kursi' . "\t" . 'Sangat Baik' . "\t" . '5'  . "\t" . '' . "\n";
            header("Content-disposition: attachment; filename=" . 'Inventaris_'.$data['dateInvIn'] . '.xls');
        }

    }
}
?>