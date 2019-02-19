<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product extends CI_Controller
{
    public function index()
    {
        $data['result'] = $this->productModel->findAll();

        $this->load->view('index', $data);

    }

    public function addtion()
    {
        
    }
}



?>