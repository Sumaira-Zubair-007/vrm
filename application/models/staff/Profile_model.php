<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile_Model extends CI_Model {

	// GET USER  

	public function get_profile($id){
		return $this->db->where('id',$id)->get(STAFFS)->row();
	}



	// UPDATE PROFILE


	public function update_m($id = NULL , $data =array()){
		if($id != NULL && !empty($data))
			return $this->db->where('id',$id)->update(STAFFS,$data);
		else
			return false;
	}

}
