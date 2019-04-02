
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

class TrashService extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function trashednotesService($email)
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

        $query = "SELECT * from userNotes Where userId ='$userId' AND deleteNote = '1' ";
        $stmt = $this->db->conn_id->prepare($query);
        $res = $stmt->execute();
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print json_encode($arr);
    }
    public function untrashService($uid, $flag)
    {

        $query = "UPDATE userNotes SET deleteNote = '$flag'  where id = '$uid'";
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
    public function fetching($uid)
    {
        $time = "";

        $sekretkey = "chandu";

        $channel = new ConnectingToRedis();
        $client = $channel->redisConnection();
        $token = $client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;
        // $token = $headers['Authorization'];

        if ($token != null) {

            $jwt = new JWT();
            if ($jwt->verifyc($token, $sekretkey)) {

                $query = "SELECT * FROM userNotes where userId = '$userId' and archive = 0";

                $statement = $this->connect->prepare($query);

                if ($statement->execute()) {
                    $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                    print json_encode($arr);

                }
            } else {
                $result = array(
                    "message" => "500",
                );
                print json_encode($result);
                return "500";
            }
        } else {
            $result = array(
                "message" => "600",
            );
            print json_encode($result);
            return "600";
        }

    }
}