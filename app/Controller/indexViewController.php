<?php

namespace App\Controller;
// session_start();

class indexViewController
{

    public static function login($app, $request, $response, $args)
    {
        // Render index view
        $notLogin = isset($_SESSION['notLogin']);
        unset($_SESSION['notLogin']);
        $logout = isset($_SESSION['logout']);
        // return var_dump($_SESSION);
        // return var_dump($_SESSION);
        // unset($_SESSION['logout']);
        $isRegister = isset($_SESSION['isRegister']);
        
        session_destroy();
        // unset($_SESSION['isRegister']);
        $app->view->render($response, 'layout/log.html', [
            'login' => true,
            'notLogin' => $notLogin,
            'logout' => $logout,
            'isRegister' => $isRegister
        ]);
    }

    public static function register($app, $request, $response, $args)
    {
        // Render index view
        $app->view->render($response, 'layout/log.html', [
            'register' => true
        ]);
    }
}
