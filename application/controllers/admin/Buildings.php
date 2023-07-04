<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buildings extends BASE_Controller_Admin {


	public function __construct(){
		parent::__construct();


		// CLASS MODEL

		$this->load->model('admin/buildings_model','m');
		//
		$this->load->library("stripe");
	}


	
	public function index()
	{
		$this->data['title'] = lang('buildings');
		$this->data['buildings'] = $this->m->index_m();

		$this->load->view('admin/building/index',$this->data);
	}


	public function add()
	{
		$this->data['title']  = lang('buildings');
		//
		$this->data['owners'] = $this->m->get_owners_m();
		
		$this->load->view('admin/building/add',$this->data);
	}


	public function create()
	{
		// ONLY ACCEPT POST REQUEST
		if ($this->input->server('REQUEST_METHOD') == 'POST'){


			// VALIDATION OF FIELDS

			$this->form_validation->set_rules('code',"Building Code",'required|is_unique[buildings.code]');

			$this->form_validation->set_rules('address',"Building Address",'required');
			//
			$this->form_validation->set_rules('owner_id',"Owner",'required|numeric');


			
			// ERROR DELIMETER
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			// FORM VALIDATION TRUE
			if($this->form_validation->run() == TRUE){

			
				// Personal Information ....
				$data['owner_id']       = $this->input->post("owner_id");
				$data['code']           = $this->input->post('code');
				$data['address']        = $this->input->post('address');
				
				$data['ids']            = substr(md5(uniqid(rand(), true)), 0, 20);
 				$data['status']         = 1;			
				$data['created_at']     = NOW;		
				$data['updated_at']     = NOW;		


		
				// inserting records via model

				if($id = $this->m->add_m($data)){
	
					$this->session->set_flashdata('success',lang('success_building_add'));
				}
				else
					$this->session->set_flashdata('error',lang('error_building_add'));

			

				return redirect('admin/buildings');
				
			}
			// FORM VALIDATION FALSE
			else{

				return $this->add();
			}


			
		}

		// UNAUTORIZED
		else{

			return $this->add();
		}

	}

	// view
	public function view($id = NULL){
		if($id != NULL){

			$this->data['title']    		= lang('building');
			$this->data['building'] 		= $this->m->show_with_owner_bank_m($id);
			$this->data['show_compliance']  = 0;

			if ($id == '20' || $id == '31' ) {
				$this->data['show_compliance']  = 1;
			}
			// 
			if(empty($this->data['building'])){
				return show_404();
			}
			// 
			$this->data['invoices'] = $this->m->get_invoices_m($id);
			//
			return $this->load->view('admin/building/view',$this->data);

		}
		else
			return redirect('admin/buildings');
	}


	// EDIT RECORD



	public function edit($id = NULL){
		if($id != NULL){

			$this->data['title']    = lang('buildings');
			$this->data['building'] = $this->m->show_m($id);
			//
			$this->data['owners'] = $this->m->get_owners_m();

			return $this->load->view('admin/building/edit',$this->data);

		}
		else
			return redirect('admin/buildings');
	}



	// UPDATE


	public function update()
	{
		// ONLY ACCEPT POST REQUEST
		if ($this->input->server('REQUEST_METHOD') == 'POST'){

			// UPDATED ID

			$id = ($this->input->post('id'))?$this->input->post('id'):NULL;


			// VALIDATION OF FIELDs

			$this->form_validation->set_rules('address',"Building Address",'required');
			//
			$this->form_validation->set_rules('owner_id',"Owner",'required|numeric');

			//
			if(!empty($this->input->post("code")))
				$this->form_validation->set_rules('code',"Building Code",'required|is_unique[buildings.code]');





			// ERROR DELIMETER
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			// FORM VALIDATION TRUE
			if($this->form_validation->run() == TRUE){


				// Personal Information ....
				$data['owner_id']       = $this->input->post("owner_id");
				$data['address']        = $this->input->post('address');
				//				
				$data['updated_at']     = NOW;			

				//
				if(!empty($this->input->post("code")))
					$data['code']           = $this->input->post('code');


		
				// inserting records via model

				if($id = $this->m->update_m($id, $data)){
	
					$this->session->set_flashdata('success',lang('success_building_update'));
				}
				else
					$this->session->set_flashdata('error',lang('error_building_update'));


				return redirect('admin/buildings');
			}


			
			// FORM VALIDATION FALSE
			else{

				if($id != NULL)
					return $this->edit($id);
				else
					return redirect('admin/buildings');
			}



		}

		// UNAUTORIZED
		else{

			return $this->add();
		}

	}



	// DELETE RECORD

	public function delete($id = NULL){
		if($id != NULL){
			if($this->db->where('id',$id)->delete('buildings'))
				$this->session->set_flashdata('success',lang('success_building_delete'));
			else
				$this->session->set_flashdata('error',lang('error_building_delete'));
		}

		return redirect('admin/buildings');
	}

	// ENABLE DISABLE ACCESS
	public function enable_disable($id = NULL,$status = 0){
		if($id != NULL){
			// status
			$data['status'] = $status == 0 ? 1 : 0;


			if($this->m->update_m($id,$data))
				$this->session->set_flashdata('success',lang('success_building_update'));
			else
				$this->session->set_flashdata('error',lang('error_building_update'));
		}

		return redirect('admin/buildings');
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
	            return redirect("admin/buildings");
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
	        	return redirect('admin/buildings');
	        }

		}
		else
			return redirect('admin/buildings');
	}

	public function bank_account_verify($id = NULL){
		if($id != NULL){

			$building = $this->m->show_with_owner_bank_m($id);
			//
			if(empty($building) || empty($building->setup_intent_id) ||  !in_array($building->setup_intent_status, ['pending','requires_action'])){
				die('ff');
				return show_404();
			}

			// attach session redirect ...

			$setup = $this->stripe->retrieve_setup_intent($building->setup_intent_id);

			// success ??
	        if(!$setup->success){
	            $this->setup->set_flashdata('error',$setup->message);
	            return redirect("admin/buildings/view/".$id);
	        }
	        // original object...
	        $setup = $setup->setup;
	        //

	        // does it really requires verification??
	        if(isset($setup->next_action->verify_with_microdeposits->hosted_verification_url) && !empty($setup->next_action->verify_with_microdeposits->hosted_verification_url)){
	        	return redirect($setup->next_action->verify_with_microdeposits->hosted_verification_url);
	        }

	        // something spammy ...
	        return redirect('admin/buildings/view/'.$id);

		}
		else
			return redirect('admin/buildings');
	}


	public function bank_account_success($session_id = NULL){
		if(!empty($session_id)){
			// retrieve the session first of all..
			$session = $this->stripe->retrieve_session($session_id);
			// success ??
	        if(!$session->success){
	            $this->setup->set_flashdata('error',$session->message);
	            return redirect("admin/buildings");
	        }

	        // original object.
	        $session = $session->session;

	        // update the record
	        $up_data['setup_intent_status'] = $session->setup_intent->status;
	        $up_data['status']              = $session->setup_intent->status == "succeeded" ? 1 : 0;
	        $up_data['payment_method_id']   = $session->setup_intent->payment_method->id;
	        $up_data['customer_id']         = $session->customer;
	        $up_data['currency']            = "usd";

	        //
	        if(isset($session->setup_intent->payment_method->us_bank_account)){
	        	$up_data['bank_name'] = $session->setup_intent->payment_method->us_bank_account->bank_name;
	        	$up_data['fingerprint'] = $session->setup_intent->payment_method->us_bank_account->fingerprint;
	        	$up_data['account_number'] = $session->setup_intent->payment_method->us_bank_account->last4;
	        }
	        //
	        $this->m->update_bank_record($session->setup_intent->id, $up_data);

		    $this->session->set_flashdata('success',"Bank account was added successfully. We will verify it shortly");
			return redirect('admin/buildings');
		}
	}


	public function bank_account_delete($id = NULL, $ba_id = NULL){
		if($id != NULL && $ba_id != NULL)
		{
			$data['setup_intent_status'] = "";
			$data['status']              = 0;
	        $data['payment_method_id']   = "";

			$this->m->update_bank_m($id, $ba_id, $data);

			$this->session->set_flashdata('error',lang('bank_deleted'));
			return redirect("admin/buildings/view/".$id);
		}
	}


	public function bank_account_error($id = NULL){
	    $this->session->set_flashdata('error',"Error! Establishing a connection with the bank account");
		return redirect('admin/buildings');
	}

	
}
