<?php

namespace App\Controller;
// session_start();

class indexApiController
{

    public static function Login($app, $request, $response, $args)
    {
        // 
        // return var_dump($request->getParsedBody());
        // get the requested data
        $data = $request->getParsedBody();
        // if(isset($_COOKIE['user'])&&isset($_COOKIE['pass'])){
            //     $data =[
                //         $_COOKIE['user'],
                //         $_COOKIE['pass']
                //     ];
                // }
                // return var_dump($_COOKIE);
            // select the user db 
            $verAwal = $app->db->select('tbl_users','*',[
            "AND"=>[
                "OR"=>[
                    "username" => $data["user"],
                    "email" => $data["user"]
                ],
                "password" => $data["pass"]
            ]
        ]);
        // return var_dump($verAwal);
        // if exist, login
        if ($verAwal != null) {
            // return var_dump($verAwal[0]['username']);
            $_SESSION['user'] = $verAwal[0]['first_name'].' '.$verAwal[0]['last_name'];
            $_SESSION['type'] = $verAwal[0]['id_user_type'];
            $_SESSION['id_parent'] = $verAwal[0]['id_user'];

            $_SESSION['isLogin'] = true;
            if(isset($data['remember-me'])){
                //create cookie
                setcookie("user",$data['user'],time()+ (86400 * 30), "/");
                setcookie("pass",$data['pass'],time()+ (86400 * 30), "/");
            }

            return $response->withRedirect('/');
        } //Else if not exist, can't login
        else {
            $_SESSION['notValidate'] = true;
            return $response->withRedirect('/login');
        }
    }

    public static function register($app, $request, $response, $args)
    {
        // 
        // return var_dump($request->getParsedBody());

        // get the requested data
        $data = $request->getParsedBody();
        // select the user db 
        $verAwal = $app->db->select('tbl_users', '*', [
            "OR"=>[
                "username" => $data["user"],
                "email" => $data["email"],
            ]
        ]);
        // return var_dump($verAwal);
        // if exist, can't register
        if ($verAwal != null) {
            $_SESSION['hasData'] = true;
            return $response->withJson(array('success' => true,'hasData'=>true));

        } //Else if not exist, register
        else {
            // return var_dump($verAwal);
            $insert = $app->db->insert('tbl_users', [
                "username" => $data["email"],
                "email" => $data["email"],
                "password" => $data["password"],
                "type" => $data['type']
            ]);
            // $_SESSION['user'] = $data['user'];
            $_SESSION['hasData'] = false;
            $_SESSION['isRegister'] = true;
            return $response->withJson(array('success' => true));
            // return $response->withRedirect('/login');
        }
    }

    public static function logout($app, $request, $response, $args)
    {
        // session_destroy();
        $_SESSION['logout'] = true;
        return $response->withRedirect('/login');
    }
}
