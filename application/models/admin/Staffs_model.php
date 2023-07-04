<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staffs_Model extends CI_Model
{


    public function index_m()
    {
        return $this->db->get(STAFFS)->result();
    }


    public function add_m($data = array())
    {
        if (!empty($data)){
            $this->db->insert(STAFFS, $data);

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
            ->get(STAFFS)->row();
        else
            return false;
    }

    public function update_m($id = NULL, $data = array())
    {
        if ($id != NULL && !empty($data))
            return $this->db->where('id', $id)->update(STAFFS, $data);
        else
            return false;
    }





}
