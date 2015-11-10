<?php
/**
 * survey1.php a test page for the SurveySez app
 
 Based on demo_shared.php which is a test page for your IDB connection
 
 * building DB applications using IDB connections
 *
 * @package SurveySez
 * @author Blake Schwartz <blakehschwartz@gmail.com>
 * @version 0.1 2015/05/12
 * @link http://blakehschwartz.com/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see survey_inc.php  
 * @todo none
 */
# '../' works for a sub-folder.  use './' for the root
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

$config->titleTag = smartTitle(); #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php
$config->metaDescription = smartTitle() . ' - ' . $config->metaDescription; 

# SQL statement - PREFIX is optional way to distinguish your app
$sql = "select Title, Description from sp15_surveys";

//END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to header_inc.php
?>
<h3 align="center"><?php echo $config->titleTag; ?></h3>
<?php
#IDB::conn() creates a shareable database connection via a singleton class
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

echo '<div align="center"><h4>SQL STATEMENT: <font color="red">' . $sql . '</font></h4></div>';
if(mysqli_num_rows($result) > 0)
{#there are records - present data
	while($row = mysqli_fetch_assoc($result))
	{# pull data from associative array
	   echo '<p>';
	   echo 'Title: <b>' . $row['Title'] . '</b><br />';
	   echo 'Description: <b>' . $row['Description'] . '</b><br />';
	   echo '</p>';
	}
}else{#no records
	echo '<div align="center">Sorry, there are no records that match this query</div>';
}
@mysqli_free_result($result);
get_footer(); #defaults to footer_inc.php
?>
