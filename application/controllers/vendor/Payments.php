<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends BASE_Controller_Vendor {


	public function __construct(){
		parent::__construct();


		// CLASS MODEL

		$this->load->model('vendor/payments_model','m');
		// session user
		$this->id = $this->session->userdata('id');
	}


	
	public function index()
	{
		$this->data['title'] = lang('payments');
		$this->data['payments'] = $this->m->index_m($this->id);

		$this->load->view('vendor/payment/index',$this->data);
	}


}
