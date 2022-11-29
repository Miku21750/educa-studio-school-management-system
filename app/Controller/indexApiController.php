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
        // select the user db 
        $verAwal = $app->db->select('tbl_users', '*', [
            "username" => $data["user"],
            "password" => $data["pass"]
        ]);
        // return var_dump($verAwal);
        // if exist, login
        if ($verAwal != null) {
            // return var_dump($verAwal[0]['username']);
            $_SESSION['user'] = $verAwal[0]['username'];
            $_SESSION['type'] = $verAwal[0]['type'];
            return $response->withRedirect('/');
        } //Else if not exist, can't login
        else {
            return var_dump($verAwal . "aaaa");
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
            "username" => $data["email"],
            "email" => $data["email"],
            "password" => $data["password"],
        ]);
        // return var_dump($verAwal);
        // if exist, can't register
        if ($verAwal != null) {
            return $response->withJson(array('success' => true));
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
            $_SESSION['isRegister'] = true;
            return $response->withJson(array('success' => true));
            // return $response->withRedirect('/login');
        }
    }

    public static function logout($app, $request, $response, $args)
    {
        session_destroy();
        $_SESSION['logout'] = true;
        return $response->withRedirect('/login');
    }
}
