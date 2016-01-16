<!DOCTYPE html>
<!--[if lt IE 7]>	<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>		<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>		<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Claire &amp; Joe : Contact Us | Wedding . Joe Morrow.org</title>
		<meta name="description" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base target="_blank">

		<link href="http://fonts.googleapis.com/css?family=EB+Garamond|Josefin+Sans" rel="stylesheet" type="text/css">
		<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

		<link rel="stylesheet" href="../css/normalize.min.css">
		<link rel="stylesheet" href="../css/main.css">

		<script src="../js/vendor/modernizr-2.6.2.min.js"></script>
	</head>
	<body class="content">
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<div class="back"><a target="_self" href="../">Back to Home</a></div>

		<div class="page" id="top">
			<header>
				<h1>Contact Us</h1>
			</header>

<?php

// For debugging, set this to true
$debug = false;
$debug = ($debug || isset($_REQUEST["debug"])) ? trim($_REQUEST["debug"]) : false;

// Show the form at the bottom of the page selectively based on the user's input
$showForm = true;

// First, see if we're receiving a submission
if (isset($_POST["submit"])) {

	// If so, gather the input
	$name = trim($_POST["name"]);
	$otherNames = trim($_POST["otherNames"]);
	$address1 = trim($_POST["address1"]);
	$address2 = trim($_POST["address2"]);
	$city = trim($_POST["city"]);
	$state = trim($_POST["state"]);
	$zip = trim($_POST["zip"]);
	$country = trim($_POST["country"]);
	$phone = trim($_POST["phone"]);
	$email = trim($_POST["email"]);
	$message = trim($_POST["message"]);
	$human = trim($_POST["human"]);

	$firstName = array_shift(explode(" ", $name));

	// Build the address
	$address = $address1 . "\n";
	$address .= ($address2) ? $address2 . "\n" : "";
	$address .= $city . ", " . $state . " " . $zip . "\n";
	$address .= ($country) ? $country . "\n" : "";
	$address .= ($phone) ? $phone . "\n" : "";

	// Then, build the Email message
	$to = "wedding-form@joemorrow.org";
	$from = "From: " . $to;
	$subject = "A New Address from " . $name . " via wedding.joemorrow.org/contact";
	$body = "Here's a new address submission from http://wedding.joemorrow.org/address\n\nFrom: $name <$email>\n\nAddress:\n$address\n\nMessage:\n$message\n\nNumber of Kitties: $human\n(EOM)\n";

	// If we're debugging, output the variables
	if ($debug) {
		echo "<p><pre>";
		print_r($_POST);
		echo "\n\nFirst Name:\n$firstName\n";
		echo "\n\nAddress:\n$address\n";
		echo "\n\nMessage:\n$body\n";
		echo "</pre></p>";
	}

	// Our SPAM filter only checks for a text entry.
	if (is_numeric($human)) {
		if (imap_mail($to, $subject, $body, $from)) {

			// Don't show the form if the send was successful
			$showForm = false;
?>
			<section class="success">
				<p>Thanks for your updated address, <?= $firstName ?>!  You'll be hearing from us soon.</p>
			</section>

			<footer>
				<p><a target="_self" href="javascript:history.go(-2)"><i class="fa fa-hand-o-left fa-fw"></i>Go Back</a></p>
				<p><a target="_self" href="../"><i class="fa fa-home fa-fw"></i>Back to Home</a></p>
			</footer>

<?php
		} else {
			// The Email didn't send correctly, do show the form again.
			$showForm = true;

?>
			<section class="error">
				<p>Something went wrong, please try again.</p>
			</section>

<?php
		}
	} else {
		// Failed the SPAM filter.  Since this could be a bot, don't show the form again.  Humans can "Go Back" if they'd like.
		$showForm = false;

?>
			<section class="error">
				<p>No, sorry, please enter your favorite number of kitties as a number, like 12 or 400.</p>
			</section>

			<footer>
				<p><a target="_self" href="javascript:history.go(-1)"><i class="fa fa-hand-o-left fa-fw"></i>Go Back</a></p>
				<p><a target="_self" href="../"><i class="fa fa-home fa-fw"></i>Back to Home</a></p>
			</footer>

<?php
	}
}

if ($showForm) {
?>
			<section>
				<p>Please share your address with us.</p>

				<form method="post" action="index.php" target="_self">
					<fieldset>
						<legend>You and Your Guests</legend>
						<label>Your Name</label>
						<input name="name" type="text" required="required" autofocus>

						<label>Names of Others in Your Party</label>
						<input name="otherNames" type="text">
					</fieldset>

					<fieldset>
						<legend>Your Address</legend>
						<label>Address Line 1</label>
						<input name="address1" type="text" required="required">

						<label>Address Line 2</label>
						<input name="address2" type="text">

						<label>City</label>
						<input name="city" type="text" required="required">

						<label>State</label>
						<select name="state" required="required">
							<option value="" selected="selected"></option>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>

						<label>Zip</label>
						<input name="zip" type="input" required="required">

						<label>Country</label>
						<select name="country" type="text" required="required">
							<option value=""></option>
							<option value="US" selected="selected">United States</option>
							<option value="JM">Jamaica</option>
						</select>
					</fieldset>

					<fieldset>
						<legend>Contact Information</legend>
						<label>Your Email Address</label>
						<input name="email" type="email" required="required">

						<label>Your Phone Number</label>
						<input name="phone" type="tel">
					</fieldset>
					
					<fieldset>
						<legend>Your Message</legend>
						<label>Comments or Other Information</label>
						<textarea name="message" required="required"></textarea>
					</fieldset>

					<fieldset>
						<legend>Anti-SPAM</legend>
						<label>What's your favorite number of kitties? (anti-spam)</label>
						<input name="human" placeholder="Enter a number" required="required">
					</fieldset>

<?php
	if ($debug) {
?>
					<label>Debug?</label>
					<input name="debug" type="radio" value="">No
					<input name="debug" type="radio" value="true" checked="checked">Yes

<?php
	}
?>
					<input id="submit" name="submit" type="submit" value="Submit">
				</form>
			</section>

			<footer>
				<p><a target="_self" href="javascript:history.go(-2)"><i class="fa fa-hand-o-left fa-fw"></i>Go Back</a></p>
				<p><a target="_self" href="../"><i class="fa fa-home fa-fw"></i>Back to Home</a></p>
			</footer>

<?php
}
?>
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="../js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

		<script src="../js/plugins.js"></script>
		<script src="../js/main.js"></script>

		<!-- Google Analytics -->
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-50830737-1', 'joemorrow.org');
			ga('send', 'pageview');
		</script>
	</body>
</html>
