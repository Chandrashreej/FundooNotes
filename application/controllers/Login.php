<?php

//helps to get the access the access the files within framework
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * creation of login class that extends CI_Controller
 */
class Login extends CI_Controller
{

    /**
     * creating function signin for logging in to the web browser
     */
    public function signin()
    {

        session_start(); //session gets started when ever signing function is executed

        //the data is got from the webpage and that data is decoded
        $form_data = json_decode(file_get_contents("php://input"));

        $validation_error = ''; //creating local variable

        //to check wheather the user has entered the emsil
        if (empty($form_data->email)) {

            $error[] = 'Email is Required';

        } else {

            //to check wheather the user has entered the valid emsil
            if (!filter_var($form_data->email, FILTER_VALIDATE_EMAIL)) {

                $error[] = 'Invalid Email Format';

            } else {

                $data[':email'] = $form_data->email;
            }
        }
        //to check wheather the user has entered the password
        if (empty($form_data->password)) {

            $error[] = 'Password is Required';
        }

        //if the error is empty it enters
        if (empty($error)) {
            //crfeating a query
            $query = "SELECT * FROM register WHERE email = '$form_data->email'";
            //passing the query for selecting data
            $statement = $this->db->conn_id->prepare($query);

            //if the statement gets executed enters the if loop
            if ($statement->execute($data)) {
                //featching all the data
                $result = $statement->fetchAll();

                if ($statement->rowCount() > 0) {
                    // getting all the data as a result
                    foreach ($result as $row) {
                        //verfying password
                        if (password_verify($form_data->password, $row["password"])) {

                            $_SESSION["name"] = $row["name"];

                        } else {
                            //if user has given wrong password
                            $validation_error = 'Wrong Password';
                        }
                    }
                } else {
                    //if user has given wrong email
                    $validation_error = 'Wrong Email';
                }
            }
        } else {

            $validation_error = implode(", ", $error);
        }

        $output = array(

            'error' => $validation_error,

        );
        //converting data back to json string
        echo json_encode($output);
    }


}
