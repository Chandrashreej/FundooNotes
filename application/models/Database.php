<?php
class Database extends CI_Model{

    public function __construct(){
        parent::__construct();
     //   $this->load->model("Database");
    }

    public function insertUser($user){
        $this->db->insert("users",$user);
    }
}
?>
