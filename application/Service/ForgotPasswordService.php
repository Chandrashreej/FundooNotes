<?php
include '/var/www/html/codeigniter/application/static/LinkConstants.php';
include '/var/www/html/codeigniter/application/Service/DatabaseConnection.php';
include '/var/www/html/codeigniter/application/RabbitMQ/sender.php';

class ForgotPasswordService extends CI_Controller
{
    private $connect;
    public $constants = "";
    public function __construct()
    {
        parent::__construct();
        $ref = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $this->constants = new LinkConstants();

    }
    // public function userForgotPasswordService($email){

    //     $num = $this->isUserPresent($email);

    //     if ($num == 1) {
    //         $result = array(
    //             "message" => "200",
    //         );
    //         print json_encode($result);
    //         return "200";

    //     } else if ($num == 2) {

    //         $result = array(
    //             "message" => "204",
    //         );
    //         print json_encode($result);
    //         return "204";

    //     }
    //     return $result;
    // }
    public function isUserPresent($email)
    {
        $data[':email'] = $email;
        $query = "SELECT * FROM createuser where email = '$email'";

        $statement = $this->connect->prepare($query);

        if ($statement->execute($data)) {

            $result = $statement->fetchAll();
            $c = $statement->rowCount();
            if ($statement->rowCount() > 0) {

                return true;
            } else {
                return false;
            }
        }
    }
    public function userForgotPasswordService($email)
    {
        if ($this->isUserPresent($email)) {
            $ref = new SendMail();
            $token = md5($email);
            $query = "UPDATE createuser SET reset_key = '$token' where email = '$email'";
            $statement = $this->connect->prepare($query);
            $statement->execute();
            $sub = 'password recovery mail';
            $body = $this->constants->resetLinkMasssage . $this->constants->resetLink . $token;
            $response = $ref->sendEmail($email, $sub, $body);
            if ($response == "sent") {
                $data = array(
                    "message" => "200",
                );
                print json_encode($data);
                return "200";

            } else {
                $data = array(
                    "message" => "204",
                );
                print json_encode($data);
                return "204";

            }

        } else {
            $data = array(
                "message" => "404",
            );
            print json_encode($data);
            return "404";
        }
    }

    /**
     * @method checkEmail() check email is present
     * @return void
     */
    // public function checkEmail($email)
    // {
    //     $query     = "SELECT * FROM registration ORDER BY id";
    //     $statement = $this->connect->prepare($query);
    //     $statement->execute();
    //     $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
    //     foreach ($arr as $titleData) {
    //         if ($titleData['email'] == $email && $titleData['active'] == '1') {
    //             return true;
    //         }
    //     }
    //     return false;
    // }
}
