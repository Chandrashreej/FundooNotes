<?php
class Uselogin extends CI_Controller
{ 
    private $connect;
    public function __construct()
    {
        parent::__construct();
       
    }


    public function login($email,$password)
    {
        $result = [];
        //crfeating a query
        $query = "SELECT * FROM createuser WHERE email = '$email'";
        //passing the query for selecting data
        $statement = $this->db->conn_id->prepare($query);
    
        if ($statement) {
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
?>