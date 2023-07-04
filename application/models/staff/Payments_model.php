<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments_Model extends CI_Model
{


    public function index_m()
    {
        return $this->db->select(PAYMENTS.'.*, '. BUILDINGS. '.code as building_no, '. INVOICES. '.order_no')
        ->from(PAYMENTS)
        ->join(INVOICES, INVOICES.'.id = '.PAYMENTS.'.invoice_id')
        ->join(BUILDINGS, BUILDINGS.'.id = '.INVOICES.'.building_id')
        ->order_by(PAYMENTS.".id", "desc")
        ->group_by(PAYMENTS.'.id')
        ->get()->result();
    }




}
