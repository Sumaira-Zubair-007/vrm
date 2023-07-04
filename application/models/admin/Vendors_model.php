<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendors_Model extends CI_Model
{


    public function index_m()
    {
        return $this->db->get(VENDORS)->result();
    }


    public function add_m($data = array())
    {
        if (!empty($data)){
            $this->db->insert(VENDORS, $data);

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
            ->get(VENDORS)->row();
        else
            return false;
    }

    public function update_m($id = NULL, $data = array())
    {
        if ($id != NULL && !empty($data))
            return $this->db->where('id', $id)->update(VENDORS, $data);
        else
            return false;
    }





}
