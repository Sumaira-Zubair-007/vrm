<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends BASE_Controller_Admin {
	private $id;

	public function __construct(){
		parent::__construct();


		// CLASS MODEL

		$this->load->model('admin/profile_model','m');

		$this->id = $this->session->userdata('id');

		$this->load->library("stripe");
	}


	
	public function index()
	{
		$this->data['title'] = lang('profile');

		$this->data['user'] = $this->m->get_profile($this->id);
		$this->load->view('admin/profile/index',$this->data);
	}


	// EDIT RECORD

	public function stripedet() {

		echo "Stripe details";

		$stripe = new \Stripe\StripeClient(
			'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'
		  );
		
		$account = $stripe->accounts->retrieve(
					'acct_1My1zcD5djSdXoeC',
					[]
				);
		
		
		echo "<pre>";
		print_r($account);
		echo "</pre>";
		
		// $stripe->accounts->update(
		// 	'acct_1L0nAfRjGoH8SQnF',
		// 	['settings' => [
		// 		'payments' => [
		// 			['statement_descriptor' => 'ABDULLAH FERSEN']
		// 		]
		// 	]		
		// 	]
		// );

		// echo "<pre>";
		// print_r($account);
		// echo "</pre>";

		
		exit;
	}




	// UPDATE


	public function update()
	{
		// ONLY ACCEPT POST REQUEST
		if ($this->input->server('REQUEST_METHOD') == 'POST'){

			// UPDATED ID

			$id = $this->session->userdata('id');


			// VALIDATION OF FIELDS

			
			$this->form_validation->set_rules('name',"Name",'required');
			$this->form_validation->set_rules('email',"Email",'valid_email|is_unique[users.email]');

			// ERROR DELIMETER
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			// FORM VALIDATION TRUE
			if($this->form_validation->run() == TRUE){


				$data['name']  = $this->input->post('name');
				
				if(!empty($this->input->post('email')))
					$data['email']  = $this->input->post('email');

				


				if (!empty($_FILES['file']['name'])){
					// FILE UPLOAD CONFIG
					$config['upload_path']   = FCPATH.'/upload/admins/';
					$config['allowed_types'] = 'gif|jpg|png|jpeg';
					$config['max_size']      = '1000';

					// CUSTOM NAME

					$img_name = time().'_'.$_FILES["file"]['name'];
					$config['file_name'] = $img_name;


					// FILE UPLOAD LIBRARY LOADING ....
					$this->load->library('upload', $config);

					if ($this->upload->do_upload('file')){

						$upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
						$data['picture'] = $upload_data['file_name'];

					}
					else
					{
						$this->session->set_flashdata('errors',$this->upload->display_errors());

					}
				}


				// inserting records via model

				if($this->m->update_m($id , $data)){
					if(isset($data['name']))
						$this->session->set_userdata('name',$data['name']);

					if(isset($data['picture']))
						$this->session->set_userdata('picture',$data['picture']);

					$this->session->set_flashdata('success',lang('success_profile_update'));
				}
					
				else{
					$this->session->set_flashdata('error',lang('error_profile_update'));
				}
					


				return redirect('admin/profile');
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




	public function password(){
		// ONLY ACCEPT POST REQUEST
		if ($this->input->server('REQUEST_METHOD') == 'POST'){
			if(!empty($this->input->post('password')) && !empty($this->input->post('c_password'))){

				if($this->input->post('password') == $this->input->post('c_password')){
					$data['password'] = md5($this->input->post('password'));

					if($this->m->update_m($this->id , $data)){
						$this->session->set_flashdata('success',lang('success_profile_update'));
					}
					else{
						$this->session->set_flashdata('error',lang('error_profile_update'));
					}
				}
				else{
					$this->session->set_flashdata('error',lang('confirm_password_match'));
				}

			}
			else
			{
				$this->session->set_flashdata('error',lang('password_empty'));
			}
		}
		else
		{
			$this->session->set_flashdata('error',lang('unauthorize_request'));
		}

		return redirect('admin/profile');

	}
}
