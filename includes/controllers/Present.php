<?php
/**
 * Created by PhpStorm.
 * User: barte
 * Date: 26.02.2019
 * Time: 19:16
 */

class Present extends Controller
{
	private static function tableExists($tableName) {
		$query = "SHOW TABLES LIKE '$tableName'";
		$result = DB::query($query);
		return !empty($result);
	}

	public static function numbers($tableName) {
		if(self::tableExists($tableName)) {
			$query = "SELECT Count(*) AS 'number', country FROM `$tableName` GROUP BY country ORDER BY number DESC";
			$result = DB::query( $query, $params = array(), $fetch = PDO::FETCH_ASSOC );
			$labels = array();
			$series = array();
			foreach ($result as $double) {
				$number = $double['number'];
				$country = $double['country'];
				array_push( $labels, $country );
				array_push( $series, $number );
			}

			return array(true, 'labels' => $labels, 'series' => $series);
		}
		else {
			return array(false, 'Taka tablica nie istnieje.');
		}
	}
}