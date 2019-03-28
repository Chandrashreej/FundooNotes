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
include '/var/www/html/codeigniter/application/Service/MoreOptionService.php';

/**
 * creation of login class that extends CI_Controller
 */
class MoreOptions extends CI_Controller
{
    /**
     * @var string $NoteService
     */
    private $moreService = "";

    /**
     * constructor establish DB connection
     */
    public function __construct()
    {
        parent::__construct();
        $this->moreService = new MoreOptionsSevice();
    }
    public function coloringBackgroundFunction()
    {
        $id = $_POST["id"];
        $color = $_POST["value"];
        return $this->moreService->coloringBackgroundFunctionService($id,$color);
    }
    public function coloringBackgroundForReminder()
    {
        $id = $_POST["id"];
        $color = $_POST["value"];
        return $this->moreService->coloringBackgroundFunctionServiceForReminder($id,$color);
    } 
}