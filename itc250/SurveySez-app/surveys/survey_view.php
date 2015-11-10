<?php
/**
 * survey_view.php is a page to demonstrate the proof of concept of the 
 * initial SurveySez objects.
 *
 * Objects in this version are the Survey, Question & Answer objects
 * 
 * @package nmCommon
 * @author Blake Schwartz
 * @version 2.09x 2015
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see Question.php
 * @see Answer.php
 * @see Response.php
 * @see Choice.php
 */
 
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
spl_autoload_register('MyAutoLoader::NamespaceLoader');//required to load SurveySez namespace objects
$config->metaRobots = 'no index, no follow';#never index survey pages

# check variable of item passed in - if invalid data, forcibly redirect back to demo_list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "surveys/index.php");
}

$myResult = new SurveySez\Result($myID);
if($myResult->isValid)
{
	$PageTitle = "'Result to " . $myResult->Title . "' Survey!";
}else{
	$mySurvey = new SurveySez\MY_Survey($myID); //MY_Survey extends survey class so methods can be added
if($mySurvey->isValid)
{
	$config->titleTag = "'" . $mySurvey->Title . "' Survey!";
}else{
	$config->titleTag = smartTitle(); //use constant 
    }
}



#END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>
<h3><?=$config->titleTag?></h3>

<?php

if($myResult->isValid)
{# check to see if we have a valid SurveyID
	echo "Survey Title: <b>" . $myResult->Title . "</b><br />";  //show data on page
	echo "Survey Description: " . $myResult->Description . "<br />";
	$myResult->showGraph() . "<br />";	//showTallies method shows all questions, answers and tally totals!
    echo SurveySez\MY_Survey::responseList($myID);    
	unset($myResult);  //destroy object & release resources
}else{
	if($mySurvey->isValid)
{ #check to see if we have a valid SurveyID
	echo '<p class="text-muted">' . $mySurvey->Description . '</p>';
	echo $mySurvey->showQuestions();

}else{
	echo "Sorry, no such survey!";	
    }	
}




get_footer(); #defaults to theme footer or footer_inc.php

/*
function responseList($myID)
{
   return $myID; 
}
*/









