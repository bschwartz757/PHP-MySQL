<?php
/**
 * demo_add.php is a single page web application that allows us to add a new customer to 
 * an existing table
 *
 * This page is based on demo_edit.php
 *
 * Any number of additional steps or processes can be added by adding keywords to the switch 
 * statement and identifying a hidden form field in the previous step's form:
 *
 *<code>
 * <input type="hidden" name="act" value="next" />
 *</code>
 * 
 * The above code shows the parameter "act" being loaded with the value "next" which would be the 
 * unique identifier for the next step of a multi-step process
 *
 * @package nmCommon
 * @author Blake Schwartz
 * @version 2.09x 2015
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
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
	case "add": //2) Form for adding new customer data
	 	addForm();
	 	break;
	case "insert": //3) Insert new customer data
		insertExecute();
		break; 
	default: //1)Show existing favorites
	 	showFavorites();
}

function showFavorites()
{//Select Favorites
	global $config;
	get_header();
	echo '<h3 align="center">' . smartTitle() . '</h3>';

	//$sql = "select CustomerID,FirstName,LastName,Email from test_Customers";
    
    
    $sql="select `FavoriteID`, `LastName`, `FirstName`, `Email`, `Title`, `URL`, `Description`, `Category`, `DateAdded` from sp15_Favorites";
    
       
	$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
	if (mysqli_num_rows($result) > 0)//at least one record!
	{//show results
		echo '<table align="center" border="1" style="border-collapse:collapse" cellpadding="3" cellspacing="3">';
		echo '<tr>
                <th>FavoriteID</th>
                <th>LastName</th>
                <th>FirstName</th>
                <th>Email</th>
                <th>Title</th>
                <th>URL</th>
                <th>Description</th> 
                <th>Category</th>
                <th>DateAdded</th>
			</tr>
			';
		while ($row = mysqli_fetch_assoc($result))
		{//dbOut() function is a 'wrapper' designed to strip slashes, etc. of data leaving db
			echo '<tr>
					<td>'	
				     . (int)$row['FavoriteID'] . '</td>
				    <td>' . dbOut($row['LastName']) . '</td>
				    <td>' . dbOut($row['FirstName']) . '</td>
				    <td>' . dbOut($row['Email']) . '</td>
				    <td>' . dbOut($row['Title']) . '</td>
				    <td>' . dbOut($row['URL']) . '</td>
				    <td>' . dbOut($row['Description']) . '</td>
				    <td>' . dbOut($row['Category']) . '</td>
				    <td>' . dbOut($row['DateAdded']) . '</td>                    
				</tr>
				';
		}
		echo '</table>';
	}else{//no records
      echo '<div align="center"><h3>Currently No Favorites in Database.</h3></div>';
	}
	echo '<div align="center"><a href="' . THIS_PAGE . '?act=add">ADD FAVORITES</a></div>';
	@mysqli_free_result($result); //free resources
	get_footer();
}

function addForm()
{# shows details from a single customer, and preloads their first name in a form.
	global $config;
	$config->loadhead .= '
	<script type="text/javascript" src="' . VIRTUAL_PATH . 'include/util.js"></script>
	<script type="text/javascript">
		function checkForm(thisForm)
		{//check form data for valid info
			if(empty(thisForm.LastName,"Please Enter User\'s First Name")){return false;}
			if(empty(thisForm.FirstName,"Please Enter User\'s Last Name")){return false;}
			if(!isEmail(thisForm.Email,"Please Enter a Valid Email")){return false;}
            
			if(empty(thisForm.Title,"Please Enter Favorite\'s Title")){return false;}
            
            if(empty(thisForm.URL,"Please Enter Favorite\'s URL")){return false;}
            if(empty(thisForm.Description,"Please Enter Favorite\'s Description")){return false;}
			if(empty(thisForm.Category,"Please Enter Favorite\'s Category")){return false;}            
                  
			return true;//if all is passed, submit!
		}
	</script>';
	
	get_header();
	echo '<h3 align="center">' . smartTitle() . '</h3>
	<h4 align="center">Add Customer</h4>
	<form action="' . THIS_PAGE . '" method="post" onsubmit="return checkForm(this);">
	<table align="center">
	   <tr><td align="right">Last Name</td>
		   	<td>
		   		<input type="text" name="LastName" />
		   		<font color="red"><b>*</b></font> <em>(alphanumerics & punctuation)</em>
		   	</td>
	   </tr>
	   <tr>
       <td align="right">First Name</td>
		   	<td>
		   		<input type="text" name="FirstName" />
		   		<font color="red"><b>*</b></font> <em>(alphanumerics & punctuation)</em>
		   	</td>
	   </tr>
	   <tr>
       <td align="right">Email</td>
		   	<td>
		   		<input type="text" name="Email" />
		   		<font color="red"><b>*</b></font> <em>(valid email only)</em>
		   	</td>
	   </tr>    
	   <tr>
       <td align="right">Title</td>
		   	<td>
		   		<input type="text" name="Title" />
		   		<font color="red"><b>*</b></font> <em>(alphanumerics & punctuation)</em>
		   	</td>
	   </tr>
	   <tr>
       <td align="right">URL</td>
		   	<td>
		   		<input type="text" name="URL" />
		   		<font color="red"><b>*</b></font> <em>(valid URL only)</em>
		   	</td>
	   </tr>
	   <tr>
       <td align="right">Description</td>
		   	<td>
		   		<input type="text" name="Description" />
		   		<font color="red"><b>*</b></font> <em>(alphanumerics & punctuation)</em>
		   	</td>
	   </tr>
	   <tr>
       <td align="right">Category</td>
		   	<td>
		   		<input type="text" name="Category" />
		   		<font color="red"><b>*</b></font> <em>(valid numbers only)</em>
		   	</td>
	   </tr>
	   <input type="hidden" name="act" value="insert" />
	   <tr>
	   		<td align="center" colspan="2">
	   			<input type="submit" value="Add Favorite!"><em>(<font color="red"><b>*</b> required field</font>)</em>
	   		</td>
	   </tr>
	</table>    
	</form>
	<div align="center"><a href="' . THIS_PAGE . '">Exit Without Add</a></div>
	';
	get_footer();
	
}

function insertExecute()
{
	$iConn = IDB::conn();//must have DB as variable to pass to mysqli_real_escape() via iformReq()
	
	$redirect = THIS_PAGE; //global var used for following formReq redirection on failure

	$LastName = strip_tags(iformReq('LastName',$iConn));
	$FirstName = strip_tags(iformReq('FirstName',$iConn));
	$Email = strip_tags(iformReq('Email',$iConn));
	$Title = strip_tags(iformReq('Title',$iConn));
	$URL = strip_tags(iformReq('URL',$iConn));
	$Description = strip_tags(iformReq('Description',$iConn));
	$Category = strip_tags(iformReq('Category',$iConn));    
	
	//next check for specific issues with data
	if(!ctype_graph($_POST['LastName'])|| !ctype_graph($_POST['FirstName']))
	{//data must be alphanumeric or punctuation only	
		feedback("First and Last Name must contain letters, numbers or punctuation");
		myRedirect(THIS_PAGE);
	}	
	
	if(!onlyEmail($_POST['Email']))
	{//data must be alphanumeric or punctuation only	
		feedback("Data entered for email is not valid");
		myRedirect(THIS_PAGE);
	}

    //build string for SQL insert with replacement vars, %s for string, %d for digits 
    $sql = "INSERT INTO sp15_Favorites (LastName, FirstName, Email, Title, URL, Description, Category, DateAdded) VALUES ('%s','%s','%s','%s','%s','%s','%s','%d')"; 

    # sprintf() allows us to filter (parameterize) form data 
	$sql = sprintf($sql,$LastName,$FirstName,$Email,$Title,$URL,$Description,$Category,$DateAdded);

	@mysqli_query($iConn,$sql) or die(trigger_error(mysqli_error($iConn), E_USER_ERROR));
	#feedback success or failure of update
	if (mysqli_affected_rows($iConn) > 0)
	{//success!  provide feedback, chance to change another!
		feedback("Favorite Added Successfully!","notice");
	}else{//Problem!  Provide feedback!
		feedback("Favorite NOT added!");
	}
	myRedirect(THIS_PAGE);
}

