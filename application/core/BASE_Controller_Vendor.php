<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Core class for Auth check on each class
 */
class BASE_Controller_Vendor extends CI_Controller
{

	
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id') || $this->session->userdata('type') != 2)
			return redirect('/vendor');

		// fetch user to check status
		$this->user   =  $this->db->where('id',$this->session->userdata('id'))->get(VENDORS)->row();

		// is disabled ??
        if($this->user->status != 1){
            // unset session
            $this->session->sess_destroy();
			return redirect('/vendor');
        }

		// Settings info
		$this->data['settings'] = $this->db->get(SETTINGS)->row();
	}
}

?>