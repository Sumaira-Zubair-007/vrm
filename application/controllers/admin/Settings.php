<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends BASE_Controller_Admin {
	

	public function __construct(){
		parent::__construct();


		// CLASS MODEL

		$this->load->model('admin/settings_model','m');

	}


	
	public function index()
	{
		$this->data['title'] = lang('setting');
		$this->data['setting'] = $this->m->index_m();

		$this->load->view('admin/setting/index',$this->data);
	}


	// EDIT RECORD





	// UPDATE


	public function general()
	{
		// ONLY ACCEPT POST REQUEST
		if ($this->input->server('REQUEST_METHOD') == 'POST'){

			// UPDATED ID

			$id = $this->input->post('id');




			// VALIDATION OF FIELDS

			
			$this->form_validation->set_rules('id',"ID",'required');
			$this->form_validation->set_rules('name',"Name",'required');
			$this->form_validation->set_rules('email',"Email",'required|valid_email');
			$this->form_validation->set_rules('description',"Description",'required');
			$this->form_validation->set_rules('keywords',"Keywords",'required');
			$this->form_validation->set_rules('copyright',"Copyright",'required');
			

			// ERROR DELIMETER
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			// FORM VALIDATION TRUE
			if($this->form_validation->run() == TRUE){


				$data['name']  = $this->input->post('name');
				$data['email']  = $this->input->post('email');
				$data['description']  = $this->input->post('description');
				$data['keywords']  = $this->input->post('keywords');
				$data['copyright']  = $this->input->post('copyright');


				$data['updated_at'] = NOW;


				// inserting records via model

				if($this->m->update_m($id , $data))
					$this->session->set_flashdata('success',lang('success_setting_update'));

				else
					$this->session->set_flashdata('error',lang('error_setting_update'));



				return redirect('admin/settings');
			}


			
			// FORM VALIDATION FALSE
			else{
				return $this->index();

			}



		}

		// UNAUTORIZED
		else{

			return $this->index();
		}

	}


	// payment
	public function payment(){
		// ONLY ACCEPT POST REQUEST

		$id = ($this->input->post('id')?$this->input->post('id'):false);
		if (($this->input->server('REQUEST_METHOD') == 'POST') && ($id)){
			
			$data['stripe_publish_key']  = $this->input->post('stripe_publish_key');
			$data['stripe_secret_key']   = $this->input->post('stripe_secret_key');
			$data['stripe_webhook_key']  = $this->input->post('stripe_webhook_key');
			$data['stripe_mode']  = $this->input->post('stripe_mode') == 'live'?'live':'development';

			// plaid
			$data['plaid_client_id']  = $this->input->post('plaid_client_id');
			$data['plaid_client_secret']   = $this->input->post('plaid_client_secret');
			
			$data['plaid_environment']  = in_array($this->input->post('plaid_environment'), ['production','development','sandbox']) ? $this->input->post('plaid_environment'):'development';

			$data['updated_at']   = NOW;
			

			if($this->m->update_m($id , $data))
				$this->session->set_flashdata('success',lang('success_setting_update'));

			else
				$this->session->set_flashdata('error',lang('error_setting_update'));
		}
		else
		{
			$this->session->set_flashdata('error',lang('unauthorize_request'));
		}

		return redirect('admin/settings');

	}
}
