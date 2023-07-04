<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends BASE_Controller_Vendor {


	public function __construct(){
		parent::__construct();


		// CLASS MODEL

		$this->load->model('vendor/invoices_model','m');
		// session user
		$this->id = $this->session->userdata('id');
	}


	
	public function index()
	{
		$this->data['title'] = lang('invoices');
		$this->data['invoices'] = $this->m->index_m($this->id);

		$this->load->view('vendor/invoice/index',$this->data);
	}

	// upload INVOICE
	public function upload_invoice($id = NULL){

		if($id != NULL){
			$this->data['title'] = lang('invoices');
			//
			$this->data['invoice']  = $this->m->show_m($id, $this->id);
			//
			if(!empty($this->data['invoice']) && $this->data['invoice']->status == "open" && $this->data['invoice']->requires_vendor_invoice == 1){
				return $this->load->view('vendor/invoice/view',$this->data);
			}
		}

		return redirect('vendor/invoices', $this->data);
	}

	// process credentials 

	public function process_invoice(){
		$this->form_validation->set_rules('invoice_id', 'Invoice Id', 'required');

		// FORM VALIDATION TRUE
		if($this->form_validation->run() == TRUE){



			// details
			$id        = $this->input->post('invoice_id');
			$invoice   = $this->m->show_m($id, $this->id); // invoice 

			//
			if(empty($invoice) || $invoice->status != "open"){
				$this->session->set_flashdata('error' , "Oops! Invoice cannot be upload");
				return redirect("vendor/invoices/upload_invoice/".$id);
			}

		
			if (!empty($_FILES['file']['name'])){
				// FILE UPLOAD CONFIG
				$config['upload_path']   = FCPATH.'/upload/invoices/';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
				$config['max_size']      = '5000';

				// CUSTOM NAME

				$file_name = time().'_'.$_FILES["file"]['name'];
				$config['file_name'] = $file_name;


				// FILE UPLOAD LIBRARY LOADING ....
				$this->load->library('upload', $config);

				if ($this->upload->do_upload('file')){

					$upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
					$invoice_data['vendor_invoice'] = $upload_data['file_name'];

					// update invoice
					$this->m->update_m($id,$this->id,$invoice_data);
					//success
					$this->session->set_flashdata("success", lang('success_invoice_update'));

				}
				else
				{
					echo '<pre>';print_r($this->upload->display_errors());die();
					$this->session->set_flashdata('errors',$this->upload->display_errors());

				}
			}

		}
		
		return redirect("vendor/invoices");
		// end to invoice payment
	}



}
