<?php

namespace App\Controller;

class ClassController
{

    function getTeacher($app, $request, $response, $args){
        
    }

    public static function insertClass($app, $request, $response, $args){

    }


    public static function viewAddClass($app, $request, $response, $args){
        $app->view->render($response, 'class/add-class.html', [
            'test' => 'test',

            
        ]);

    }
    

}
