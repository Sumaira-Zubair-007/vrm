<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends BASE_Controller_Staff {


	public function __construct(){
		parent::__construct();


		// CLASS MODEL

		$this->load->model('staff/payments_model','m');
		// session user
		$this->id = $this->session->userdata('id');
	}


	
	public function index()
	{
		$this->data['title'] = lang('payments');
		$this->data['payments'] = $this->m->index_m();

		$this->load->view('staff/payment/index',$this->data);
	}


}
