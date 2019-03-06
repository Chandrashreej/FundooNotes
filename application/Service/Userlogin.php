<?php
class Uselogin extends CI_Controller
{
    private $connect;
    public function __construct()
    {
        parent::__construct();

    }

    public function userLoginFunction($email, $password)
    {

        $num = $this->isUserPresent($email, $password);
        if ($num == 1) {
            $result = array(
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

        } else if ($num == 0) {

            $result = array(

                "message" => "100",
            );
            print json_encode($result);
            return "100";

        }
        return $result;
    }

    public function isUserPresent($email, $password)
    {
        $query = "SELECT * FROM createuser ORDER BY id";

        $statement = $this->db->conn_id->prepare($query);

        $statement->execute();

        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($arr as $userData) {

            if (($userData['email'] == $email) && ($userData['password'] == $password)) {
                return 1;
            } else if (($userData['email'] == $email) && ($userData['password'] != $password)) {
                return 2;
            } else if (($userData['email'] != $email) && ($userData['password'] == $password)) {
                return 3;
            }

        }
        return 0;
    }

}
