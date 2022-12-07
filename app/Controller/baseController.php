<?php
namespace App\Controller;

use Psr\Container\ContainerInterface;

class baseController{
    protected $c;
    public function __construct(ContainerInterface $container){
        $this->c = $container;
    }
}
?>