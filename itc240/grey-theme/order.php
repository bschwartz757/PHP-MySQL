<?php include 'include/config.php'; ?>
<?php include 'include/header.php'; ?>
		  <h1>Order a website here!</h1>
				<p>We love to make websites</p>
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
					$today = date("F j, Y, g:i a");
					$subject = 'Email from ' . $_POST['Name'] . ' ' . $today;

					$message = process_post();//loop through all form elements
					$headers = 'From: noreply@blakehschwartz.com' . PHP_EOL .
								'Reply-To: ' . $replyto . PHP_EOL .
								'X-Mailer: PHP/' . phpversion();

					mail($to, $subject, $message, $headers);

					echo "<p>Thank you for your message!</p>";
					echo '<p><a href="order.php">Order another website!</a></p>';

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
			<label for ="Type">Type of website:</label>
			<input type="radio" id="Type" name="Type_of_website" required="required" title="We need to know what type of site" placeholder="Choose the type of site" value="Custom" /> Custom<br>

			<input type="radio" name="Type_of_website" required="required" title="We need to know what type of site" placeholder="Choose the type of site" value="CMS" /> CMS<br>

			<input type="radio" name="Type_of_website" required="required" title="We need to know what type of site" placeholder="Choose the type of site" value="Framework" /> Framework<br>

		</p>

		<p>
			<label for ="Features">Features:</label>
			<input type="checkbox" id="Features" name="Website_features[]" value="SEO" /> Search Engine Visibility<br>

			<label for ="Features">Features:</label>
			<input type="checkbox" id="Features" name="Website_features[]" value="SMO" /> Social Media Integration<br>

			<label for ="Features">Features:</label>
			<input type="checkbox" id="Features" name="Website_features[]" value="Shopping Cart" /> Shopping Cart<br>

			<label for ="Features">Features:</label>
			<input type="checkbox" id="Features" name="Website_features[]" value="Website Search" /> Website Search<br>


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
