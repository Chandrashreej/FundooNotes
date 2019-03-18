<?php
/********************************************************************************************/

/**
 *Controller Api
 *
 * @author chandrashree j
 * @since 09-01-2019
 */

/********************************************************************************************/

//helps to get the access the access the files within framework
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');

// below file is required to work on
include '/var/www/html/codeigniter/application/Service/Userlogin.php';

/**
 * creation of login class that extends CI_Controller
 */
class Login extends CI_Controller
{
    /**
     * @var string $logService
     */
    private $logService = "";

    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        parent::__construct();
        $this->logService = new Uselogin();
    }

    /**
     * @method signin() to login in to application logic
     * @return void
     */
    public function signin()
    {
        $email = $_POST["email"];
        $password = $_POST["password"];
        // $this->load->library('Redis');
        // $redis = $this->redis->config();
        // $redis->set($email, $email);
        return $this->logService->userLoginFunction($email, $password);
    }

}
