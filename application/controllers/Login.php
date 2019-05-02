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
    public $var;
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
        $var = $this->logService->userLoginFunction($email, $password);
        return $var;
    }

    

    public function logout()
    {
        $email = $_POST["email"];
        $var = $this->logService->logoutService($email);
        return $var;


    }

    public function socialLogin(){
        $email = $_POST['email'];
        $name = $_POST['firstname'];
        $pltForm = $_POST['pltForm'];
        $this->logService->socialSigin($email,$name, $pltForm);
    }

    public function adderToDatabase()
    {
		$this->load->library('doctrine');
		$em = $this->doctrine->em;

		// $query = $em->createQuery('SELECT u FROM Entity\Demo u ');
		// $users = $query->getResult();


		$group = new Entity\UserGroup;
		$group->setName('Users');

		$user = new Entity\User;
		$user->setUsername('wildlyinaccuratefgf');
		$user->setPassword('Passw0rdfgfg');
		$user->setEmail('wildlyinaccurate@gmail.com');
		$user->setGroup($group);

		// When you have set up your database, you can persist these entities:
		$em = $this->doctrine->em;
		$em->persist($group);
		$em->persist($user);
		$em->flush();

		$this->load->view('welcome_message', array(
			'user' => $user,
			'group' => $group,
		));
    }

}
