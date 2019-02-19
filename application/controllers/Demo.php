<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
//require_once APPPATH . '/libraries/Format.php';

class Demo extends CI_Controller
{
    // public function index()
    // {
    //     $data['a']= 123;
    //     $data['username'] = 'abc';
    //     $this->load->view('index',$data);

    // }

    // public function hi($fullname)
    // {
    //     $data['result'] = 'Hi'.$fullname;
    //     $this->load->view('hi', $data);
    // }

    // public function sum($a, $b)
    // {
    //     $data['result'] = $a + $b;
    //     $this->load->view('hi', $data);
    // }
    // public function myredirect()
    // {
    //     redirect('demo/index');
    // }
    public function __construct()
    {
        parent::__construct();

    }
    public function get($userid = null)
    {
        $query = "SELECT * FROM address";
        if ($userid !== null) {
            $query .= " WHERE id = $userid";
        }
        $this->queryRun($query);
    }
    public function index()
    {

        //checks the request of http
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->get();
        } elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
            $this->editDetails();
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->addDetails();
        } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            $this->deleteDetails();
        }

    }
    public function addDetails()
    {
        $newdetails = $_POST;
        $details = require_once "userarray.php";
        foreach ($newdetails as $key => $value) {
            if (array_key_exists($key, $details)) {
                $details[$key] = $value;
            }
        }
        $query = "INSERT INTO  address (firstname,lastname,email) VALUES('" . $details["firstname"] . "','" . $details["lastname"] . "'," . $details["email"] . ")";
        //echo $query ;
        $this->queryRun($query);

    }
    public function editDetails()
    {
        // parsing input from http request
        parse_str(file_get_contents("php://input"), $_PUT);
        // checking for correct input
        if (array_key_exists("id", $_PUT)) {
            $details = require_once "userarray.php";
            foreach ($_PUT as $key => $value) {
                if (array_key_exists($key, $details)) {
                    $details[$key] = $value;
                }
            }
            $query = "UPDATE address SET ";
            foreach ($details as $key => $value) {
                if ($value !== null) {
                    if (is_string($value)) {
                        $query .= "$key = '$value',";
                    } else {
                        $query .= "$key = $value,";
                    }
                }
            }
            $query = substr($query, 0, -1) . " WHERE id = " . $details["id"];
            $this->queryRun($query);
        } else {
            echo json_encode(array("status" => 500, "message" => "id Required of user"), JSON_PRETTY_PRINT);
        }
    }
    public function deleteDetails($id = null)
    {
        if ($id == null) {
            parse_str(file_get_contents("php://input"), $_DELETE);
            //var_dump($_DELETE);
            if (array_key_exists("id", $_DELETE)) {
                $query = "DELETE FROM address WHERE id = " . $_DELETE["id"];
                $this->queryRun($query);
            } else {
                echo json_encode(array("status" => 500, "message" => "id Required of user"), JSON_PRETTY_PRINT);
            }
        } else {
            $query = "DELETE FROM address WHERE id = $id";
            $this->queryRun($query);
        }
    }
    public function response($code, $body = "")
    {
        $error = [200 => "sucess", 400 => 'failed'];
    }

    /**
     * function t orun query and return status to the user
     *
     * @return json the json data of the sql query
     */
    public function queryRun($query)
    {
        if (!($res = $this->db->query($query))) {
            $error = $this->db->error(); // Has keys 'code' and 'message'
            echo json_encode(array("status" => 500, "message" => $error["message"]), JSON_PRETTY_PRINT);
        } else {
            //   var_dump($res);
            if (is_bool($res)) {
                echo json_encode(array("status" => 200, "message" => "succes"), JSON_PRETTY_PRINT);
            } else {
                echo json_encode(array("status" => 200, "message" => $res->result()), JSON_PRETTY_PRINT);
            }

        }
    }

}
