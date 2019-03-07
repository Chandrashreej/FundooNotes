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

        } 
        return $result;
    }

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

}
