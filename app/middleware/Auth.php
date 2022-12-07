<?php
    namespace App\middleware;
    // session_start();

    class Auth {
        public function __invoke($req,$res,$next){
            if(!isset($_SESSION['user']) && !isset($_SESSION['status'])){
                $_SESSION['notLogin'] = true;
                return $res->withRedirect('\login');
                
            }else if(isset($_SESSION['status'])){
                if($_SESSION['status'] == 0){
                    $_SESSION['notVericate'] = true;
                    return $res->withRedirect('\login');
                }else{
                    if($_SESSION['user'] == " "){
                        $_SESSION['freshAccount'] = true;
                    }else{
                        $_SESSION['freshAccount'] = false;
                    }
                }
            }
            // return die(var_dump($_SESSION));
            return $next($req, $res);
        }
    }
?>
