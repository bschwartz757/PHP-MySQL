<?php
/**
 * demo_mysqli.php is both a test page for your mysql (classic) connection, and a starting point for 
 * building DB applications using mysql classic connections
 *
 * @package nmCommon
 * @author Blake Schwartz
 * @version 2.09x 2015
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see config_inc.php  
 * @see header_inc.php
 * @see footer_inc.php 
 * @todo none
 */

 # '../' works for a sub-folder.  use './' for the root
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription;  
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

# SQL statement - PREFIX is optional way to distinguish your app
$sql = "select FirstName, LastName, Email from test_Customers";

//END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to header_inc.php
?>
<h3 align="center"><?php echo $config->titleTag ?></h3>
<p>This page is both a test page for your mysql classic connection, and a starting point for
building DB applications using mysql connections</p>
<p>creates a simple mysql connection via the function conn()</p>
<?php
$myConn = conn('',FALSE); # conn() creates mysql classic connection  

#$result stores data object in memory - $sql & conn are flipped in mysql_ classic connection
$result = mysql_query($sql,$myConn) or die(trigger_error(mysql_error($myConn), E_USER_ERROR));

echo '<div align="center"><h4>SQL STATEMENT: <font color="red">' . $sql . '</font></h4></div>';
if(mysql_num_rows($result) > 0)
{#there are records - present data
	while($row = mysql_fetch_assoc($result))
	{# pull data from associative array
	   echo '<p>';
	   echo 'FirstName: <b>' . $row['FirstName'] . '</b><br />';
	   echo 'LastName: <b>' . $row['LastName'] . '</b><br />';
	   echo 'Email: <b>' . $row['Email'] . '</b><br />';
	   echo '</p>';
	}
}else{#no records
	echo '<div align="center">Sorry, there are no records that match this query</div>';
}
@mysql_free_result($result);
get_footer(); #defaults to footer_inc.php
?>
