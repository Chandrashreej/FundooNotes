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

include '/var/www/html/codeigniter/application/Service/Userlogin.php';

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
    private $client ;
    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        parent::__construct();
        $ref = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $this->constants = new LinkConstants();
        $channel = new ConnectingToRedis();
        $this->client = $channel->redisConnection();

    }
    public function isSetNotesDialogService($email, $title, $takeANote, $dateAndTime, $color, $id)
    {
        if ($title == "null") {
            $title = "";
        }
        if ($takeANote == "null") {
            $takeANote = "";
        }

        $query = "UPDATE userNotes SET title  = '$title', takeANote = '$takeANote', dateAndTime = '$dateAndTime', color = '$color' WHERE id = '$id'";

        $stmt = $this->connect->prepare($query);
        $res = $stmt->execute();

        if ($res) {


            $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$id'";

            $statement = $this->db->conn_id->prepare($query);

            $res = $statement->execute();

            $value = $statement->fetchAll(PDO::FETCH_ASSOC);

            if($value['pin'] == 1){

                $key1 = "pinned";

                $num = $this->client->hset($key1, $uid, json_encode($value));

            }elseif($value['pin'] == 0)
            {
                $key1 = "notes";

                $num = $this->client->hset($key1, $uid, json_encode($value));
            }

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

    public function isSetNotesService($email, $title, $takeANote, $dateAndTime, $color, $image, $pin, $notelabelid)
    {
        if ($pin != 1) {

            $pin = 0;
        }

        $archive = 0;

        $delete = 0;

        if ($title == "null") {

            $title = "";

        }
        if ($takeANote == "null") {

            $takeANote = "";
        }

        if ($image == "undefined") {

            $image = "";
        }

        $sekretkey = "chandu";

        $token = $this->client->get('token');

        $array = array(

            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;

        $index = "";

        if ($token != null) {

            $jwt = new JWT();

            if ($jwt->verifyc($token, $sekretkey)) {

                $query = "INSERT into userNotes (userId,title,takeANote,dateAndTime, archive, deleteNote , color, image,pin) values ('$userId','$title','$takeANote','$dateAndTime','$archive', '$delete','$color', '$image', '$pin')";

                $stmt = $this->db->conn_id->prepare($query);

                $res = $stmt->execute();

                if ($res) {

                    $query = "SELECT * from userNotes where id = LAST_INSERT_ID()";

                    $statement = $this->db->conn_id->prepare($query);

                    $res = $statement->execute();

                    $value = $statement->fetchAll(PDO::FETCH_ASSOC);


                    if($pin == 0)
                    {
                        $key1 = "notes";
                        

                        $this->client->hset($key1, $value['id'] , json_encode($value));                    
                    }
                    elseif($pin == 1)
                    {
                        $key1 = "pinned";

                        $this->client->hset($key1, $value['id'] , json_encode($value)); 
                    }


                    $query = "INSERT into labelNoteMap (noteId, labelId) values (LAST_INSERT_ID(), '$notelabelid')";

                    $statement = $this->db->conn_id->prepare($query);

                    $res = $statement->execute();

                    if ($res) {

                        $result = array(

                            "message" => "200",

                        );

                        print json_encode($result);

                        return "200";
                    } else {

                        // throw new Exception("Label cant be added to notes.....by chandu");
                        $result = array(
                            "message" => "200",
                        );
                        print json_encode($result);
                        return "200";
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

    public function getAllNotesService($email)
    {
        $time = "";

        $sekretkey = "chandu";


        $token = $this->client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;

        if ($token != null) {

            $jwt = new JWT();
            if ($jwt->verifyc($token, $sekretkey)) {

                $start = 0;
                $stop = -1;
                $key = "notes";


                $value = $this->client->hvals($key);
                // $value = $this->client->LRANGE($key, $start, $stop);
                if ($value == null) {

                    $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$userId'  and archive = 0 and deleteNote = 0 and pin = 0 ORDER BY n.id DESC";

                    $statement = $this->connect->prepare($query);

                    if ($statement->execute()) {
                        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);




                        foreach ($arr as $rads) {
                            //  $value = $arr[$i];
                            $value = json_encode($rads);
                            $key1 = "notes";
                            $id_var = $rads['id'];

                            $num = $this->client->hset($key1, $id_var, $value);

                        }
                        //
                        $value = json_encode($arr);
                        //  $key1 = "notes";
                        //  $start = 0;
                        //  $stop = -1;

                        //

                        //  $this->client = ConnectingToRedis::redisConnection();
                        //     $var = $this->client->hdel($key1, $id_var, $value);

                        //

                        // $this->client = ConnectingToRedis::redisConnection();
                        // $this->client->set("notes", $value);$j = 0; $j < count($value); $j++$i = 0; $i < count($arr); $i++

                        print($value);
                        //
                    }

                } else {
                    $str = [];
                    $var;
                    foreach ($value as $rads) {
                        $var = json_decode($rads);
                        array_push($str, $var);
                    }
                    // $this->client = ConnectingToRedis::redisConnection();

                    // $key1 = "notes";
                    // $start = -1;
                    // $var = json_encode($var);
                    // $adi = $this->client->lrem($key1, '0', $var);

                    print json_encode($str);
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
    public function getAllReminderService($email)
    {
        $time = "";

        $sekretkey = "chandu";

        $channel = new ConnectingToRedis();
        $this->client = $channel->redisConnection();
        $token = $this->client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;

        if ($token != null) {

            $jwt = new JWT();
            if ($jwt->verifyc($token, $sekretkey)) {

                $key = "reminder";

                $value = $this->client->hvals($key);

                if ($value == null) {

                    $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$userId'  and archive = 0 and deleteNote = 0 and pin = 0 and n.dateAndTime !='undefined' ORDER BY n.id DESC";

                    $statement = $this->connect->prepare($query);

                    if ($statement->execute()) {
                        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($arr as $rads) {
                            //  $value = $arr[$i];
                            $value = json_encode($rads);
                            $key1 = "reminder";
                            $id_var = $rads['id'];

                            $num = $this->client->hset($key1, $id_var, $value);

                        }
                        //
                        $value = json_encode($arr);
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
    public function deleteNoteService($id)
    {
        $time = "";

        $sekretkey = "chandu";


        $token = $this->client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;
        // $token = $headers['Authorization'];

        if ($token != null) {

            $jwt = new JWT();
            if ($jwt->verifyc($token, $sekretkey)) {

                $query = "DELETE from userNotes WHERE id = '$id'";
                $statement = $this->connect->prepare($query);
                $res = $statement->execute();

                if ($res) {

                    $key1 ="notes";
                    $key2 ="reminder";
                    $var = $this->client->hdel($key1, $id);
                    $var = $this->client->hdel($key2, $id);

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

    public function getNameValueService($email)
    {
        $sekretkey = "chandu";

        $token = $this->client->get('token');

        $array = array(

            'HS256',

        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;

        if ($token != null) {

            $jwt = new JWT();

            if ($jwt->verifyc($token, $sekretkey)) {

                $query = "SELECT * FROM createuser where email = '$email'";

                $statement = $this->connect->prepare($query);

                if ($statement->execute()) {

                    $arr = $statement->fetchAll(PDO::FETCH_ASSOC);

                    $firstname = ($arr[0]["firstname"]);

                    print json_encode($firstname);

                } else {

                    $result = array(

                        "message" => "500",
                    );

                    print json_encode($result);

                    return "500";

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

    public function imageFetcherService($email)
    {

        $sekretkey = "chandu";


        $token = $this->client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;
        // $token = $headers['Authorization'];

        if ($token != null) {

            $jwt = new JWT();
            if ($jwt->verifyc($token, $sekretkey)) {

                $query = "SELECT * FROM createuser where email = '$email'";

                $statement = $this->connect->prepare($query);

                if ($statement->execute()) {
                    $arr = $statement->fetchAll(PDO::FETCH_ASSOC);

                    $image = ($arr[0]["image"]);

                    print json_encode($image);
                } else {
                    $result = array(
                        "message" => "500",
                    );
                    print json_encode($result);
                    return "500";
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
    public function imageSetterService($email, $value)
    {

        $sekretkey = "chandu";

        $token = $this->client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;
        // $token = $headers['Authorization'];

        if ($token != null) {

            $jwt = new JWT();
            if ($jwt->verifyc($token, $sekretkey)) {

                $query = "UPDATE createuser set image = '$value' WHERE  email = '$email'";

                $statement = $this->db->conn_id->prepare($query);

                if ($statement->execute()) {
                    $result = array(
                        "message" => "500",
                    );
                    print json_encode($result);
                } else {
                    $result = array(
                        "message" => "500",
                    );
                    print json_encode($result);
                    return "500";
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


        $token = $this->client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;

        if ($token != null) {

            $jwt = new JWT();
            if ($jwt->verifyc($token, $sekretkey)) {


                $key = "pinned";


                $value = $this->client->hvals($key);

                if ($value == null) {

                    $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$userId'  and archive = 0 and deleteNote = 0 and pin = 1 ORDER BY n.id DESC";

                    $statement = $this->db->conn_id->prepare($query);

                    $res = $statement->execute();

                    if ($res) {

                        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($arr as $rads) {
                            //  $value = $arr[$i];
                            $value = json_encode($rads);
                            $key1 = "pinned";
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

    public function getAllPinnedReminderService($email)
    {
        $time = "";

        $sekretkey = "chandu";

        $token = $this->client->get('token');

        $array = array(
            'HS256',
        );
        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;
        // $token = $headers['Authorization'];

        if ($token != null) {

            $jwt = new JWT();
            if ($jwt->verifyc($token, $sekretkey)) {

                $key = "reminderPinned";


                $value = $this->client->hvals($key);

                if ($value == null) {

                    $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$userId'  and archive = 0 and deleteNote = 0 and pin = 1 and n.dateAndTime !='undefined' ORDER BY n.id DESC";

                    $statement = $this->db->conn_id->prepare($query);

                    $res = $statement->execute();

                    if ($res) {

                        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($arr as $rads) {
                            //  $value = $arr[$i];
                            $value = json_encode($rads);
                            $key1 = "reminderPinned";
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
