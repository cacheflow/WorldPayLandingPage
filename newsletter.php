<!DOCTYPE html>
<html lang="en">

	<head>

		<!-- Basic -->
		<meta charset="utf-8">
		<title>WorldPay</title>
		<meta name="description" content="WorldPay">		
		   
		<!-- Libs CSS -->
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
		
		<!-- Google Fonts -->	
		<link href='http://fonts.googleapis.com/css?family=Lato:400,900italic,900,700italic,400italic,300italic,300,100italic,100' rel='stylesheet' type='text/css'>
		   
	</head>

	<body>
		<div id="contentForm">
	
			<?php
			// Credits: https://gist.github.com/mfkp/1488819

			session_cache_limiter('nocache');
			header('Expires: ' . gmdate('r', 0));
			header('Content-type: application/json');

			$apiKey 	= '5d8e5d657e472b579d7f8fa448eca38a-us9'; - // How get your Mailchimp API KEY - http://kb.mailchimp.com/article/where-can-i-find-my-api-key
			$listId 	= '998c7bf428'; - // How to get your Mailchimp LIST ID - http://kb.mailchimp.com/article/how-can-i-find-my-list-id
			$submit_url	= "http://us9.api.mailchimp.com/2.0/?method=listSubscribe"; - // Replace us2 with your actual datacenter

			$double_optin = false;
			$send_welcome = false;
			$email_type = 'html';
			$email = $_POST['email'];
			$merge_vars = array( 'YNAME' => $_POST['yname'] );

			$data = array(
			    'email_address' => $email,
			    'apikey' => $apiKey,
			    'id' => $listId,
			    'double_optin' => $double_optin,
			    'send_welcome' => $send_welcome,
				'merge_vars' => $merge_vars,
			    'email_type' => $email_type
			);

			$payload = json_encode($data);
			 
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $submit_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
			 
			$result = curl_exec($ch);
			curl_close ($ch);

			$data = json_decode($result);

			if ($data->error) {
			    $arrResult = array ('response'=>'error','message'=>$data->error);
			} else {
			    $arrResult = array ('Got it, you have been added to our email list.');
			}




			?> 

				<div class="container">
					<div class="row">
						<div class="col-sm-6 col-sm-offset-3">
							<div id="form_response" class="text-center">
								<img class="img-responsive" src="img/thumbs/mail_sent.png" alt="image" />
								<h1>Thank You</h1>
								<p>You've been added to our mailing list.</p>
								<a class="btn btn-primary btn-lg" href="index.html">Back To The Site</a>
							</div>
						</div>	
					</div>					
				</div>

		</div> 

	</body> 
</html>

echo json_encode($arrResult);

