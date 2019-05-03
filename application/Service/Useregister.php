<?php
/********************************************************************************************/

/**
 *Controller Api
 *
 * @author chandrashree j
 * @since 09-01-2019
 */

/********************************************************************************************/
/**
 * creation of Useregister class that extends CI_Controller
 */
class Useregister extends CI_Controller
{
    /**
     * @var string  $connect  PDO object
     */
    private $connect;
    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        parent::__construct();

    }
    /**
     * @var string $fname
     * @var string $lname
     * @var string $email
     * @var string $phonenum
     * @var string $password
     * @method registration() Adds data into the database
     * @return void
     */
    public function registerUserService($fname, $lname, $phonenum, $email, $password)
    {
        $flag = $this->isEmailPresent($email, $phonenum);
        if ($flag == 0) {
            $result = [];
            $data = [
                'firstname' => $fname,
                'lastname' => $lname,
                'phonenum' => $phonenum,
                'email' => $email,
                'password' => $password,
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
            return $result;
        } else if ($flag == 1) {
            $data = array(
                "message" => "201",
            );
            print json_encode($data);
            return "201";

        } else {
            $data = array(
                "message" => "203",
            );
            print json_encode($data);
            return "203";

        }

    }
    /**
     * @method isEmailPresent() check email number duplicate
     * @return void
     */
    public function isEmailPresent($email, $number)
    {
        $query = "SELECT * FROM createuser ORDER BY email";
        $statement = $this->db->conn_id->prepare($query);
        $statement->execute();
        $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($arr as $titleData) {
            if (($titleData['email'] == $email) || ($titleData['phonenum'] == $number)) {
                if ($titleData['email'] == $email) {
                    //user email found duplicate
                    return 1;
                } else if ($titleData['phonenum'] == $number) {
                    // user phone found duplicate
                    return 2;
                }
            }
        }
        //no duplicate not found
        return 0;
    }

}
