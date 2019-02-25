<?php
//helps to get the access the access the files within framework
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * creation of login class that extends CI_Controller
 */
class LoginModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    public function execute($email)
    {
        //crfeating a query
        $query = "SELECT * FROM register WHERE email = '$email'";
        //passing the query for selecting data
        $statement = $this->db->conn_id->prepare($query);
        
        return $statement;
    }
}