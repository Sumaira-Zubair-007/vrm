<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Core class for Auth check on each class
 */
class BASE_Controller_Admin extends CI_Controller
{
	protected $data;
	public function __construct()
	{
		parent::__construct();
		if(!$this->session->userdata('id') || $this->session->userdata('type') != 1)
			return redirect('admin');

		// Settings info
		$this->data['settings'] = $this->db->get(SETTINGS)->row();
	}
}

 ?>