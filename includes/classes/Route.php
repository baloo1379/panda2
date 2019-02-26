<?php
/**
 * Created by PhpStorm.
 * User: barte
 * Date: 26.02.2019
 * Time: 14:16
 */

class Route
{
	private static $validRoutes = array();

	private static function registerRoute($route){
		self::$validRoutes = BASEDIR.$route;
	}

	public static function isValidRoute($route) {
		 return in_array($route, array(self::$validRoutes));
	}

	public static function set($route, $function) {
		if($_SERVER['REQUEST_URI'] == BASEDIR.$route) {
			self::registerRoute($route);
			$function->__invoke();
		}
		elseif (explode('?', $_SERVER['REQUEST_URI'])[0] == BASEDIR.$route) {
			self::registerRoute($route);
			$function->__invoke();
		}
		elseif ($_GET['url'] == $route){
			self::registerRoute($route);
			$function->__invoke();
		}
	}
}