<?php
/********************************************************************************************/

/**
 *Controller Api
 *
 * @author chandrashree j
 * @since 09-01-2019
 */

/********************************************************************************************/

//helps to get the access the files within framework
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');

// below file is required to work on
include '/var/www/html/codeigniter/application/Service/ForgotPasswordService.php';

/**
 * creation of login class that extends CI_Controller
 */
class ForgotPassword extends CI_Controller
{

    /**
     * @var string $serviceReference serviceReference
     */
    private $logService = "";
    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        parent::__construct();
        $this->forgotService = new ForgotPasswordService();
    }
    /**
     * @method forgotPasswordFunction() sending reseting password ink to registered email
     * @return void
     */
    public function forgotPasswordFunction()
    {
        $email = $_POST["email"];

        return $this->forgotService->userForgotPasswordService($email);
    }
    /**
     * @method resetPasswordFunction() resets the pass word of corresesponding email
     * @return void
     */
    public function resetPasswordFunction()
    {
        $token = $_POST["token"];
        $password = $_POST["password"];
        $password = password_hash($password, PASSWORD_DEFAULT);

        return $this->forgotService->userResetPasswordService($token, $password);
    }

    /**
     * @method getEmailId() ge the forgotten email id
     * @return void
     */
    public function getEmailId()
    {
        $token = $_POST["token"];
        return $this->forgotService->getEmailId($token);

    }

}
