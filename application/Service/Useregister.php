<?php
class Useregister extends CI_Controller
{ 
    private $connect;
    public function __construct()
    {
        parent::__construct();
       
    }



    public function insertDb($fname,$lname,$phonenum,$email,$password)
    {
        $result = [];
        $data = [
            'firstname' => $fname,
            'lastname' => $lname,
            'phonenum'=>$phonenum,
            'email' => $email,
            'password'=>$password
        ];
        $query = "INSERT into createuser (firstname,lastname,phonenum,email,password) values ('$fname','$lname','$phonenum','$email','$password')";
        $stmt = $this->db->conn_id->prepare($query);
        $res = $stmt->execute($data);
        
        
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
     
}
?>