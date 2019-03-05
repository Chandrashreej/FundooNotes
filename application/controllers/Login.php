<?php

//helps to get the access the access the files within framework
defined('BASEPATH') or exit('No direct script access allowed');
include ('/var/www/html/codeigniter/application/Service/Userlogin.php');

/**
 * creation of login class that extends CI_Controller
 */
class Login extends CI_Controller
{
    private $logService = "";
    public function __construct()
    {
        parent::__construct();
         $this->logService = new Uselogin();
    }


    public function signin()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];

        
        return $this->logService->login($email, $password);
    }

    

}
