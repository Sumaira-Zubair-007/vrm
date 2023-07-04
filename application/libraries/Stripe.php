<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// require the libraries
require_once APPPATH . "third_party/stripe/vendor/autoload.php";
require_once APPPATH . "third_party/ramsey/vendor/autoload.php";
use Ramsey\Uuid\Uuid;



class Stripe{

	
	public function __construct(){
		$this->ci =& get_instance();
		// Settings info
		//$this->settings = $this->ci->db->where('id', '2')->get(SETTINGS)->row();
		$this->settings = $this->ci->db->where('id', '1')->get(SETTINGS)->row();

		 // set api key & latest version
        \Stripe\Stripe::setApiKey($this->settings->stripe_secret_key);  
        \Stripe\Stripe::setApiVersion("2020-08-27");


        // idempotency key
        // $this->idempotency_key = Uuid::uuid4()->toString();

    }


    /* retrieve account 
	** @param $account_id
	*  @return  account object 
	*/ 

	public function retrieve_account($account_id){
		try {
			$response = new stdClass();
			
			
            // step 1 ...
            $account = \Stripe\Account::retrieve($account_id);
			
            //
			$response->success   = true;
			$response->account   = $account;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}


	/* retrieve account balance 
	** @param $account_id
	*/ 

	public function retrieve_balance($account_id){
		try {
			$response = new stdClass();
			
            // step 1 ...
            $account = \Stripe\Balance::retrieve($account_id);
			
            //
			$response->success   = true;
			$response->account   = $account;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}


    /* create account 
	** @param $return_url, $success_url, $account_id, $step
	*  @return  account object 
	*/ 

	public function create_account($return_url, $refresh_url, $account_id, $step = 1){
		try {
			$response = new stdClass();
			
			if($step == 1){
			    // step 1 ...
    			$account = \Stripe\Account::create([
                    'type' => 'standard',
                  ]);
                  
                $account_id = $account->id;
			}
            
            // part 2 ...
            $link = \Stripe\AccountLink::create([
                'account'     => $account_id,
                'refresh_url' => $refresh_url,
                'return_url'  => $return_url,
                'type'        => 'account_onboarding',
              ]);

			$response->success   = true;
			$response->account   = $account_id;
			$response->link      = $link;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}


    /* create customer 
    ** @param  array
    *  @return  customer object 
    */ 

    public function create_customer($customer_arr = array()){
        try {
            $response = new \stdClass();

            // api call 
            $customer = Stripe\Customer::create($customer_arr);
            $response->success   = true;
            $response->customer  = $customer;
        } catch (\Exception $e) {
            $response->success = false;
            $response->message = $e->getMessage();
        }

        return $response;
    }




    /* create invoice ... 
	** @param connect transfer account, transfer_amount, customer id, payment method id  currency, description
	*  @return  invoice object 
	*/ 

	public function create_invoice($transfer_account, $transfer_amount, $customer_id, $description, $statement_descriptor= "", $metadata = array() ){

		
		try {
			$response = new stdClass();
			
            //
            $invoice  = \Stripe\Invoice::create([
                'customer'          	=> $customer_id,
                'description'       	=> $description,
				'statement_descriptor' 	=> $statement_descriptor,
                'metadata'          	=> $metadata,
                // 'payment_settings'  => [
                // 	'payment_method_types'    => ['ach_credit_transfer', 'us_bank_account', 'card'],
                // 	'payment_method_options'  => [
                // 		'us_bank_account' => [
	               //  		'verification_method' => 'instant',
	               //  		'financial_connections' => ['permissions' => ['payment_method']],
	               //  	]
	               //  ]
                // ],
                'transfer_data'     => [
                	'destination' => $transfer_account,
                	'amount'      => $transfer_amount
                ],
                'expand' => ['payment_intent']
              ]);

            // finalize it
            $invoice->finalizeInvoice([
            	'expand' => ['payment_intent']
            ]);
    

			$response->success   = true;
			$response->invoice   = $invoice;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}



	/* create invoice item ... 
	** @param customer id, amount, currency, description
	*  @return  invoice item object 
	*/ 

	public function create_invoice_item($customer_id, $amount, $currency = "usd", $description = ""){
		try {
			$response = new stdClass();
			
            //
            $item = \Stripe\InvoiceItem::create([
                'customer'     => $customer_id,
                'amount'       => $amount,
                'currency'     => strtolower($currency),
                'description'  => $description,
              ]);

			$response->success   = true;
			$response->item      = $item;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}

	/* delete invoice item... 
	** @param invoice item id
	*  @return  invoice item object 
	*/ 

	public function delete_invoice_item($item_id){
		try {
			$response = new stdClass();
			
            //
            $item = \Stripe\InvoiceItem::retrieve($item_id);
            $item->delete();

			$response->success   = true;
			$response->item      = $item;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}

	/* void invoice ... 
	** @param invoice id
	*  @return  invoice  object 
	*/ 

	public function void_invoice($invoice_id){
		try {
			$response = new stdClass();
			
            //
            $invoice = \Stripe\Invoice::retrieve($invoice_id);
            $invoice->voidInvoice();

			$response->success   = true;
			$response->invoice   = $invoice;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}

	/* pay invoice ... 
	** @param invoice id, source
	*  @return  invoice  object 
	*/ 

	public function pay_invoice($invoice_id, $payment_method_id){
		try {
			$response = new stdClass();
			
            //
            $invoice = \Stripe\Invoice::retrieve($invoice_id);
            $invoice->pay([
            	'payment_method' => $payment_method_id,
            	'expand' => ['payment_intent']
            ]);

			$response->success   = true;
			$response->invoice   = $invoice;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}

	/* retrieve invoice ... 
	** @param invoice id
	*  @return  invoice  object 
	*/ 

	public function retrieve_invoice($invoice_id){
		try {
			$response = new stdClass();
			
            //
            $invoice = \Stripe\Invoice::retrieve([
            	'id' 	=> $invoice_id,
            	'expand' => ['charge.balance_transaction']
            ]);

			$response->success   = true;
			$response->invoice   = $invoice;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}


	// UPDATE V2 --------------------------------

	
    /* create session ... 
	** @param 
	*  @return  session object 
	*/ 

	public function create_session(){
		try {
			$response = new stdClass();
			
            //
            $session  = \Stripe\Checkout\Session::create([
            	'customer_creation'    => 'always',
            	'payment_method_types' => ['us_bank_account'],
            	'payment_method_options'  => [
            		'us_bank_account' => [
                		'verification_method' => 'automatic',
                		'financial_connections' => ['permissions' => ['payment_method']],
                	]
                ],
				'mode' => 'setup',
				'success_url' => base_url('admin/buildings/bank_account_success/{CHECKOUT_SESSION_ID}'),
				'cancel_url'  => base_url('admin/buildings/bank_account_error/{CHECKOUT_SESSION_ID}'),
            ]);

           

			$response->success   = true;
			$response->session   = $session;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}

	/* retrieve session ... 
	** @param session id
	*  @return  session  object 
	*/ 
	public function retrieve_session($session_id){
		try {
			$response = new stdClass();
			
            //
            $session  = \Stripe\Checkout\Session::retrieve([
            	'id' 	=> $session_id,
            	'expand' => ['setup_intent.payment_method']
            ]);

			$response->success   = true;
			$response->session   = $session;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}

	/* retrieve setup intent ... 
	** @param setup intent id
	*  @return  setup intent  object 
	*/ 
	public function retrieve_setup_intent($setup_intent_id){
		try {
			$response = new stdClass();
			
            //
            $setup = \Stripe\SetupIntent::retrieve([
            	'id' 	 => $setup_intent_id,
            	'expand' => ['payment_method']
            ]);

			$response->success   = true;
			$response->setup     = $setup;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}


	/* create Payment Intent ... 
	** @param payment intent id
	*  @return  payment intent  object 
	*/ 
	public function create_payment_intent($customer_id, $payment_id, $amount){
		try {
			$response = new stdClass();
			
            //
            $setup = \Stripe\PaymentIntent::create([
            	'payment_method_types' => ['us_bank_account'],
  				'payment_method' => $payment_id,
				'customer' => $customer_id,
				'setup_future_usage' => 'off_session',
				'amount' => $amount,
				'currency' => 'usd',
				'description'  => 'Payment for invoice'
            ]);

			$response->success   = true;
			$response->setup     = $setup;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}


	/* confirm Payment Intent ... 
	** @param payment intent id
	*  @return  payment intent  object 
	*/ 
	public function confirm_payment_intent($payment_intent_id, $payment_method_id){
		try {
			$response = new stdClass();
			
            //
            $setup = \Stripe\PaymentIntent::confirm([
            	'id' => $payment_intent_id,
  				'payment_method' => $payment_method_id
            ]);

			$response->success   = true;
			$response->setup     = $setup;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}


	/* retrieve Payment Intent ... 
	** @param payment intent id
	*  @return  payment intent  object 
	*/ 
	public function retrieve_payment_intent($payment_id){
		try {
			$response = new stdClass();
			
            //
            $setup = \Stripe\PaymentIntent::retrieve([
            	'id' 	 => $payment_id
            ]);

			$setup->confirm();
			generateResponse($setup);

			$response->success   = true;
			$response->setup     = $setup;
		} catch (Exception $e) {
			$response->success = false;
			$response->message = $e->getMessage();
		}

		return $response;
	}
	

	function generateResponse($intent) {
		# Note that if your API version is before 2019-02-11, 'requires_action'
		# appears as 'requires_source_action'.
		if ($intent->status == 'requires_action' &&
			$intent->next_action->type == 'use_stripe_sdk') {
		  # Tell the client to handle the action
		  echo json_encode([
			'requires_action' => true,
			'payment_intent_client_secret' => $intent->client_secret
		  ]);
		} else if ($intent->status == 'succeeded') {
		  # The payment didn’t need any additional actions and completed!
		  # Handle post-payment fulfillment
		  echo json_encode([
			"success" => true
		  ]);
		} else {
		  # Invalid status
		  http_response_code(500);
		  echo json_encode(['error' => 'Invalid PaymentIntent status']);
		}
	}

}

?>