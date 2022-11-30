<?php

namespace App\Controller;
// session_start();

class userViewController
{

    public static function dashboard($app, $request, $response, $args)
    {
        $app->view->render($response, 'dashboard/student.html', $args);
    }

    public static function allStudent($app, $request, $response, $args)
    {
        $app->view->render($response, 'students/all-student.html', $args);
    }

    public static function studentDetails($app, $request, $response, $args)
    {
        $app->view->render($response, 'students/student-details.html', $args);
    }

    public static function admitForm($app, $request, $response, $args)
    {
        $app->view->render($response, 'students/admit-form.html', $args);
    }

    public static function studentPromotion($app, $request, $response, $args)
    {
        $app->view->render($response, 'students/student-promotion.html', $args);
    }
}
