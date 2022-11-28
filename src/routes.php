<?php

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

return function (App $app) {
    $container = $app->getContainer();
    // login
    $app->get('/login', function (Request $request, Response $response, array $args) use ($container) {
        

        // Render index view
        $container->view->render($response, 'layout/log.html', $args);
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
        $container->view->render($response, 'dashboard/index.html', $args);
    });
   
};
