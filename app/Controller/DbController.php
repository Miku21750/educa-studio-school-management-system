<?php
namespace App\Controller;

use App\Controller\baseController;
use Slim\Http\Request;
use Slim\Http\Response;
use Medoo\Medoo;

class DbController extends baseController{
    public function getData(){
        $user = $this->c->db->get();
    }
}
?>