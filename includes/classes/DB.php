<?php
/**
 * Created by PhpStorm.
 * User: barte
 * Date: 26.02.2019
 * Time: 14:20
 */

class DB
{
	public static $host = 'localhost';
	public static $dbName = 'panda2';
	protected static $username = 'bartix997';
	protected static $password = 'zxszxs321';

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

	public static function query($query, $params=array(), $fetch=PDO::FETCH_NUM) {
		$statement = self::connect()->prepare($query);
		$statement->execute($params);
		if (explode(' ', $query)[0] == 'SELECT' || explode(' ', $query)[0] == 'SHOW' ) {
			if($statement) {
				$data = $statement->fetchAll($fetch);
				return $data;
			}

		}
	}
}