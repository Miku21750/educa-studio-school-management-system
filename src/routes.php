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
        $verAwal = $container->db->select('tbl_users', '*', [
            "username" => $data["user"],
            "password" => $data["pass"]
        ]);
        // return var_dump($verAwal);
        // if exist, login
        if ($verAwal != null) {
            // return var_dump($verAwal[0]['username']);
            $_SESSION['user'] = $verAwal[0]['username'];
            return $response->withRedirect('/');
        } //Else if not exist, can't login
        else {
            return var_dump($verAwal . "aaaa");
        }
    });
    //end login

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
        $verAwal = $container->db->select('tbl_users', '*', [
            "username" => $data["user"],
            "password" => $data["pass"]
        ]);
        // if not exist, can't register
        if ($verAwal != null) {
            return var_dump($verAwal . "aaaa");
        } //Else if not exist, register
        else {
            // return var_dump($verAwal);
            $insert = $container->db->insert('tbl_users', [
                "username" => $data['user'],
                "password" => $data['pass']
            ]);
            // $_SESSION['user'] = $data['user'];
            $_SESSION['isRegister'] = true;
            return $response->withRedirect('/login');
        }
    });
    //end Register

    //logout
    $app->get('/logout', function (Request $request, Response $response, array $args) use ($container) {
        session_destroy();
        $_SESSION['logout'] = true;
        return $response->withRedirect('/login');
    });
    //end Logout 

    //student
    $app->get('/all-students', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'students/all-student.html', $args);
    });
    $app->get('/student-details', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'students/student-details.html', $args);
    });
    $app->get('/admit-form', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'students/admit-form.html', $args);
    });
    $app->get('/student-promotion', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'students/student-promotion.html', $args);
    });
    //end Student

    //Teacher
    $app->get('/all-teacher', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'teacher/all-teacher.html', $args);
    });
    $app->get('/teacher-details', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'teacher/teacher-details.html', $args);
    });
    $app->get('/add-teacher', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'teacher/add-teacher.html', $args);
    });
    $app->get('/teacher-payment', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'teacher/teacher-payment.html', $args);
    });
    //end Teacher 

    //Parent
    $app->get('/all-parents', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'parents/all-parents.html', $args);
    });
    $app->get('/parents-details', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'parents/parents-details.html', $args);
    });
    $app->get('/add-parents', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'parents/add-parents.html', $args);
    });
    //end Parent

    //Book
    $app->get('/all-book', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'library/all-book.html', $args);
    });
    $app->get('/add-book', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'library/add-book.html', $args);
    });
    //end Book

    //Acconunt
    $app->get('/all-fees', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'acconunt/all-fees.html', $args);
    });
    $app->get('/all-expense', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'acconunt/all-expense.html', $args);
    });
    $app->get('/add-expense', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'acconunt/add-expense.html', $args);
    });
    //end Acconunt

    //Class
    $app->get('/all-class', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'class/all-class.html', $args);
    });
    $app->get('/add-class', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'class/add-class.html', $args);
    });
    //end Class

    //Subject 
    $app->get('/all-subject', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'others/all-subject.html', $args);
    });
    //End Subject

    //Class Routine
    $app->get('/class-routine', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'others/class-routine.html', $args);
    });
    //End Class Routine

    //Attendance
    $app->get('/student-attendence', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'others/student-attendence.html', $args);
    });
    //End Attendance

    //Exam
    $app->get('/exam-schedule', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'others/exam/exam-schedule.html', $args);
    });
    $app->get('/exam-grade', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'others/exam/exam-grade.html', $args);
    });
    //End Exam

    //Transport 
    $app->get('/transport', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'others/transport.html', $args);
    });
    //End Transport

    //Hostel
    $app->get('/hostel', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'others/hostel.html', $args);
    });
    //End Hostel

    //notice
    $app->get('/notice-board', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'others/notice-board.html', $args);
    });
    // End Notice

    // Message
    $app->get('/messaging', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'others/messaging.html', $args);
    });
    // End Message

    // Map
    $app->get('/map', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'others/map.html', $args);
    });
    // End Map

    // Account
    $app->get('/account-settings', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'others/account-settings.html', $args);
    });
    // End Account

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
