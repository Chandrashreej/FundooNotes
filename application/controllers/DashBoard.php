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

    public function setNotesDialog()
    {
        $email = $_POST["email"];
        $takeANote = $_POST["takeANote"];
        $title = $_POST["title"];
        $dateAndTime = $_POST["dateAndTime"];
        $color = $_POST["color"];
        $id = $_POST["id"];

        // $this->load->library('Redis');
        // $redis = $this->redis->config();
        // $redis->set($email, $email);
        return $this->NoteService->isSetNotesDialogService($email, $title, $takeANote, $dateAndTime, $color, $id);
    }
    public function setReminderDialog()
    {
        $email = $_POST["email"];
        $takeANote = $_POST["takeANote"];
        $title = $_POST["title"];
        $dateAndTime = $_POST["dateAndTime"];
        $color = $_POST["color"];
        $id = $_POST["id"];

        // $this->load->library('Redis');
        // $redis = $this->redis->config();
        // $redis->set($email, $email);
        return $this->NoteService->isSetReminderDialogService($email, $title, $takeANote, $dateAndTime, $color, $id);
    } 

    public function setNotes()
    {
        $email =        $_POST["email"];
        $takeANote =    $_POST["takeANote"];
        $title =        $_POST["title"];
        $dateAndTime =  $_POST["dateAndTime"];
        $color =        $_POST["color"];
        $image =        $_POST["image"];
        $pin =          $_POST["pinned"];
        $notelabelid =  $_POST["notelabelid"];

        // $this->load->library('Redis');
        // $redis = $this->redis->config();
        // $redis->set($email, $email);
        return $this->NoteService->isSetNotesService($email, $title, $takeANote, $dateAndTime, $color, $image, $pin, $notelabelid);
    }




    public function getNameValue()
    {
        $email = $_POST["email"];
        return $this->NoteService->getNameValueService($email);
    }

    public function setReminderNotes()
    {
        $email =        $_POST["email"];
        $takeANote =    $_POST["takeANote"];
        $title =        $_POST["title"];
        $dateAndTime =  $_POST["dateAndTime"];
        $color =        $_POST["color"];
        return $this->NoteService->setAllReminderService($email, $title, $takeANote, $dateAndTime, $color);
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

    public function imageFetcher()
    {
        $email = $_POST["email"];
        return $this->NoteService->imageFetcherService($email);
    }

    public function imageSetter()
    {
        $email = $_POST["email"];
        $value = $_POST["value"];
        return $this->NoteService->imageSetterService($email, $value);
    }

    public function getAllPinnedNotes()
    {

        $email = $_POST["email"];
        return $this->NoteService->getAllPinnedNotesService($email);
    }

}
