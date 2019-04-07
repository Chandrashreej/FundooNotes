
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
include '/var/www/html/codeigniter/application/Service/LabelService.php';

/**
 * creation of login class that extends CI_Controller
 */
class Label extends CI_Controller
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
        $this->refService = new LabelService();
    }
    public function addingLabel(){
        $email = $_POST['email'];
        $label = $_POST['labelmodel'];
        $this->refService->labelAddingService($email,$label);
    }
    public function fetchingLabel()
    {
        $email = $_POST['email'];
        $this->refService->labelFetchingService($email);
    }

    public function doctrine()
    {
        $items = Doctrine_Query::create()
            ->from('Example e')
            ->leftJoin('e.Foobar')
            ->where('e.id = ?', 20)
            ->execute();
    }
}