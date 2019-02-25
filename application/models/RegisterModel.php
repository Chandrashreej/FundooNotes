<?php
//helps to get the access the access the files within framework
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * creation of login class that extends CI_Controller
 */
class RegisterModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function execute($name, $email,$password)
    {
        //the data is added to database using query
        $query = "INSERT INTO register (name, email, password) VALUES ('$name', '$email', '$password')";

        $statement = $this->db->query($query);

        return $statement;
    }
}