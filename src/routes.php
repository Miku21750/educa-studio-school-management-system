<?php

use App\Controller\indexApiController;
use App\Controller\indexViewController;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Medoo\Medoo; //Pindahkan ke conroller nanti
use App\middleware\Auth;
use App\Controller\userViewController;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/login', function (Request $request, Response $response, array $args) use ($container) {
        return indexViewController::login($this, $request, $response, $args);
    });

    $app->get('/register', function (Request $request, Response $response, array $args) use ($container) {
        return indexViewController::register($this, $request, $response, $args);
    });

    $app->get('/logout', function (Request $request, Response $response, array $args) use ($container) {
        return indexApiController::logout($this, $request, $response, $args);
    });


    $app->get('/student', function (Request $request, Response $response, array $args) use ($container) {
        return userViewController::dashboard($this, $request, $response, $args);
    });

    $app->group('/student', function () use ($app) {

        $app->get('/all-students', function (Request $request, Response $response, array $args) use ($app) {
            return userViewController::allStudent($this, $request, $response, $args);
        });

        $app->get('/admit-form', function (Request $request, Response $response, array $args) use ($app) {
            return userViewController::admitForm($this, $request, $response, $args);
        });

        $app->get('/student-details', function (Request $request, Response $response, array $args) use ($app) {
            return userViewController::studentPromotion($this, $request, $response, $args);
        });

        $app->get('/student-promotion', function (Request $request, Response $response, array $args) use ($app) {
            return userViewController::studentPromotion($this, $request, $response, $args);
        });
    });

    $app->group('/api', function () use ($app) {

        $app->post('/login', function (Request $request, Response $response, array $args) use ($app) {
            return indexApiController::Login($this, $request, $response, $args);
        });

        $app->post('/register', function (Request $request, Response $response, array $args) use ($app) {
            return indexApiController::register($this, $request, $response, $args);
        });

        $app->group('/user', function () use ($app) {

            $app->post('/account-setting', function (Request $request, Response $response, array $args) use ($app) {
                return 0;
            });
    
        });

    });
    
    // //student
    // $app->get('/all-students', function (Request $request, Response $response, array $args) use ($container) {
    //     // Render index view
    //     $container->view->render($response, 'students/all-student.html', $args);
    // });
    // $app->get('/student-details', function (Request $request, Response $response, array $args) use ($container) {
    //     // Render index view
    //     $container->view->render($response, 'students/student-details.html', $args);
    // });
    // $app->get('/admit-form', function (Request $request, Response $response, array $args) use ($container) {
    //     // Render index view
    //     $container->view->render($response, 'students/admit-form.html', $args);
    // });
    // $app->get('/student-promotion', function (Request $request, Response $response, array $args) use ($container) {
    //     // Render index view
    //     $container->view->render($response, 'students/student-promotion.html', $args);
    // });

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

    $app->get('/parent', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $container->view->render($response, 'dashboard/parent.html', $args);
    });
    $app->get('/', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $type = $_SESSION['type'];
        // return var_dump($type);
        if ($type == 1) {
            $type = "Student";
            $container->view->render($response, 'dashboard/student.html', [
                'user' => $_SESSION['user'],
                'type' => $type
            ]);
            // return $response->withRedirect('/student');
        }
        if ($type == 2) {
            $type = "Teacher";
            $container->view->render($response, 'dashboard/teacher.html', [
                'user' => $_SESSION['user'],
                'type' => $type
            ]);
        }
        if ($type == 3) {
            $type = "Admin";
            $container->view->render($response, 'dashboard/index.html', [
                'user' => $_SESSION['user'],
                'type' => $type
            ]);
        }
        if ($type == 4) {
            $type = "Parent";
            $container->view->render($response, 'dashboard/parent.html', [
                'user' => $_SESSION['user'],
                'type' => $type
            ]);
        } // else {
        //     // Hapus ini
        //     $type = "Student";
        //     $container->view->render($response, 'dashboard/student.html', [
        //         'user' => $_SESSION['user'],
        //         'type' => $type
        //     ]);
        //     return $response->withRedirect('/student');
        // }
    })->add(new Auth()) ; // Auth Aku Nonaktifkan dulu
};
