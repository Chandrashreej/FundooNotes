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
include ('/var/www/html/codeigniter/application/Service/Userlogin.php');

/**
 * creation of login class that extends CI_Controller
 */
class Login extends CI_Controller
{

    
}