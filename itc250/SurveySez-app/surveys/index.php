<?php
/**
 * 
 * @package nmCommon
 * @author Blake Schwartz
 * @version 2.09x 2015
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see demo_view_pager.php
 * @see Pager.php 
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 
 
# SQL statement
$sql = 
"
select CONCAT(a.FirstName, ' ', a.LastName) AdminName, s.SurveyID, s.Title, s.Description, 
date_format(s.DateAdded, '%W %D %M %Y %H:%i') 'DateAdded' from "
. PREFIX . "surveys s, " . PREFIX . "Admin a where s.AdminID=a.AdminID order by s.DateAdded desc
";

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php  
$config->titleTag = 'Surveys made with love & PHP in Seattle';

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>
<h3 align="center"><?=smartTitle();?></h3>

<?php
#reference images for pager
$prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
$next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';

# Create instance of new 'pager' class
$myPager = new Pager(10,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset

# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

if(mysqli_num_rows($result) > 0)
{#records exist - process
	if($myPager->showTotal()==1){$itemz = "survey";}else{$itemz = "surveys";}  //deal with plural
    echo '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';
    
	while($row = mysqli_fetch_assoc($result))
	{# process each row

  
    
         		echo '<table align="center" border="1" style="border-collapse:collapse" cellpadding="3" cellspacing="3">';
		echo '<tr>
                <th>SurveyID</th>
                <th>DateAdded</th>
                <th>Title</th>
                <th>Description</th>
                <th>AdminName</th>
			</tr>
			<tr>
					<td>
                   <a href="' . VIRTUAL_PATH . 'surveys/survey_view.php?id=' . (int)$row['SurveyID'] . '">' . dbOut($row['SurveyID']) . '</a>
 
                    </td>
				    <td>' . dbOut($row['DateAdded']) . '</td>
				    <td>' . dbOut($row['Title']) . '</td>
				    <td>' . dbOut($row['Description']) . '</td>
				    <td>' . dbOut($row['AdminName']) . '</td>                   
				</tr>
				';
      

   				     //. (int)$row['SurveyID'] . 
    
    
    }
    

		echo '</table>';    
    

    
    
    
	echo $myPager->showNAV(); # show paging nav, only if enough records	 
}else{#no records
    echo "<div align=center>I'm sorry, there are currently no surveys.</div>";	
}
@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php
?>
