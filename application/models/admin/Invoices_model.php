<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices_Model extends CI_Model
{


    public function index_m()
    {
        return $this->db->select(INVOICES.'.*, '. VENDORS. '.name as vendor_name, '. VENDORS. '.email as vendor_email, '. BUILDINGS.'.code as building_code, '. BUILDINGS. '.address as building_address ')
        ->where(INVOICES.'.status !=', 'void')
        ->from(INVOICES)
        ->join(VENDORS, VENDORS.'.id = '.INVOICES.'.vendor_id')
        ->join(BUILDINGS, BUILDINGS.'.id = '.INVOICES.'.building_id')
        ->order_by(INVOICES.'.id', 'desc')
        ->get()->result();
    }


    public function show_m($id = NULL)
    {
        if ($id != NULL)
           return $this->db->where('id',$id)
            ->get(INVOICES)->row();
        else
            return false;
    }

    public function get_order_no($order_no = NULL)
    {
        if ($order_no != NULL)
           return $this->db->where('order_no',$order_no)
            ->get(INVOICES)->row();
        else
            return false;
    }

    public function update_m($id = NULL, $data = array())
    {
        if ($id != NULL && !empty($data))
            return $this->db->where('id', $id)->update(INVOICES, $data);
        else
            return false;
    }

    public function show_vendor_m($id = NULL)
    {
        if ($id != NULL)
           return $this->db->where('id',$id)
            ->where("status", 1)
            ->where("reference_account_status", 1)
            ->get(VENDORS)->row();
        else
            return false;
    }

    public function show_building_m($id = NULL){
        if ($id != NULL){
            return $this->db->select('b.*,ba.customer_id,ba.payment_method_id')
            ->where('b.id',$id)
            ->from(BUILDINGS.' as b')
            ->join(BANKS.'  as ba','ba.building_id = b.id')
            ->order_by("ba.id",'desc')
            ->get()->row();
        }
        else
            return false;
    }

    public function show_owner_m($id = NULL)
    {
        if ($id != NULL)
           return $this->db->where('id',$id)
            ->where("status", 1)
            ->get(OWNERS)->row();
        else
            return false;
    }

    // getting customer id, payment method id and total amount through invoice_id
    public function get_payment_int_m($id = NULL){
        if ($id != NULL){
            return $this->db->select('ba.payment_method_id,ba.customer_id,i.total_amount, p.status, p.payment_id')
            ->where('i.id',$id)
            ->from(INVOICES.' as i')
            ->join(PAYMENTS.'  as p','i.id = p.invoice_id')
            ->join(BANKS.'  as ba','ba.building_id = i.building_id')
            ->get()->row();
        }
        else
            return false;
    }

    // active vendors only
    public function get_vendors_m()
    {
        return $this->db->where("status", 1)
        ->where("reference_account_status", 1)
        ->get(VENDORS)->result();
    }

     public function get_buildings_m(){
        
        return $this->db->select('b.*, o.name,o.email,o.picture,ba.bank_name,ba.account_number,ba.fingerprint,ba.currency,ba.customer_id,ba.setup_intent_id,ba.setup_intent_status,ba.payment_method_id,ba.status as ba_status')
        ->where('b.status',1)
        ->where('o.status',1)
        ->where('ba.status',1)
        ->where("ba.setup_intent_status", "succeeded")
        ->from(BUILDINGS.' as b')
        ->join(OWNERS.' as o','o.id = b.owner_id')
        ->join(BANKS.'  as ba','ba.building_id = b.id','left')
        ->order_by("ba.id",'desc')
        ->group_by("b.id,o.id")
        ->get()
        ->result();
        
    }

    public function add_m($data = array())
    {
        if (!empty($data)){
            $this->db->insert(INVOICES, $data);

            // INVOICE ID
            return $this->db->insert_id();

        }
        else
            return false;
    }

    public function add_payment_m($data = array())
    {
        if (!empty($data)){
            $this->db->insert(PAYMENTS, $data);

            // INVOICE ID
            return $this->db->insert_id();

        }
        else
            return false;
    }

    public function update_payment_m($invoice_id = NULL, $data = array())
    {
        if ($invoice_id != NULL && !empty($data))
            return $this->db->where('invoice_id', $invoice_id)->update(PAYMENTS, $data);
        else
            return false;
    }
    
    public function update_bank_m($building_id = NULL, $data = array())
    {
        if ($building_id != NULL && !empty($data))
            return $this->db->where('building_id', $building_id)->update(BANKS, $data);
        else
            return false;
    }

    public function get_total_payment_m(){
        
        return $this->db->select('SUM(total_amount) AS total_amount')
        ->from(INVOICES)
        ->get()->row()->total_amount;
        
    }

}
