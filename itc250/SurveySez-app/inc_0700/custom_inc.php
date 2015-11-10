<?php
/**
 * custom_inc.php stores custom functions specific to your application
 * 
 * Keeping common_inc.php clear of your functions allows you to upgrade without conflict
 * 
 * @package nmCommon
 * @author Blake Schwartz
 * @version 2.09x 2015
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @todo add safeEmail to common_inc.php
 */
 
/**
 * Place your custom functions below so you can upgrade common_inc.php without trashing 
 * your custom functions.
 *
 * An example function is commented out below as a documentation example  
 *
 * View common_inc.php for many more examples of documentation and starting 
 * points for building your own functions!
 */ 

/**
 * Checks data for alphanumeric characters using PHP regular expression.  
 *
 * Returns true if matches pattern.  Returns false if it doesn't.   
 * It's advised not to trust any user data that fails this test.
 *
 * @param string $str data as entered by user
 * @return boolean returns true if matches pattern.
 * @todo none
 */

/* 
function onlyAlphaEXAMPLE($myString)
{
  if(preg_match("/[^a-zA-Z]/",$myString))
  {return false;}else{return true;} //opposite logic from email?  
}#end onlyAlpha() 
*/ 

/*
$today = date("Y-m-d H:i:s");

$to = 'bill@grn.im';
$subject = 'Test Email, No ReplyTo: ' . $today;
$message = '
	Test Message Here.  Below should be a carriage return or two: ' . PHP_EOL . PHP_EOL .
	'Here is some more text.  Hopefully BELOW the carriage return!
';
*/
function safeEmail($to, $subject, $message, $replyTo='')
{#builds and sends a safe email, using Reply-To properly!
	$fromDomain = $_SERVER["SERVER_NAME"];
	$fromAddress = "noreply@" . $fromDomain; //form always submits from domain where form resides

	if($replyTo==''){$replyTo='';}

	$headers = 'From: ' . $fromAddress . PHP_EOL .
		'Content-Type: text/html; charset=ISO-8859-1 ' . PHP_EOL .
		'Reply-To: ' . $replyTo . PHP_EOL .
		'X-Mailer: PHP/' . phpversion();
	return mail($to, $subject, $message, $headers);
}
