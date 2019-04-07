<?php
/********************************************************************************************/

/**
 *Controller Api
 *
 * @author chandrashree j
 * @since 09-01-2019
 */

/********************************************************************************************/
include '/var/www/html/codeigniter/application/Service/JWT.php';
require '/var/www/html/codeigniter/application/jwt/vendor/autoload.php';
include '/var/www/html/codeigniter/application/Service/ConnectingToRedis.php';
include '/var/www/html/codeigniter/application/static/LinkConstants.php';
include '/var/www/html/codeigniter/application/Service/DatabaseConnection.php';
/**
 * creation of Uselogin class that extends CI_Controller
 */
use \Firebase\JWT\JWT;

class Uselogin extends CI_Controller
{
    /**
     * @var string  $connect  PDO object
     */
    private $connect;

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
    /**
     * @method userLoginFunction() login in to fundo logic
     * @return void
     */
    public function userLoginFunction($email, $password)
    {

        $num = $this->isUserPresent($email, $password);
        if ($num == 1) {
            $login = new Uselogin;
            $token = $login->generateJWTToke($email);
            $result = array(
                "token" => $token,
                "message" => "200",
            );
            print json_encode($result);
            return "200";

        } else if ($num == 2) {

            $result = array(
                "message" => "204",
            );
            print json_encode($result);
            return "204";

        } else if ($num == 3) {

            $result = array(

                "message" => "400",
            );
            print json_encode($result);
            return "400";

        }
        return $result;
    }
    public function generateJWTToke($email)
    {

        $query = "SELECT * FROM createuser  where email = '$email'";
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        $sekretkey = "chandu";
        foreach ($arr as $titleData) {
            $phonenum = $titleData['phonenum'];

            $userId = $titleData['id'];
        }
        $payload = array(
            "phonenum" => $phonenum,
            "userId" => $userId,
        );

        $token = JWT::encode($payload, $sekretkey);
        $client = ConnectingToRedis::redisConnection();
        $client->set("token", $token);
        return $token;
    }
    /**
     * @method isUserPresent() check email and pass match
     * @return void
     */
    public function isUserPresent($email, $password)
    {
        $data[':email'] = $email;
        $query = "SELECT * FROM createuser where email = '$email'";

        $statement = $this->db->conn_id->prepare($query);

        if ($statement->execute($data)) {
            $result = $statement->fetchAll();

            if ($statement->rowCount() > 0) {

                foreach ($result as $row) {

                    if (password_verify($password, $row["password"])) {
                        return 1;
                    } else {
                        return 2;
                    }
                }
            } else {
                return 3;
            }
        }
    }
    public function emailpresent($email)
    {
        $query = "SELECT * FROM createuser where email = '$email'";
        $stmt = $this->db->conn_id->prepare($query);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }



    public function socialSigin($email, $name)
    {
        $emailExists = $this->emailpresent($email);
        if ($emailExists) {

            $login = new Uselogin;
            $token = $login->generateJWTToke($email);

            $data = array(
                "token" => $token,
                "message" => "200",
            );
            print json_encode($data);
        } else {

            $uid = uniqid();
            $client = ConnectingToRedis::redisConnection();
            
            $key =$client->get('scretkey');
            $query = "INSERT into createuser (firstname,email) values ('$name','$email')";
            $stmt = $this->db->conn_id->prepare($query);
            $res = $stmt->execute();
            if ($res) {
                $token = JWT::encode($email, $key);
                $data = array(
                    "token" => $token,
                    "message" => "200",
                );
                print json_encode($data);
            } else {
                $data = array(
                    "message" => "204",
                );
                print json_encode($data);

            }
        }
    }

}
