<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends BASE_Controller_Vendor {


	public function __construct(){
		parent::__construct();

		$this->load->model('vendor/dashboard_model','m');
	}


	
	public function index()
	{
		$this->data['title'] =lang('dashboard');
		$this->data['stats'] = $this->m->get_summary($this->user->id);
		
		$this->load->view('vendor/dashboard/index',$this->data);
	}



	// function to do user Logout

	public function logout()
	{

		$this->session->unset_userdata('id');
		$this->session->unset_userdata('name');
		$this->session->unset_userdata('type');
		$this->session->unset_userdata('picture');
		$this->session->unset_userdata('created_at');
		$this->session->sess_destroy();
		return redirect('/vendor');
	}
	// end to function


}
