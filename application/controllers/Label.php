
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
header("Access-Control-Allow-Methods: GET, OPTIONS, POST");
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Headers: Authorization");
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin,Content-Range, Authorization, Content-Description, Content-Disposition,');
include '/var/www/html/codeigniter/application/Service/ConnectingToRedis.php';
// use \Firebase\JWT\JWT;




include '/var/www/html/codeigniter/application/controllers/JWT.php';

// below file is required to work on
include '/var/www/html/codeigniter/application/Service/LabelService.php';

/**
 * creation of login class that extends CI_Controller
 */
class Label extends CI_Controller
{
    /**
     * @var string $NoteService
     */
    private $refService = "";

    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        parent::__construct();
        $this->refService = new LabelService();
    }


    public function addingLabel(){
        $email = $_POST['email'];
        $label = $_POST['labelmodel'];
        $this->refService->labelAddingService($email,$label);
        $this->load->library('doctrine');
        $em = $this->doctrine->em;
    }

    public function addingLabfgel(){
        $email = $_POST['email'];
        $label = $_POST['labelmodel'];

        $sekretkey = "chandu";

        $channel = new ConnectingToRedis();
        $client = $channel->redisConnection();
        $token = $client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;



        $this->load->library('doctrine');

        $em = $this->doctrine->em;


        $group = new Entity\DocLabel;
		$group->setLabelName($label);
        $group->setUserId($userId);

        $query = $em->find('Entity\DocLabel',1);

        $em = $this->doctrine->em;
		$em->persist($group);
        $em->flush();
        

    }
    public function fetchingLabel()
    {
        $email = $_POST['email'];
        $this->refService->labelFetchingService($email);
    }

    public function doctrine()
    {
        $items = Doctrine_Query::create()
            ->from('Example e')
            ->leftJoin('e.Foobar')
            ->where('e.id = ?', 20)
            ->execute();
    }

    public function labeler()
	{
		$this->load->library('doctrine');
		$em = $this->doctrine->em;

		// $query = $em->createQuery('SELECT u FROM Entity\Demo u ');
		// $users = $query->getResult();


		$group = new Entity\UserGroup;
		$group->setName('Users');

		$user = new Entity\User;
		$user->setUsername('wildlyinaccurate');
		$user->setPassword('Passw0rd');
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
