<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webhook_model extends CI_Model
{

	//  update payment ...
	public function update_payment($payment_id, $status){

		// retrieve the payment ...
		$is_payment = $this->db->where('payment_id',$payment_id)
		->get(PAYMENTS)->row();

		// update only if payment exists in our system ....
		if(!empty($is_payment)){
			
			$data['status']   =  $status;
			// update
			return $this->db->where('id',$is_payment->id)->update(PAYMENTS,$data);
		}
		
	}

	// update invoice

	public function update_invoice($invoice, $net_amount ){
		// retrieve the invoice ...
		$is_inv = $this->db->where('invoice_id',$invoice->id)
		->get(INVOICES)->row();

		// update only if invoice exists in our system ....
		if(!empty($is_inv)){
			
			$data['total_paid']         =  $invoice->amount_paid / 100;
			$data['status']             =  $invoice->status;
			//
			$data['net_amount']         =  $net_amount;
			// update
			return $this->db->where('id',$is_inv->id)->update(INVOICES,$data);
		}
	}


	// update invoice failed
	public function update_invoice_failed($invoice){
		// retrieve the invoice ...
		$is_inv = $this->db->where('invoice_id',$invoice->id)
		->get(INVOICES)->row();

		// update only if invoice exists in our system ....
		if(!empty($is_inv)){
			
			$data['status']	= "failed";
			// update
			return $this->db->where('id',$is_inv->id)->update(INVOICES,$data);
		}
	}


	public function update_connect($account_id, $data ){
		// retrieve the vendo account ...
		$is_acc = $this->db->where('reference_account_id',$account_id)
		->get(VENDORS)->row();

		// update only if vendo account exists in our system ....
		if(!empty($is_acc)){
			
			// update
			return $this->db->where('id',$is_acc->id)->update(VENDORS,$data);
		}
	}

	// retrieve payment by payment id ...
	public function retrieve_payment($payment_id){
		return $this->db->where("status", "succeeded")->get(PAYMENTS)->row();
	}

	// retrieve bank by setup intent id ...
	public function retrieve_bank($setup_intent_id){
		return $this->db->where("setup_intent_id", $setup_intent_id)->get(BANKS)->row();
	}

	// UPDATE bank by setup intent id
	public function update_bank($setup_intent_id = NULL, $data = array())
    {
        if ($setup_intent_id != NULL && !empty($data))
            return $this->db->where('setup_intent_id', $setup_intent_id)->update(BANKS, $data);
        else
            return false;
    }


	// set payment as dispute by payment id ...
	public function set_invoice_dispute($invoice_id, $status){
		return $this->db->where("status", "paid")
		->where("id", $invoice_id)
		->update(INVOICES, ['status' => $status]);
	}

	// set payment as dispute by payment id ...
	public function set_payment_dispute($payment_id, $status){
		return $this->db->where("status", "succeeded")
		->where("payment_id", $payment_id)
		->update(PAYMENTS, ['status' => $status]);
	}


}