<?php

use App\Controller\DashboardStudentController;
use App\Controller\indexApiController;
use App\Controller\indexViewController;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Medoo\Medoo; //Pindahkan ke conroller nanti
use App\middleware\Auth;
use App\Controller\userViewController;
use App\Controller\DashbordParentController;
use App\Controller\dashboardAdminController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



return function (App $app) {
    $container = $app->getContainer();

    $app->get(
        '/login',
        function (Request $request, Response $response, array $args) use ($container) {
            return indexViewController::login($this, $request, $response, $args);
        }
    );

    $app->get(
        '/register',
        function (Request $request, Response $response, array $args) use ($container) {
            return indexViewController::register($this, $request, $response, $args);
        }
    );

    $app->get(
        '/logout',
        function (Request $request, Response $response, array $args) use ($container) {
            return indexApiController::logout($this, $request, $response, $args);
        }
    );


    // $app->get(
    //     '/student',
    //     function (Request $request, Response $response, array $args) use ($container) {
    //         return userViewController::dashboard($this, $request, $response, $args);
    //     }
    // );

    $app->group(
        '/student',
        function () use ($app) {

            $app->get(
                '/all-students',
                function (Request $request, Response $response, array $args) use ($app) {
                    return userViewController::allStudent($this, $request, $response, $args);
                }
            );

            $app->get(
                '/admit-form',
                function (Request $request, Response $response, array $args) use ($app) {
                    return userViewController::admitForm($this, $request, $response, $args);
                }
            );

            $app->get(
                '/student-details',
                function (Request $request, Response $response, array $args) use ($app) {
                    return userViewController::studentPromotion($this, $request, $response, $args);
                }
            );

            $app->get(
                '/student-promotion',
                function (Request $request, Response $response, array $args) use ($app) {
                    return userViewController::studentPromotion($this, $request, $response, $args);
                }
            );
        }
    )->add(new Auth());

    $app->group(
        '/api',
        function () use ($app) {

            $app->post(
                '/login',
                function (Request $request, Response $response, array $args) use ($app) {
                    return indexApiController::Login($this, $request, $response, $args);
                }
            );

            $app->post(
                '/register',
                function (Request $request, Response $response, array $args) use ($app) {
                    return indexApiController::register($this, $request, $response, $args);
                }
            );

            $app->group(
                '/user',
                function () use ($app) {
                    $app->post(
                        '/account-setting',
                        function (Request $request, Response $response, array $args) use ($app) {
                            return 0;
                        }
                    );
                }
            );


            $app->group(
                '/admin',
                function () use ($app) {

                    $app->get(
                        '/apidata',
                        function (Request $request, Response $response, array $args) use ($app) {
                            return DashboardAdminController::apiData($this, $request, $response, $args);;
                        }
                    );
                }
            );

            $app->get('/{id}/select', function (Request $request, Response $response, array $args) use ($app) {
                $data = $args['id'];
                return DashbordParentController::tampil_data($this, $request, $response, [
                    'data' => $data
                ]);
            });
            $app->get('/{id}/result', function (Request $request, Response $response, array $args) use ($app) {
                $data = $args['id'];
                return DashbordParentController::tampil_data_result($this, $request, $response, [
                    'data' => $data
                ]);
            });
        }
    );


    // verification email start here
    $app->get(
        '/verifEmail',
        function (Request $request, Response $response, array $args) use ($container) {
            // return var_dump($request->getParams());
            $data = $request->getParams();
            // return var_dump($data);
            $container->db->update('tbl_users', [
                "status" => 1
            ], [
                "id_user" => $data['key']
            ]);
            unset($_SESSION['isRegistered']);
            $_SESSION['isValidatingEmail'] = true;
            return $response->withRedirect('/login');
            // echo "<p>Sukses verifikasi, <a href='/login'>Silahkan Login</a></p>";
            // $data = $request->getParams();

        }
    );
    // verification email end here

    // Forgot Password start here
    $app->post(
        '/forgotPass',
        function (Request $request, Response $response, array $args) use ($container) {
            $data = $request->getParsedBody();
            $Valid = $container->db->select('tbl_users', ['id_user', 'email', 'password'], [
                'email' => $data['email']
            ]);
            $isValid = $Valid[0];
            // return var_dump($isValid);
            // $link = "<a href='localhost:8200/forgotPass?key=" . $isValid['id_user'] . "'>Click to reset Pass</a>";
            $mail = new PHPMailer;
            //Memberi tahu PHPMailer untuk menggunakan SMTP
            $mail->isSMTP();
            //Mengaktifkan SMTP debugging
            // 0 = off (digunakan untuk production)
            // 1 = pesan client
            // 2 = pesan client dan server
            $mail->SMTPDebug = 2;
            //HTML-friendly debug output
            $mail->Debugoutput = 'html';
            //hostname dari mail server
            $mail->Host = 'smtp.gmail.com';
            // gunakan
            // $mail->Host = gethostbyname('smtp.gmail.com');
            // jika jaringan Anda tidak mendukung SMTP melalui IPv6
            //Atur SMTP port - 587 untuk dikonfirmasi TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 587;
            //Set sistem enkripsi untuk menggunakan - ssl (deprecated) atau tls
            $mail->SMTPSecure = 'tls';
            //SMTP authentication
            $mail->SMTPAuth = true;
            //Username yang digunakan untuk SMTP authentication - gunakan email gmail
            $mail->Username = "rafaelfarizi1@gmail.com";
            //Password yang digunakan untuk SMTP authentication
            $mail->Password = "dqwuvxffdphlgdml";
            //Email pengirim
            $mail->setFrom('rafaelfarizi1@gmail.com', 'Miku21 Margareth');
            //  //Alamat email alternatif balasan
            //  $mail->addReplyTo('balasemailke@example.com', 'First Last');
            //Email tujuan
            $mail->addAddress($isValid['email']);
            //Subject email
            $mail->Subject = 'PHPMailer GMail SMTP test';
            //Membaca isi pesan HTML dari file eksternal, mengkonversi gambar yang di embed,
            //Mengubah HTML menjadi basic plain-text
            //  $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
            //Replace plain text body dengan cara manual
            $mail->Body = '<a href="http://localhost:8200/changePass?key=' . $isValid['id_user'] . '&email=' . $isValid['email'] . '">Klik link ini untuk ganti password</a>';
            $mail->AltBody = 'This is a plain-text message body';
            //Attach file gambar
            //  $mail->addAttachment('images/phpmailer_mini.png');
            //mengirim pesan, mengecek error

            if (!$mail->send()) {
                echo "Email Error: " . $mail->ErrorInfo;
            } else {
                $_SESSION['forgotPassSend'] = true;

                return $response->withRedirect('/login');
            }
        }
    );
    $app->get(
        '/changePass',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            // return var_dump($request->getParams());
            $data = $request->getParams();
            $container->view->render($response, 'layout/log.html', [
                'key' => $data['key'],
                'isReset' => true
            ]);
        }
    );
    $app->post(
        '/changePass',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $data = $request->getParsedBody();
            // return var_dump($data);
            if ($data['pass'] == $data['pass2']) {
                $changePass = $container->db->update('tbl_users', [
                    'password' => $data['pass']
                ], [
                    'id_user' => $data['id_user']
                ]);
                $_SESSION['changedPass'] = true;
                // return var_dump(true);
                return $response->withRedirect('/login');
            } else {
                return $container->view->render($response, 'layout/log.html', [
                    'key' => $data['key'],
                    'isReset' => true,
                    'notValidChanged' => true
                ]);
                // return var_dump(false);
            }
            // $container->view->render($response, 'layout/log.html', [
            //     'key'=>$data['key'],
            //     'isReset'=> true
            // ]);
        }
    );
    // Forgot Password end here
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
    $app->get(
        '/all-teacher',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'teacher/all-teacher.html', $args);
        }
    );
    $app->get(
        '/teacher-details',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'teacher/teacher-details.html', $args);
        }
    );
    $app->get(
        '/add-teacher',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'teacher/add-teacher.html', $args);
        }
    );
    $app->get(
        '/teacher-payment',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'teacher/teacher-payment.html', $args);
        }
    );
    //end Teacher 

    //Parent
    $app->get(
        '/all-parents',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'parents/all-parents.html', $args);
        }
    );
    $app->get(
        '/parents-details',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'parents/parents-details.html', $args);
        }
    );
    $app->get(
        '/add-parents',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'parents/add-parents.html', $args);
        }
    );
    //end Parent

    //Book
    $app->get(
        '/all-book',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'library/all-book.html', $args);
        }
    );
    $app->get(
        '/add-book',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'library/add-book.html', $args);
        }
    );
    //end Book

    //Acconunt
    $app->get(
        '/all-fees',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'acconunt/all-fees.html', $args);
        }
    );
    $app->get(
        '/all-expense',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'acconunt/all-expense.html', $args);
        }
    );
    $app->get(
        '/add-expense',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'acconunt/add-expense.html', $args);
        }
    );
    //end Acconunt

    //Class
    $app->get(
        '/all-class',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'class/all-class.html', $args);
        }
    );
    $app->get(
        '/add-class',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'class/add-class.html', $args);
        }
    );
    //end Class

    //Subject 
    $app->get(
        '/all-subject',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'others/all-subject.html', $args);
        }
    );
    //End Subject

    //Class Routine
    $app->get(
        '/class-routine',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'others/class-routine.html', $args);
        }
    );
    //End Class Routine

    //Attendance
    $app->get(
        '/student-attendence',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'others/student-attendence.html', $args);
        }
    );
    //End Attendance

    //Exam
    $app->get(
        '/exam-schedule',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'others/exam/exam-schedule.html', $args);
        }
    );
    $app->get(
        '/exam-grade',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'others/exam/exam-grade.html', $args);
        }
    );
    //End Exam

    //Transport 
    $app->get(
        '/transport',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'others/transport.html', $args);
        }
    );
    //End Transport

    //Hostel
    $app->get(
        '/hostel',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'others/hostel.html', $args);
        }
    );
    //End Hostel

    //notice
    $app->get(
        '/notice-board',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'others/notice-board.html', $args);
        }
    );
    // End Notice

    // Message
    $app->get(
        '/messaging',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'others/messaging.html', $args);
        }
    );
    // End Message

    // Map
    $app->get(
        '/map',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'others/map.html', $args);
        }
    );
    // End Map

    // Account
    $app->get(
        '/account-settings',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'others/account-settings.html', $args);
        }
    );
    // End Account

    // Dashboard
    // $app->get(
    //     '/teacher',
    //     function (Request $request, Response $response, array $args) use ($container) {
    //         // Render index view
    //         $container->view->render($response, 'dashboard/teacher.html', $args);
    //     }
    // );


    // $app->get('/parent', function (Request $request, Response $response, array $args) use ($container) {
    //     // Render index view
    //     $container->view->render($response, 'dashboard/parent.html', $args);
    // });
    // $app->get(
    //     '/',
    //     function (Request $request, Response $response, array $args) use ($container) {
    //         // Render index view
    //         $type = $_SESSION['type'];
    //         // return var_dump($type);
    //         if ($type == 1) {
                
    //         }
    //     }
    // );
    $app->get(
        '/',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $type = $_SESSION['type'];
            // return var_dump($type);
            // return var_dump($_COOKIE);
            if ($type == 1) {
                $type = "Student";
                $id_student = $_SESSION['id_user'];
                $id_student = 'id_user';
                // $container->view->render($response, 'dashboard/student.html', [
                //     'user' => $_SESSION['user'],
                //     'type' => $type
                // ]);
                // return $response->withRedirect('/student');
                return DashboardStudentController::view_data_student($this, $request, $response, [
                    'user' => $_SESSION['user'],
                    'username' => $_SESSION['username'],
                    'type' => $type,
                    'id_student' => $id_student
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
                return DashboardAdminController::getData($this, $request, $response, [
                    'user' => $_SESSION['user'],
                    'type' => $type,
                ]);
            }
            if ($type == 4) {
                $type = "Parent";
                $id_parent = $_SESSION['id_parent'];

                return DashbordParentController::index($this, $request, $response, [
                    'user' => $_SESSION['user'],
                    'type' => $type,
                    'id_parent' => $id_parent,
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
        }
    )->add(new Auth()); // Auth Aku Nonaktifkan dulu
};
