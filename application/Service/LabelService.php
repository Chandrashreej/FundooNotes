

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

include '/var/www/html/codeigniter/application/static/LinkConstants.php';
include '/var/www/html/codeigniter/application/Service/DatabaseConnection.php';
include '/var/www/html/codeigniter/application/Service/verifyAPICalls.php';
include '/var/www/html/codeigniter/application/Service/ConnectingToRedis.php';
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Authorization");
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin,Content-Range, Authorization, Content-Description, Content-Disposition,');
include '/var/www/html/codeigniter/application/Service/JWT.php';
header("Access-Control-Allow-Methods: GET, OPTIONS, POST");
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * creation of ForgotPasswordService class that extends CI_Controller
 */
//
use \Firebase\JWT\JWT;

class LabelService extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function labelAddingService($email, $label)
    {
        $sekretkey = "chandu";

        $channel = new ConnectingToRedis();
        $client = $channel->redisConnection();
        $token = $client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;

        $query = "INSERT into labels (userId, label, creationTime) values ('$userId','$label',now())";
        $stmt = $this->db->conn_id->prepare($query);
        $res = $stmt->execute();
        if ($res) {
            $data = array(
                "status" => "200",
            );
            print json_encode($data);
        } else {
            $data = array(
                "status" => "204",
            );
            print json_encode($data);
            return "204";
        }
    }

    public function labelFetchingService($email)
    {
        $sekretkey = "chandu";

        $channel = new ConnectingToRedis();
        $client = $channel->redisConnection();
        $token = $client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;
        $query = "SELECT * from labels Where userId ='$userId'  ";
        $stmt = $this->db->conn_id->prepare($query);
        $res = $stmt->execute();

        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print json_encode($arr);
    }
}
