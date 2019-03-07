<?php
class ForgotPasswordService extends CI_Controller
{ 
    private $connect;
    public function __construct()
    {
        parent::__construct();
       
    }
    public function userForgotPasswordService($email){

        $num = $this->isUserPresent($email);

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

                return 1;
            } else {
                return 2;
            }
        }
    }
}