<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * class to handle the user api 
 * also act as a controller extends ci controller
 *      
 */
class Api extends CI_Controller
{
    /**
     * function to handl the http request called default as it is a index function 
     * 
     * @return void
     */
    public function index()
    {
        //checks the request of http
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->get();
        } elseif ($_SERVER["REQUEST_METHOD"] == "PUT") {
            $this->editUser();
        } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->addUser();
        } elseif ($_SERVER["REQUEST_METHOD"] == "DELETE") {
            $this->deleteUser();
        }
    }
    /**
     * function to return the data of all the users from database if null then returns all the user
     * 
     * @var userid integer value of user id
     * @return json user data of user in json format
     */
    public function get($userid = null)
    {
        $query = "SELECT * FROM address";
        if ($userid !== null) {
            $query .= " WHERE id = $userid";
        }
        $this->queryRun($query);
    }
    /**
     * function to add user in the database as a new entry in the database
     *  @return void
     */
    public function AddUser()
    {
        $newdetails = $_POST;
        $details = require_once("userarray.php");
        foreach ($newdetails as $key => $value) {
            if (array_key_exists($key, $details)) {
                $details[$key] = $value;
            }
        }
        $query = "INSERT INTO  address (fname,lname,mob) VALUES('" . $details["fname"] . "','" . $details["lname"] . "'," . $details["mob"] . ")";
        //echo $query ;
        $this->queryRun($query);
    }
    /**
     * function to edit user details of a saved user
     * 
     * @return void return void and trigger query run function
     */
    public function editUser()
    {
        // parsing input from http request 
        parse_str(file_get_contents("php://input"), $_PUT);
        // checking for correct input
        if (array_key_exists("id", $_PUT)) {
            $details = require_once("userarray.php");
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
    /**
     * funciton to delete user from the data base by id 
     * @return void
     */
    public function deleteUser($id = null)
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
        }
        else{
            $query = "DELETE FROM address WHERE id = $id";
            $this->queryRun($query);
        }
    }
    /**
     * function to return the response of the http request
     * 
     * @return void
     */
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
            if (is_bool($res))
                echo json_encode(array("status" => 200, "message" => "succes"), JSON_PRETTY_PRINT);
            else
                echo json_encode(array("status" => 200, "message" => $res->result()), JSON_PRETTY_PRINT);
        }
    }
}
?>
