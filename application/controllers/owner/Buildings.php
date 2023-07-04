<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buildings extends BASE_Controller_Owner {


	public function __construct(){
		parent::__construct();


		// CLASS MODEL

		$this->load->model('owner/buildings_model','m');
		
		$this->load->library("stripe");

		// session user
		$this->id = $this->session->userdata('id');
	}


	
	public function view($building_id = NULL)
	{
		$this->data['title'] = lang('Building');
		$this->data['build'] = $this->m->get_building_m($this->id, $building_id);
		// 
		if(empty($this->data['build'])){
			return show_404();
		}
		// 
		$this->data['invoices'] = $this->m->get_invoices_m($this->id, $building_id);
		//

		if ($building_id == '31' ) {
			$this->data['show_bank']  		= 1;
			$this->data['show_compliance']  = 1;
		}

		$this->load->view('owner/building/view',$this->data);
	}
	
	// Approve pay invoice access
	public function approve($id = NULL, $bid = NULL){
		
		if($id != NULL && $bid != NULL)
		{
			$data['pay_status'] = 'approved';

			if($this->m->update_m($id, $data))
				$this->session->set_flashdata('success',lang('success_status_updated'));
			else
				$this->session->set_flashdata('error',lang('error_vendor_update'));
		}

		return redirect('owner/buildings/view/'.$bid);
	}

	public function bank_account($id = NULL){
		if($id != NULL){
			//
			$building = $this->m->show_with_owner_bank_m($id);
			//
			if(empty($building)){
				return show_404();
			}

			// attach session redirect ...

			$session = $this->stripe->create_session();
			// success ??
	        if(!$session->success){
	            $this->session->set_flashdata('error',$session->message);
	            return redirect("owner/building");
	        }
	        // original object ...
	        $session = $session->session;

	        // insert to db
	        $data['building_id']           =  $id;
	        $data['setup_intent_id']       = $session->setup_intent;
	        $data['setup_intent_status']   = "pending";
	        $data['status']                = 0;
	        $data['created_at']            = NOW;

	        // end to db insert

	        if($this->m->insert_bank_record($data)){
	        	return redirect($session->url);
	        } else {
	        	$this->session->set_flashdata('error',lang('error_bank_add'));
	        	//
	        	return redirect('owner/building');
	        }

		}
		else
			return redirect('owner/building');
	}
}
