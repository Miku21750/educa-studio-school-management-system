<?php

use Slim\App;
use Medoo\Medoo;
use App\Controller\DbController;

return function (App $app) {
    $container = $app->getContainer();

    // view renderer
    $container['renderer'] = function ($c) {
        $settings = $c->get('settings')['renderer'];
        return new \Slim\Views\PhpRenderer($settings['template_path']);
    };

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };
    
    // add upload dir
    $container['upload_directory'] = getcwd() . '/uploads/Profile';

    //add db public
    // return var_dump($_SESSION);
    if(isset($_SESSION['user'])){
        $container['auth'] = function ($app) {
            // Add message for navbar
            $message = $app->db->select('tbl_messages(m)', [
                '[>]tbl_users' => 'id_user'
            ], [
                'id_message',
                'totalMessage'=> Medoo::raw("(SELECT COUNT(id_message) FROM `tbl_messages` AS `m` LEFT JOIN `tbl_users` USING (`id_user`) WHERE username = '".$_SESSION['username']."' AND readed = 0)"),
                'id_user',
                'receiver_email',
                'sender_email',
                'title',
                'message',
                'readed',
                'photo_sender'=>Medoo::raw('(SELECT photo_user FROM tbl_users WHERE email = m.sender_email)'),
                'first_name_sender'=>Medoo::raw('(SELECT first_name FROM tbl_users WHERE email = m.sender_email)'),
                'last_name_sender'=>Medoo::raw('(SELECT last_name FROM tbl_users WHERE email = m.sender_email)'),
                'time_sended'
            ], 
            // [
            //     'username' => $_SESSION['username'],
            //     // "HAVING" => [
            //         'time_sendedr' => Medoo::raw('CAST(CURRENT_TIMESTAMP AS DATE)')
            //     // ]

            // ]
            Medoo::raw("WHERE
            username = '".$_SESSION['username']."'
            AND
            ((CAST(time_sended AS DATE) = CURRENT_DATE) OR readed = 0)
            ORDER BY time_sended DESC
            ")
        );
            // return die(var_dump($message));
            return $message;

            //countMessage
        };
        $container['notif'] = function ($app) {
            $dataNotice = $app->db->select('tbl_notifications', [
                'totalNotif'=> Medoo::raw("(SELECT COUNT(id_notification) FROM `tbl_notifications` AS `m` WHERE date_notice BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW())"),
                'id_notification',
                'title',
                'details',
                'posted_by',
                'date_notice',
                'terbaca',
                'category'
            ], 
            Medoo::raw("WHERE
            date_notice BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW() 
            ORDER BY `id_notification` DESC")
        );
            // return die(var_dump($dataNotice));
            return $dataNotice;
            //countMessage
        };

    };

    $container['view'] = function ($container) {
        $view = new \Slim\Views\Twig('../templates', [
            'cache' => false
        ]);
        //add global session
        $environment = $view->getEnvironment();
        $environment->addGlobal('session', $_SESSION);
        if(isset($_SESSION['user'])){
            $environment->addGlobal('auth', $container->auth);
            $environment->addGlobal('notif', $container->notif);
        }
        // return var_dump(auth);


        $router = $container->get('router');
        $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
        $view->addExtension(new \Slim\Views\TwigExtension($router, $uri));

        return $view;
    };

    // Konfigurasi Medoo 
    $container['db'] = function($c){
        $database = new Medoo([
            'database_type' => 'mysql',
            'server' => '127.0.0.1',
            'database_name' => 'educa_db',
            'username' => 'root',
            'password' => '',
        ]);
        return $database;
    };
    // $container['db'] = function($c){
    //     $database = new Medoo([
    //         'database_type' => 'mysql',
    //         'server' => '103.150.196.234',
    //         'port' => '33090',
    //         'database_name' => 'educa_db',
    //         'username' => 'educational_purpose_user',
    //         'password' => '{%login=true%}',
    //     ]);
    //     return $database;
    // };

};
