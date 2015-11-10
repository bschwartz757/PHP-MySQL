<?php
/**
 * beers_list_pager.php along with beers_view_pager.php provides a sample web application
 *
 * The difference between demo_list.php and demo_list_pager.php is the reference to the
 * Pager class which processes a mysqli SQL statement and spans records across multiple
 * pages.
 *
 * The associated view page, demo_view_pager.php is virtually identical to demo_view.php.
 * The only difference is the pager version links to the list pager version to create a
 * separate application from the original list/view.
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

<p>This page demonstrates a List/View web application.</p>
<p>This page is the entry point of the application.</p>
<?php
#reference images for pager
$prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
$next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

#Create a connection
# connection comes first in mysqli (improved) function
$iConn = @mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME) or die(myerror(__FILE__,__LINE__,mysqli_connect_error()));


# Create instance of new 'pager' class
$myPager = new Pager(5,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql,$iConn);  #load SQL, pass in existing connection, add offset
$result = mysqli_query($iConn,$sql) or die(myerror(__FILE__,__LINE__,mysqli_error($iConn)));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	if($myPager->showTotal()==1){$itemz = "beer";}else{$itemz = "beers";}  //deal with plural
    echo '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';
	while($row = mysqli_fetch_assoc($result))
	{# process each row
         echo '<div align="center"><a href="' . VIRTUAL_PATH . 'beers_view.php?id=' . (int)$row['BeerID'] . '">' . dbOut($row['Beer']) . '</a>';
         echo ' <i>Alcohol Content:</i> <font color="red">$' . number_format((float)$row['AlcoholContent'],2)  . '%</font></div>';
	}
	echo $myPager->showNAV(); # show paging nav, only if enough records
}else{#no records
    echo "<div align=center>What! No beers?  There must be a mistake!!</div>";
}
@mysqli_free_result($result);

include 'include/footer.php';
?>
