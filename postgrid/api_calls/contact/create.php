<?php 

	if($_SERVER['REQUEST_METHOD'] === 'POST'){

		// GET FORM DATA SUBMITTED IN FORM

		$description 		= $_POST['description'];
		$name 				= $_POST['name'];
		$company 			= $_POST['company'];
		$job_title 			= $_POST['job_title'];
		$address_line_one 	= $_POST['address_line_one'];
		$address_line_two 	= $_POST['address_line_two'];
		$city				= $_POST['city'];
		$province_state 	= $_POST['province_state'];
		$postal_zip_code 	= $_POST['postal_zip_code'];
		$country 			= $_POST['country'];
		$phone_number 		= $_POST['phone_number'];
		$email 				= $_POST['email'];

		// API CALL TO CREATE CONTACT IN POSTGRID

 		  $header = array(
				'x-api-key:live_sk_fJhob1zXYvxYBbNf9oTCVs' 
		  );

		  $curl = curl_init();

		  curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.postgrid.com/print-mail/v1/contacts',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_HTTPHEADER => $header,
		  CURLOPT_POSTFIELDS => 'firstName='.$name.'&companyName='.$company.'&addressLine1='.$address_line_one.'&addressLine2='.$address_line_two.'&city='.$city.'&provinceOrState='.$province_state.'&description='.$description.'&countryCode='.$country.'&postalOrZip='.$postal_zip_code.'&jobTitle='.$job_title.'&email='.$email.'&phoneNumber='.$phone_number,
		));

		$response = curl_exec($curl);

		curl_close($curl);
		
		$response = json_decode($response);

		if(isset($response->id)){			
				
			echo 'Contact Added';
		}
		else{
			echo 'Something went wrong';
		}
	}

?>