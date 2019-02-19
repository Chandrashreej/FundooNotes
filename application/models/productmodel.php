<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ProductModel extends CI_Model
{
   public function findAll() {
        return $this->db->get('product')->result();
    }
}

?>