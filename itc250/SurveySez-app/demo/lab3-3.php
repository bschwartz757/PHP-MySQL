<?php
/**
 * demo_postback_nohtml.php is a single page web application that allows us to request and view 
 * a customer's name
 *
 * This version uses no HTML directly so we can code collapse more efficiently
 *
 * This page is a model on which to demonstrate fundamentals of single page, postback 
 * web applications.
 *
 * Any number of additional steps or processes can be added by adding keywords to the switch 
 * statement and identifying a hidden form field in the previous step's form:
 *
 *<code>
 * <input type="hidden" name="act" value="next" />
 *</code>
 * 
 * The above live of code shows the parameter "act" being loaded with the value "next" which would be the 
 * unique identifier for the next step of a multi-step process
 *
 * @package nmCommon
 * @author Blake Schwartz
 * @version 2.09x 2015
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @todo finish instruction sheet
 * @todo add more complicated checkbox & radio button examples
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 
/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

//END CONFIG AREA ----------------------------------------------------------

# Read the value of 'action' whether it is passed via $_POST or $_GET with $_REQUEST
if(isset($_REQUEST['act'])){$myAction = (trim($_REQUEST['act']));}else{$myAction = "";}

switch ($myAction) 
{//check 'act' for type of process
	case "display": # 2)Display user's name!
	 	showName();
	 	break;
    case "delete": # 3)Delete the ducks!
	 	deleteDucks();
        showForm();
	 	break;
	default: # 1)Ask user to enter their name 
	 	showForm();
}

function deleteDucks()
{
    //echo "delete the ducks!"; 
    startSession();
    unset($_SESSION['ducks']);
    feedback('Ducks deleted!');
}

function showForm()
{# shows form so user can enter their name.  Initial scenario
	get_header(); #defaults to header_inc.php	
	
	echo 
	'<script type="text/javascript" src="' . VIRTUAL_PATH . 'include/util.js"></script>
	<script type="text/javascript">
		function checkForm(thisForm)
		{//check form data for valid info
			//if(empty(thisForm.YourName,"Please Enter Your Name")){return false;}
			return true;//if all is passed, submit!
		}
	</script>
	<h3 align="center">' . smartTitle() . '</h3>
    <h2 align="center">What if ducks could play football?!</h2>
	<p align="center">Please enter your fantasy duck\'s name and info:</p> 
	<form action="' . THIS_PAGE . '" method="post" onsubmit="return checkForm(this);">
		<table align="center">
			<tr>
				<td align="right">
					Name
				</td>
				<td>
					<input type="text" name="Name" required="required" /><font color="red"><b>*</b></font> <em>(alphabetic only)</em>
				</td>
			</tr>
            
            <tr>
				<td align="right">
					Team
				</td>
				<td>
					<input type="text" name="Team" required="required" /><font color="red"><b>*</b></font> <em>(alphabetic only)</em>
				</td>
			</tr>
            
            <tr>
				<td align="right">
					Games Played
				</td>
				<td>
					<input type="text" name="Games" required="required" /><font color="red"><b>*</b></font> <em>(numeric only)</em>
				</td>
			</tr>

            <tr>
				<td align="right">
					Total Touchdowns
				</td>
				<td>
					<input type="text" name="Touchdowns" required="required" /><font color="red"><b>*</b></font> <em>(numeric only)</em>
				</td>
			</tr>
            
			<tr>
				<td align="center" colspan="2">
					<input type="submit" value="Submit Info"><em>(<font color="red"><b>*</b> required field</font>)</em>
				</td>
			</tr>
		</table>
		<input type="hidden" name="act" value="display" />
	</form>
	';
	get_footer(); #defaults to footer_inc.php
}

function showName()
{#form submits here we show entered name
    
    //dumpDie($_POST);
    
	get_header(); #defaults to footer_inc.php
    
    startSession();//starts sessions cleanly - inside common_inc.php
    
    //if no session exists, create session
    //is session exists, add duck
    
    
    
    
    
    if(!isset($_SESSION['ducks']))
    { //if no session exists, create session
        $_SESSION['ducks'] = array();
    }
    
    
    
    
    //if session exists, add duck
    $_SESSION['ducks'][] = new Duck($_POST['Name'], $_POST['Team'], $_POST['Games'],  $_POST['Touchdowns']);

    //Use a counter to display the number of ducks in the session:
/*    $counter = 0;
    while(isset($_SESSION['ducks']))
    {   This creates some kind of infinite loop. Does not work. */
    
    $counter = 0;
    foreach($_SESSION['ducks'] as $myDuck)
        {
    echo $myDuck . 'Average TDs per game: ' . round($myDuck->Touchdowns/$myDuck->Games, 2) . '<br><br>';
        $counter++;
        }
    
/*        $counter++;        
    echo '<p align="center">Total number of ducks: ' . $counter . '</p>';    
    }*/
    echo '<p align="center">Total number of ducks: ' . $counter . '</p>';    
    
    echo '<p align="center"><a href="' . THIS_PAGE . '">Enter another duck</a></p>';
    
    echo '<p align="center"><a href="' . THIS_PAGE . '?act=delete">Delete the ducks</a></p>';    
    
    
    
    /*
	if(!isset($_POST['YourName']) || $_POST['YourName'] == '')
	{//data must be sent	
		feedback("No form data submitted"); #will feedback to submitting page via session variable
		myRedirect(THIS_PAGE);
	}  
	
	if(!ctype_alnum($_POST['YourName']))
	{//data must be alphanumeric only	
		feedback("Only letters and numbers are allowed.  Please re-enter your name."); #will feedback to submitting page via session variable
		myRedirect(THIS_PAGE);
	}
	
	$myName = strip_tags($_POST['YourName']);# here's where we can strip out unwanted data
	
	echo '<h3 align="center">' . smartTitle() . '</h3>';
	echo '<p align="center">Your name is <b>' . $myName . '</b>!</p>';
	echo '<p align="center"><a href="' . THIS_PAGE . '">RESET</a></p>';
	*/
    get_footer(); #defaults to footer_inc.php
}

class Duck{
    public $Name = '';
    public $Team = '';    
    public $Games = 0;
    public $Touchdowns = 0;    
    
    function __construct($Name,$Team,$Games,$Touchdowns)
    {
        $this->Name = $Name;
        $this->Team = $Team;
        $this->Games = $Games;
        $this->Touchdowns = $Touchdowns;    
    } #end constructor
    
    function __toString()
    {
        $myReturn = '';
        $myReturn .= 'Name: ' . $this->Name . ' | ';
        $myReturn .= 'Team: ' . $this->Team . ' | ';
        $myReturn .= 'Games: ' . $this->Games . ' | ';
        $myReturn .= 'Touchdowns: ' . $this->Touchdowns . ' | ';        
        
        return $myReturn;
    
    } #toString
    
} #end Duck()
