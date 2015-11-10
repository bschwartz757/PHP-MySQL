<?php
/**
 * beers_list.php along with beers_view.php provides a sample web application
 *
 * this app is contingent upon the  installation and proper
 * configuration of the nmMini package (config-mini.php) or equivalent
 *
 */

require 'include/config.php'; #provides configuration, pathing, error handling, db credentials

# SQL statement
$sql = "select BeerID, Beer, AlcoholContent from Beers";

#Fills <title> tag
$title = 'A Selection of Top-Rated Beers';

# END CONFIG AREA ----------------------------------------------------------

include 'include/header.php'; #header must appear before any HTML is printed by PHP
?>
<h3 align="center"><?=THIS_PAGE;?></h3>

<p>This page, along with <b>beers_view.php</b>, demonstrate a List/View web application.</p>

<?php

# connection comes first in mysqli (improved) function

$iConn = @mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die(myerror(__FILE__,__LINE__,mysqli_connect_error()));
$result = mysqli_query($iConn,$sql) or die(myerror(__FILE__,__LINE__,mysqli_error($iConn)));
if(mysqli_num_rows($result) > 0)
{#records exist - process
	while($row = mysqli_fetch_assoc($result))
	{# process each row
         echo '<div align="center"><b><a href="beers_view.php?id=' . (int)$row['BeerID'] . '">' . dbOut($row['Beer']) . '</b></a>';
         echo ' <i>Alcohol By Volume:</i> <font color="red">' . number_format((float)$row['AlcoholContent'],2)  . '%</font></div>';

	}
}else{#no records
    echo "<div align=center>What! No beers?  There must be a mistake!!</div>";
}
@mysqli_free_result($result);

include 'include/footer.php';
?>
