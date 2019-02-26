<?php
/**
 * Created by PhpStorm.
 * User: barte
 * Date: 26.02.2019
 * Time: 14:20
 */

class DB
{
	private static $host = 'localhost';
	private static $dbName = 'panda2';
	private static $username = 'bartix997';
	private static $password = 'zxszxs321';

	private static function connect() {
		try {
			$pdo = new PDO("mysql:host=".self::$host.";dbname=".self::$dbName.";charset=utf8", self::$username, self::$password);
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		}
		catch (PDOException $e) {
			echo "Database connection error<br>".$e->getMessage();
		}
	}

	public static function query($query, $params=array()) {
		$statement = self::connect()->prepare($query);
		$statement->execute($params);
		if (explode(' ', $query)[0] == 'SELECT') {
			$data = $statement->fetchAll();
			return $data;
		}
	}
}