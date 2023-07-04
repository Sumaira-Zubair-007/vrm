<?php 

	if($_SERVER['REQUEST_METHOD'] === 'POST'){

		// GET FORM DATA SUBMITTED IN FORM

		$description 		= $_POST['description'];
		$to_contact 		= $_POST['to_contact'];
		$from_contact 		= $_POST['from_contact'];
		$item_one_name 		= $_POST['item_one_name'];
		$item_one_amount 	= $_POST['item_one_amount'];
		$item_two_name		= $_POST['item_two_name'];
		$item_two_amount 	= $_POST['item_two_amount'];
		$date_due 			= $_POST['date_due'];
		$amount_due 		= $_POST['amount_due'];
		$account_no 		= $_POST['account_no'];

		// API CALL TO CREATE CONTACT IN POSTGRID

 		  $header = array(
				'x-api-key:live_sk_fJhob1zXYvxYBbNf9oTCVs' 
		  );

		  $curl = curl_init();
		  
		  curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://api.postgrid.com/print-mail/v1/letters',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_HTTPHEADER => $header,
			  CURLOPT_POSTFIELDS => 'to='.$to_contact.'&from='.$from_contact.'&addressPlacement=top_first_page&returnEnvelope=return_envelope_fk8b7Zzgn8ReB7AZSea6xd&metadata[duedate]='.$date_due.'&metadata[amount_due]='.$amount_due.'&metadata[account_num]='.$account_no.'&metadata[item_1_name]='.$item_one_name.'&metadata[item_1_amount]='.$item_one_amount.'&metadata[item_2_name]='.$item_two_name.'&metadata[item_2_amount]='.$item_two_amount.'&template=template_kM92JftdyfgvUyWUFKWCaf&description='.$description ,
		));

		$response = curl_exec($curl);

		curl_close($curl);
		
		$response = json_decode($response);

		if(isset($response->id)){
			echo 'Letter created';
		}
		else{
			echo 'Something went wrong';
		}
	}

?>