<?php
/********************************************************************************************/

/**
 *Controller Api
 *
 * @author chandrashree j
 * @since 09-01-2019
 */

/********************************************************************************************/
include '/var/www/html/codeigniter/application/jwt/vendor/firebase/php-jwt/src/JWT.php';
/**
 * creation of Uselogin class that extends CI_Controller
 */
class Uselogin extends CI_Controller
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
     * @method userLoginFunction() login in to fundo logic
     * @return void
     */
    public function userLoginFunction($email, $password)
    {

        $num = $this->isUserPresent($email, $password);
        if ($num == 1) {
            //$token = $this->jwtTokenGenerator($email);
            $data = array(
                //"token" => $token,
                "message" => "200",
            );
            print json_encode($data);
            return "200";

        } else if ($num == 2) {

            $result = array(
                "message" => "204",
            );
            print json_encode($result);
            return "204";

        } else if ($num == 3) {

            $result = array(

                "message" => "400",
            );
            print json_encode($result);
            return "400";

        }
        return $result;
    }
    /**
     * @method jwtTokenGenerator() 
     * @return token
     */
    public function jwtTokenGenerator($secretKey)
    {

        // // $payload   = ['iat' => time(), 'iss' => 'localhost', 'userid' => $email];
        // $secretKey = "prashant";
        $token = JWT::encode($email, $secretKey);
        return $token;

    }
    /**
     * @method isUserPresent() check email and pass match
     * @return void
     */
    public function isUserPresent($email, $password)
    {
        $data[':email'] = $email;
        $query = "SELECT * FROM createuser where email = '$email'";

        $statement = $this->db->conn_id->prepare($query);

        if ($statement->execute($data)) {
            $result = $statement->fetchAll();

            if ($statement->rowCount() > 0) {

                foreach ($result as $row) {

                    if (password_verify($password, $row["password"])) {
                        return 1;
                    } else {
                        return 2;
                    }
                }
            } else {
                return 3;
            }
        }
    }

}
