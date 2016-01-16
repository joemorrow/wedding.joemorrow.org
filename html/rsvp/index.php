<!DOCTYPE html>
<!--[if lt IE 7]>	<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>		<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>		<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title>RSVP : Claire &amp; Joe</title>
		<meta name="description" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<base target="_blank">

		<link href="http://fonts.googleapis.com/css?family=EB+Garamond|Josefin+Sans" rel="stylesheet" type="text/css">
		<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

		<link rel="stylesheet" href="../css/normalize.min.css">
		<link rel="stylesheet" href="../css/main.css">

		<script src="../js/vendor/modernizr-2.6.2.min.js"></script>
	</head>
	<body class="content right rsvp">
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<div class="page" id="top">
			<header>
				<h1>RSVP</h1>
			</header>

<?php
// For debugging, set this to true
$debug = false;
$debug = ($debug || isset($_REQUEST["debug"])) ? trim($_REQUEST["debug"]) : false;

// Show the form at the bottom of the page selectively based on the user's input
$showForm = true;

// We'll use this later to track referers on the first-time visit to the page (ie. not a form submission)
$theReferer = "";

// First, see if we're receiving a submission
if (isset($_POST["submit"])) {

	// If so, gather the input
	$name = trim($_POST["name"]);
	$attendance = trim($_POST["attendance"]);
	$count = trim($_POST["count"]);
	$song = trim($_POST["song"]);
	$email = trim($_POST["email"]);
	$comments = trim($_POST["comments"]);
	$referer = trim($_POST["referer"]);

	// Then, build the Email message
	$attend = ($attendance == "accept");

	$to = "wedding-form@joemorrow.org";
	$from = "From: " . $to;
	$subject = "A ";
	$subject .= ($attend) ? " Yes " : " No ";
	$subject .= "RSVP from " . $name . " via wedding.joemorrow.org/rsvp";

	$body = "Here's a new message from http://wedding.joemorrow.org/rsvp\n\nFrom: $name <$email>\n";
	$body .= "Referer = \"" . $referer . "\"\n\n";
	$body .= ($attend) ? "Will attend\nThere will be $count guest(s) in total\n\nSong Recommendations:  $song\n\n" : "Will not attend\n\n";
	$body .= "Comments:\n$comments\n\n(EOM)\n";

	// If we're debugging, output the variables
	if ($debug) {
		echo "<p><pre>";
		print_r($_POST);
		echo "\n\nFirst Name:\n$firstName\n";
		echo "\n\nReference:\n$ref\n";
		echo "\n\nMessage:\n$body\n";
		echo "</pre></p>";
	}

//	if (imap_mail($to, $subject, $body, $from)) {
	if (!function_exists("imap_mail") || imap_mail($to, $subject, $body, $from)) {

		// Don't show the form if the send was successful
		$showForm = false;

		if ($attend) {
?>
			<section class="success">
				<h2>Thanks for your reply, we are looking forward to celebrating with you!</h2>
				<p>If you haven't already done so, please make your <a href="../accommodations/">hotel and travel</a> plans soon; <strong>our hotel blocks will be released on August 27</strong>.</p>
				<p>Although it's not required, please <a target="_self" href="../contact/?ref=shuttle">let us know</a> if you're interested in taking our hotel shuttle to the ceremony, so we can size our reservations accordingly.</p>
				<p>Please <a href="../contact/">contact us</a> if you have any questions!</p>

			</section>

<?php
		} else {
?>				

			<section class="success">
				<p>Thanks for your reply, we're sorry to hear you won't be joining us.</p>
			</section>
<?php
		}
	} else {
		// The Email didn't send correctly, do show the form again.
		$showForm = true;

?>
			<section class="error">
				<p>Something went wrong, please try again.</p>
				<p>You can also just send us an <a href="mailto:wedding-errors@joemorrow.org">Email</a> and we'll get back to you right away.  Sorry.  That's about how fancy this site is.</p>
			</section>

<?php
	}

// Otherwise, this is the first time through the page, so inject the HTTP referer
// If somebody came here by typing in the URL, this will be blank.
} else
	$theReferer = $_SERVER["HTTP_REFERER"];

if ($showForm) {
?>
			<section>
				<p>Please respond by Friday, September 12.</p>

				<form method="post" action="index.php" target="_self">

					<fieldset id="name">
						<label class="hidden">Your Names</label>
						<input name="name" type="text" required="required" placeholder="Your Names" autofocus>
					</fieldset>

					<fieldset id="attendance">
						<label class="hidden">Attendance</label>
						<label><input name="attendance" type="radio" value="accept" required="required">Will celebrate in person!</label>
						<label><input name="attendance" type="radio" value="decline" required="required">Will celebrate in spirit.</label>
					</fieldset>

					<fieldset id="count" class="hidden accept">
						<label>There will be <input name="count" type="number" min="1" required="required" placeholder="#"> of us attending.</label>
					</fieldset>

					<fieldset id="song" class="hidden accept">
						<label>Please recommend a good song or two for dancing</label>
						<input name="song" type="text">
					</fieldset>

					<fieldset id="email" class="hidden accept">
						<label>Please share your Email address if you'd like to receive schedule information and updates</label>
						<input name="email" type="email" placeholder="          @">
					</fieldset>

					<fieldset id="comments">
						<label>Comments</label>
						<input name="comments" type="text">
					</fieldset>

<?php
	if ($debug) {
?>
					<fieldset id="debug">
						<label>Debug?</label>
						<input name="debug" type="radio" value="">No
						<input name="debug" type="radio" value="true" checked="checked">Yes
					</fieldset>
<?php
	}
?>

					<input id="referer" name="referer" type="hidden" value="<?= $theReferer ?>">
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
