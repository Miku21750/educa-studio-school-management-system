<?php


    function encrypt($data, $password){
        $iv = substr(sha1(mt_rand()), 0, 16);
        $password = sha1($password);
    
        $salt = sha1(mt_rand());
        $saltWithPassword = hash('sha256', $password.$salt);
    
        // ABAIKAN NULL, TIDAK APA APA.
        $encrypted = openssl_encrypt(
          "$data", 'aes-256-cbc', "$saltWithPassword", null, $iv
        );
        $msg_encrypted_bundle = "$iv:$salt:$encrypted";
        return $msg_encrypted_bundle;
    }
    
    
    function decrypt($msg_encrypted_bundle, $password){
        $password = sha1($password);
    
        $components = explode( ':', $msg_encrypted_bundle );
        $iv            = $components[0];
        $salt          = hash('sha256', $password.$components[1]);
        $encrypted_msg = $components[2];
    
        // ABAIKAN NULL, TIDAK APA APA.
        $decrypted_msg = openssl_decrypt(
          $encrypted_msg, 'aes-256-cbc', $salt, null, $iv
        );
    
        if ( $decrypted_msg === false )
            return false;
        return $decrypted_msg;
    }

// "MASUKAN PASSWORD DISINI"
$insertPassword = $_GET['pass'];
// "MASUKAN SALT DISINI"
$insertSalt = $_GET['salt'];
// Mengenerate
$decryptPassword = encrypt($insertPassword, $insertSalt);
// Result
echo "\nMasukan password kedalam database melalui phpmyadmin\n";
echo $decryptPassword. "\n\n";

error_reporting(0);
$email = $_GET['email'];
if ($email != ""){
echo "Atau jalankan Querry ini didatabase :\n";
echo "UPDATE tbl_users SET password ='".$decryptPassword."' WHERE email='".$email."';\n\n";
}

// jalankan dengan 
// php-cgi -f .\passwordGenerator.php pass={Masukan_Password} salt={Masukan_Salt_disini} email={masukan_email_disini}