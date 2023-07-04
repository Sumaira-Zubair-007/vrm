<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends BASE_Controller_Admin {


	public function __construct(){
		parent::__construct();


		// CLASS MODEL

		$this->load->model('admin/payments_model','m');
	}


	
	public function index()
	{
		$this->data['title'] = lang('payments');
		$this->data['payments'] = $this->m->index_m();

		$this->load->view('admin/payment/index',$this->data);
	}


}
