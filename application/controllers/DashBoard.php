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
header("Access-Control-Allow-Methods: GET, OPTIONS");
defined('BASEPATH') or exit('No direct script access allowed');

// below file is required to work on
include '/var/www/html/codeigniter/application/Service/DashboardService.php';

/**
 * creation of login class that extends CI_Controller
 */
class DashBoard extends CI_Controller
{
    /**
     * @var string $NoteService
     */
    private $NoteService = "";

    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        parent::__construct();
        $this->NoteService = new DashboardService();
    }
    public function setNotes()
    {

        $email = $_POST["email"];
        $takeANote = $_POST["takeANote"];
        $title = $_POST["title"];
        // $this->load->library('Redis');
        // $redis = $this->redis->config();
        // $redis->set($email, $email);
        return $this->NoteService->isSetNotesService($email, $title, $takeANote);
    }
    
    public function getAllNotes()
    {

        $email = $_POST["email"];
        return $this->NoteService->getAllNotesService($email);
    }
}
