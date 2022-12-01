<?php

namespace App\Controller;
// session_start();

class indexViewController
{

    public static function login($app, $request, $response, $args)
    {
        // check if access to the index but without login 
        // return var_dump(isset($_COOKIE['user']) && isset($_COOKIE['pass']));
        $cookpie = null;
        
        if(isset($_COOKIE['user']) && isset($_COOKIE['pass'])){
            $usercook = $_COOKIE['user'];
            $passcook = $_COOKIE['pass'];
            $cookpie = [
                'user'=>$usercook,
                'pass'=>$passcook
            ];
        }
        // return var_dump($cookpie);
        $notLogin = isset($_SESSION['notLogin']);
        unset($_SESSION['notLogin']);
        //check if not validate
        $notValidate = isset($_SESSION['notValidate']);
        unset($_SESSION['notValidate']);
        //check if logout mode
        $logout = isset($_SESSION['logout']);
        // unset($_SESSION['logout']);
        //check if register mode success
        $isRegister = isset($_SESSION['isRegister']);
        unset($_SESSION['isRegister']);
        $isValidatingEmail = isset($_SESSION['isValidatingEmail']);
        unset($_SESSION['isValidatingEmail']);
        $changedPass = isset($_SESSION['changedPass']);
        unset($_SESSION['changedPass']);
        $forgotPassSend = isset($_SESSION['forgotPassSend']);
        unset($_SESSION['forgotPassSend']);

        
        session_destroy();
        // unset($_SESSION['isRegister']);
        $app->view->render($response, 'layout/log.html', [
            'login' => true,
            'notLogin' => $notLogin,
            'logout' => $logout,
            'isRegister' => $isRegister,
            'notValidate' => $notValidate,
            'isValidatingEmail' => $isValidatingEmail,
            'changedPass' => $changedPass,
            'forgotPassSend'=> $forgotPassSend,
            'cookpie' => $cookpie
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
