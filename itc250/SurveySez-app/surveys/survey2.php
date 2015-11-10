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

//END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to header_inc.php
?>
<h3 align="center"><?php echo $config->titleTag; ?></h3>
<?php


$mySurvey = new survey(1);

echo $mySurvey->Title;

get_footer(); #defaults to footer_inc.php

/**
* Survey class, holds survey data
*
* More stuff about the class
*
*<code>
*code sample goes here;
*</code>
*
* @see RelatedClass
* @todo none
*/

class survey {

    public $SurveyID = 0;
    public $Title = '';
    public $Description = '';
    public $isValid = false;
      
    /**
    * Constructor for survey class
    *
    * Loads data from survey table
    *
    * @param in $id number of current survey
    * @return void
    * @todo none
    */
    public function __construct($id)
        {
            $id = (int)$id; #cast to integer
            $sql = "select Title, Description from sp15_surveys where SurveyID=$id"; 
            $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
            if(mysqli_num_rows($result) > 0)
            {#there are records - present data
                while($row = mysqli_fetch_assoc($result))
                {# pull data from associative array
        
                    $this->Title = dbOut($row['Title']);
                    $this->Description = dbOut($row['Description']);
                    $this->SurveyID = $id;
                    $this->isValid = true;

	           }# Endwhile
            }# Endif
        
@mysqli_free_result($result);
        
        
        }# End constructor

}# End survey class



