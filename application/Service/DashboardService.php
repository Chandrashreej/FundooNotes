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

class DashboardService extends CI_Controller
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
    public function isSetNotesService($email, $title, $takeANote)
    {
        // $headers = apache_request_headers();
        // print_r($headers);

        $time = "";

        $sekretkey = "chandu";

        $payload = JWT::decode($token, $$sekretkey);

        $userId = $payload["id"];
        // $token = $headers['Authorization'];

        if ($token != null) {

            $jwt = new JWT();
            if ($jwt->verify($token, $sekretkey)) {

                $query = "INSERT into userNotes (userId,title,takeANote,dateAndTime) values ('$userId','$title','$takeANote','$time')";

                $stmt = $this->connect->prepare($query);
                $res = $stmt->execute();

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
            }else{
                $result = array(
                    "message" => "500",
                );
                print json_encode($result);
                return "500";
            }
        }else{
            $result = array(
                "message" => "600",
            );
            print json_encode($result);
            return "600";
        }

    }

    public function setAllReminderService($email, $title, $takeANote)
    {

        $query = "INSERT into userReminder (email,title,takeANote) values ('$email','$title','$takeANote')";

        $stmt = $this->connect->prepare($query);
        $res = $stmt->execute();

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
    }

    public function getAllNotesService($email)
    {
        $query = "SELECT * FROM userNotes where email = '$email'";

        $statement = $this->connect->prepare($query);

        if ($statement->execute()) {
            $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
            print json_encode($arr);

        }

    }
    public function getAllReminderService($email)
    {
        $query = "SELECT * FROM userReminder where email = '$email'";

        $statement = $this->connect->prepare($query);

        if ($statement->execute()) {
            $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
            print json_encode($arr);
        }

    }
    public function deleteNoteService($id)
    {
        $query = "DELETE from userNotes WHERE id = '$id'";
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
    }

    public function deleteReminderService($id)
    {
        $query = "DELETE from userReminder WHERE id = '$id'";
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
    }
}
