<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments_Model extends CI_Model
{


    public function index_m($vendor_id = NULL)
    {
        return $this->db->select(PAYMENTS.'.*, '. BUILDINGS. '.CODE as building_no, '. INVOICES. '.order_no,'. BUILDINGS. '.address as building_address ')
        ->from(PAYMENTS)
        ->join(INVOICES, INVOICES.'.id = '.PAYMENTS.'.invoice_id')
        ->join(BUILDINGS, BUILDINGS.'.id = '.INVOICES.'.building_id')
        ->where(PAYMENTS.'.vendor_id', $vendor_id)
        ->order_by(PAYMENTS.".id", "desc")
        ->get()->result();
    }




}
