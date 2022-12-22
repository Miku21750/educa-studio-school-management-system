<?php

use App\Controller\ClassController;
use App\Controller\ClassRoutineController;
use App\Controller\DashboardAdminController;
use App\Controller\DashboardStudentController;
use App\Controller\DashboardTeacherController;
use App\Controller\DashbordParentController; //Pindahkan ke conroller nanti
use App\Controller\ExamController;
use App\Controller\HostelController;
use App\Controller\indexApiController; //Pindahkan ke conroller nanti
use App\Controller\indexViewController;
use App\Controller\LibraryController;
use App\Controller\ParentController;
use App\Controller\StudentController;
use App\Controller\SubjectController;
use App\Controller\TeacherController;
use App\Controller\TransportController;
use App\middleware\Auth;
use Medoo\Medoo;
use PHPMailer\PHPMailer\PHPMailer;
use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;
use App\Controller\AcconuntController;
use App\Controller\UserCredentialController;

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

    // All Student
    // $app->get(
    //     '/all-students',
    //     function (Request $request, Response $response, array $args) use ($container) {
    //         return DashboardStudentController::allStudent($this, $request, $response, $args);
    //     }
    // )->add(new Auth());

    // // admit form student
    // $app->get(
    //     '/admit-form',
    //     function (Request $request, Response $response, array $args) use ($container) {
    //         return DashboardStudentController::admitForm($this, $request, $response, $args);
    //     }
    // )->add(new Auth());

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
                        $app->post(
                            '/update-password',
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
                                            return DashboardAdminController::apiData($this, $request, $response, $args);
                                            ;
                                        }
                        );

                        $app->get(
                            '/chart',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return DashboardAdminController::lineChart($this, $request, $response, $args);
                                            ;
                                        }
                        );
                    }
            );

            $app->group(
                '/kelas',
                function () use ($app) {

                        $app->post(
                            '/tambah-kelas',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return $response->withJson(ClassController::insertClassMod($this, $request, $response, $args));
                                        }
                        );

                        $app->post(
                            '/hapus-kelas',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return ClassController::deleteClassMod($this, $request, $response, [
                                                'data' => $data
                                            ]);
                                        }
                        );

                        $app->get(
                            '/getallclassdt',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return ClassController::getAllClassDt($this, $request, $response, $args);
                                        }
                        );

                        $app->get(
                            '/getallclassS',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return ClassController::getAllClassS($this, $request, $response, $args);
                                        }
                        );

                        $app->get(
                            '/{id}detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $args['id'];
                                            // return var_dump($data);
                                            return ClassController::modal_detail($this, $request, $response, [
                                                'data' => $data
                                            ]);
                                        }
                        );
                        $app->post(
                            '/updateclass',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return ClassController::update_kelas_detail($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );
                    }
            );

            $app->group(
                '/library',
                function () use ($app) {

                        $app->get(
                            '/getBook',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return LibraryController::tampil_data($this, $request, $response, $args);
                                        }
                        );

                        $app->get(
                            '/getBookS',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return LibraryController::tampil_dataS($this, $request, $response, $args);
                                        }
                        );

                        $app->get(
                            '/{id}/book-detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $args['id'];
                                            // return var_dump($data);
                                            return LibraryController::detail($this, $request, $response, [
                                                'data' => $data
                                            ]);
                                        }
                        );

                        $app->post(
                            '/update-book-detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return LibraryController::update_book_detail($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );

                        $app->post(
                            '/delete-book',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return LibraryController::delete($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );

                        $app->post(
                            '/add-book',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return LibraryController::add_book($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );
                    }
            );

            $app->group(
                '/subject',
                function () use ($app) {
                        $app->get(
                            '/{id}/subject-detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $args['id'];
                                            // return var_dump($data);
                                            return SubjectController::detail($this, $request, $response, $data);
                                        }
                        );
                    }
            );

            $app->group(
                '/class-routine',
                function () use ($app) {
                        $app->get(
                            '/{id}/class-routine-detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $args['id'];
                                            return ClassRoutineController::detail($this, $request, $response, $data);
                                        }
                        );
                    }
            );

            $app->group(
                '/transport',
                function () use ($app) {

                        $app->get(
                            '/getTransport',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return TransportController::tampil_data($this, $request, $response, $args);
                                        }
                        );

                        $app->get(
                            '/getTransportS',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return TransportController::tampil_dataS($this, $request, $response, $args);
                                        }
                        );

                        $app->get(
                            '/{id}/transport-detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $args['id'];
                                            // return var_dump($data);
                                            return TransportController::detail($this, $request, $response, $data);
                                        }
                        );

                        $app->post(
                            '/update-transport-detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return TransportController::update_transport_detail($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );

                        $app->post(
                            '/delete-transport',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return TransportController::delete($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );

                        $app->post(
                            '/add-transport',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return TransportController::add_transport($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );
                    }
            );

            $app->group(
                '/hostel',
                function () use ($app) {

                        $app->get(
                            '/getHostel',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return HostelController::tampil_data($this, $request, $response, $args);
                                        }
                        );

                        $app->get(
                            '/getHostelS',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return HostelController::tampil_dataS($this, $request, $response, $args);
                                        }
                        );

                        $app->get(
                            '/{id}/hostel-detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $args['id'];
                                            // return var_dump($data);
                                            return HostelController::detail($this, $request, $response, $data);
                                        }
                        );

                        $app->post(
                            '/update-hostel-detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return HostelController::update_hostel_detail($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );

                        $app->post(
                            '/delete-hostel',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return HostelController::delete($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );

                        $app->post(
                            '/add-hostel',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return HostelController::add_hostel($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );
                    }
            );

            $app->group(
                '/exam',
                function () use ($app) {

                        $app->get(
                            '/getExam',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return ExamController::tampil_data($this, $request, $response, $args);
                                        }
                        );

                        $app->get(
                            '/getExamS',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return ExamController::tampil_dataS($this, $request, $response, $args);
                                        }
                        );

                        $app->get(
                            '/getExamGrade',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return ExamController::tampil_data_grade($this, $request, $response, $args);
                                        }
                        );

                        $app->get(
                            '/getExamGradeS',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return ExamController::tampil_data_gradeS($this, $request, $response, $args);
                                        }
                        );

                        $app->get(
                            '/{id}/exam-detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $args['id'];
                                            // return var_dump($data);
                                            return ExamController::detail($this, $request, $response, $data);
                                        }
                        );

                        $app->get(
                            '/{id}/grade-detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $args['id'];
                                            // return var_dump($data);
                                            return ExamController::grade_detail($this, $request, $response, $data);
                                        }
                        );

                        $app->post(
                            '/update-exam-detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return ExamController::update_exam_detail($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );

                        $app->post(
                            '/update-grade-detail',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return ExamController::update_grade_detail($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );

                        $app->post(
                            '/delete-exam',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return ExamController::delete($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );

                        $app->post(
                            '/add-exam',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return var_dump($data);
                                            return ExamController::add_exam($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );
                        $app->post(
                            '/add-exam-result',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            $data = $request->getParsedBody();
                                            // return die(var_dump($data));
                                            return ExamController::add_exam_result($this, $request, $response, [
                                                'data' => $data,
                                            ]);
                                        }
                        );
                    }
            );

            $app->group(
                '/student',
                function () use ($app) {
                        $app->get(
                            '/apidata',
                            function (Request $request, Response $response, array $args) use ($app) {
                                            return DashboardStudentController::apiDataM($this, $request, $response, $args);
                                        }
                        );
                    }
            );
            $app->get(
                '/{id}/examResult',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $args['id'];
                        return DashboardStudentController::view_data_exam($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );

            $app->get(
                '/{id}/select',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $args['id'];
                        return DashbordParentController::tampil_data($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->get(
                '/{id}/result',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $args['id'];
                        return DashbordParentController::tampil_data_result($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->get(
                '/allparents',
                function (Request $request, Response $response, array $args) use ($app) {
                        return ParentController::tampil_data($this, $request, $response, $args);
                    }
            );
            $app->get(
                '/allsubject',
                function (Request $request, Response $response, array $args) use ($app) {
                        return SubjectController::view_data_subject($this, $request, $response, $args);
                    }
            );
            $app->post(
                '/addsubject',
                function (Request $request, Response $response, array $args) use ($app) {
                        $tambah = $request->getParsedBody();
                        return SubjectController::add_subject($this, $request, $response, [
                            'tambah' => $tambah,
                        ]);
                    }
            );
            $app->post(
                '/deletesubject',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return SubjectController::delete_subject($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->post(
                '/updatesubject',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return SubjectController::update_subject($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->get(
                '/allclassroutine',
                function (Request $request, Response $response, array $args) use ($app) {
                        return $response->withJson(ClassRoutineController::view_data_classroutine($this, $request, $response, $args));
                    }
            );
            $app->get(
                '/allclassroutine1',
                function (Request $request, Response $response, array $args) use ($app) {
                        return $response->withJson(ClassRoutineController::view_data_classroutine1($this, $request, $response, $args));
                    }
            );
            $app->get(
                '/allclassroutineguru',
                function (Request $request, Response $response, array $args) use ($app) {
                        return $response->withJson(ClassRoutineController::view_data_classroutineguru($this, $request, $response, $args));
                    }
            );
            $app->post(
                '/addclassroutine',
                function (Request $request, Response $response, array $args) use ($app) {
                    $tambah = $request->getParsedBody();
                    // die(var_dump($tambah));
                    return ClassRoutineController::add_class_routine($this, $request, $response, [
                        'tambah' => $tambah,
                    ]);
                }
            );
            $app->post(
                '/deleteclassroutine',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return ClassRoutineController::delete_class_routine($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            $app->post(
                '/updateclassroutine',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return ClassRoutineController::update_class_routine($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            $app->get(
                '/{id}/detail',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $args['id'];
                        // return var_dump($data);
                        return ParentController::detail($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->get(
                '/parent-detail/{id}',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $args['id'];
                        // return var_dump($data);
                        return ParentController::parent_detail($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->post(
                '/update-parent-detail',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return ParentController::update_parent_detail($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->post(
                '/delete-parent',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return ParentController::delete($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->post(
                '/add-parent',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return ParentController::add_parent($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->get(
                '/dashboard-teacher',
                function (Request $request, Response $response, array $args) use ($app) {
                        return DashboardTeacherController::tampil_data($this, $request, $response, $args);
                    }
            );
            $app->get(
                '/allstudents',
                function (Request $request, Response $response, array $args) use ($app) {
                        return StudentController::tampil_data($this, $request, $response, $args);
                    }
            );
            $app->get(
                '/all-alumni',
                function (Request $request, Response $response, array $args) use ($app) {
                        return StudentController::tampil_alumni($this, $request, $response, $args);
                    }
            );
            $app->post(
                '/delete-student',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return StudentController::delete($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->get(
                '/student-detail/{id}',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $args['id'];
                        // return var_dump($data);
                        return StudentController::student_detail($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->post(
                '/update-student-detail',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return StudentController::update_student_detail($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->post(
                '/add-student',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return StudentController::add_student($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->post(
                '/add-promotion',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return StudentController::add_promotion($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->POST(
                '/admission/{id}',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $args['id'];
                        // return var_dump($data);
                        return StudentController::add_admission($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->get(
                '/allteachers',
                function (Request $request, Response $response, array $args) use ($app) {

                        return TeacherController::tampil_data($this, $request, $response, $args);
                    }
            );
            $app->get(
                '/teacher_detail/{id}',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $args['id'];
                        // return var_dump($data);
                        return TeacherController::teacher_detail($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->post(
                '/delete-teacher',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return TeacherController::delete($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->post(
                '/update-teacher-detail',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return TeacherController::update_teacher_detail($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->post(
                '/add-teacher',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return TeacherController::add_teacher($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->get(
                '/allpayment',
                function (Request $request, Response $response, array $args) use ($app) {

                        return TeacherController::tampil_data_payment($this, $request, $response, $args);
                    }
            );
            $app->get(
                '/allpayment-teacher',
                function (Request $request, Response $response, array $args) use ($app) {

                        return TeacherController::tampil_data_payment_teacher($this, $request, $response, $args);
                    }
            );
            $app->get(
                '/allfees',
                function (Request $request, Response $response, array $args) use ($app) {

                        return AcconuntController::tampil_data($this, $request, $response, $args);
                    }
            );
            $app->post(
                '/delete-fees',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return AcconuntController::delete($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            $app->get(
                '/{id}/payment-detail',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $args['id'];
                        // return var_dump($data);
                        return AcconuntController::payment_detail($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            $app->post(
                '/update-payment-detail',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return AcconuntController::update_payment_detail($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            $app->get(
                '/allexpense',
                function (Request $request, Response $response, array $args) use ($app) {

                        return AcconuntController::tampil_data_expense($this, $request, $response, $args);
                    }
            );
            $app->post(
                '/add-payment',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return AcconuntController::add_payment($this, $request, $response, [
                            'data' => $data,
                        ]);
                    }
            );
            $app->get(
                '/all-result',
                function (Request $request, Response $response, array $args) use ($app) {
                        // return var_dump($data);
                        return ExamController::tampil_data_result($this, $request, $response, $args);
                    }
            );
            $app->get(
                '/all-resultS',
                function (Request $request, Response $response, array $args) use ($app) {
                        // return var_dump($data);
                        return ExamController::tampil_data_resultS($this, $request, $response, $args);
                    }
            );
            $app->post(
                '/delete-result',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return ExamController::delete_result($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            $app->get(
                '/{id}/result-detail',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $args['id'];
                        // return var_dump($data);
                        return ExamController::result_detail($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            $app->post(
                '/update-result-detail',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return ExamController::update_result_detail($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            //Peminjaman buku
            $app->get(
                '/all-peminjaman',
                function (Request $request, Response $response, array $args) use ($app) {
                    // return var_dump($data);
                    return LibraryController::tampil_data_peminjaman($this, $request, $response, $args);
                }
            );
            $app->post(
                '/pinjam',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return LibraryController::pinjam($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            $app->post(
                '/pengembalian',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return LibraryController::pengembalian($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            $app->post(
                '/delete-peminjaman',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return LibraryController::delete_peminjaman($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            $app->get(
                '/{id}/pinjam-detail',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $args['id'];
                        // return var_dump($data);
                        return LibraryController::peminjaman_detail($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            $app->post(
                '/update-peminjaman',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $request->getParsedBody();
                        // return var_dump($data);
                        return LibraryController::update_peminjaman($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            $app->get(
                '/{id}/pinjam_siswa',
                function (Request $request, Response $response, array $args) use ($app) {
                        $data = $args['id'];
                        // return var_dump($data);
                        return LibraryController::tampil_data_peminjaman_siswa($this, $request, $response, [
                            'data' => $data
                        ]);
                    }
            );
            //Get Data Select2
            $app->get(
                '/get-guru',
                function (Request $request, Response $response, array $args) use ($app) {
                   
                    return ClassRoutineController::get_data_guru($this, $request, $response, $args);
                }
            );
            $app->get(
                '/get-ortu',
                function (Request $request, Response $response, array $args) use ($app) {
                   
                    return StudentController::get_data_ortu($this, $request, $response, $args);
                }
            );
            $app->get(
                '/get-siswa',
                function (Request $request, Response $response, array $args) use ($app) {
                   
                    return StudentController::get_data_siswa($this, $request, $response, $args);
                }
            );
            $app->get(
                '/get-all',
                function (Request $request, Response $response, array $args) use ($app) {
                   
                    return StudentController::get_data_all($this, $request, $response, $args);
                }
            );
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
                "status" => 1,
            ], [
                    "id_user" => $data['key'],
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
                'email' => $data['email'],
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
                'isReset' => true,
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
                    'password' => $data['pass'],
                ], [
                        'id_user' => $data['id_user'],
                    ]);
                $_SESSION['changedPass'] = true;
                // return var_dump(true);
                return $response->withRedirect('/login');
            } else {
                return $container->view->render($response, 'layout/log.html', [
                    'key' => $data['key'],
                    'isReset' => true,
                    'notValidChanged' => true,
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
    $app->get(
        '/all-alumni',
        function (Request $request, Response $response, array $args) use ($container) {

            return StudentController::all_alumni($this, $request, $response, [
                'user' => $_SESSION['username'],
                'id_user' => $_SESSION['id_user'],
                'type' => $_SESSION['type'],
                'type_user' => $_SESSION['type_user'],
            ]);
        }
    )->add(new Auth());
    $app->get(
        '/all-students',
        function (Request $request, Response $response, array $args) use ($container) {

            return StudentController::index($this, $request, $response, [
                'user' => $_SESSION['username'],
                'id_user' => $_SESSION['id_user'],
                'type' => $_SESSION['type'],
                'type_user' => $_SESSION['type_user'],
            ]);
        }
    )->add(new Auth());

    $app->get('/admit-form', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view

        return StudentController::page_add_student($this, $request, $response, $args);
    }
    );
    $app->get('/student-promotion/{id}', function (Request $request, Response $response, array $args) use ($container) {
        // Render index view
        $data = $args['id'];

        return StudentController::student_promotion($this, $request, $response, [
            'data' => $data,
        ]);
    }
    );

    //Teacher
    $app->get(
        '/all-teacher',
        function (Request $request, Response $response, array $args) use ($container) {

            return TeacherController::index($this, $request, $response, [
                'user' => $_SESSION['username'],
                'id_user' => $_SESSION['id_user'],
                'type' => $_SESSION['type'],
                'type_user' => $_SESSION['type_user'],
            ]);
        }
    )->add(new Auth());
    $app->get(
        '/add-teacher',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return TeacherController::page_add_teacher($this, $request, $response, $args);
        }
    )->add(new Auth());
    $app->get(
        '/teacher-payment',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return TeacherController::page_payment($this, $request, $response, $args);
        }
    )->add(new Auth());
    //end Teacher

    //Parent
    $app->get(
        '/all-parents',
        function (Request $request, Response $response, array $args) use ($container) {
            return ParentController::index($this, $request, $response, [
                'user' => $_SESSION['username'],
                'id_parent' => $_SESSION['id_user'],
                'type' => $_SESSION['type'],
                'type_user' => $_SESSION['type_user'],
            ]);
        }
    )->add(new Auth());
    $app->get(
        '/parents-details',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'parents/parents-details.html', $args);
        }
    )->add(new Auth());
    $app->get(
        '/add-parents',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return ParentController::page_add_parent($this, $request, $response, $args);
        }
    )->add(new Auth());
    //end Parent

    //Book
    $app->get(
        '/all-book',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return LibraryController::option_book_detail($this, $request, $response, $args);
        }
    )->add(new Auth());
    $app->get(
        '/all-peminjaman',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return LibraryController::peminjaman($this, $request, $response, $args);
        }
    )->add(new Auth());
    $app->get(
        '/add-book',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return LibraryController::option_book($this, $request, $response, $args);
        }
    )->add(new Auth());
    //end Book

    //Acconunt
    $app->get(
        '/all-fees',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return AcconuntController::index($this, $request, $response, $args);
        }
    )->add(new Auth());

    $app->get(
        '/all-expense',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return AcconuntController::pengeluaran($this, $request, $response, $args);
        }
    )->add(new Auth());
    $app->get(
        '/add-expense',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return AcconuntController::page_add_payment($this, $request, $response, $args);
        }
    )->add(new Auth());
    //end Acconunt

    //Class
    $app->get(
        '/all-class',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return ClassController::index($this, $request, $response, $args);

            // $container->view->render($response, 'class/all-class.html', $args);
        }
    )->add(new Auth());
    $app->get(
        '/add-class',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return ClassController::viewAddClass($this, $request, $response, $args);
        }
    )->add(new Auth());
    //end Class

    //Subject
    $app->get(
        '/all-subject',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return SubjectController::index($this, $response, $request, $args);
        }
    );
    //End Subject

    //Class Routine
    $app->get(
        '/class-routine',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            // $container->view->render($response, 'others/class-routine.html', $args);
            return ClassRoutineController::index($this, $response, $request, $args);
        }
    )->add(new Auth());
    //End Class Routine

    //Attendance
    $app->get(
        '/student-attendence',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            // $class = $container->db->query("SELECT * FROM tbl_classes c LEFT JOIN tbl_sections s ON c.id_section = s.id_section");
            $class = $container->db->select('tbl_classes', [
                '[>]tbl_sections' => 'id_section'
            ], '*');
            $subject = $container->db->select('tbl_subjects', '*');
            // SELECT session FROM `tbl_users` WHERE session != 0 GROUP BY session
            $sessionAttend = $container->db->select('tbl_users', 'session', [
                'session[!]' => 0,
                'GROUP' => [
                    'session'
                ]
            ]);
            // return die(var_dump($sessionAttend));
            $container->view->render($response, 'others/student-attendence.html', [
                'class' => $class,
                'subject' => $subject,
                'sessionAttend' => $sessionAttend
            ]);
        }
    )->add(new Auth());
    $app->get(
        '/viewAttendSheet',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $dataRequest = $request->getParams();
            $tanggal = $container->db->select('tbl_attendances', 'tanggal', [
                'id_class' => $dataRequest['class'],
                'id_subject' => $dataRequest['subject'],
                'GROUP' => [
                    'tanggal'
                ]
            ]);
            $checkTodayIfAdd = $container->db->select('tbl_attendances', 'tanggal', [
                'id_class' => $dataRequest['class'],
                'id_subject' => $dataRequest['subject'],
                'tanggal' => Medoo::raw('CURRENT_DATE')
            ]);
            $viewStudentAttend = $container->db->select('tbl_users', [
                '[>]tbl_classes' => 'id_class',
                '[>]tbl_sections' => ['tbl_classes.id_section' => 'id_section'],
                '[>]tbl_subjects' => 'id_subject',
                '[>]tbl_attendances' => 'id_user'
            ], [
                    'id_user',
                    'first_name',
                    'last_name',
                    'tbl_classes.class',
                    'tbl_sections.section',
                    'tbl_subjects.subject_name',
                    'tbl_attendances.id_attendance',
                    'tbl_attendances.tanggal'
                ], [
                    'tbl_users.id_class' => $dataRequest['class'],
                    // 'id_subject' => $dataRequest['subject'],
                    'session' => $dataRequest['session']
                ]);
            $dataStudentArrivedInAttend = $container->db->select('tbl_users', [
                '[>]tbl_classes' => 'id_class',
                '[>]tbl_sections' => ['tbl_classes.id_section' => 'id_section'],
                '[>]tbl_subjects' => 'id_subject',
                '[>]tbl_attendances' => 'id_user'
            ], [
                    'id_user',
                    'first_name',
                    'last_name',
                    'tbl_classes.class',
                    'tbl_sections.section',
                    'tbl_subjects.subject_name',
                    'tbl_attendances.id_attendance',
                    'tbl_attendances.tanggal'
                ], [
                    'tbl_users.id_class' => $dataRequest['class'],
                    'session' => $dataRequest['session'],
                    'GROUP' => [
                        'id_user'
                    ]
                ]);
            $checkTotalStudent = count($dataStudentArrivedInAttend);
            $checkStudentDateIfExistChecklist = [];
            for ($i = 0; $i < $checkTotalStudent; $i++) {
                $checkValidTotalStudent = $container->db->select('tbl_attendances', 'tanggal', [
                    'id_subject' => $dataRequest['subject'],
                    'id_class' => $dataRequest['class'],
                    'id_user' => $dataStudentArrivedInAttend[$i]['id_user'],
                    'absence' => 1
                ]);
                // $checkStudentDateIfExistChecklist = $checkValidTotalStudent;
                array_push($checkStudentDateIfExistChecklist, $checkValidTotalStudent);
                // if($checkValidTotalStudent);
            }
            // return die(var_dump($dataStudentArrivedInAttend));
            // return die(var_dump($checkStudentDateIfExistChecklist));
    
            $subjectStudentAttend = $container->db->select('tbl_subjects', '*', [
                'id_subject' => $dataRequest['subject']
            ]);
            $classStudentAttend = $container->db->select('tbl_classes', '*', [
                'id_class' => $dataRequest['class']
            ]);
            if ($checkTodayIfAdd == null) {
                $insert = $container->db->insert('tbl_attendances', [
                    'id_subject' => $dataRequest['subject'],
                    'id_class' => $dataRequest['class'],
                    'tanggal' => Medoo::raw('CURRENT_TIMESTAMP')
                ]);
                // return die(var_dump($insert));
                $tanggal = $container->db->select('tbl_attendances', 'tanggal', [
                    'id_subject' => $dataRequest['subject'],
                    'id_class' => $dataRequest['class'],
                    'GROUP' => [
                        'tanggal'
                    ]
                ]);
                return $response->withJson(
                    array(
                        'viewStudentAttend' => $viewStudentAttend,
                        'dateStudentAttend' => $tanggal,
                        'classStudentAttend' => $classStudentAttend,
                        'subjectStudentAttend' => $subjectStudentAttend,
                        'checkStudentDateIfExistChecklist' => $checkStudentDateIfExistChecklist,
                        'dataStudentArrivedInAttend' => $dataStudentArrivedInAttend,
                        'typeUser' => $_SESSION['type']
                    )
                );
            } else {
                return $response->withJson(
                    array(
                        'viewStudentAttend' => $viewStudentAttend,
                        'dateStudentAttend' => $tanggal,
                        'classStudentAttend' => $classStudentAttend,
                        'subjectStudentAttend' => $subjectStudentAttend,
                        'checkStudentDateIfExistChecklist' => $checkStudentDateIfExistChecklist,
                        'dataStudentArrivedInAttend' => $dataStudentArrivedInAttend,
                        'typeUser' => $_SESSION['type'],
                    )
                );
            }
        }
    )->add(new Auth());
    $app->post(
        '/sendAbsence',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $dataRequest = $request->getParsedBody();

            $allValues = count($dataRequest['user']);
            // return die(var_dump($dataRequest));
            for ($i = 0; $i < $allValues; $i++) {
                $checkIfExistUpdate = $container->db->select('tbl_attendances', 'id_attendance', [
                    'id_user' => $dataRequest['user'][$i],
                    'id_class' => $dataRequest['subject'][1],
                    'id_subject' => $dataRequest['subject'][0],
                    'tanggal' => $dataRequest['date'][$i]
                ]);
                // return die(var_dump($checkIfExistUpdate));
                if ($checkIfExistUpdate != null) {
                    $container->db->update('tbl_attendances', [
                        'absence' => $dataRequest['absence'][$i]
                    ], [
                            'id_attendance' => $checkIfExistUpdate[0]
                        ]);
                } else {
                    $container->db->insert('tbl_attendances', [
                        'id_user' => $dataRequest['user'][$i],
                        'id_class' => $dataRequest['subject'][1],
                        'id_subject' => $dataRequest['subject'][0],
                        'tanggal' => $dataRequest['date'][$i],
                        'absence' => $dataRequest['absence'][$i]
                    ]);
                }
            }
            return $response->withJson(array('success' => true));
        }
    )->add(new Auth());
    //End Attendance

    //Exam
    $app->get(
        '/exam-schedule',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return ExamController::option_exam($this, $request, $response, $args);
        }
    )->add(new Auth());
    $app->get(
        '/exam-grade',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'exam/exam-grade.html', $args);
        }
    )->add(new Auth());
    $app->get(
        '/exam-result',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return ExamController::exam_result($this, $request, $response, $args);
        }
    )->add(new Auth());
    $app->get(
        '/tugas',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $class = $container->db->select('tbl_classes', [
                '[>]tbl_sections' => 'id_section'
            ], '*');
            $subject = $container->db->select('tbl_subjects', '*');
            // SELECT session FROM `tbl_users` WHERE session != 0 GROUP BY session
            $sessionAttend = $container->db->select('tbl_users', 'session', [
                'session[!]' => 0,
                'GROUP' => [
                    'session'
                ]
            ]);
            // return die(var_dump($sessionAttend));
            return $container->view->render($response, 'exam/tugas.html', [
                'class' => $class,
                'subject' => $subject,
                'sessionAttend' => $sessionAttend
            ]);
            // $container->view->render($response, 'exam/tugas.html', $args);
        }
    )->add(new Auth());
    $app->get(
        '/viewTaskSheet',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $dataRequest = $request->getParams();
            // $tanggal = $container->db->select('tbl_attendances', 'tanggal', [
            //     'id_subject' => $dataRequest['subject'],
            //     'GROUP' => [
            //         'tanggal'
            //     ]
            // ]);
            // $checkTodayIfAdd = $container->db->select('tbl_attendances', 'tanggal', [
            //     'id_subject' => $dataRequest['subject'],
            //     'tanggal' => Medoo::raw('CURRENT_DATE')
            // ]);
            // return die(var_dump($dataRequest));
            $viewStudentAttend = $container->db->select('tbl_users', [
                '[>]tbl_classes' => 'id_class',
                '[>]tbl_sections' => ['tbl_classes.id_section' => 'id_section'],
                '[>]tbl_subjects' => 'id_subject',
                '[>]tbl_tasks' => 'id_user'
            ], [
                    'id_user',
                    'first_name',
                    'last_name',
                    'tbl_classes.class',
                    'tbl_sections.section',
                    'tbl_subjects.subject_name',
                    'tbl_tasks.id_task',
                    'tbl_tasks.task_name',
                    'tbl_tasks.score',
                ], [
                    'tbl_users.id_class' => $dataRequest['class'],
                    'session' => $dataRequest['session']
                ]);
                $dataTimestamp = [];
            // $dataSearchTimestamp = $container->db->select('tbl_tasks',[
            //     'created_at'
            // ],[
            //     ''
            // ]);
            switch ($dataRequest['taskType']) {
                case 'TGS': {
                        $dataAvaliable = $container->db->select(
                            'tbl_tasks',
                            '*',
                            Medoo::raw("WHERE
                        task_type='" . $dataRequest["taskType"] . "'
                            AND
                        id_class='".$dataRequest['class']."'
                            AND
                        id_subject='".$dataRequest['subject']."'
                            HAVING 
                        (date(created_at) = '" . $dataRequest["date"] . "')
                    ")
                        );
                        $taskName = "TUGAS";
                        $lastData = '';
                        $data_id = [];
                        // return die(var_dump($dataAvaliable));
                        $dataCountTugas = $container->db->select('tbl_tasks', '*', [
                            'task_type' => $dataRequest['taskType'],
                            'id_class'=>$dataRequest['class'],
                            'id_subject'=>$dataRequest['subject'],
                            'GROUP' => [
                                'created_at'
                            ]
                        ]);
                        // return die(var_dump($dataCountTugas));
                        $lastData = count($dataCountTugas);

                    }
                    break;
                case 'UH': {
                        $dataAvaliable = $container->db->select(
                            'tbl_tasks',
                            '*',
                            Medoo::raw("WHERE
                        task_type='" . $dataRequest["taskType"] . "' 
                            AND
                        id_class='".$dataRequest['class']."'
                            AND
                        id_subject='".$dataRequest['subject']."'
                            HAVING 
                        (date(created_at) = '" . $dataRequest["date"] . "')
                            
                    ")
                        );
                        $lastData = '';
                        $taskName = "UH";
                        $dataCountTugas = $container->db->select('tbl_tasks', '*', [
                            'task_type' => $dataRequest['taskType'],
                            'id_class'=>$dataRequest['class'],
                            'id_subject'=>$dataRequest['subject'],
                            'GROUP' => [
                                'created_at'
                            ]
                        ]);
                        $lastData = count($dataCountTugas);
                    }
                    break;
                default:
                    break;
            }
            // return die(var_dump($dataAvaliable));
            // for ($j = 0; $j < count($dataAvaliable); $j++) {
            //     $updateTaskName = $container->db->update('tbl_tasks', [
            //         'task_name' => $taskName . ' ' . ($lastData)
            //     ], [
            //             'id_task' => $dataAvaliable[$j]['id_task']
            //         ]);
            //     // return die(var_dump($updateTaskName));
            // }
            $dataStudentTaskSuccess = $container->db->select('tbl_users', [
                '[>]tbl_classes' => 'id_class',
                '[>]tbl_sections' => ['tbl_classes.id_section' => 'id_section'],
                '[>]tbl_subjects' => 'id_subject',
                '[>]tbl_tasks' => 'id_user'
            ], [
                    'id_user',
                    'first_name',
                    'last_name',
                    'tbl_classes.class',
                    'tbl_sections.section',
                    'tbl_subjects.subject_name',
                    'tbl_tasks.id_task',
                    'tbl_tasks.task_name',
                    'tbl_tasks.score',
                ], [
                    'tbl_users.id_class' => $dataRequest['class'],
                    'session' => $dataRequest['session'],
                    'GROUP' => [
                        'id_user'
                    ]
                ]);
            $checkTotalTask = $container->db->select('tbl_users', [
                '[>]tbl_classes' => 'id_class',
                '[>]tbl_sections' => ['tbl_classes.id_section' => 'id_section'],
                '[>]tbl_subjects' => 'id_subject',
                '[>]tbl_tasks' => 'id_user'
            ], [
                    'id_user',
                    'first_name',
                    'last_name',
                    'tbl_classes.class',
                    'tbl_sections.section',
                    'tbl_subjects.subject_name',
                    'tbl_tasks.id_task',
                    'tbl_tasks.task_name',
                    'tbl_tasks.score',
                ], [
                    'tbl_users.id_class' => $dataRequest['class'],
                    'session' => $dataRequest['session'],
                    'tbl_tasks.task_type'=> $dataRequest['taskType'],
                ]);
            // return die(var_dump($checkTotalTask));
            $checkTotalStudent = count($dataStudentTaskSuccess);
            $checkStudentDateIfExistChecklist = [];
            for ($i = 0; $i < count($checkTotalTask); $i++) {
                $checkValidTotalStudent = $container->db->select('tbl_tasks', 'score', [
                    'id_class'=>$dataRequest['class'],
                    'id_subject' => $dataRequest['subject'],
                    'id_user' => $checkTotalTask[$i]['id_user'],
                    'score[!]' => 0
                ]);
                // $checkStudentDateIfExistChecklist = $checkValidTotalStudent;
                array_push($checkStudentDateIfExistChecklist, $checkValidTotalStudent);
                // if($checkValidTotalStudent);
                // return die(var_dump($checkValidTotalStudent));
            }
            // return die(var_dump($checkTotalTask));
    
            $taskStudentAlreadyExist = $container->db->select('tbl_tasks', '*', [
                'task_name' => $taskName . ' ' . ($lastData)
            ]);
            $subjectStudentAttend = $container->db->select('tbl_subjects', '*', [
                'id_subject' => $dataRequest['subject']
            ]);

            if ($dataStudentTaskSuccess == null) {
                // $insert = $container->db->insert('tbl_tasks', [
                //     'id_subject' => $dataRequest['subject'],
                //     'tanggal' => Medoo::raw('CURRENT_TIMESTAMP')
                // ]);
                return $response->withJson(
                    array(
                        'viewStudentAttend' => $viewStudentAttend,
                        // 'dateStudentAttend' => $tanggal,
                        'subjectStudentAttend' => $subjectStudentAttend,
                        'taskStudentAlreadyExist' => $taskStudentAlreadyExist,
                        'checkStudentDateIfExistChecklist' => $checkStudentDateIfExistChecklist,
                        'dataStudentTaskSuccess' => $dataStudentTaskSuccess,
                        'dataTaskAvailable' => $dataCountTugas,
                        'totalTask' => $checkTotalTask,
                        'typeUser' => $_SESSION['type']
                    )
                );
            } else {
                return $response->withJson(
                    array(
                        'viewStudentAttend' => $viewStudentAttend,
                        // 'dateStudentAttend' => $tanggal,
                        'subjectStudentAttend' => $subjectStudentAttend,
                        'taskStudentAlreadyExist' => $taskStudentAlreadyExist,
                        'checkStudentDateIfExistChecklist' => $checkStudentDateIfExistChecklist,
                        'dataStudentTaskSuccess' => $dataStudentTaskSuccess,
                        'dataTaskAvailable' => $dataCountTugas,
                        'totalTask' => $checkTotalTask,
                        'typeUser' => $_SESSION['type'],
                    )
                );
            }
        }
    )->add(new Auth());
    $app->post(
        '/createNewTask',
        function (Request $request, Response $response, array $args) use ($container) {
            $dataRequest = $request->getParsedBody();
            $selectStudent = $container->db->select('tbl_users', 'id_user',[
                'id_class'=>$dataRequest['class'],
                'session'=>$dataRequest['session'],
            ]);
            $dataCountTugas = $container->db->select('tbl_tasks', '*', [
                'task_type' => $dataRequest['taskType'],
                'id_class'=>$dataRequest['class'],
                'id_subject'=>$dataRequest['subject'],
                'GROUP' => [
                    'created_at'
                ]
            ]);
            $taskName = '';
            switch ($dataRequest['taskType']){
                case 'TGS':{
                        $taskName = 'TUGAS';
                }
                break;
                case 'UH':{
                    $taskName = 'UH';
                }
                break;
                default:
                    break;
            }
            $lastData = count($dataCountTugas);
            for($i=0;$i<count($selectStudent);$i++){
                $insert = $container->db->insert('tbl_tasks', [
                    'id_class'=>$dataRequest['class'],
                    'id_subject'=>$dataRequest['subject'],
                    'task_name' => $taskName . ' ' . ($lastData + 1),
                    'id_user'=>$selectStudent[$i],
                    'task_type'=>$dataRequest['taskType']
                ]);
                // array_push($insert->inser)
            }
        //     $dataAvaliable = $container->db->select('tbl_tasks', '*', 
        //     Medoo::raw("WHERE
        //     task_type='".$dataRequest["taskType"]."' 
        //     HAVING 
        //         (date(created_at) = '".$dataRequest["date"]."')
        // ")
        //  );
        //     $dataCountTugas = $container->db->select('tbl_tasks', '*', [
        //         'task_type'=>$dataRequest['taskType'],
        //         'GROUP'=>[
        //             'created_at'
        //         ]
        //         ]
        //     );
            return $response->withJson(array('success' => true));
            // $lastData = count($dataCountTugas);
        }
    );
    $app->post(
        '/sendScoreTask',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $dataRequest = $request->getParsedBody();
            // return die(var_dump($dataRequest));
            $allValues = count($dataRequest['id_user']);
            // return die(var_dump($dataRequest));
            for ($i = 0; $i < $allValues; $i++) {
                $checkIfExistUpdate = $container->db->select('tbl_tasks', 'id_task', [
                    'id_user' => $dataRequest['id_user'][$i],
                    'task_name' => $dataRequest['id_task'][$i],
                    'id_class' => $dataRequest['Subject'][1],
                    'id_subject'=> $dataRequest['Subject'][0],
                ]);
                // return die(var_dump($checkIfExistUpdate));
                if ($checkIfExistUpdate != null) {
                    $container->db->update('tbl_tasks', [
                        'score' => $dataRequest['score'][$i+2]
                    ], [
                            'id_task' => $checkIfExistUpdate[0]
                        ]);
                } else {
                    // $container->db->insert('tbl_tasks', [
                    //     'id_user' => $dataRequest['user'][$i],
                    //     'id_class'=> $dataRequest['subject'][2],
                    //     'id_subject' => $dataRequest['subject'][1],
                    //     'tanggal' => $dataRequest['date'][$i],
                    //     'absence' => $dataRequest['absence'][$i]
                    // ]);
                }
            }
            return $response->withJson(array('success' => true));
        }
    )->add(new Auth());
    $app->get(
        '/final-score',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $class = $container->db->select('tbl_classes', [
                '[>]tbl_sections' => 'id_section'
            ], '*');
            $subject = $container->db->select('tbl_subjects', '*');
            // SELECT session FROM `tbl_users` WHERE session != 0 GROUP BY session
            $sessionAttend = $container->db->select('tbl_users', 'session', [
                'session[!]' => 0,
                'GROUP' => [
                    'session'
                ]
            ]);
            // return die(var_dump($sessionAttend));
            return $container->view->render($response, 'exam/final-score.html', [
                'class' => $class,
                'subject' => $subject,
                'sessionAttend' => $sessionAttend
            ]);
            // $container->view->render($response, 'exam/tugas.html', $args);
        }
    )->add(new Auth());
    $app->get(
        '/finalscore',
        function (Request $request, Response $response, array $args) use ($app) {
            $data = $request->getParams();
            //     return var_dump($request->getParams());
            // die();
                return ExamController::tampil_data_final_score($this, $request, $response, [
                    'data' => $data
                ]);
            }
    );
    $app->get(
        '/get-final-score',
        function (Request $request, Response $response, array $args) use ($container) {
            $data = $request->getParams();
            $dataAttendance = $container->db->select('tbl_attendances','*',[
                'id_class'=>$data['class'],
                'id_subject'=>$data['subject']
            ]);
            $dataTask = $container->db->select('tbl_tasks','*',[
                'id_class'=>$data['class'],
                'id_subject'=>$data['subject']
            ]);
            $dataStudent = $container->db->select('tbl_users', '*',[
                'id_class'=>$data['class'],
                // 'id_subject'=>$data['subject']
            ]);
            return $response->withJson(array(
                'dataAttend'=>$dataAttendance,
                'dataTask'=>$dataTask,
                'dataStudent'=>$dataStudent,
                'typeUser' => $_SESSION['type']
            ));

            // return die(var_dump($dataStudent));
            
        }
    )->add(new Auth());
    //End Exam

    //Transport
    $app->get(
        '/transport',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'transport/transport.html', $args);
        }
    )->add(new Auth());
    //End Transport

    //Hostel
    $app->get(
        '/hostel',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'hostel/hostel.html', $args);
        }
    )->add(new Auth());
    //End Hostel

    //notice
    $app->get(
        '/notice-board',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            // return var_dump($dataNotice);
            $container->view->render($response, 'others/notice-board.html', $args);
        }
    )->add(new Auth());
    $app->get(
        '/getNotice',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view'
            // return die(var_dump($_SESSION));
    
            $condition = [
                'ORDER' => [
                    'id_notification' => 'DESC',
                ],
            ];

            if (!empty($request->getParam('search'))) {
                $search = $request->getParam('search');
                $condition['OR'] = [
                    'title[~]' => '%' . $search . '%',
                    'date_notice' => Medoo::raw("1 OR (date_notice BETWEEN '" . $search . "' AND '" . $search . " 23:59:59')"),
                ];
            } else if (!empty($_SESSION['type'])) {
                $user_type = $_SESSION['type'];
                if ($user_type != '3') {
                    switch ($user_type) {
                        case '1': {
                                $condition += [
                                    'category[!]' => ['Pembayaran_SPP', 'Pembayaran_Gaji']
                                ];
                            }
                            break;
                        case '2': {
                                $condition += [
                                    'category[!]' => 'Pembayaran_SPP'
                                ];
                            }
                            break;
                        case '4': {
                                $condition += [
                                    'category' => ['Pembayaran_SPP', 'Exam']
                                ];
                            }
                            break;
                        default: {
                            }
                            break;
                    }
                }
            }
            $dataNotice = $container->db->select('tbl_notifications', '*', $condition);
            // return var_dump($dataNotice);
            return $response->withJson($dataNotice);
        }
    )->add(new Auth());

    $app->get(
        '/getNoticeS',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view'
            // return var_dump($request->getParam('search'));
    
            $condition = [
                'ORDER' => [
                    'id_notification' => 'DESC',
                    // 'category[!]' => 'Pembayaran' 
                ],
            ];

            if ($_SESSION['type'] == 1) {
                $category = [
                    'category[!]' => ['Pembayaran_Gaji', 'Pembayaran_SPP']
                ];
            } elseif ($_SESSION['type'] == 4) {
                $category = [
                    'category' => ['Pembayaran_SPP', 'Exam']
                ];
            } elseif ($_SESSION['type'] == 3) {
                $category = [
                    'category' => ['Pembayaran_SPP', 'Pembayaran_Gaji', 'Exam', 'Event', 'Pengumuman_Sekolah']
                ];
            } else {
                $category = [
                    'category' => ['Pembayaran_Gaji', 'Exam', 'Event']
                ];
            }

            $dataNotice = $container->db->select('tbl_notifications', '*', $category, $condition);
            //return var_dump($dataNotice);
            return $response->withJson($dataNotice);
        }
    )->add(new Auth());

    $app->get(
        '/getNoticeNavbar',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view'
            // return var_dump($request->getParam('search'));
            $dataNotice = $container->notif;
            //return var_dump($dataNotice);
            return $response->withJson($dataNotice);
        }
    )->add(new Auth());
    $app->get(
        '/getNoticeDetails',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view'
            // return var_dump($request->getParam('id'));
            $id = $request->getParam('id');
            $dataNotice = $container->db->select('tbl_notifications', '*', [
                'id_notification' => $id,
            ]);
            //return var_dump($dataNotice);
            return $response->withJson($dataNotice);
        }
    )->add(new Auth());

    $app->get(
        '/getNoticeDetailsS',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view'
            // return var_dump($request->getParam('id'));
            $id = $request->getParam('id');
            $dataNotice = $container->db->select('tbl_notifications', '*', [
                'id_notification' => $id,
                // 'category[!]' => 'Pembayaran'
            ]);
            //return var_dump($dataNotice);
            return $response->withJson($dataNotice);
        }
    )->add(new Auth());
    $app->post(
        '/sendNotice',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $dataRequest = $request->getParsedBody();
            // return var_dump($dataRequest);
            $dateEvent = $dataRequest['date_event'];
            if ($dateEvent = '') {
                $dateEvent = 0;
            }
            $sendNotice = $container->db->insert('tbl_notifications', [
                'title' => $dataRequest['title'],
                'details' => $dataRequest['details'],
                'posted_by' => $dataRequest['UserType'],
                'date_event' => $dataRequest['date_event'],
                'category' => $dataRequest['category'],

            ]);
            return $response->withJson(array('success' => true));
            // $container->view->render($response, 'others/notice-board.html', $args);
        }
    )->add(new Auth());
    $app->post(
        '/editNotice',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $dataRequest = $request->getParsedBody();
            //return var_dump($dataRequest);
            $dateEvent = $dataRequest['date_event'];
            if ($dateEvent = '') {
                $dateEvent = 0;
            }
            $sendNotice = $container->db->update('tbl_notifications', [
                'title' => $dataRequest['title'],
                'details' => $dataRequest['details'],
                'posted_by' => $dataRequest['UserType'],
                'date_event' => $dataRequest['date_event'],
                'category' => $dataRequest['category'],
            ], [
                    'id_notification' => $dataRequest['id']
                ]);
            return $response->withJson(array('success' => true));
            // $container->view->render($response, 'others/notice-board.html', $args);
        }
    )->add(new Auth());
    $app->post(
        '/deleteNotice',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $dataRequest = $request->getParsedBody();
            $delete = $container->db->delete('tbl_notifications', [
                'id_notification' => $dataRequest['id_notification']
            ]);
            //return var_dump($delete);
            return $response->withJson(array('success' => true));
            // $container->view->render($response, 'others/notice-board.html', $args);
        }
    )->add(new Auth());
    // End Notice

    // Message
    $app->get(
        '/messaging',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $data = $container->db->select('tbl_users', [
                'id_user',
                'email',
                'first_name',
                'last_name',
                'username',
            ]);
            // return var_dump($data);
            $container->view->render($response, 'others/messaging.html', [
                'data' => $data,
                'idSenderDefault' => $_SESSION['id_user'],
            ]);
        }
    )->add(new Auth());
    $app->get(
        '/getNameMessage',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $id = $request->getParam('id_user');
            // return var_dump($request->getParam('id_user'));
            $data = $container->db->select('tbl_users', [
                'id_user',
                'first_name',
                'last_name',
            ], [
                    "id_user" => $id,
                ]);
            // $container->view->render($response, 'others/messaging.html', $args);
            return $response->withJson($data);
        }
    )->add(new Auth());
    $app->get(
        '/getEmailMessage',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $id = $request->getParam('id_user');
            // return var_dump($request->getParam('id_user'));
            $data = $container->db->select('tbl_users', [
                'id_user',
                'email',
            ], [
                    "id_user" => $id,
                ]);
            // $container->view->render($response, 'others/messaging.html', $args);
            return $response->withJson($data);
        }
    )->add(new Auth());
    $app->get(
        '/get_id_ortu',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $NISN = $request->getParam('id_user');
            // return var_dump($request->getParam('id_user'));
            $data = $container->db->select('tbl_users', [
                'NISN',
                'first_name',
                'last_name',
            ], [
                    "id_user" => $NISN,
                ]);
            // return var_dump($data);
    
            return $response->withJson($data);
        }
    )->add(new Auth());
    $app->get(
        '/get_id_expenses',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $id_user_type = $request->getParam('id_user_type');
            $param = $request->getParams();
            // return var_dump($request->getParam($param));
            // die();
            $condition = [
                "id_user[!]" => 0,
                "id_user_type" => $id_user_type,
                "LIMIT" => 5,

            ];
            if(isset($param['q'])){
                $search = $param['q'];
                $condition['OR'] = [
                    'first_name[~]' => '%' . $search . '%',
                    'last_name[~]' => '%' . $search . '%',            
                ];
            }
            $data = $container->db->select('tbl_users', [
                '[><]tbl_user_types' => 'id_user_type',

            ], '*',$condition);
            // return var_dump($data);
    
            return $response->withJson($data);
        }
    );
    $app->post(
        '/messageSend',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $data = $request->getParsedBody();
            // return var_dump($data);
            $dataSender = $container->db->select('tbl_users', [
                'email',
                'first_name',
                'last_name',
                'username',
            ], [
                    'id_user' => $data['id_sender'],
                ]);
            $dataReceipent = $container->db->select('tbl_users', 'email', [
                'id_user' => $data['id_user'],
            ]);
            // return die(var_dump($dataSender[0]['email']));
            // return die(var_dump($dataSender[0]));
            $insert = $container->db->insert('tbl_messages', [
                'id_user' => $data['id_user'],
                'receiver_email' => $dataReceipent[0],
                'sender_email' => $dataSender[0]['email'],
                'title' => $data['title'],
                'message' => $data['message'],
                'readed' => 0,
            ]);

            // kirim email
            $mail = new PHPMailer(true);
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
            $mail->addAddress($dataSender[0]['email']);
            //Subject email
            $mail->Subject = 'PHPMailer GMail SMTP test';
            //Membaca isi pesan HTML dari file eksternal, mengkonversi gambar yang di embed,
            //Mengubah HTML menjadi basic plain-text
            //  $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
            $dataName = '';
            if ($dataSender[0]['first_name'] == '') {
                $dataName = $dataSender[0]['username'];
            } else {
                $dataName = $dataSender[0]['first_name'] . ' ' . $dataSender[0]['last_name'];
            }
            ;
            //Replace plain text body dengan cara manual
            $mail->Body = '<h3>You got message from ' . $dataName . '</h3><br><h1>' . $data['title'] . '</h1><br><br><p>' . $data['message'] . '</p>';
            $mail->AltBody = 'This is a plain-text message body';
            //Attach file gambar
            //  $mail->addAttachment('images/phpmailer_mini.png');
            //mengirim pesan, mengecek error
    
            if (!$mail->send()) {
                echo "Email Error: " . $mail->ErrorInfo;
            }
            return;
            // kirim email end here
    
            // $container->view->render($response, 'others/messaging.html', $args);
        }
    )->add(new Auth());
    $app->post(
        '/readedMessage',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $data = $request->getParsedBody();
            // return var_dump($data);
            $dataSender = $container->db->update('tbl_messages', [
                'readed' => 1,
            ], [
                    'id_message' => $data['id_message'],
                ]);
            // return var_dump($dataSender);
            // $container->view->render($response, 'others/messaging.html', $args);
            return $response->withJson(array('success' => true));
        }
    )->add(new Auth());
    $app->get(
        '/getMessageDetails',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view'
            // return var_dump($request->getParam('id'));
            $id = $request->getParam('id_message');
            $dataNotice = $container->db->select('tbl_messages(m)', [
                '[>]tbl_users' => 'id_user',
            ], [
                    'id_message',
                    'totalMessage' => Medoo::raw("(SELECT COUNT(id_message) FROM `tbl_messages` AS `m` LEFT JOIN `tbl_users` USING (`id_user`) WHERE username = '" . $_SESSION['username'] . "')"),
                    'id_user',
                    'receiver_email',
                    'sender_email',
                    'title',
                    'message',
                    'readed',
                    'photo_sender' => Medoo::raw('(SELECT photo_user FROM tbl_users WHERE email = m.sender_email)'),
                    'first_name_sender' => Medoo::raw('(SELECT first_name FROM tbl_users WHERE email = m.sender_email)'),
                    'last_name_sender' => Medoo::raw('(SELECT last_name FROM tbl_users WHERE email = m.sender_email)'),
                    'time_sended',
                ], [
                    'username' => $_SESSION['username'],
                    'id_message' => $id,
                ]);
            //return var_dump($dataNotice);
            return $response->withJson($dataNotice);
        }
    )->add(new Auth());
    // End Message

    // Map
    $app->get(
        '/map',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $container->view->render($response, 'others/map.html', $args);
        }
    )->add(new Auth());
    // End Map

    // Account
    // Set profile setting
    $app->get(
        '/profile-setting',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            return UserCredentialController::profilesetting($this, $request, $response, $args);
        }
    )->add(new Auth());

    $app->get(
        '/add-account',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $isAddAccount = isset($_SESSION['successAddingAccount']);
            unset($_SESSION['successAddingAccount']);
            $container->view->render($response, 'others/account/add-account.html', [
                'isAddAccount' => $isAddAccount,
            ]);
        }
    )->add(new Auth());
    $app->post(
        '/add-account',
        function (Request $request, Response $response, array $args) use ($container) {
            // Render index view
            $data = $request->getParsedBody();
            $addPhoto = 'default.png';
            // return var_dump($data);
    
            $insert = $container->db->insert('tbl_users', [
                "first_name" => $data['first_name'],
                "last_name" => $data['last_name'],
                "gender" => $data['gender'],
                "date_of_birth" => $data['date_of_birth'],
                "religion" => $data['religion'],
                "phone_user" => $data['phone_user'],
                "address_user" => $data['address_user'],
                "id_user_type" => 3,
                "status" => 1,
                "photo_user" => $addPhoto,
            ]);
            $_SESSION['successAddingAccount'] = true;
            return $response->withRedirect('/add-account');
            // $container->view->render($response, 'others/account/add-account.html', $args);
        }
    )->add(new Auth());
    $app->get(
        '/all-account',
        function (Request $request, Response $response, array $args) use ($container) {

            // $data = $container->db->select('tbl_users', '*');
            // return var_dump($data);
            // Render index view
            // $container->view->render($response, 'others/account/all-account.html', [
            //     'data'=> $data
            // ]);
            $container->view->render($response, 'others/account/all-account.html', $args);
        }
    )->add(new Auth());
    $app->get(
        '/getAllAccount',
        function (Request $request, Response $response, array $args) use ($container) {
            $search = $request->getParam('search') ?? '';
            $account = $container->db->select('tbl_users', '*');
            // return var_dump($search);
            // die();
    

            $totaldata = count($account);
            $totalfiltered = $totaldata;
            $conditions = [
                'id_user[!]' => 0
            ];
            if (!empty($request->getParam('search'))) {
                $search = $request->getParam('search');
                $conditions['OR'] = [
                    'tbl_users.first_name[~]' => '%' . $search . '%',
                    'tbl_users.last_name[~]' => '%' . $search . '%',
                    'tbl_users.username[~]' => '%' . $search . '%',
                    'tbl_user_types.user_type[~]' => '%' . $search . '%',

                ];
                $account = $container->db->select(
                    'tbl_users',
                    [
                        '[><]tbl_user_types' => 'id_user_type'
                    ],
                    '*',
                    $conditions
                );
                $totaldata = count($account);
                $totalfiltered = $totaldata;
            }

            $account = $container->db->select('tbl_users', [
                '[><]tbl_user_types' => 'id_user_type'
            ], '*', $conditions);
            $data = array();
            // return var_dump($account);
            if (!empty($account)) {

                return $response->withJson(array('account' => $account, 'totalData' => $totalfiltered));
            }
            // return var_dump($data);
        }
    )->add(new Auth());
    $app->get(
        '/account-data',
        function (Request $request, Response $response, array $args) use ($container) {
            // return var_dump($request->getParams());
            $id = $request->getParam('id_user');
            $data = $container->db->select('tbl_users', '*', [
                'id_user' => $id,
            ]);
            // return var_dump($data);
            return $response->withJson($data[0]);
        }
    )->add(new Auth());
    $app->post(
        '/editAccount',
        function (Request $request, Response $response, array $args) use ($container) {
            $data = $request->getParsedBody();
            // return var_dump($data);
            // get image
            $directory = $container->get('upload_directory');
            $uploadedFiles = $request->getUploadedFiles();
            // handle single input with single file upload
            $uploadedFile = $uploadedFiles['profileImage'];
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = moveUploadedFile($directory, $uploadedFile);
                $response->write('uploaded ' . $filename . '<br/>');
            }
            // return var_dump(isset($filename));
            $addUpdate = $filename;
            if (!isset($filename)) {
                $addUpdate = $data['imageDefault'];
            }

            // return var_dump($uploadedFiles);
            $update = $container->db->update('tbl_users', [
                "first_name" => $data['first_name'],
                "last_name" => $data['last_name'],
                "gender" => $data['gender'],
                "date_of_birth" => $data['date_of_birth'],
                "religion" => $data['religion'],
                "phone_user" => $data['phone_user'],
                "address_user" => $data['address_user'],
                "short_bio" => $data['data_short_bio'],
                "photo_user" => $addUpdate,
            ], [
                    "id_user" => $data['id_user'],
                ]);
            // return var_dump($update);
            return $response->withRedirect('/all-account');
        }
    );
    $app->post(
        '/ubah-password',
        function (Request $request, Response $response, array $args) use ($container) {
            return $response->withJson(UserCredentialController::ubahPassword($this, $request, $response, $args));
        }
    );
    $app->post(
        '/ubah-email',
        function (Request $request, Response $response, array $args) use ($container) {
            return UserCredentialController::sendEmailVerification($this, $request, $response, $args);
        }
    );
    $app->get(
        '/verifEmailChange/{key}/{email}',
        function (Request $request, Response $response, array $args) use ($container) {
            // return die(var_dump($args));
            return UserCredentialController::ubahEmail($this, $request, $response, $args);
        }
    );
    $app->post(
        '/ubah-username',
        function (Request $request, Response $response, array $args) use ($container) {
            return $response->withJson(UserCredentialController::ubahUsername($this, $request, $response, $args));
        }
    );

    $app->post(
        '/account-delete-data',
        function (Request $request, Response $response, array $args) use ($container) {
            $data = $request->getParsedBody();
            // return var_dump($data);
            $delete = $container->db->delete('tbl_users', [
                'id_user' => $data['id'],
            ]);
            return $response->withJson(array("success"));

            // return var_dump($data);
        }
    )->add(new Auth());

    $app->post(
        '/editDataProfile',
        function (Request $request, Response $response, array $args) use ($container) {
            $data = $request->getParsedBody();
            // return var_dump($data);
            // get image
            $directory = $container->get('upload_directory');

            $uploadedFiles = $request->getUploadedFiles();
            // handle single input with single file upload
            $uploadedFile = $uploadedFiles['profileImage'];
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = moveUploadedFile($directory, $uploadedFile);
                // $filename = move_uploaded_file($uploadedFile, '' . $directory . 'ProfileId' . $data['id_user'] . '');
                // return var_dump($filename);
                $response->write('uploaded ' . $filename . '<br/>');
            }
            // return var_dump(isset($filename));
            $addUpdate = $filename;
            if (!isset($filename)) {
                $addUpdate = $data['imageDefault'];
            } else {
                $fileDefault = $data['imageDefault'];
                // if default? return'
                if ($fileDefault == 'default.png') {
                } else {
                    // return var_dump(file_exists('../public/uploads/Profile/'.$fileDefault));
                    unlink('../public/uploads/Profile/' . $fileDefault);
                }
            }

            // return var_dump($uploadedFiles);
            $update = $container->db->update('tbl_users', [
                "first_name" => $data['first_name'],
                "last_name" => $data['last_name'],
                "gender" => $data['gender'],
                "date_of_birth" => $data['date_of_birth'],
                "religion" => $data['religion'],
                "blood_group" => $data['blood_group'],
                "occupation" => $data['occupation'],
                "phone_user" => $data['phone_user'],
                "address_user" => $data['address_user'],
                "short_bio" => $data['data_short_bio'],
                "photo_user" => $addUpdate,
            ], [
                    "id_user" => $data['id_user'],
                ]);
            // return var_dump($update);
            $_SESSION['user'] = '' . $data['first_name'] . ' ' . $data['last_name'];
            $_SESSION['photo_user'] = $addUpdate;
            return $response->withRedirect('/profile-setting');
        }
    );

    // End profile setting

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
    $app->get('/adminDataIncome', function (Request $request, Response $response, array $args) use ($container) {
        // return var_dump($request->getParams());
        $data = $request->getParam('tahun');
        return dashboardAdminController::apiData($container, $request, $response, [
            'data' => $data
        ]);
    }
    );
    $app->get(
        '/',
        function (Request $request, Response $response, array $args) use ($container) {
            // return var_dump($_SESSION);
            // Render index view
            $type = $_SESSION['type'];
            $type_user = $_SESSION['type_user'];
            // return var_dump($_SESSION);
            $id_student = $_SESSION['id_user'];
            // $photo_student = $_SESSION['photo_user'];
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
                    'id_student' => $id_student,
                    'type_user' => $type_user,
                ]);
                // return $response->withRedirect('/student');
            }
            if ($type == 2) {
                $type = "Teacher";
                return DashboardTeacherController::view($this, $request, $response, [
                    'user' => $_SESSION['user'],
                    'username' => $_SESSION['username'],
                    'type' => $type,
                    'nama_user' => $type_user,
                ]);
            }
            if ($type == 3) {
                $type = "Admin";
                // return var_dump($type_user);
                return DashboardAdminController::getData($this, $request, $response, [
                    'user' => $_SESSION['user'],
                    'type' => $type,
                    'nama_user' => $type_user,
                    'username' => $_SESSION['username'],
                ]);
            }
            if ($type == 4) {
                $type = "Parent";
                $id_parent = $_SESSION['id_user'];

                return DashbordParentController::index($this, $request, $response, [
                    'user' => $_SESSION['user'],
                    'type' => $type,
                    'id_parent' => $id_parent,
                    'type_user' => $type_user,
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
function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
    $oriname = $uploadedFile->getClientFilename();
    // $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = Date('YmdHis') . '-' . $oriname;

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;

    // return $filename;
}