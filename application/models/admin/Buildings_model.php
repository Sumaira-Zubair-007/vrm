<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buildings_Model extends CI_Model
{


    public function index_m()
    {
        return $this->db->get(BUILDINGS)->result();
    }


    public function add_m($data = array())
    {
        if (!empty($data)){
            $this->db->insert(BUILDINGS, $data);

            // USER ID
            return $this->db->insert_id();

        }
        else
            return false;
    }


    public function show_m($id = NULL)
    {
        if ($id != NULL)
           return $this->db->where('id',$id)
            ->get(BUILDINGS)->row();
        else
            return false;
    }

    public function update_m($id = NULL, $data = array())
    {
        if ($id != NULL && !empty($data))
            return $this->db->where('id', $id)->update(BUILDINGS, $data);
        else
            return false;
    }

    public function show_with_owner_bank_m($id = NULL){
        if ($id != NULL){
            return $this->db->select('b.*, o.name,o.email,o.picture,ba.id as bid,ba.bank_name,ba.account_number,ba.fingerprint,ba.currency,ba.customer_id,ba.setup_intent_id,ba.setup_intent_status,ba.payment_method_id,ba.status as ba_status')
            ->where('b.id',$id)
            ->from(BUILDINGS.' as b')
            ->join(OWNERS.' as o','o.id = b.owner_id')
            ->join(BANKS.'  as ba','ba.building_id = b.id','left')
            ->order_by("ba.id",'desc')
            ->get()->row();
        }
        else
            return false;
    }

     // active owners only
    public function get_owners_m()
    {
        return $this->db->select("o.*,b.code")
        ->where("o.status", 1)
        // ->where("b.code", NULL)
        ->from(OWNERS.' as o')
        ->join(BUILDINGS.' as b', 'o.id = b.owner_id', 'left')
        ->group_by('o.id')
        ->order_by('o.id','desc')
        ->get()->result();
    }


    public function get_invoices_m($building_id = NULL)
    {
        if ($building_id != NULL){
            return $this->db->select(INVOICES.'.*, '. VENDORS. '.name as vendor_name, '. VENDORS. '.email as vendor_email')
            ->from(INVOICES)
            ->where("building_id", $building_id)
            ->where(INVOICES.'.status !=', 'void')
            ->join(VENDORS, VENDORS.'.id = '.INVOICES.'.vendor_id')
            ->order_by(INVOICES.'.id', 'desc')
            ->get()
            ->result();
        }
        else
            return false;
    }

     public function insert_bank_record($data = array())
    {
        if (!empty($data)){
            $this->db->insert(BANKS, $data);

            // USER ID
            return $this->db->insert_id();

        }
        else
            return false;
    }


     public function update_bank_record($setup_intent_id = NULL, $data = array())
    {
        if (!empty($setup_intent_id) && !empty($data)){
            $this->db->where('setup_intent_id', $setup_intent_id)->update(BANKS, $data);
            //
            return true;

        }
        else
            return false;
    }


    public function update_bank_m($id = NULL, $ba_id = NULL, $data = array())
    {
        if ($id != NULL && !empty($data))
            return $this->db->where('id', $ba_id)->where('building_id', $id)->update(BANKS, $data);
        else
            return false;
    }


}
