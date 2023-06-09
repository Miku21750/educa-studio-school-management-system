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
        // unset($_SESSION['notLogin']);
        //check if not validate
        $notValidate = isset($_SESSION['notValidate']);
        // unset($_SESSION['notValidate']);
        //check if logout mode
        $logout = isset($_SESSION['logout']);
        // unset($_SESSION['logout']);
        // check if not vericate
        $notVericate = isset($_SESSION['notVericate']);
        
        //check if register mode success
        $isRegister = isset($_SESSION['isRegister']);
        $isValidatingEmail = isset($_SESSION['isValidatingEmail']);
        $changedPass = isset($_SESSION['changedPass']);
        $forgotPassSend = isset($_SESSION['forgotPassSend']);
        // return var_dump($_SESSION);
        // unset($_SESSION['isRegister']);
        $app->view->render($response, 'layout/log.html', [
            'login' => true,
            'notLogin' => $notLogin,
            'logout' => $logout,
            'isRegister' => $isRegister,
            'notValidate' => $notValidate,
            'notVericate'=> $notVericate,
            'isValidatingEmail' => $isValidatingEmail,
            'changedPass' => $changedPass,
            'forgotPassSend'=> $forgotPassSend,
            'cookpie' => $cookpie
        ]);
        session_destroy();
    }

    public static function register($app, $request, $response, $args)
    {
        // Render index view
        $app->view->render($response, 'layout/log.html', [
            'register' => true
        ]);
    }
}
