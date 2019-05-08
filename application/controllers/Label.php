
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
use \Firebase\JWT\JWT;

include '/var/www/html/codeigniter/application/controllers/JWT.php';

// below file is required to work on
// include '/var/www/html/codeigniter/application/Service/LabelService.php';

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
        // $this->refService = new LabelService();
    }

    // public function addingLafsbel(){
    //     $email = $_POST['email'];
    //     $label = $_POST['labelmodel'];
    //     $this->refService->labelAddingService($email,$label);
    //     $this->load->library('doctrine');
    //     $em = $this->doctrine->em;
    // }

    public function addingLabel()
    {
        $email = $_POST['email'];
        $label = $_POST['labelname'];

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

        $em = $this->doctrine->em;
        $em->persist($group);
        $em->flush();

    }
    public function fetchingLabel()
    {
        // $email = $_POST['email'];
        // $this->refService->labelFetchingService($email);

        // $email = $_POST['email'];
        // $label = $_POST['labelmodel'];

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

        $query = $em->createQuery("SELECT u.id,u.userId,u.labelname FROM \Entity\DocLabel u WHERE u.userId = '$userId'");
        $users = $query->getResult();

        // $arr = $users[0];

        // $users = $query->getScalarResult();
        // return $users;

        print json_encode($users);

    }

    public function deleteLabel()
    {
        $email = $_POST['email'];
        $label = $_POST['labelname'];

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
        $query = $em->createQuery("DELETE \Entity\DocLabel u WHERE u.id = '$label'");
        $labelobj = $query->getResult();

    }
    public function updateLabel()
    {

        $email = $_POST["email"];
        $newLabel = $_POST["newLabel"];
        $labId = $_POST["labId"];

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

        $query = $em->createQuery("UPDATE \Entity\DocLabel u SET u.labelname = '$newLabel' WHERE u.id = '$labId' AND u.userId ='$userId'");
        $users = $query->getResult();

    }

    public function getAllLabeledPinnedNotes()
    {
        $labelname = $_POST["labelname"];
        $email = $_POST["email"];

        $sekretkey = "chandu";

        $channel = new ConnectingToRedis();
        $client = $channel->redisConnection();
        $token = $client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;

        $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$userId' and l.labelname ='$labelname'  and archive = 0 and deleteNote = 0 and pin = 1 ORDER BY n.id DESC";

        $statement = $this->db->conn_id->prepare($query);

        if ($statement->execute()) {

            $arr = $statement->fetchAll(PDO::FETCH_ASSOC);

            print json_encode($arr);
        }
    }
    public function getAllLabeledNotes()
    {

        $labelname = $_POST["labelname"];
        $email = $_POST["email"];

        $sekretkey = "chandu";

        $channel = new ConnectingToRedis();
        $client = $channel->redisConnection();
        $token = $client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;

        $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$userId' and l.labelname ='$labelname'  and archive = 0 and deleteNote = 0 and pin = 0 ORDER BY n.id DESC";

        $statement = $this->db->conn_id->prepare($query);

        if ($statement->execute()) {

            $arr = $statement->fetchAll(PDO::FETCH_ASSOC);

            print json_encode($arr);
        }

    }

    public function setlabeleledNotes()
    {
        $email = $_POST["email"];

        $takeANote = $_POST["takeANote"];

        $title = $_POST["title"];

        $dateAndTime = $_POST["dateAndTime"];
        
        $labelname = $_POST["labelname"];

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
        // $group = new Entity\DocLabel;
        // $group->getUserId($labelname);

        $group = new Entity\DocLabel;

        $group->setLabelName($labelobj[0]['labelname']);
        $group->setUserId($labelobj[0]['userId']);

        $em = $this->doctrine->em;

        $user->setDocLabel($group);

        $em = $this->doctrine->em;
        $em->persist($user);
        $em->flush();

    }

}
