<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Webhook extends CI_Controller
{
    private $settings;

    public function __construct()
    {
        parent::__construct();

        // THEME MODEL
        $this->load->model('webhook_model', 'm');

        // Helpers
        $this->load->library('stripe');

        // Settings info
        $this->settings = $this->db->get(SETTINGS)->row();


    }


    /* 
    ** Stripe webhook
    */
    public function init(){ 
        // webhook key 
        $webhook_key = $this->settings->stripe_webhook_key;
        // Retrieve the request's body
        $payload = @file_get_contents("php://input");


        if (!isset($_SERVER["HTTP_STRIPE_SIGNATURE"])) {
            // Couldn't get verification signatures
            http_response_code(400);
            echo "No direct access";
            exit;
        }

        $sig_header = $_SERVER["HTTP_STRIPE_SIGNATURE"];

        $event = null;

        try {

            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $webhook_key
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit;
        } catch(\Stripe\Error\SignatureVerification $e) {
            // Invalid signature
            http_response_code(400);
            exit;
        }
       
        if(isset($event->type) && ($event->type == 'invoice.paid' || $event->type == 'invoice.payment_failed' || $event->type == "charge.dispute.created" || $event->type == "setup_intent.succeeded" || $event->type == "account.updated")){

              // if there's data in event as well
            if(isset($event->data->object) && !empty($event->data->object)){
                $object = $event->data->object; // this is whole  object for use

                switch ($event->type) {
                    // invoice paid successful
                    case 'invoice.paid':
                    $this->process_invoice_update($object);
                    break;

                    // invoice failed
                    case 'invoice.payment_failed':
                        $this->process_invoice_failed($object);
                        break;

                    // payment dispute
                    case 'charge.dispute.created':
                    $this->process_payment_dispute($object);
                    break;

                    // ach bank successful
                    case 'setup_intent.succeeded':
                    $this->process_bank_success($object);
                    break;
                    


                    // connect account update as per requirements
                    case 'account.updated':
                    $this->process_account_update($object);
                    break;
                }
            }

        }


        // response 200 (success)
        http_response_code(200);
    }


    private function process_invoice_update($obj){
        // retrieve the invoice 
        $invoice = $this->stripe->retrieve_invoice($obj->id);
        // 
        if($invoice->success == true &&  $invoice->invoice->status == "paid"){
            // original object ..
            $invoice = $invoice->invoice;

            // connect case

            if(!empty($invoice->transfer_data)){

                $net_amount = ( ( $invoice->total - $invoice->transfer_data->amount ) - $invoice->charge->balance_transaction->fee) / 100;
            } else {
                $net        = ($invoice->total -  $invoice->charge->balance_transaction->fee) / 100;
            }
            // update the invoice record ..
            $this->m->update_invoice($invoice, $net_amount);
            // update the payment record ...
            $this->m->update_payment($invoice->payment_intent, "succeeded");
        }
    }

    // payment failed
    private function process_invoice_failed($obj){
        // retrieve the invoice 
        $invoice = $this->stripe->retrieve_invoice($obj->id);
        // 
        if($invoice->success == true &&  $invoice->invoice->status == "open"){
            
            // update the invoice record ..
            $this->m->update_invoice_failed($invoice);
            // update the payment record ...
            $this->m->update_payment($invoice->payment_intent, "failed");
        }
    }


    // INVOICE / PAYMENT DISPUTE
    private function process_payment_dispute($obj){
        // retrieve the payment first
        $payment = $this->m->retrieve_payment($obj->payment_intent);
        //
        if(!empty($payment) && $payment->status == "succeeded"){
            // update the invoice record ..
            $this->m->set_invoice_dispute($payment->invoice_id, "dispute");
            // update the payment record ...
            $this->m->set_payment_dispute($obj->payment_intent, "dispute");

        }
    }

    // update bank account status
    private function process_bank_success($setup_intent = NULL){
        if($setup_intent == NULL)
            return false;
      
        // retrieve the bank first
        $bank = $this->m->retrieve_bank($setup_intent->id);
        //


        if(!empty($bank) && in_array($bank->setup_intent_status, ['pending', 'requires_action'])){
        
            $up_data['setup_intent_status'] = $setup_intent->status;
            $up_data['status']              = $setup_intent->status == "succeeded" ? 1 : 0;
            $up_data['payment_method_id']   = $setup_intent->payment_method;
            $up_data['customer_id']         = $setup_intent->customer;
            $up_data['currency']            = "usd";

            //
            $this->m->update_bank($setup_intent->id, $up_data);
        }
    }



    // update connect account
    private function process_account_update($account = NULL){
        if($account == NULL)
            return false;
      
        
        // status confirmation ...
        if($account->details_submitted && $account->charges_enabled && $account->payouts_enabled){
            $data['reference_account_status'] = 1;
        } else {
            $data['reference_account_status'] = 2; // pending and wait for the hook ...
        }
        // 
        $this->m->update_connect($account->id , $data);
    }






    



}
