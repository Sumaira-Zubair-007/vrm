<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends BASE_Controller_Vendor {
	private $id;

	public function __construct(){
		parent::__construct();


		// CLASS MODEL

		$this->load->model('vendor/profile_model','m');

		$this->id = $this->session->userdata('id');
	}


	
	public function index()
	{
		$this->data['title'] = lang('profile');

		$this->data['user'] = $this->m->get_profile($this->id);
		$this->load->view('vendor/profile/index',$this->data);
	}


	// EDIT RECORD





	// UPDATE


	public function update()
	{
		// ONLY ACCEPT POST REQUEST
		if ($this->input->server('REQUEST_METHOD') == 'POST'){

			// UPDATED ID

			$id = $this->session->userdata('id');


			// VALIDATION OF FIELDS

			
			$this->form_validation->set_rules('name',"Name",'required');
			$this->form_validation->set_rules('email',"Email",'valid_email|is_unique[vendors.email]');

			// ERROR DELIMETER
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			// FORM VALIDATION TRUE
			if($this->form_validation->run() == TRUE){


				$data['name']  = $this->input->post('name');
				
				if(!empty($this->input->post('email')))
					$data['email']  = $this->input->post('email');

				


				if (!empty($_FILES['file']['name'])){
					// FILE UPLOAD CONFIG
					$config['upload_path']   = FCPATH.'/upload/vendors/';
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
					


				return redirect('vendor/profile');
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

		return redirect('vendor/profile');

	}
    
    public function onboarding(){
        // stripe part ...
        $this->load->library("stripe");
        // ....
        $return_url  = base_url("vendor/profile/complete");
        $refresh_url = base_url("vendor/profile/onboarding");
        $account_id  = NULL;
        // get the account ...
        $user        = $this->m->get_profile($this->id);
        $step        = 1;
        
        if(!empty($user->reference_account_id)){
            $step    = 2;
            // ...
            $account_id = $user->reference_account_id;
        }
            
        // create an account ...
        $account     = $this->stripe->create_account($return_url, $refresh_url, $account_id, $step);

        // success ??
        if(!$account->success){
            $this->session->set_flashdata('error',$account->message);
            return redirect("vendor/profile");
        }

        // 
        $data['reference_account_id'] = $account->account;
        // 
        if($this->m->update_m($this->id , $data)){
            return redirect($account->link->url);
        }
        else{
            $this->session->set_flashdata('error',lang('error_profile_update'));
        }
        
    }
    
    public function complete(){
       // stripe part ...
        $this->load->library("stripe");
        // get the account ...
        $user        = $this->m->get_profile($this->id);
        
		$log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL."Data: <pre>";
		$log .= print_r($_REQUEST, true);
		$log .= " ---- ";        
		$log .= print_r($_POST, true);
		//Save string to log, use FILE_APPEND to append.
		file_put_contents('./stripe_completed_'.date("j.n.Y").strtotime(time()).'.log', $log, FILE_APPEND);
 
        //
        if(empty($user->reference_account_id)){
            return redirect('vendor/profile/onboarding');
        }
            
        // create an account ...
        $account     = $this->stripe->retrieve_account($user->reference_account_id);

        // success ??
        if(!$account->success){
            $this->session->set_flashdata('error',$account->message);
            return redirect("vendor/profile");
        }

        // 
        $data['reference_account_id']         = $account->account->id;
        // status confirmation ...
        if($account->account->details_submitted && $account->account->charges_enabled && $account->account->payouts_enabled){
            $data['reference_account_status'] = 1;
        } else {
            $data['reference_account_status'] = 2; // pending and wait for the hook ...
        }
        // 
        if($this->m->update_m($this->id , $data)){
            $this->session->set_flashdata('success',lang('success_account_update'));
            return redirect("vendor/profile");
        }
        else{
            $this->session->set_flashdata('error',lang('error_account_update'));
        }   
    }
}
