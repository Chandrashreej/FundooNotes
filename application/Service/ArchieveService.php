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
include '/var/www/html/codeigniter/application/Service/ConnectingToRedis.php';
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Authorization");
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin,Content-Range, Authorization, Content-Description, Content-Disposition,');
include '/var/www/html/codeigniter/application/Service/JWT.php';
header("Access-Control-Allow-Methods: GET, OPTIONS, POST");
defined('BASEPATH') or exit('No direct script access allowed');
include '/var/www/html/codeigniter/application/Service/Userlogin.php';

/**
 * creation of ForgotPasswordService class that extends CI_Controller
 */
//
use \Firebase\JWT\JWT;

class ArchiveService extends CI_Controller
{
    private $client;
    public function __construct()
    {
        parent::__construct();
        $channel = new ConnectingToRedis();
        $this->client = $channel->redisConnection();
    }
    public function archivednotes($email)
    {

        $sekretkey = "chandu";

        $token = $this->client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;

        $key = "archieve";

        $value = $this->client->hvals($key);

        if ($value == null) {

            $query = "SELECT * from userNotes Where userId ='$userId' AND archive = '1' ";

            $stmt = $this->db->conn_id->prepare($query);

            $res = $stmt->execute();

            if ($res) {

                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($arr as $rads) {
                    //  $value = $arr[$i];
                    $value = json_encode($rads);

                    $key1 = "archieve";

                    $id_var = $rads['id'];

                    $num = $this->client->hset($key1, $id_var, $value);

                }
                $value = json_encode($arr);

                print($value);
            }
        } else {

            $str = [];

            $var;

            foreach ($value as $rads) {

                $var = json_decode($rads);
                
                array_push($str, $var);
            }

            print json_encode($str);
        }

    }
    public function archive($uid)
    {

        $query = "UPDATE userNotes SET archive = '0'  where id = '$uid'";

        $stmt = $this->db->conn_id->prepare($query);

        $res = $stmt->execute();

        if ($res) {

            $query = "SELECT * from userNotes where id = '$uid'";

            $statement = $this->db->conn_id->prepare($query);

            $res = $statement->execute();

            $value = $statement->fetchAll(PDO::FETCH_ASSOC);

            $key1 = "archieve";

            $num = $this->client->hdel($key1, $uid);

            if ($value['pin'] == 1) {

                $key1 = "pinned";

                $num = $this->client->hset($key1, $uid, json_encode($value));

            } elseif ($value['pin'] == 0) {
                $key1 = "notes";

                $num = $this->client->hset($key1, $uid, json_encode($value));
            }

            // $sekretkey = "chandu";

            // $channel = new ConnectingToRedis();
            // $this->client = $channel->redisConnection();
            // $token = $this->client->get('token');

            // $array = array(
            //     'HS256',
            // );
            // $payload = JWT::decode($token, $sekretkey, $array);

            // $userId = $payload->userId;

            // $query = "SELECT * from userNotes Where userId ='$userId'";
            // $stmt = $this->db->conn_id->prepare($query);
            // $res = $stmt->execute();
            // $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // print json_encode($arr);
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

}
