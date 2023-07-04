<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends BASE_Controller_Staff {


	public function __construct(){
		parent::__construct();


		// CLASS MODEL

		$this->load->model('staff/invoices_model','m');
		// session user
		$this->id = $this->session->userdata('id');
	}


	
	public function index()
	{
		$this->data['title'] = lang('invoices');
		$this->data['invoices'] = $this->m->index_m();

		$this->load->view('staff/invoice/index',$this->data);
	}


	public function add()
	{

		if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ) {
			$this->session->set_userdata('return_url', $_SERVER['HTTP_REFERER']); 
		} 

		$this->data['title']   = lang('invoices');
		//
		$this->data['vendors'] = $this->m->get_vendors_m();
		$this->data['buildings'] = $this->m->get_buildings_m();
		//
		$this->load->view('staff/invoice/add',$this->data);
	}


	public function create()
	{
		// ONLY ACCEPT POST REQUEST
		if ($this->input->server('REQUEST_METHOD') == 'POST'){
 
			// VALIDATION OF FIELDS
			$this->form_validation->set_rules('building_id','Building','trim|required');
			$this->form_validation->set_rules('order_no','Work Order No','trim|required');
			//
			$this->form_validation->set_rules('vendor_id','Vendor','trim|required');
			$this->form_validation->set_rules('total_amount','Total amount','required');
			
			// ERROR DELIMETER
			$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

			// FORM VALIDATION TRUE
			if($this->form_validation->run() == TRUE){
				$data['vendor_id']            = $this->input->post("vendor_id");
				$data['building_id']          = $this->input->post("building_id");
				$order_no = $data['order_no']             = $this->input->post("order_no");
				//
				$data['total_amount']         = $this->input->post("total_amount");

				$invoice_order_no  			  = $this->m->get_order_no($order_no);

				if (!empty($invoice_order_no)) {
					$this->session->set_flashdata('error',lang('duplicate_Invoice_Order_No'));

					return redirect("staff/invoices/add");
				}

				// retrieve the vendor ..
				$vendor     = $this->m->show_vendor_m($data['vendor_id']);
				$building   = $this->m->show_building_m($data['building_id']);
				
				if(empty($vendor) || empty($building)){
					$this->session->set_flashdata('error',lang('error_invoice_add'));
					//
					return redirect("staff/invoices");
				}
				//

				// transfer amount to vendor ...
				$data['transfer_amount']      = round($this->input->post("total_amount") * ($vendor->percentage / 100), 2);

				 


				
		       	// ------------------ step 2  ----------------------------------------------
				$customer_id     = $building->customer_id;
				$total_amount    = $data['total_amount'] * 100;
				$description     = "Invoice for Building ". $building->code . ' & Work Order '. $data['order_no'];
				$currency        = "usd";
				 
		        // ---------------------- end to step 2 ------------------------------------
		       	 
				// ------------------ step 3  ----------------------------------------------
				$account_id            	= $vendor->reference_account_id;
				$customer_id           	= $building->customer_id;
				$transfer_amount 		= $data['transfer_amount'] * 100;
				$description     		= "Invoice for Building ". $building->code . ' & Work Order '. $data['order_no'] .'& Vendor '. $vendor->name;
				$statement_descriptor   = "W:".$data['order_no']."Bld:$building->code";

				$metadata        		= array("vendor" => $vendor->name, 'building' => $building->address);
 
		        // ---------------------- end to step 3 ------------------------------------
		        $data['invoice_id']   	= "";
		        $data['currency']     	= "";
		        $data['total_paid']   	= "";
		        $data['invoice_url']  	= "";
		        $data['status']       	= "Need Approval";
				$data['pay_status'] 	= "Need Approval";
		         
				 
		        //
		        $data['created_at']   = NOW;
				// end to stripe work part here ...

 
				// inserting records via model
				if($id = $this->m->add_m($data)){
		        	//
					$this->session->set_flashdata('success',lang('success_invoice_add_but_needs_approval_from_admin'));
				}
				else
					$this->session->set_flashdata('error',lang('error_invoice_add'));

				
				if (!empty($this->session->userdata('return_url')) ) {
					$return_url = $this->session->userdata('return_url');
					$this->session->unset_userdata('return_url'); 
					return redirect($return_url);
				}else {
					return redirect('staff/invoices');
				}	

				
				
			}
			// FORM VALIDATION FALSE
			else{

				return redirect('staff/invoices');
			} 
		} 
		// UNAUTORIZED
		else{

			return redirect("staff/invoices");
		}
	}

	// VOID INVOICE
	public function pay_invoice($id = NULL){

		if($id != NULL){
			$this->data['title'] = lang('invoices');
			//
			$this->data['invoice']  = $this->m->show_m($id);
			//
			if(!empty($this->data['invoice']) && $this->data['invoice']->status == "open"){
				// does it require vendor invoice and Is it already there ??
				if($this->data['invoice']->requires_vendor_invoice == 1 && empty($this->data['invoice']->vendor_invoice)){
					$this->session->set_flashdata("error", lang("error_vendor_invoice_required"));
				} else {
					return $this->load->view('staff/invoice/pay',$this->data);
				}
			}
		}

		return redirect('staff/invoices', $this->data);
	}

	// process credentials 

	public function process_invoice(){
		$this->form_validation->set_rules('invoice_id', 'Invoice Id', 'required');

		// FORM VALIDATION TRUE
		if($this->form_validation->run() == TRUE){

			
			// stripe
			$this->load->library('stripe');



			// details
			$id        = $this->input->post('invoice_id');
			$invoice   = $this->m->show_m($id); // invoice 
			//
			if(empty($invoice) || $invoice->status != "open"){
				$this->session->set_flashdata('error' , "Oops! Invoice cannot be paid");
				return redirect("staff/invoices/pay_invoice/".$id);
			}
			// does it require vendor invoice and Is it already there ??
			if($invoice->requires_vendor_invoice == 1 && empty($invoice->vendor_invoice)){
				$this->session->set_flashdata("error", lang("error_vendor_invoice_required"));
				return redirect("staff/invoices");
			} 

			//
			$building     = $this->m->show_building_m($invoice->building_id);
			//
			if(empty($building)){
				$this->session->set_flashdata('error',lang('error_invoice_add'));
				//
				return redirect("staff/invoices/pay_invoice/".$id);
			}
			//


			

			// STEP 2

			$inv  = $this->stripe->pay_invoice($invoice->invoice_id, $building->payment_method_id);

			// error ?
			if($inv->success == false){
				$this->session->set_flashdata('error',$inv->message);
				return redirect("admin/invoices/pay_invoice/".$id);
			}

			// original object
			$inv   = $inv->invoice;
			// invoice data
			$invoice_data['total_paid'] = $inv->amount_paid / 100;
			$invoice_data['status']     = $inv->status == 'paid' ? 'paid' : 'processing';
			// payment data
			$payment_data['status']     = $inv->payment_intent->status == 'succeeded' ? 'succeeded' : 'processing';

			// update invoice
			$this->m->update_m($invoice->id,$invoice_data);

			// update payment
			$this->m->update_payment_m($invoice->id,$payment_data);
			//success
			$this->session->set_flashdata("success", lang('success_invoice_paid'));

		}
		
		return redirect("staff/invoices");
		// end to invoice payment
	}


}
