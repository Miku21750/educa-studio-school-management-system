<?php

namespace App\Controller;

class DashbordParentConroller
{

    public static function index($app, $request, $response, $args)
    {
        $user = $args['user'];
        $type = $args['type'];
        $id_parent = $args['id_parent'];

        // $data = $app->db->select('tbl_users', [
        //     "[><]tbl_finances" => "id_user"
        // ], '*',[
        //     "id_parent" => $id_parent,
        //     'status' => "BELUM BAYAR"
        // ]);

        $totaldata = $app->db->sum('tbl_users', [
            "[><]tbl_finances" => "id_user"
        ], 'amount_payment',[
            "id_parent" => $id_parent,
            'status' => "BELUM BAYAR"
        ]);
        // var_dump($totaldata);

        $app->view->render($response, 'dashboard/parent.html', [
            'totaldata' => $totaldata,
            'user' => $user,
            'type' => $type,
            'user' => $user
        ]);
    }


}

?>
