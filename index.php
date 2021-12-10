
<!DOCTYPE html>

<html>

<head>
	<title>Pay - RZ Web Media</title>
	<link rel="shortcut icon" href="https://rzwebmedia.com/wp-content/uploads/2021/06/favicon.png" type="image/x-icon">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script src="https://js.stripe.com/v3/"></script>
	<style>
		.StripeElement {
			background-color: white;
			height: 40px;
			padding: 10px 12px;
			border-radius: 4px;
			border: 1px solid transparent;
			box-shadow: 0 1px 3px 0 #e6ebf1;
			-webkit-transition: box-shadow 150ms ease;
			transition: box-shadow 150ms ease;
		}

		.StripeElement--focus {
			box-shadow: 0 1px 3px 0 #cfd7df;
		}

		.StripeElement--invalid {
			border-color: #fa755a;
		}

		.StripeElement--webkit-autofill {
			background-color: #fefde5 !important;
		}
	</style>
	
	<style type="text/css">

		.inputtext{

			border: 0;

			border-bottom: 1px solid #d4d4d4;

			border-radius: 0;

			box-shadow: none;

			transition: 0.4s all;

		}

		.border-info {

			border-color: #d4d4d4!important;

		}

		input[type="text"]:not(.browser-default):focus:not([readonly]){

			border-bottom: 3px solid #95d9ff;

			-webkit-box-shadow: 0 1px 0 0 #4285f4;

			box-shadow: none !important;

		}

		input[type="email"]:not(.browser-default):focus:not([readonly]){

			border-bottom: 3px solid #95d9ff;

			-webkit-box-shadow: 0 1px 0 0 #4285f4;

			box-shadow: none !important;

		}

		form input[type="number"]:not(.browser-default):focus:not([readonly]){

			border-bottom: 3px solid #95d9ff;

			-webkit-box-shadow: 0 1px 0 0 #4285f4;

			box-shadow: none !important;

		}

	</style>

</head>


<body>

	

	<div class="container">

		<div class="row">

			<div class="col-lg-6 col-sm-8 offset-lg-3 offset-sm-2">

				<!-- <h2 class="my-4 text-center">Product Name</h2> -->

				<div class="card border border-info mt-4">

					<div class="card-body">

						<h3 class="text-center">Payout</h3>

						<hr> 

						<div class="alert alert-success alert-dismissible fade show" style="display: none;">

							<button type="button" class="close" data-dismiss="alert">&times;</button>

							<strong>CVV is required  </div>

								<?= form_open("payout", 'method="post" id="payment-form" class="form" role="form"')?>
									<div class="form-group">

										<label for="cc_name">Customer Name</label>

										<input type="text" name="name" value="" class="form-control inputtext mb-3 StripeElement StripeElement--empty" placeholder="" required>

									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-md-6">
												<label for="cc_name">Product Name</label>
												<input type="text" name="products"  value="" class="form-control inputtext mb-3 StripeElement StripeElement--empty" placeholder="" required>
											</div>

											<div class="col-lg-6">
												<label class="">Amount</label>
												<input type="number" name="amount" value="" class="form-control inputtext mb-3 StripeElement StripeElement--empty" placeholder="" required>
											</div>
										</div>
									</div>

									<div class="form-group">

										<label for="cc_name">Currency</label>

										<div class="col-md-4">

											<select class="form-control inputtext" name="currency" size="0" required>

												<option value="usd" >USD</option>

												<option value="aud" >AUD</option>

												<option value="cad" >CAD</option>

												<option value="gbp" >GBP</option>

												<option value="inr" >INR</option>

											</select>

										</div>

									</div>
									<!-- Used to display form errors. -->

									<div style="color:red; font-size: 12px;" id="card-errors" role="alert">
										<?= $errors?>
									</div>

									<div class="form-group row">
										<div class="col-lg-12">
											<div class="form-check">
												<input type="checkbox" name="terms" class="form-check-input" id="tncCheck" checked >
												<label class="form-check-label" for="tncCheck"><small>I agree to the 
													<a href="https://rzwebmedia.com/terms-and-conditions/" target="_blank">terms and conditions</a> and <a href="https://rzwebmedia.com/wp-content/uploads/2021/10/Refund-Cancellation-Policy.pdf" target="_blank"> refund and cancellation</a> policy</small></label>
											</div>
											</div>

										</div>

									</div> 
									<div class="form-group row">

										<div class="col-md-6">

											<span type="" class="btn btn-danger btn-lg btn-block mt-4" id="cancelBttn">Cancel</span>

										</div>

										<div class="col-md-6">

											<button class="btn btn-success btn-lg btn-block mt-4 ">Submit</button>

										</div>

									</div>

								</form>

							</div>

						</div>

					</div>

				</div>
			</div>

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

			<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->

			<script src="https://js.stripe.com/v3/"></script>

			<script>

 
 var style = {

 	base: {

 		color: '#32325d',

 		fontFamily: '"Helvetica Neue", Helvetica, sans-serif',

 		fontSmoothing: 'antialiased',

 		fontSize: '16px',

 		'::placeholder': {

 			color: '#aab7c4'

 		}

 	},

 	invalid: {

 		color: '#fa755a',

 		iconColor: '#fa755a'

 	}

 };
 
 //Style button with BS
 
 // Create an instance of the card Element.
 
 var card = elements.create('card', {style: style});
 
 // Add an instance of the card Element into the `card-element` <div>.
 
 card.mount('#card-element');
 
 
 
 // Handle real-time validation errors from the card Element.
 
 card.addEventListener('change', function(event) {

 	var displayError = document.getElementById('card-errors');

 	if (event.error) {

 		displayError.textContent = event.error.message;

 	} else {

 		displayError.textContent = '';

 	}

 }); 
 document.getElementById("tncCheck").addEventListener("click", function(){

 	if(document.getElementById("tncCheck").checked == true){

 		document.getElementById('tnc-errors').style.display = "none";

 	}else{

 		document.getElementById('tnc-errors').style.display = "block";

 	}

 }); 
 
 // Handle form submission.
 
 var form = document.getElementById('payment-form');
 
 form.addEventListener('submit', function(event) {

 	event.preventDefault();

 	if(document.getElementById("tncCheck").checked == false){

 		document.getElementById("tnc-errors").style.display = "";

 		return false;

 	}else{
	   //stripe.createToken(card);
	   stripe.createToken(card).then(function(result) {

	   	console.log(result);

	   	if (result.error) {

		   // Inform the user if there was an error.

		   var errorElement = document.getElementById('card-errors');

		   errorElement.textContent = result.error.message;



		 } else {

		   // Send the token to your server.

		   stripeTokenHandler(result.token);

		 }

		});    

	 }

	});
 
 document.getElementById("cancelBttn").addEventListener("click", function(){

 	document.getElementById('payment-form').reset();

 });
 
 
 
 // Submit the form with the token ID.
 
 function stripeTokenHandler(token) {  

   // Insert the token ID into the form so it gets submitted to the server

   var form = document.getElementById('payment-form');

   var hiddenInput = document.createElement('input');

   hiddenInput.setAttribute('type', 'hidden');

   hiddenInput.setAttribute('name', 'stripeToken');

   hiddenInput.setAttribute('value', token.id);

   form.appendChild(hiddenInput);



   // Submit the form

   form.submit();

 }
</script>

</body>

</html>