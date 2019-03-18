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
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * creation of ForgotPasswordService class that extends CI_Controller
 */
class DashboardService extends CI_Controller
{
    /**
     * @var string  $connect  PDO object
     */
    private $connect;
    public $constants = "";

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


        $query = "INSERT into userNotes (email,title,takeANote) values ('$email','$title','$takeANote')";

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
    
}
