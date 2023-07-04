<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Core class for Auth check on each class
 */
class BASE_Controller_Owner extends CI_Controller
{

	
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id') || $this->session->userdata('type') != 4)
			return redirect('/owner');

		// fetch user to check status
		$this->user   =  $this->db->where('id',$this->session->userdata('id'))->get(OWNERS)->row();

		// is disabled ??
        if($this->user->status != 1){
            // unset session
            $this->session->sess_destroy();
			return redirect('/owner');
        }

		// Settings info
		$this->data['settings']    = $this->db->get(SETTINGS)->row();
		// Buildings
		$this->data['buildings']   = $this->db->where("owner_id", $this->user->id)
		->where("status", 1)
		->get(BUILDINGS)->result();
	}
}

?>