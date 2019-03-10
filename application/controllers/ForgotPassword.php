<?php

//helps to get the access the access the files within framework
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
include ('/var/www/html/codeigniter/application/Service/ForgotPasswordService.php');

/**
 * creation of login class that extends CI_Controller
 */
class ForgotPassword extends CI_Controller
{
    private $logService = "";
    public function __construct()
    {
        parent::__construct();
        $this->forgotService = new ForgotPasswordService();
    }

    public function forgotPasswordFunction()
    {
        $email = $_POST["email"];

        return $this->forgotService->userForgotPasswordService($email);
    }

    public function resetPasswordFunction()
    {
        $token = $_POST["token"];
        $password = $_POST["password"];
        $password=password_hash($password, PASSWORD_DEFAULT);

        return $this->forgotService->userResetPasswordService($token, $password);
    }
    public function getEmailId()
    {
        $token = $_POST["token"];
        return $this->forgotService->getEmailId($token);

    }

}
