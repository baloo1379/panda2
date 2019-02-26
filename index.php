<?php

define('BASEDIR', '/panda2/');
define('SITE_NAME', 'Panda 2');



function loader($class_name) {
	if(file_exists("./includes/classes/$class_name.php")) {
		require_once "./includes/classes/$class_name.php";
	}
	elseif (file_exists("./includes/controllers/$class_name.php")) {
		require_once "./includes/controllers/$class_name.php";
	}
}



spl_autoload_register('loader');

require_once 'Routes.php';