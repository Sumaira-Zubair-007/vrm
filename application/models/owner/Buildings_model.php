<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buildings_Model extends CI_Model
{

    public function get_building_m($owner_id = NULL, $building_id = NULL){
        if ($owner_id != NULL && $building_id != NULL){
            return $this->db->select('b.*, o.name,o.email,o.picture')
            ->where('b.id',$building_id)
            ->where("o.id", $owner_id)
            ->from(BUILDINGS.' as b')
            ->join(OWNERS.' as o','o.id = b.owner_id')
            ->get()->row();
        }
        else
            return false;
    }

    public function get_invoices_m($owner_id = NULL, $building_id = NULL)
    {
        if ($building_id != NULL){
            return $this->db->select('i.*')
            ->from(INVOICES.' as i')
            ->where("building_id", $building_id)
            ->where("b.owner_id", $owner_id)
            ->join(BUILDINGS.' as b','b.id = i.building_id')
            ->order_by('i.id', 'desc')
            ->get()
            ->result();
        }
        else
            return false;
    }

    public function show_with_owner_bank_m($id = NULL){
        if ($id != NULL){
            return $this->db->select('b.*, o.name,o.email,o.picture,ba.bank_name,ba.account_number,ba.fingerprint,ba.currency,ba.customer_id,ba.setup_intent_id,ba.setup_intent_status,ba.payment_method_id,ba.status as ba_status')
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


    public function update_m($id = NULL, $data = array())
    {
        if ($id != NULL && !empty($data))
            return $this->db->where('id', $id)->update(INVOICES, $data);
        else
            return false;
    }

}
