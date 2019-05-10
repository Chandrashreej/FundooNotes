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
include_once '/var/www/html/codeigniter/application/Service/JWT.php';
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

    private $client;
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
    public function moreOptionsService($id, $color, $flag)
    {
        // $headers = apache_request_headers();
        // print_r($headers);

        // $time = "";

        $sekretkey = "chandu";

        $token = $this->client->get('token');

        $array = array(
            'HS256',
        );

        $payload = JWT::decode($token, $sekretkey, $array);

        $userId = $payload->userId;

        // // $token = $headers['Authorization'];

        // if ($token != null) {
        // }
        //     $jwt = new JWT();
        //     if ($jwt->verifyc($token, $sekretkey)) {
        // }

        if ($flag == "color") {

            $query = "UPDATE userNotes set color = '$color' WHERE  id = '$id'";

            $statement = $this->connect->prepare($query);

            $res = $statement->execute();

            if ($res) {

                $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId,n.indexId,n.pin,n.archive,n.deleteNote,n.indexId,n.pin,n.archive,n.deleteNote from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.id ='$id'";

                $statement = $this->db->conn_id->prepare($query);

                $res = $statement->execute();

                $value = $statement->fetchAll(PDO::FETCH_ASSOC);

                if ($value['pin'] == 1) {

                    $key1 = "pinned";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));

                } elseif ($value['pin'] == 0) {
                    $key1 = "notes";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));
                }

            } else {

                $result = array(

                    "message" => "204",

                );

                print json_encode($result);

                return "204";

            }
        } elseif ($flag == "Archive") {

            $query = "UPDATE userNotes set archive = '$color' WHERE  id = '$id'";

            $statement = $this->connect->prepare($query);

            $res = $statement->execute();

            if ($res) {

                $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId,n.indexId,n.pin,n.archive,n.deleteNote from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$id'";

                $statement = $this->db->conn_id->prepare($query);

                $res = $statement->execute();

                $value = $statement->fetchAll(PDO::FETCH_ASSOC);

                $key1 = "archieve";

                $num = $this->client->hset($key1, $id, json_encode($value[0]));

                if ($value['pin'] == 1) {

                    $key1 = "pinned";

                    $num = $this->client->hdel($key1, $id);

                } elseif ($value['pin'] == 0) {
                    $key1 = "notes";

                    $num = $this->client->hdel($key1, $id);
                }

            } else {

                $result = array(

                    "message" => "204",

                );

                print json_encode($result);

                return "204";

            }
        } elseif ($flag == "Delete") {

            $query = "UPDATE userNotes set deleteNote = '$color' WHERE  id = '$id'";

            $statement = $this->connect->prepare($query);

            $res = $statement->execute();

            if ($res) {

                $query = "UPDATE userNotes set pin = 0 WHERE  id = '$id'";

                $statement = $this->connect->prepare($query);

                $res = $statement->execute();

                if ($res) {

                    $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId,n.indexId,n.pin,n.archive,n.deleteNote from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$id'";

                    $statement = $this->db->conn_id->prepare($query);

                    $res = $statement->execute();

                    $value = $statement->fetchAll(PDO::FETCH_ASSOC);

                    $key1 = "trash";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));

                    if ($value['pin'] == 1) {

                        $key1 = "pinned";

                        $num = $this->client->hdel($key1, $id);

                    } elseif ($value['pin'] == 0) {
                        $key1 = "notes";

                        $num = $this->client->hdel($key1, $id);
                    }

                }

            } else {

                $result = array(

                    "message" => "204",

                );
                print json_encode($result);

                return "204";

            }
        } elseif ($flag == "deleteDate") {

            $query = "UPDATE userNotes set dateAndTime = '$color' WHERE  id = '$id'";

            $statement = $this->connect->prepare($query);

            $res = $statement->execute();

            if ($res) {

                $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId,n.indexId,n.pin,n.archive,n.deleteNote from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$id'";

                $statement = $this->db->conn_id->prepare($query);

                $res = $statement->execute();

                $value = $statement->fetchAll(PDO::FETCH_ASSOC);

                if ($value['pin'] == 1) {

                    $key1 = "pinned";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));

                } elseif ($value['pin'] == 0) {
                    $key1 = "notes";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));
                }

            } else {

                $result = array(

                    "message" => "204",

                );
                print json_encode($result);

                return "204";
            }

        } elseif ($flag == "image") {

            $query = "UPDATE userNotes set image = '$color' WHERE  id = '$id'";

            $statement = $this->connect->prepare($query);

            $res = $statement->execute();

            if ($res) {

                $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId,n.indexId,n.pin,n.archive,n.deleteNote from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$id'";

                $statement = $this->db->conn_id->prepare($query);

                $res = $statement->execute();

                $value = $statement->fetchAll(PDO::FETCH_ASSOC);

                if ($value['pin'] == 1) {

                    $key1 = "pinned";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));

                } elseif ($value['pin'] == 0) {
                    $key1 = "notes";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));
                }

            } else {

                $result = array(

                    "message" => "204",

                );
                print json_encode($result);

                return "204";

            }
        } elseif ($flag == "reminderValue") {

            $query = "UPDATE userNotes set dateAndTime = '$color' WHERE  id = '$id'";

            $statement = $this->connect->prepare($query);

            $res = $statement->execute();

            if ($res) {

                $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId,n.indexId,n.pin,n.archive,n.deleteNote,n.index from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.id ='$id'";

                $statement = $this->db->conn_id->prepare($query);

                $res = $statement->execute();

                $value = $statement->fetchAll(PDO::FETCH_ASSOC);
                
                    if ($value['pin'] == 1) {

                        $key1 = "pinned";

                        $num = $this->client->hset($key1, $id, json_encode($value[0]));

                    } elseif ($value['pin'] == 0) {
                        $key1 = "notes";

                        $num = $this->client->hset($key1, $id, json_encode($value[0]));
                    }

                

            } else {

                $result = array(

                    "message" => "204",

                );
                print json_encode($result);

                return "204";

            }
        } elseif ($flag == "pinned") {

            $query = "UPDATE userNotes set pin = '$color' WHERE  id = '$id'";

            $statement = $this->connect->prepare($query);

            $res = $statement->execute();

            if ($res) {

                $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId,n.indexId,n.pin,n.archive,n.deleteNote from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$id'";

                $statement = $this->db->conn_id->prepare($query);

                $res = $statement->execute();

                $value = $statement->fetchAll(PDO::FETCH_ASSOC);

                if ($color == 1) {

                    $key1 = "pinned";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));

                    $key1 = "notes";

                    $num = $this->client->hdel($key1, $id);

                } elseif ($color == 0) {

                    $key1 = "pinned";

                    $num = $this->client->hdel($key1, $id);

                    $key1 = "notes";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));
                }

            } else {

                $result = array(

                    "message" => "204",

                );
                print json_encode($result);

                return "204";

            }

        } elseif ($flag == "closelabel") {

            $query = "DELETE FROM labelNoteMap WHERE noteId = '$id' and labelId = '$color'";

            $statement = $this->connect->prepare($query);

            $res = $statement->execute();

            if ($res) {

                $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId,n.indexId,n.pin,n.archive,n.deleteNote from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$id'";

                $statement = $this->db->conn_id->prepare($query);

                $res = $statement->execute();

                $value = $statement->fetchAll(PDO::FETCH_ASSOC);

                if ($value['pin'] == 1) {

                    $key1 = "pinned";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));

                } elseif ($value['pin'] == 0) {
                    $key1 = "notes";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));
                }

            } else {

                $result = array(

                    "message" => "204",

                );
                print json_encode($result);

                return "204";

            }
        } elseif ($flag == "addlabel") {

            $query = "INSERT into labelNoteMap (noteId, labelId) values ('$id', '$color')";

            $statement = $this->connect->prepare($query);

            $res = $statement->execute();

            if ($res) {

                $query = "SELECT n.title, n.id, n.takeANote, n.dateAndTime, n.color,n.image,l.labelname,ln.labelId,n.indexId,n.pin,n.archive,n.deleteNote from userNotes n Left JOIN labelNoteMap ln ON ln.noteId=n.id left JOIN doc_label l on ln.labelId=l.id where n.userId ='$id'";

                $statement = $this->db->conn_id->prepare($query);

                $res = $statement->execute();

                $value = $statement->fetchAll(PDO::FETCH_ASSOC);

                if ($value['pin'] == 1) {

                    $key1 = "pinned";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));

                } elseif ($value['pin'] == 0) {

                    $key1 = "notes";

                    $num = $this->client->hset($key1, $id, json_encode($value[0]));
                }

                $result = array(

                    "message" => "204",

                );
                print json_encode($result);

            } else {

                $result = array(

                    "message" => "204",

                );
                print json_encode($result);

                return "204";

            }
        }

    }

}
