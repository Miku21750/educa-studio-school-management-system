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
}
?>