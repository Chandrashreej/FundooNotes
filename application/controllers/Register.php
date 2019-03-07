<?php
//helps to get the access the access the files within framework
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: Authorization");
defined('BASEPATH') or exit('No direct script access allowed');
include '/var/www/html/codeigniter/application/Service/Useregister.php';
/**
 * creation of login class that extends CI_Controller
 */
//header('Access-Control-Allow-Origin');
class Register extends CI_Controller
{
  
    /**
     * creating the function signup to get register
     */      
    
    private $refService = "";
    public function __construct()
    {
        parent::__construct();
         $this->refService = new Useregister();
    }

    public function signup(){
        
            $fname = $_POST['firstname'];
            $lname = $_POST['lastname'];
            $email = $_POST['email'];
            $phonenum =$_POST['phonenum'];
            $password = $_POST['password'];
            $password=password_hash($password, PASSWORD_DEFAULT);
            return  $this->refService->insertDb($fname,$lname,$phonenum,$email,$password);
    
    
    }

   
}
