<?php
/**
 * Created by PhpStorm.
 * User: barte
 * Date: 26.02.2019
 * Time: 19:16
 */

class Present extends Controller
{
	public static function numbers() {
		$tableName = Upload::getLastTableName();
		$query = "SELECT Count(*) AS 'number', country FROM $tableName GROUP BY country ORDER BY number DESC";
	}
}