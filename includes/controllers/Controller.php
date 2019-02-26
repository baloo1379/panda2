<?php

class Controller extends DB
{
	public static function createView($viewName, $params=array()) {
		define('params', $params);
		require_once "./includes/views/View$viewName.php";
	}
}