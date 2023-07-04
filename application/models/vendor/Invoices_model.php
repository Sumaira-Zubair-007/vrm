<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices_Model extends CI_Model
{

    public function index_m($vendor_id = NULL)
    {
        return $this->db->select(INVOICES.'.*, '. BUILDINGS. '.code as building_no, '. BUILDINGS. '.address as building_address ')
        ->where(INVOICES.'.vendor_id', $vendor_id)
        ->from(INVOICES)
        ->join(BUILDINGS, BUILDINGS.'.id = '.INVOICES.'.building_id')
        ->order_by(INVOICES.".id", "desc")
        ->get()->result();
    }

    public function show_m($id = NULL, $vendor_id = NULL)
    {
        if ($id != NULL && $vendor_id != NULL)
           return $this->db->where('id',$id)->where("requires_vendor_invoice",1)
            ->where(INVOICES.'.vendor_id', $vendor_id)
            ->get(INVOICES)->row();
        else
            return false;
    }

    public function update_m($id = NULL, $vendor_id = NULL, $data = array())
    {
        if ($id != NULL && $vendor_id != NULL && !empty($data))
            return $this->db->where('id', $id)->where("requires_vendor_invoice",1)
            ->where(INVOICES.'.vendor_id', $vendor_id)
            ->update(INVOICES, $data);
        else
            return false;
    }




}
