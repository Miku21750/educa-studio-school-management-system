<?php
    namespace App\middleware;
    // session_start();

    class Auth {
        public function __invoke($req,$res,$next){
            if(!isset($_SESSION['user']) && !isset($_SESSION['type'])){

                $_SESSION['notLogin'] = true;
                return $res->withRedirect('\login');

            }
            return $next($req, $res);
        }
    }
?>
