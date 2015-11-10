<?php
/**
 * index.php is an ADMIN ONLY page for redirects! 
 *
 * DO NOT place this folder in the root of your application space!
 *
 * DO place this in the ADMIN folder! (whatever you name it!!)
 *
 * @package nmCommon
 * @author Blake Schwartz
 * @version 2.09x 2015
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see config_inc.php 
 * @todo none
 */
 
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials

$redirect_to_login = TRUE; #if true, will redirect to admin login page, else redirect to main site index

# END CONFIG AREA ---------------------------------------------------------- 

if($redirect_to_login)
{# redirect to current login page
	myRedirect($config->adminLogin);
}else{#redirect to main site index
	myRedirect(VIRTUAL_PATH . "index.php"); 
}
?>
