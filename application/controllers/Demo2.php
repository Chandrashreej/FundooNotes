<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/Format.php';
use Restserver\Libraries\REST_Controller;

class Demo2 extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

    }

    public function work1_post()
    {
        echo 'Id:'.$this->post('id');
        echo '<br>Name:'.$this->post('name');
        echo '<br>Price:'.$this->post('price');
    }
}
