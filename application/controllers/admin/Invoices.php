<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoices extends BASE_Controller_Admin {


	public function __construct(){
		parent::__construct();


		// CLASS MODEL

		$this->load->model('admin/invoices_model','m');
		//
		$this->id = $this->session->userdata('id');
	}


	
	public function index()
	{
		$this->data['title'] = lang('invoices');
		$this->data['invoices'] = $this->m->index_m();

		$this->load->view('admin/invoice/index',$this->data);
	}

	public function add()
	{

		if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ) {
			$this->session->set_userdata('return_url', $_SERVER['HTTP_REFERER']); 
		}


		$this->data['title']   		= lang('invoices');
		//
		$this->data['vendors'] 		= $this->m->get_vendors_m();
		$this->data['buildings'] 	= $this->m->get_buildings_m();
		//
		$this->load->view('admin/invoice/add',$this->data);
	}


	public function create()
	{
		
		// ONLY ACCEPT POST REQUEST
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

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

					return redirect("admin/invoices/add");
				}


				// retrieve the vendor ..
				$vendor     = $this->m->show_vendor_m($data['vendor_id']);
				$building   = $this->m->show_building_m($data['building_id']);
				
				if(empty($vendor) || empty($building)){
					$this->session->set_flashdata('error',lang('error_invoice_add'));
					//
					return redirect("admin/invoices");
				}
				//

				// transfer amount to vendor ...
				$data['transfer_amount']      = round($this->input->post("total_amount") * ($vendor->percentage / 100), 2);

				// stripe work starts here ...

				// stripe
				$this->load->library('stripe');


				
		       	// ------------------ step 2  ----------------------------------------------
				$customer_id     = $building->customer_id;
				$total_amount    = $data['total_amount'] * 100;
				$description     = "Invoice for Building ". $building->code . ' & Work Order '. $data['order_no'];
				$currency        = "usd";
				//
				$item  = $this->stripe->create_invoice_item($customer_id, $total_amount, $currency, $description);

				

				// success ??
		        if(!$item->success){
		            $this->session->set_flashdata('error',$item->message);
		            return redirect("admin/invoices/add");
		        }

				
		        // original invoice item object ..
		        $item = $item->item;
		        // ---------------------- end to step 2 ------------------------------------
		       	 
				// ------------------ step 3  ----------------------------------------------
				$account_id            	= $vendor->reference_account_id;
				$customer_id           	= $building->customer_id;
				$transfer_amount 		= $data['transfer_amount'] * 100;
				$description     		= "Invoice for Building ". $building->code . ' & Work Order '. $data['order_no'] .'& Vendor '. $vendor->name;
				$statement_descriptor   = "W:".$data['order_no']."Bld:$building->code";
				// echo "<pre>";print_r($vendor);echo "</pre>";
				// echo "<pre>";print_r($building);echo "</pre>";
				// exit;

				$metadata        		= array("vendor" => $vendor->name, 'building' => $building->address);
				//['vendor' => "vendorID:" . strval($vendor->id),'building' => "buildingID" . strval($building->id)];

				$invoice  = $this->stripe->create_invoice($account_id, $transfer_amount, $customer_id, $description, $statement_descriptor, $metadata);

				
				// success ??
		        if(!$invoice->success){
		        	// delete the invoice item ...
		        	$del_item = $this->stripe->delete_invoice_item($item->id);
		        	// end to invoice item delete 

		        	
		            $this->session->set_flashdata('error',$invoice->message);
		            return redirect("admin/invoices/add");
		        }
		        // original invoice object ..
		        $invoice = $invoice->invoice;
		        // ---------------------- end to step 3 ------------------------------------
		     

		        $data['invoice_id']   = $invoice->id;
		        $data['currency']     = $invoice->currency;
		        $data['total_paid']   = $invoice->amount_paid / 100;
		        $data['invoice_url']  = $invoice->hosted_invoice_url;
		        $data['status']       = $invoice->status;
		        //
		        $data['can_staff_pay']           = ($this->input->post("can_staff_pay")) == 1 ? 1 : 0;
		        $data['requires_vendor_invoice'] = ($this->input->post("requires_vendor_invoice")) == 1 ? 1 : 0;
				
				if($data['status'] == "processing")
				{
					$data['pay_status'] = "approved";
				}else{
					$data['pay_status'] = "inprocess";
				}
		        //
		        $data['created_at']   = NOW;
				// end to stripe work part here ...

				// retrieve the owner for email
				$owner = $this->m->show_owner_m($building->owner_id);
				$owner_data['building_id'] = $data['building_id'];
				$owner_data['invoice_id'] = $data['invoice_id'];
				$owner_data['owner_name'] = $owner->name;
				$owner_data['owner_email'] = $owner->email;
				
				// inserting records via model
				if($id = $this->m->add_m($data)){

					// sending email to Owner for approval of pay_status
					//$this->send_approval_email($owner_data);

					// insert to the payments record as well ...

					$paym_data['invoice_id']  = $id;
					$paym_data['vendor_id']   = $vendor->id;
					$paym_data['payment_id']  = $invoice->payment_intent->id;
					$paym_data['amount']      = $this->input->post("total_amount");
					$paym_data['transfer_amount'] = $data['transfer_amount'];	
					$paym_data['currency']    = $invoice->payment_intent->currency;
					$paym_data['status']      = $invoice->payment_intent->status;
		        	$paym_data['created_at']  = NOW;

		        	$this->m->add_payment_m($paym_data);
		        	//
					$this->session->set_flashdata('success',lang('success_invoice_add'));
				}
				else
					$this->session->set_flashdata('error',lang('error_invoice_add'));

				
				if (!empty($this->session->userdata('return_url')) ) {
					$return_url = $this->session->userdata('return_url');
					$this->session->unset_userdata('return_url'); 
					return redirect($return_url);
				}else {
					return redirect('admin/invoices');
				}	

				
				
			}
			// FORM VALIDATION FALSE
			else{

				return $this->add();
			} 
		} 
		// UNAUTORIZED
		else{

			return redirect("admin/invoices");
		}

	}
	
	// sending email
	public function send_approval_email($data) {
        $to         	= $data["owner_email"]; 
        $name       	= $data["owner_name"];
        $bid 			= $data["building_id"];
		$invoice_id		= $data["invoice_id"];
		$subject    	= "Pay Invoice Approval - VRMBIM";
        
		$actual_link    = "http://$_SERVER[HTTP_HOST]/owner/buildings/view/".$bid;
		$login_link    = "http://$_SERVER[HTTP_HOST]/owner";

        $message = "
        <html>
            <head>
                <title>Require Pay Invoice Approval - VRMBIM</title>
            </head>
            <body> 
                <table>
                    <tr>
                        <td>
                            <p>Dear ".$name.",<br>
                            A new invoice (ID: ".$invoice_id.") has been added on VRMBIM, plaese approve that for pay.  
                            You can access the website through <a href='".$actual_link."'>Click Here</a>.<br><br>
                            
                            If you have any questions, please do not hesitate to contact us at <a href='mailto:vrmbim@gmail.com'>vrmbim@gmail.com</a><br>
                            Please click on the link below to access the portal.</p>
                            <p><a href='".$login_link."'>Click Here</a> to login.</p>
                            <p>Thank You<br> 
                            VRMBIM Team</p> 
                        </td>
                    </tr>
                </table>
            </body>
        </html>
        ";
        // echo $message; exit();

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <vrmbim@gmail.com>' . "\r\n";
        $headers .= 'BCC: vrmbim@gmail.com' . "\r\n";

        mail($to,$subject,$message,$headers);
    }


	public function approve_invoice($id = NULL) 
	{
		//
		if($id != NULL){

			$invoice = $this->m->show_m($id);

			// FORM VALIDATION TRUE
			if(!empty($invoice) && ($invoice->status == "open" || $invoice->status == "processing"))
			{
				$data['vendor_id']            		= $invoice->vendor_id;
				$data['building_id']          		= $invoice->building_id;
				$data['order_no']             		= $invoice->order_no;
				//
				$data['total_amount']         		= $invoice->total_amount;
				$data['can_staff_pay']         		= $invoice->can_staff_pay;
				$data['requires_vendor_invoice']    = $invoice->requires_vendor_invoice;


				// retrieve the vendor ..
				$vendor       = $this->m->show_vendor_m($data['vendor_id']);
				$building     = $this->m->show_building_m($data['building_id']);
				//

				if(empty($vendor) || empty($building)){
					$this->session->set_flashdata('error',lang('error_approve_invoice'));
					//
					return redirect("admin/invoices");
				}
				//

				// transfer amount to vendor ...
				$data['transfer_amount']      = round($data['total_amount'] * ($vendor->percentage / 100), 2);

				// stripe work starts here ... //////////////////////////////////////

				// load stripe
				$this->load->library('stripe');
				
				// ------------------ step 2  ----------------------------------------------
				$customer_id     = $building->customer_id;
				$total_amount    = $data['total_amount'] * 100;
				$description     = "Invoice for Building ". $building->code . ' & Work Order '. $data['order_no'];
				$currency        = "usd";
				//
				$item  = $this->stripe->create_invoice_item($customer_id, $total_amount, $currency, $description);
				// success ??
				if(!$item->success){
					$this->session->set_flashdata('error',$item->message);
					return redirect("admin/invoices");
				}
				// original invoice item object ..
				$item = $item->item;
				// ---------------------- end to step 2 ------------------------------------



				// ------------------ step 3  ----------------------------------------------
				$account_id      = $vendor->reference_account_id;
				$customer_id     = $building->customer_id;
				$transfer_amount = $data['transfer_amount'] * 100;
				$description     = "Invoice for Building ". $building->code . ' & Work Order '. $data['order_no'];
				$metadata        = ['vendor' => $vendor->id,'building' => $building->id];

				$invoice  = $this->stripe->create_invoice($account_id, $transfer_amount, $customer_id, $description, $metadata);
				// success ??
				if(!$invoice->success){
					// delete the invoice item ...
					$del_item = $this->stripe->delete_invoice_item($item->id);
					// end to invoice item delete
					
					$this->session->set_flashdata('error',$invoice->message);
					return redirect("admin/invoices");
				}
				// original invoice object ..
				$invoice = $invoice->invoice;
				// ---------------------- end to step 3 ------------------------------------
			

				$data['invoice_id']   = $invoice->id;
				$data['currency']     = $invoice->currency;
				$data['total_paid']   = $invoice->amount_paid / 100;
				$data['invoice_url']  = $invoice->hosted_invoice_url;
				$data['status']       = $invoice->status;
				//
				// $data['can_staff_pay']           = ($this->input->post("can_staff_pay")) == 1 ? 1 : 0;
				// $data['requires_vendor_invoice'] = ($this->input->post("requires_vendor_invoice")) == 1 ? 1 : 0;
				//
				$data['created_at']   = NOW;
				// end to stripe work part here ...

				// updating same records via model
				if($this->m->update_m($id, $data)){
					// update to the payments record as well ...

					$paym_data['invoice_id']  = $id;
					$paym_data['vendor_id']   = $vendor->id;
					$paym_data['payment_id']  = $invoice->payment_intent->id;
					$paym_data['amount']      = $data['total_amount'];
					$paym_data['transfer_amount'] = $data['transfer_amount'];	
					$paym_data['currency']    = $invoice->payment_intent->currency;
					$paym_data['status']      = $invoice->payment_intent->status;
					$paym_data['created_at']  = NOW;

					$this->m->update_payment_m($id, $paym_data);
					//
					$this->session->set_flashdata('success',lang('success_invoice_appoved'));
				}
				else
					$this->session->set_flashdata('error',lang('error_approve_invoice'));

				

				return redirect('admin/invoices');
				
			}else{
				// If status not Open then...
				return redirect("admin/invoices");
			}
			
		}else{
			// UNAUTORIZED
			return redirect("admin/invoices");
		}
	}

	public function recreate($id = NULL)
	{
		//
		if($id != NULL){

			$invoice = $this->m->show_m($id);

			// FORM VALIDATION TRUE
			if(!empty($invoice) && ($invoice->status == "open" || $invoice->status == "processing"))
			{
				$data['vendor_id']            		= $invoice->vendor_id;
				$data['building_id']          		= $invoice->building_id;
				$data['order_no']             		= $invoice->order_no;
				//
				$data['total_amount']         		= $invoice->total_amount;
				$data['can_staff_pay']         		= $invoice->can_staff_pay;
				$data['requires_vendor_invoice']    = $invoice->requires_vendor_invoice;


				// retrieve the vendor ..
				$vendor       = $this->m->show_vendor_m($data['vendor_id']);
				$building     = $this->m->show_building_m($data['building_id']);
				//

				if(empty($vendor) || empty($building)){
					$this->session->set_flashdata('error',lang('error_re-create_invoice'));
					//
					return redirect("admin/invoices");
				}
				//

				// transfer amount to vendor ...
				$data['transfer_amount']      = round($data['total_amount'] * ($vendor->percentage / 100), 2);

				// stripe work starts here ... //////////////////////////////////////

				// load stripe
				$this->load->library('stripe');
				
		       	// ------------------ step 2  ----------------------------------------------
				$customer_id     = $building->customer_id;
				$total_amount    = $data['total_amount'] * 100;
				$description     = "Invoice for Building ". $building->code . ' & Work Order '. $data['order_no'];
				$currency        = "usd";
				//
				$item  = $this->stripe->create_invoice_item($customer_id, $total_amount, $currency, $description);
				// success ??
		        if(!$item->success){
		            $this->session->set_flashdata('error',$item->message);
		            return redirect("admin/invoices");
		        }
		        // original invoice item object ..
		        $item = $item->item;
		        // ---------------------- end to step 2 ------------------------------------



				// ------------------ step 3  ----------------------------------------------
				$account_id      = $vendor->reference_account_id;
				$customer_id     = $building->customer_id;
				$transfer_amount = $data['transfer_amount'] * 100;
				$description     = "Invoice for Building ". $building->code . ' & Work Order '. $data['order_no'];
				$metadata        = ['vendor' => $vendor->id,'building' => $building->id];

				$invoice  = $this->stripe->create_invoice($account_id, $transfer_amount, $customer_id, $description, $metadata);
				// success ??
		        if(!$invoice->success){
		        	// delete the invoice item ...
		        	$del_item = $this->stripe->delete_invoice_item($item->id);
		        	// end to invoice item delete
		        	
		            $this->session->set_flashdata('error',$invoice->message);
		            return redirect("admin/invoices");
		        }
		        // original invoice object ..
		        $invoice = $invoice->invoice;
		        // ---------------------- end to step 3 ------------------------------------
		     

		        $data['invoice_id']   = $invoice->id;
		        $data['currency']     = $invoice->currency;
		        $data['total_paid']   = $invoice->amount_paid / 100;
		        $data['invoice_url']  = $invoice->hosted_invoice_url;
		        $data['status']       = $invoice->status;
		        //
		        // $data['can_staff_pay']           = ($this->input->post("can_staff_pay")) == 1 ? 1 : 0;
		        // $data['requires_vendor_invoice'] = ($this->input->post("requires_vendor_invoice")) == 1 ? 1 : 0;
		        //
		        $data['created_at']   = NOW;
				// end to stripe work part here ...

				// updating same records via model
				if($this->m->update_m($id, $data)){
					// update to the payments record as well ...

					$paym_data['invoice_id']  = $id;
					$paym_data['vendor_id']   = $vendor->id;
					$paym_data['payment_id']  = $invoice->payment_intent->id;
					$paym_data['amount']      = $data['total_amount'];
					$paym_data['transfer_amount'] = $data['transfer_amount'];	
					$paym_data['currency']    = $invoice->payment_intent->currency;
					$paym_data['status']      = $invoice->payment_intent->status;
		        	$paym_data['created_at']  = NOW;

		        	$this->m->update_payment_m($id, $paym_data);
		        	//
					$this->session->set_flashdata('success',lang('success_invoice_re-created'));
				}
				else
					$this->session->set_flashdata('error',lang('error_re-create_invoice'));

				

				return redirect('admin/invoices');
				
			}else{
				// If status not Open then...
				return redirect("admin/invoices");
			}
			
		}else{
			// UNAUTORIZED
			return redirect("admin/invoices");
		}

	}


	public function terms_conditions()
	{
		$this->data['title'] = lang('Terms and Conditions');

		$this->load->view('admin/invoice/terms_conditions',$this->data);
	}


	// VOID INVOICE
	public function void_invoice($id = NULL){
		if($id != NULL){

			$invoice = $this->m->show_m($id);
			//
			if(!empty($invoice) && $invoice->status == "open"){
				// stripe
				$this->load->library('stripe');

				$invoice = $this->stripe->void_invoice($invoice->invoice_id);
				// success ??
		        if(!$invoice->success){
		            $this->session->set_flashdata('error',$invoice->message);
		            return redirect("admin/invoices/add");
		        }
		        // original invoice object ..
		        $invoice = $invoice->invoice;
		        //
		        $data['status'] = $invoice->status;

				if($this->m->update_m($id,$data))
					$this->session->set_flashdata('success',lang('success_invoice_update'));
				else
					$this->session->set_flashdata('error',lang('error_invoice_update'));
			}
		}

		return redirect('admin/invoices');
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
					return $this->load->view('admin/invoice/pay',$this->data);
				}
			}
		}

		return redirect('admin/invoices', $this->data);
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

			// $getInt  = $this->stripe->retrieve_setup_intent("seti_1MIFA0DD8ZpzDT6Q9vWSa7xN");
			// $getInt  = $this->stripe->retrieve_payment_intent("pi_3LBLriDD8ZpzDT6Q0enCI7St");
			$getPI  = $this->m->get_payment_int_m($id);
			$payment_status = $getPI->status;
			$customer_id  = $getPI->customer_id;
			$payment_method_id  = $getPI->payment_method_id;
			$total_amount  = $getPI->total_amount * 100;
			$payment_intent_id  = $getPI->payment_id;
			// $total_amount  = 1.00;
			
			if($payment_status == "requires_payment_method")
			{
				// $payInt  = $this->stripe->create_payment_intent($customer_id, $payment_method_id, $total_amount);

				// update payment
				// $pay_data['payment_id'] = $payInt->setup->id;
				// $pay_data['status']     = "requires_confirmation";
				// $this->m->update_payment_m($invoice->id,$pay_data);

				// confiming payment intent
				// $retr_payment = $this->stripe->retrieve_payment_intent($payment_intent_id);
			}

			// echo "<pre>";
			// print_r($retr_payment); exit();

			//
			if(empty($invoice) || $invoice->status != "open"){
				$this->session->set_flashdata('error' , "Oops! Invoice cannot be paid");
				return redirect("admin/invoices/pay_invoice/".$id);
			}
			// does it require vendor invoice and Is it already there ??
			if($invoice->requires_vendor_invoice == 1 && empty($invoice->vendor_invoice)){
				$this->session->set_flashdata("error", lang("error_vendor_invoice_required"));
				return redirect("admin/invoices");
			} 

			//
			$building     = $this->m->show_building_m($invoice->building_id);
			//
			if(empty($building)){
				$this->session->set_flashdata('error',lang('error_invoice_add'));
				//
				return redirect("admin/invoices/pay_invoice/".$id);
			}
			//

			// STEP 2
			$inv  = $this->stripe->pay_invoice($invoice->invoice_id, $building->payment_method_id);

			// echo "<pre>";
			// print_r($inv); exit();
			
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
			return redirect("admin/invoices");

		}
		// added later on 
		$this->session->set_flashdata('error',lang('error_invoice_add'));
		//
		return redirect("admin/invoices/pay_invoice/".$id);
		
		
		// end to invoice payment
	}



}
