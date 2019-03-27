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

class MoreOptionsSevice extends CI_Controller
{
    /**
     * @var string  $connect  PDO object
     */
    private $connect;
    public $constants = "";
    public $token = "";
    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        parent::__construct();
        $ref = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $this->constants = new LinkConstants();

    }
    public function coloringBackgroundFunctionService($id,$color)
    {
        // $headers = apache_request_headers();
        // print_r($headers);

        // $time = "";

        // $sekretkey = "chandu";
        
        // $channel = new ConnectingToRedis();
        // $client = $channel->redisConnection();
        // $token = $client->get('token');

        // $array = array(
        //     'HS256',
        // );
        // $payload = JWT::decode($token, $sekretkey, $array);

        // $userId = $payload->userId;
        // // $token = $headers['Authorization'];

        // if ($token != null) {

        //     $jwt = new JWT();
        //     if ($jwt->verifyc($token, $sekretkey)) {

                $query = "UPDATE userNotes set color = '$color' WHERE  id = '$id'";
                $statement = $this->connect->prepare($query);
                $res = $statement->execute();
                if ($res) {
                    $result = array(
                        "message" => "200",
                    );
                    print json_encode($result);
                    return "200";
                } else {
                    $result = array(
                        "message" => "204",
                    );
                    print json_encode($result);
                    return "204";
                }
//             } else {
//                 $result = array(
//                     "message" => "500",
//                 );
//                 print json_encode($result);
//                 return "500";
//             }
//         } else {
//             $result = array(
//                 "message" => "600",
//             );
//             print json_encode($result);
//             return "600";
//         }
 }
}


