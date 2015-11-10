<?php
//autoload-register-class.php
/*
will find and load class files that are namespaced and 
stored in a folder that follows the same relative path that 
matches the namespace

*/

spl_autoload_register('MyAutoLoader::NamespaceLoader');


//the Application class must both be in a relative path, Main/Sub/Application.php and 
//have a namespace of Main\Sub.
$myApp = new Main\Sub\Application("Joe");

echo '<pre>';
var_dump($myApp);
echo '</pre>';


/*
This class stores a collection of static methods to load
any number of library configurations

autoloader must be registered before class is called.

registration looks like the following:

<code>
spl_autoload_register('MyAutoLoader::NamespaceLoader');
</code>

*/
class MyAutoLoader
{
    /*
	will find and load class files that are namespaced and 
	stored in a folder that follows the same relative path that 
	matches the namespace
	
	This version starts with the relative path of the calling page
	as a reference	
	
	*/
	public static function NameSpaceLoader($class)
    {
        $path = str_replace('\\', '/', $class);
		$path = __DIR__ . '/' . $path . '.php';
		if (file_exists($path)) {
			include $path;
		}
    }
