<?php
/********************************************************************************************/

/**
 *Controller Api
 *
 * @author chandrashree j
 * @since 09-01-2019
 */

/********************************************************************************************/

//helps to get the access the                                                                                                                                                                          files within framework
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: Authorization");
defined('BASEPATH') or exit('No direct script access allowed');

// below file is required to work on
include '/var/www/html/codeigniter/application/Service/Useregister.php';
/**
 * creation of login class that extends CI_Controller
 */
class Register extends CI_Controller
{
    /**
     * @var string $refService
     */
    private $refService = "";
    public $var;
    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        parent::__construct();
        $this->refService = new Useregister();
    }

    /**
     * @method signup() Adds data into the database
     * @return void
     */
    public function signup()
    {

        $fname = $_POST['firstname'];
        $lname = $_POST['lastname'];
        $email = $_POST['email'];
        $phonenum = $_POST['phonenum'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $var = $this->refService->registerUserService($fname, $lname, $phonenum, $email, $password);
        return $var;
    }

}
