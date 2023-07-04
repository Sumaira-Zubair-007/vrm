<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Owners extends BASE_Controller_Admin {


	public function __construct(){
		parent::__construct();


		// CLASS MODEL

		$this->load->model('admin/owners_model','m');
	}


	
	public function index()
	{
		$this->data['title'] = lang('owners');
		$this->data['owners'] = $this->m->index_m();

		$this->load->view('admin/owner/index',$this->data);
	}


	public function add()
	{
		$this->data['title']  = lang('owners');

		
		$this->load->view('admin/owner/add',$this->data);
	}


	public function create()
	{
		// ONLY ACCEPT POST REQUEST
		if ($this->input->server('REQUEST_METHOD') == 'POST'){


			// VALIDATION OF FIELDS

			$this->form_validation->set_rules('name',"Name",'required');
			$this->form_validation->set_rules('email',"Email",'required|valid_email|is_unique[owners.email]');
			$this->form_validation->set_rules('password',"Password",'required|min_length[6]');

			// IMAGE FIELD VALIDATION 
			if (empty($_FILES['file']['name']))
				$this->form_validation->set_rules('file', 'Profile Image', 'required');

			// ERROR DELIMETER
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			// FORM VALIDATION TRUE
			if($this->form_validation->run() == TRUE){

				// FILE UPLOAD CONFIG
				$config['upload_path']   = FCPATH.'/upload/owners/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']      = '10000';

				// CUSTOM NAME

				$img_name = time().'_'.$_FILES["file"]['name'];
				$config['file_name'] = $img_name;



				// FILE UPLOAD LIBRARY LOADING ....
				$this->load->library('upload', $config);

				if ($this->upload->do_upload('file')){
					// Personal Information ....
					$data['name']      = $this->input->post('name');
					$data['email']     = $this->input->post('email');

					//
					$data['password']  = md5($this->input->post('password'));

					// important ...
					$data['status']    = 1;			
					
					$upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
					$data['picture'] = $upload_data['file_name'];

				// inserting records via model

					if($id = $this->m->add_m($data)){
						// send E-mail 
						$email_data['email']    = $this->input->post("email");
						$email_data['password'] = $this->input->post("password");
						//
						$message = $this->load->view('admin/email/owner',$email_data, TRUE);
						$subject = "Welcome to VRM Portal";
						$cc      = "fersen@newgents.com";
						sendMail($subject, $message, $email_data['email'], NULL, $cc);
						// End to send E-mail 

						$this->session->set_flashdata('success',lang('success_owner_add'));
					}
					else
						$this->session->set_flashdata('error',lang('error_owner_add'));

				}
				// upload errors
				else {
					$this->session->set_flashdata('errors',$this->upload->display_errors());

				}

				return redirect('admin/owners');
				
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


	// EDIT RECORD


	public function edit($id = NULL){
		if($id != NULL){

			$this->data['title'] = lang('owners');
			$this->data['owner'] = $this->m->show_m($id);

			return $this->load->view('admin/owner/edit',$this->data);

		}
		else
			return redirect('admin/owners');
	}



	// UPDATE


	public function update()
	{
		// ONLY ACCEPT POST REQUEST
		if ($this->input->server('REQUEST_METHOD') == 'POST'){

			// UPDATED ID

			$id = ($this->input->post('id'))?$this->input->post('id'):NULL;


			// VALIDATION OF FIELDS

			
			$this->form_validation->set_rules('name',"Name",'required');
			$this->form_validation->set_rules('email',"Email",'valid_email|is_unique[owners.email]');

			// PASSWORD FIELD VALIDATION 
			$this->form_validation->set_rules('password',"Password",'min_length[6]');




			// ERROR DELIMETER
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			// FORM VALIDATION TRUE
			if($this->form_validation->run() == TRUE){


				$data['name']          = $this->input->post('name');
				
				// email
				if($this->input->post('email'))
					$data['email']     = $this->input->post('email');

				// password
				if($this->input->post('password'))
					$data['password']  = md5($this->input->post('password'));



					

				// is image provided ??
				if (!empty($_FILES['file']['name'])){
					// FILE UPLOAD CONFIG
					$config['upload_path']   = FCPATH.'/upload/owners/';
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

				if($this->m->update_m($id , $data))
					$this->session->set_flashdata('success',lang('success_owner_update'));
				else
					$this->session->set_flashdata('error',lang('error_owner_update'));


				return redirect('admin/owners');
			}


			
			// FORM VALIDATION FALSE
			else{

				if($id != NULL)
					return $this->edit($id);
				else
					return redirect('admin/owners');
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
			if($this->db->where('id',$id)->delete('owners'))
				$this->session->set_flashdata('success',lang('success_owner_delete'));
			else
				$this->session->set_flashdata('error',lang('error_owner_delete'));
		}

		return redirect('admin/owners');
	}

	// ENABLE DISABLE ACCESS
	public function enable_disable($id = NULL,$status = 0){
		if($id != NULL){
			// status
			$data['status'] = $status == 0 ? 1 : 0;


			if($this->m->update_m($id,$data))
				$this->session->set_flashdata('success',lang('success_owner_update'));
			else
				$this->session->set_flashdata('error',lang('error_owner_update'));
		}

		return redirect('admin/owners');
	}
}
