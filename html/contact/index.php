<!DOCTYPE html>
<!--[if lt IE 7]>	<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>		<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>		<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>Contact Us : Claire &amp; Joe</title>
		<meta name="description" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base target="_blank">

		<link href="http://fonts.googleapis.com/css?family=EB+Garamond|Josefin+Sans" rel="stylesheet" type="text/css">
		<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

		<link rel="stylesheet" href="../css/normalize.min.css">
		<link rel="stylesheet" href="../css/main.css">

		<script src="../js/vendor/modernizr-2.6.2.min.js"></script>
	</head>
	<body class="content contact">
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

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

// This variable lets us track how people are coming to the form page.
$ref = (isset($_REQUEST["ref"])) ? trim($_REQUEST["ref"]) : false;

$refMessage = false;
switch ($ref) {
	case "hotel":
		$refMessage = "It looks like you're asking for more information about hotels.";
		break;
	case "shuttle":
		$refMessage = "It looks like you're interested in transportation to and from the ceremony.";
		break;
}

// First, see if we're receiving a submission
if (isset($_POST["submit"])) {

	// If so, gather the input
	$name = trim($_POST["name"]);
	$email = trim($_POST["email"]);
	$message = trim($_POST["message"]);
	$reference = (trim($_POST["reference"])) ? trim($_POST["reference"]) : "(none)";
	$human = trim($_POST["human"]);

	$firstName = array_shift(explode(" ", $name));

	// Then, build the Email message
	$to = "wedding-form@joemorrow.org";
	$from = "From: " . $to;
	$subject = "A New Message from " . $name . " via wedding.joemorrow.org/contact";
	$body = "Here's a new message from http://wedding.joemorrow.org/contact\n\nFrom: $name <$email>\n\nReference: $reference\n\nMessage:\n$message\n\nNumber of Kitties: $human\n(EOM)\n";

	// If we're debugging, output the variables
	if ($debug) {
		echo "<p><pre>";
		print_r($_POST);
		echo "\n\nFirst Name:\n$firstName\n";
		echo "\n\nReference:\n$ref\n";
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
				<p>Thanks, <?= $firstName ?>!  Your message has been sent.</p>
				<p>We'll get back to you as soon as we can.</p>
			</section>

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

<?php
	}
}

if ($showForm) {
?>
			<section>
				<p>Please send us any comments or questions you have; we'll get back to you via Email as soon as we're able.</p>
				<p>If you need immediate help, please call Claire at <a class="tel" href="tel:7738755367">(773) 875-5367</a>.</p>

				<form method="post" action="index.php" target="_self">

					<fieldset id="name">
						<label>Your Name</label>
						<input name="name" required="required" autofocus>
					</fieldset>

					<fieldset id="email">
						<label>Email Address</label>
						<input name="email" type="email" required="required" placeholder="          @">
					</fieldset>
<?php
	if ($ref) {
?>

					<fieldset id="ref">
						<br />
						<p><?= $refMessage ?></p>
						<label>Is that right?</label>
						<label><input name="reference" type="radio" value="<?= $ref ?>" checked="checked">Yes!</label>
						<label><input name="reference" type="radio" value="(none)">No, it's something else.</label>
					</fieldset>
<?php
	}
?>

					<fieldset id="message">
						<label>Your Message</label>
						<textarea name="message" required="required"></textarea>
					</fieldset>

					<fieldset id="human">
						<label>What's your favorite number of kitties? (anti-spam)</label>
						<input name="human" placeholder="Enter a number" required="required">
					</fieldset>
<?php
	if ($debug) {
?>
					<fieldset id="debug">
						<label>Debug?</label>
						<label><input name="debug" type="radio" value="">No</label>
						<label><input name="debug" type="radio" value="true" checked="checked">Yes</label>
					</fieldset>
<?php
	}
?>
					<input id="submit" name="submit" type="submit" value="Submit">
				</form>
			</section>
<?php
}
?>
		</div>

		<footer class="back"><a target="_self" href="../"><i class="fa fa-home fa-fw"></i>Back to Home</a></footer>


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
