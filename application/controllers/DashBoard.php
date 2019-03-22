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
        // $time = $_POST["time"];
        
        // $this->load->library('Redis');
        // $redis = $this->redis->config();
        // $redis->set($email, $email);
        return $this->NoteService->isSetNotesService($email, $title, $takeANote);
    }
    public function setReminderNotes()
    {
        $email = $_POST["email"];
        $takeANote = $_POST["takeANote"];
        $title = $_POST["title"];
        // $this->load->library('Redis');
        // $redis = $this->redis->config();
        // $redis->set($email, $email);
        return $this->NoteService->setAllReminderService($email, $title, $takeANote);
    }
    public function getAllNotes()
    {

        $email = $_POST["email"];
        return $this->NoteService->getAllNotesService($email);
    }
    public function getAllReminderNotes()
    {

        $email = $_POST["email"];
        return $this->NoteService->getAllReminderService($email);
    }
    public function deleteNote()
    {

        $id = $_POST["id"];
        return $this->NoteService->deleteNoteService($id);
    }
    public function deleteReminder()
    {

        $id = $_POST["id"];
        return $this->NoteService->deleteReminderService($id);
    } 
}
