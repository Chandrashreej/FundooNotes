<?php
//helps to get the access the access the files within framework
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * creation of login class that extends CI_Controller
 */
class Register extends CI_Controller
{
    /**
     * creating the function signup to get register
     */
    public function signup()
    {
        //creating a local variables
        $name = "";
        $password = "";
        $email = "";

        //getting all the data from the web page
        $form_data = json_decode(file_get_contents("php://input"));

        //creating a local variables
        $message = '';
        $validation_error = '';

        // if the name block is empty
        if (empty($form_data->name)) {

            $error[] = 'Name is Required';//messege is added to array

        } else {

            $name = $form_data->name;//else data is added to name
        }
        // if the email block is empty
        if (empty($form_data->email)) {

            $error[] = 'Email is Required';//messege is added to array

        } else {
            // if the email block is not empty but given wrong data
            if (!filter_var($form_data->email, FILTER_VALIDATE_EMAIL)) {

                $error[] = 'Invalid Email Format';

            } else {

                $email = $form_data->email;
            }
        }
        // if the password block is empty
        if (empty($form_data->password)) {

            $error[] = 'Password is Required';

        } else {
            //converting password to hashing code
            $password = password_hash($form_data->password, PASSWORD_DEFAULT);
        }

        //if the error array is empty
        if (empty($error)) {

            //the data is added to database using query
            $query = "INSERT INTO register (name, email, password) VALUES ('$name', '$email', '$password')";

            $statement = $this->db->query($query);

            if ($statement) {

                $message = 'Registration Completed';
            }
        } else {

            //else the message is shown 
            $validation_error = implode(", ", $error);
        }

        $output = array(

            'error' => $validation_error,
            'message' => $message,

        );
        
        //converting data back to json string
        echo json_encode($output);

    }
}
