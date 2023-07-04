<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices_Model extends CI_Model
{


    public function index_m()
    {
        return $this->db->select(INVOICES.'.*, '. BUILDINGS. '.code as building_no')
        ->from(INVOICES)
        ->join(BUILDINGS, BUILDINGS.'.id = '.INVOICES.'.building_id')
        ->order_by(INVOICES.".id", "desc")
        ->get()->result();
    }

    public function show_m($id = NULL)
    {
        if ($id != NULL)
           return $this->db->where('id',$id)->where("can_staff_pay",1)
            ->get(INVOICES)->row();
        else
            return false;
    }

    public function update_m($id = NULL, $data = array())
    {
        if ($id != NULL && !empty($data))
            return $this->db->where('id', $id)->where("can_staff_pay",1)
            ->update(INVOICES, $data);
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

    
    public function get_order_no($order_no = NULL)
    {
        if ($order_no != NULL)
           return $this->db->where('order_no',$order_no)
            ->get(INVOICES)->row();
        else
            return false;
    }

}
