<?php include 'include/config.php'; ?>
<?php include 'include/header.php'; ?>
		  <h1>Contact Us!</h1>
	  <p>Your information is very important to us!</p>

<?php
if(isset($_POST['Name']))
{

	//echo $_POST['Name'];
/*
	echo '<pre>';
	var_dump($_POST);
	echo '<pre>';
*/

					$to      = 'blakehschwartz@gmail.com';
					$replyto = $_POST['Email'];
					$subject = 'Test Email from ' . $_POST['Email'];
					$today = date("F j, Y, g:i a");
					$message = $_POST['Comments'];
					$headers = 'From: noreply@blakehschwartz.com' . PHP_EOL .
								'Reply-To: ' . $replyto . PHP_EOL .
								'X-Mailer: PHP/' . phpversion();

					mail($to, $subject, $message, $headers);

					echo "Thank you for your message!";

}else{

	echo
	'
	<form action="' . THIS_PAGE . '" method="post">
		<p>
			<label for ="Name">Name:</label>
			<input type="text" id="Name" name="Name" required="required" title="We need your name" /><br>
		</p>
		<p>
			<label for ="Email">Email:</label>
			<input type="text" id="Email" name="Email" required="required" title="We need your email" /><br>
		</p>
		<p>
			<label for ="Comments">Comments:</label>
			<textarea type="text" id="comments" name="comments" required="required" title="We need your comments" placeholder="comments"></textarea>
		</p>
		<input type="submit" value="Click to submit" />
	</form>
	';


}
?>

<?php include 'include/footer.php'; ?>
