<?php
/**
 * beers_view.php along with beers_list.php provides a sample web application
 *
 * this app is contingent upon the  installation and proper
 * configuration of the nmMini package (config-mini.php) or equivalent
 *
 */

require 'include/config.php'; #provides configuration, pathing, error handling, db credentials

# check variable of item passed in - if invalid data, forcibly redirect back to beers_list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{#send the user to a safe location!
	header("Location:beers_list.php");
}

//sql statement to select individual item
$sql = "select Beer,Category,Style,Brewer,Appearance,Description,AlcoholContent,Calories from Beers where BeerID = " . $myID;
//---end config area --------------------------------------------------

$foundRecord = FALSE; # Will change to true, if record found!

# connection comes first in mysqli (improved) function
$iConn = @mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die(myerror(__FILE__,__LINE__,mysqli_connect_error()));
$result = mysqli_query($iConn,$sql) or die(myerror(__FILE__,__LINE__,mysqli_error($iConn)));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	   $foundRecord = TRUE;
	   while ($row = mysqli_fetch_assoc($result))
	   {
			$Beer = dbOut($row['Beer']);
			$Category = dbOut($row['Category']);
			$Style = dbOut($row['Style']);
			$Brewer = dbOut($row['Brewer']);
			$Appearance = dbOut($row['Appearance']);
			$Description = dbOut($row['Description']);
			$AlcoholContent = (float)$row['AlcoholContent'];
			$Calories = dbOut($row['Calories']);
	   }
}

@mysqli_free_result($result); # We're done with the data!

if($foundRecord)
{#only load data if record found
	$title = $Beer . "A Selection of Top-Rated Beers"; #overwrite title with info!
}
# END CONFIG AREA ----------------------------------------------------------

include 'include/header.php'; #header must appear before any HTML is printed by PHP
?>
<h3 align="center"><?=THIS_PAGE;?></h3>

<p>This page, along with <b>beers_list.php</b>, demonstrates a List/View web application.</p>
<p><b>beers_list_pager.php</b>provides the paging (previous-next arrows) functionality.</p>
<p>This page is to be used only with <b>beers_list.php</b> or <b>beers_list_pager.php</b>, and is <b>NOT</b> the entry point of the application.</p>

<?php
if($foundRecord)
{#records exist - show beer!
?>
	<h3 align="center">An ice-cold <?=$Beer;?> Beer!</h3>
	<div align="center"><a href="beers_list.php">Want to Browse More Beers?</a></div>
	<table align="center">
		<tr>
			<td><img src="upload/b<?=$myID;?>.jpg" /></td>
			<td><?=$Beer;?> Image courtesy of Google</td>
		</tr>
		<tr>
			<td colspan="2">
				<blockquote><?=$Description;?></blockquote>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<h3><i>Beer Name:</i> <font color="red"><?=($Beer);?></font></h3>
				<h3><i>Category:</i> <font color="red"><?=($Category);?></font></h3>
				<h3><i>Style:</i> <font color="red"><?=($Style);?></font></h3>
				<h3><i>Brewery:</i> <font color="red"><?=($Brewer);?></font></h3>
				<h3><i>Appearance:</i> <font color="red"><?=($Appearance);?></font></h3>
				<h3><i>Description:</i> <font color="red"><?=($Description);?></font></h3>
				<h3><i>Alcohol Content:</i> <font color="red"><?=number_format($AlcoholContent,2);?></font></h3>
				<h3><i>Calories:</i> <font color="red"><?=($Calories);?></font></h3>
			</td>
		</tr>
	</table>
<?php
}else{//no such beer!
    echo '<div align="center">What! No such beer? There must be a mistake!!</div>';
    echo '<div align="center"><a href="beers_list.php">Another beer?</a></div>';
}

include 'include/footer.php'; #header must appear before any HTML is printed by PHP
?>
