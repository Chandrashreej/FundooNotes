<?php
/********************************************************************************************/

/**
 *Controller Api
 *
 * @author chandrashree j
 * @since 09-01-2019
 */

/********************************************************************************************/

//helps to get the access the access the files within framework
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS, POST");
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Headers: Authorization");
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin,Content-Range, Authorization, Content-Description, Content-Disposition,');

// below file is required to work on
include '/var/www/html/codeigniter/application/Service/TrashService.php';

/**
 * creation of login class that extends CI_Controller
 */
class Trash extends CI_Controller
{
    /**
     * @var string $NoteService
     */
    private $refService = "";

    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        parent::__construct();
        $this->refService = new TrashService();
    }
    public function fetchTrash()
    {
        $email = $_POST['email'];
        $this->refService->trashednotesService($email);
    }

    
    public function unTrash()
    {
        $uid = $_POST['uid'];
        $flag = $_POST['flag'];
        $this->refService->untrashService($uid, $flag);
    }

}
