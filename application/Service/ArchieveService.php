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

class ArchiveService extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }
    public function archivednotes($email){

        $sekretkey = "chandu";

        $channel = new ConnectingToRedis();
        $client = $channel->redisConnection();
        $token = $client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;

        $query = "SELECT * from userNotes Where userId ='$userId' AND archive = '1' ";
        $stmt = $this->db->conn_id->prepare($query);
        $res = $stmt->execute();
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        print json_encode($arr);
    }
    public function archive($uid){




        $query = "UPDATE userNotes SET archive = '0'  where id = '$uid'";
        $stmt = $this->db->conn_id->prepare($query);
        $res = $stmt->execute();
        if ($res) {

            $sekretkey = "chandu";

            $channel = new ConnectingToRedis();
            $client = $channel->redisConnection();
            $token = $client->get('token');
    
            $array = array(
                'HS256',
            );
            $payload = JWT::decode($token, $sekretkey, $array);
    
            $userId = $payload->userId;

            $query = "SELECT * from userNotes Where userId ='$userId'";
            $stmt = $this->db->conn_id->prepare($query);
            $res = $stmt->execute();
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            print json_encode($arr);

            
        } else {
            $data = array(
                "status" => "204",
            );
            print json_encode($data);
            return "204";
        }
    }
    public function unarchieve($uid){
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



    public function getAllNotesService($email)
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

                $query = "SELECT * FROM userNotes where userId = '$userId' and archive = 0  and deleteNote = 0 and pin = 0";

                $statement = $this->db->conn_id->prepare($query);

                $res =$statement->execute();
                if ($res) {
                    $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $array = array_reverse($arr);
                    print json_encode($array);

                
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


public function getAllPinnedNotesService($email)
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

            $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname FROM userNotes where userId = '$userId' and archive = 0  and deleteNote = 0 and pin = 1";

            $statement = $this->db->conn_id->prepare($query);

            $res= $statement->execute();
            if ($res) {
                $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                $array = array_reverse($arr);
                print json_encode($array);

            
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