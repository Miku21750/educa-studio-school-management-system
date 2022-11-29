<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Medoo\Medoo; //Pindahkan ke conroller nanti
use App\middleware\Auth;

return function (App $app) {
    $container = $app->getContainer();
    // login
    $app->get('/login', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $notLogin = isset($_SESSION['notLogin']);
        unset($_SESSION['notLogin']);
        $logout = isset($_SESSION['logout']);
        // return var_dump($_SESSION);
        unset($_SESSION['logout']);
        $isRegister = isset($_SESSION['isRegister']);
        // unset($_SESSION['isRegister']);
        $container->view->render($response, 'layout/log.html', [
            'login' => true,
            'notLogin' => $notLogin,
            'logout' => $logout,
            'isRegister' => $isRegister
        ]);
    });
    $app->post('/login', function (Request $request, Response $response, array $args) use ($container) {
        // 
        // return var_dump($request->getParsedBody());
        
        // get the requested data
        $data = $request->getParsedBody();
        // select the user db 
        $verAwal = $container->db->select('tbl_users','*',[
            "username"=>$data["user"],
            "password"=>$data["pass"]
        ]);
        // return var_dump($verAwal);
        // if exist, login
        if($verAwal != null){
            // return var_dump($verAwal[0]['username']);
            $_SESSION['user'] = $verAwal[0]['username'];
            return $response->withRedirect('/');
        } //Else if not exist, can't login
        else{
            return var_dump($verAwal . "aaaa");
        }
    });

    //Register
    $app->get('/register', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'layout/log.html', [
            'register' => true
        ]);
    });
    $app->post('/register', function (Request $request, Response $response, array $args) use ($container) {
        // 
        // return var_dump($request->getParsedBody());
        
        // get the requested data
        $data = $request->getParsedBody();
        // select the user db 
        $verAwal = $container->db->select('tbl_users','*',[
            "username"=>$data["user"],
            "password"=>$data["pass"]
        ]);
        // if not exist, can't register
        if($verAwal != null){
            return var_dump($verAwal . "aaaa");
        } //Else if not exist, register
        else{
            // return var_dump($verAwal);
            $insert = $container->db->insert('tbl_users',[
                "username"=>$data['user'],
                "password"=>$data['pass']
            ]);
            // $_SESSION['user'] = $data['user'];
            $_SESSION['isRegister'] = true;
            return $response->withRedirect('/login');
        }
    });

    //logout
    $app->get('/logout', function (Request $request, Response $response, array $args) use ($container) {
        session_destroy();
        $_SESSION['logout'] = true;
        return $response->withRedirect('/login');
    });

    // Dashboard
    $app->get('/teacher', function (Request $request, Response $response, array $args) use ($container) {
        

        // Render index view
        $container->view->render($response, 'dashboard/teacher.html', $args);
    });
    $app->get('/student', function (Request $request, Response $response, array $args) use ($container) {
       

       // Render index view
        $container->view->render($response, 'dashboard/student.html', $args);
    });
    $app->get('/parent', function (Request $request, Response $response, array $args) use ($container) {
     

        // Render index view
        $container->view->render($response, 'dashboard/parent.html', $args);
    });
    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        
        $container->view->render($response, 'dashboard/index.html', [
            'user' => $_SESSION['user']
        ]);
    })->add(new Auth());
   
};
