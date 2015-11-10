<?php
/*
* config.php - a file to store data and
* configuration info
*/

include 'credentials.php';
include 'common.php';

define('DEBUG',TRUE); #we want to see all errors

date_default_timezone_set('America/Los_Angeles'); #sets default date/timezone for this website

/* automatic path settings - use the following 4 path settings for placing all code in one application folder */
define('VIRTUAL_PATH', 'http://blakehschwartz.com/itc240/sandbox/grey/'); # Virtual (web) 'root' of application for images, JS & CSS files
define('PHYSICAL_PATH', '/home/blasch13/blakehschwartz.com/itc240/sandbox/grey/'); # Physical (PHP) 'root' of application for file & upload reference
define('INCLUDE_PATH', PHYSICAL_PATH . 'include/'); # Path to PHP include files - INSIDE APPLICATION ROOT

# End Config area --------------------------------
ob_start();  #buffers our page to be prevent header errors. Call before INC files or ANY html!
header("Cache-Control: no-cache");header("Expires: -1");#Helps stop browser & proxy caching


define('THIS_PAGE' ,basename($_SERVER['PHP_SELF']));

$nav1["index.php"] = "Home Page";
$nav1["links.php"] = "Links";
$nav1["order.php"] = "Order a Website";
$nav1["about.php"] = "About Us";
$nav1["contact.php"] = "Contact Us";
$nav1["beers_list_pager.php"] = "Beers";



//echo THIS_PAGE;

switch (THIS_PAGE) {

	case 'order.php':
		# code...
		$title = "My Title";
		$banner = "My Banner";
		$slogan = "My Slogan";
	break;

	case 'links.php':
		# code...
		$title = "My Links Page";
		$banner = "My Links Banner";
		$slogan = "My Links Slogan";
	break;

	default:
		$title = THIS_PAGE;
		$banner = "My Links Banner";
		$slogan = "My Links Slogan";
}

function makeLinks($linkArray)
{
    $myReturn = '';
    foreach($linkArray as $url => $text)
    {//current page, add class
    	if (THIS_PAGE == $url) {
    		# code...

        $myReturn .= '<li class="current"><a href="' . $url . '">' . $text . '</a></li>';

    	}else{

        $myReturn .= '<li><a href="' . $url . '">' . $text . '</a></li>';

    	}

    }
    return $myReturn;
}

//used for order.php to build a better email
function process_post()
{//loop through POST vars and return a single string
				$myReturn = ''; //set to initial empty value

				foreach($_POST as $varName=> $value)
				{#loop POST vars to create JS array on the current page - include email
									$strippedVarName = str_replace("_"," ",$varName);#remove underscores
								if(is_array($_POST[$varName]))
									{#checkboxes are arrays, and we need to collapse the array to comma separated string!
													$myReturn .= $strippedVarName . ": " . implode(",",$_POST[$varName]) . PHP_EOL;
									}else{//not an array, create line
													$myReturn .= $strippedVarName . ": " . $value . PHP_EOL;
									}
				}
				return $myReturn;
}

function myerror($myFile, $myLine, $errorMsg)
{
				if(defined('DEBUG') && DEBUG)
				{
							echo "Error in file: <b>" . $myFile . "</b> on line: <b>" . $myLine . "</b><br />";
							echo "Error Message: <b>" . $errorMsg . "</b><br />";
							die();
				}else{
		echo "I'm sorry, we have encountered an error.  Would you like to buy some socks?";
		die();
				}
}

/**
 * Wrapper function for processing data pulled from db
 *
 * Forward slashes are added to MySQL data upon entry to prevent SQL errors.
 * Using our dbOut() function allows us to encapsulate the most common functions for removing
 * slashes with the PHP stripslashes() function, plus the trim() function to remove spaces.
 *
 * Later, we can add to this function sitewide, as new requirements or vulnerabilities develop.
 *
 * @param string $str data as pulled from MySQL
 * @return $str data cleaned of slashes, spaces around string, etc.
 * @see dbIn()
 * @todo none
 */
function dbOut($str)
{
	if($str!=""){$str = stripslashes(trim($str));}//strip out slashes entered for SQL safety
	return $str;
} #End dbOut()
