<?php

$header = array(
	'x-api-key:live_sk_fJhob1zXYvxYBbNf9oTCVs' 
);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.postgrid.com/print-mail/v1/contacts?limit=2000',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTPHEADER => $header,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
$response = json_decode($response);

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Letter Form</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
		<link href="assets/css/select.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="assets/css/stylesheet.css">
	</head>
	<body>
		<section style="margin-top: 50px;">
			<div class="container">
				<div class="row">
					<div class="col-xs-12">
						<h3 class="title">Create A Letter</h3>
					</div>
				</div>
				<div class="row">
					<form action="api_calls/letters/create.php" method="post">
						<div class="col-xs-12">
							<div class="form-group floating_label">
								<input class="form-control" id="description" type="text" name="description" placeholder=""/>
								<label for="description">Description</label>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
								<select class="sel_ser form-control" id="to_contact" name="to_contact" required>
									<option value="0">To Contact *</option>
									<?php
										foreach ($response->data as $contact) { ?>
											<option value="<?php echo $contact->id; ?>"><?php echo $contact->firstName . " ".$contact->lastName; ?></option>
									<?php } ?>
									
								</select>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="form-group">
								<select class="sel_ser form-control" id="from_contact" name="from_contact" required>
									<option value="0">From Contact *</option>
									<?php
										foreach ($response->data as $contact) { ?>
											<option value="<?php echo $contact->id; ?>"><?php echo $contact->firstName . " ".$contact->lastName; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="form-group floating_label">
								<input class="form-control" id="item_one_name" type="text" name="item_one_name" placeholder=""/>
								<label for="item_one_name">Item 1 Name</label>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="form-group floating_label">
								<input class="form-control" id="item_one_amount" type="text" name="item_one_amount" placeholder=""/>
								<label for="item_one_amount">Item 1 Amount</label>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="form-group floating_label">
								<input class="form-control" id="item_two_name" type="text" name="item_two_name" placeholder=""/>
								<label for="item_two_name">Item 2 Name</label>
							</div>
						</div>
						<div class="col-md-6 col-xs-12">
							<div class="form-group floating_label">
								<input class="form-control" id="item_two_amount" type="text" name="item_two_amount" placeholder=""/>
								<label for="item_two_amount">Item 2 Amount</label>
							</div>
						</div>
						<div class="col-md-4 col-xs-12">
							<div class="form-group floating_label float_active">
								<input class="form-control" id="date_due" type="date" name="date_due" placeholder="" required>
								<label for="date_due">Date Due *</label>
							</div>
						</div>
						<div class="col-md-4 col-xs-12">
							<div class="form-group floating_label">
								<input class="form-control" id="amount_due" type="text" name="amount_due" placeholder="" required>
								<label for="amount_due">Amount Due *</label>
							</div>
						</div>
						<div class="col-md-4 col-xs-12">
							<div class="form-group floating_label">
								<input class="form-control" id="account_no" type="text" name="account_no" placeholder="" required>
								<label for="account_no">Account No *</label>
							</div>
						</div>
						<!-- <div class="col-xs-12">
							<div class="form-group">
								<select class="form-control" id="return_envelope">
									<option value="0">Select a Return Envelope *</option>
									<option value="Contact 1">Contact 1</option>
									
								</select>
							</div>
						</div> -->
						<div class="col-xs-12">
							<input type="submit" class="btn btn-default btn_submit" value="Create">
						</div>
					</form>
				</div>
			</div>
		</section>
		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/select.js"></script>
		<script type="text/javascript" src="assets/js/script.js"></script>
	</body>
</html>

