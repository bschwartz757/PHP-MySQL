<?php
/**
 * survey3.php a test page for the SurveySez app
 
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


if($mySurvey->isValid)
{
    echo 'The survey title is: ' . $mySurvey->Title . '<br/>';
    echo 'The survey description is: ' . $mySurvey->Title . '<br/>';  
    
    dumpDie($mySurvey);
    
}else{
    echo 'Sorry, no such survey';
}

//echo $mySurvey->Title;

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
* @see Question
* @todo none
*/

class Survey {

    public $SurveyID = 0;
    public $Title = '';
    public $Description = '';
    public $isValid = false;
    public $aQuestions = array();
      
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
        
        if($id < 1)
        {
               return false;
        } // Don't hit the db if zero
        
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
        
            $sql = "select q.QuestionID, q.Question, q.Description from sp15_questions q inner join sp15_surveys s on s.SurveyID = q.SurveyID where s.SurveyID = $id";        
        
            $result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
            if(mysqli_num_rows($result) > 0)
            {#there are records - present data
                while($row = mysqli_fetch_assoc($result))
                {# pull data from associative array
                    $this->aQuestions[] = new Question(dbOut($row['QuestionID']),dbOut($row['Question']),dbOut($row['Description']));
                    
                    
                /*  $this->Title = dbOut($row['Title']);
                    $this->Description = dbOut($row['Description']);
                    $this->SurveyID = $id;
                    $this->isValid = true;  */

	           }# Endwhile
            }# Endif
        
@mysqli_free_result($result);        
             
        }# End constructor

}# End survey class


/**
* Question class, holds question data

This class is loaded when a survey is created
*
* More stuff about the class
*
*<code>
$mySurvey = new survey(1);
*</code>
*
* @see Survey
* @todo none
*/

class Question 
{
    public $QuestionID = 0;
    public $Text = '';
    public $Description = '';
    
    public function __construct($QuestionID,$Text,$Description)
    {
        $this->QuestionID = $QuestionID;
        $this->Text = $Text;
        $this->Description = $Description;

    }# end Constructor
    
    
}# End Question class


