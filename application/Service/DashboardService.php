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
    public function isSetReminderDialogService($email, $title, $takeANote, $dateAndTime, $color, $id)
    {
        if ($title == "null") {
            $title = "";
        }
        if ($takeANote == "null") {
            $takeANote = "";
        }

        $query = "UPDATE userReminder SET title  = '$title', takeANote = '$takeANote', dateAndTime = '$dateAndTime', color = '$color' WHERE id = '$id'";

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
    public function isSetNotesService($email, $title, $takeANote, $dateAndTime, $color, $image, $pin, $notelabelid)
    {
        // $headers = apache_request_headers();
        // print_r($headers);
        if($pin != 1)
        {
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
        //$color = "white";
        $index= "";
        if ($token != null) {

            $jwt = new JWT();
            if ($jwt->verifyc($token, $sekretkey)) {

                $query = "INSERT into userNotes (userId,title,takeANote,dateAndTime, archive, deleteNote , color, image,pin, indexId) values ('$userId','$title','$takeANote','$dateAndTime','$archive', '$delete','$color', '$image', '$pin', '$index')";

                $stmt = $this->db->conn_id->prepare($query);
                $res = $stmt->execute();

                if ($res) {

                    $query = "SELECT * FROM userNotes where userId = '$userId' and title = '$title' ";

                    $statement = $this->connect->prepare($query);

                    if ($statement->execute()) {

                        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($arr as $notesData) {

                            $phonenum = $notesData['title'];
                
                            $index = $notesData['id'];
                        }
 
                        // $index = ($arr[0]["id"]);


                        $query = "INSERT into labelNoteMap (noteId, labelId) values ('$index', '$notelabelid')";

                        $statement = $this->db->conn_id->prepare($query);
        
                        if ($statement->execute()) {
                            $result = array(
                                "message" => "200",
                            );
                            print json_encode($result);
                            return "200";
                        }


                        }

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

    public function setAllReminderService($email, $title, $takeANote, $dateAndTime, $color)
    {
        // $dateAndTime = "";

        if ($title == "null") {
            $title = "";
        }
        if ($takeANote == "null") {
            $takeANote = "";
        }
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

                $query = "INSERT into userReminder (userId,title,takeANote,dateAndTime,color) values ('$userId','$title','$takeANote','$dateAndTime','$color')";

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

                // $query = "SELECT * from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId = '$userId' and archive = 0 and deleteNote = 0 and pin = 0 ORDER BY n.id DESC";
                $query ="SELECT *  from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$userId'  and archive = 0 and deleteNote = 0 and pin = 0 ORDER BY n.id DESC";


                // SELECT * from userNotes n Left JOIn labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on 
        //         ln.labelId=l.id where n.userId = 36 and archive = 0 and deleteNote = 0 and pin = 0 ORDER BY n.id DESC
// n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname
                $statement = $this->connect->prepare($query);

                if ($statement->execute()) {
                    $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                    // $array = array_reverse($arr);
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
    public function getAllReminderService($email)
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
                $query = "SELECT * FROM userNotes where userId = '$userId' and dateAndTime != 'undefined'";

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
    public function deleteNoteService($id)
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

        $channel = new ConnectingToRedis();
        $client = $channel->redisConnection();
        $token = $client->get('token');

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
                    // for($i=0;$i<count($arr);$i++)
                    // {
                    $firstname = ($arr[0]["firstname"]);

                    // $firstname =$arr[$i];

                    // }
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
    public function deleteReminderService($id)
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

                $query = "SELECT * FROM createuser where email = '$email'";

                $statement = $this->connect->prepare($query);

                if ($statement->execute()) {
                    $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                    // for($i=0;$i<count($arr);$i++)
                    // {
                    $image = ($arr[0]["image"]);

                    // $firstname =$arr[$i];

                    // }
                    print json_encode($image);
                } else {
                    $result = array(
                        "message" => "500",
                    );
                    print json_encode($result);
                    return "500";
                }
        //     } else {
        //         $result = array(
        //             "message" => "500",
        //         );
        //         print json_encode($result);
        //         return "500";
        //     }
        // } else {
        //     $result = array(
        //         "message" => "600",
        //     );
        //     print json_encode($result);
        //     return "600";
        // }
    }
    public function imageSetterService($email, $value)
    {

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
        //     } else {
        //         $result = array(
        //             "message" => "500",
        //         );
        //         print json_encode($result);
        //         return "500";
        //     }
        // } else {
        //     $result = array(
        //         "message" => "600",
        //     );
        //     print json_encode($result);
        //     return "600";
        // }
    }



    public function imageNote($base64,$uid,$noteid){
        $query = "UPDATE notes SET image = '$base64'  where user_id = '$uid' AND id='$noteid'";
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

            $query ="SELECT *  from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$userId'  and archive = 0 and deleteNote = 0 and pin = 1 ORDER BY n.id DESC";

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
