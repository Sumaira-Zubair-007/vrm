<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_Model extends CI_Model {



	// GET CITIES 


	public function index_m(){
		return $this->db->get(SETTINGS)->row();
	}

	

	// UPDATE PROFILE


	public function update_m($id = NULL , $data =array()){
		if($id != NULL && !empty($data))
			return $this->db->where('id',$id)->update(SETTINGS,$data);
		else
			return false;
	}


	// Currencies

	public function get_currencies(){
		return $this->db->group_by('name')->get(CURRENCIES)->result();
	}

}
