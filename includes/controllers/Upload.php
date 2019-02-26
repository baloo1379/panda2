<?php

function arrayToSQL($data) {
	$result = '(';
	for ($i=0; $i<count($data); $i++) {
		$result .= '\''.addslashes($data[$i]).'\'';
		if($i<count($data)-1) {
			$result .= ', ';
		}
		else {
			$result .= '), ';
		}
	}
	return $result;
}

function removeSpaces($data) {
	return preg_replace('/\s+/', '', $data);
}

function validMySQL($var) {
$var=stripslashes($var);
$var=htmlentities($var);
$var=strip_tags($var);
//$var=removeSpaces($var);
return $var;
}

class Upload extends Controller
{
	private static $lastFileDir;

	private static $lastTableName;

	private static $lastHeader;

	public static function getLastTableName() {
		return self::$lastTableName;
	}

	public static function receiveFile() {
		try {
			$file = Request::file( 'file' );
			$fileName = strtolower(validMySQL(removeSpaces($file['name'])));
			$tableName = explode('.', $fileName)[0];
			$destination = getcwd().'\\files\\'.basename($fileName);
			if(!move_uploaded_file($file['tmp_name'], $destination)) {
				return array(false, 'Move error');
			}
			self::$lastFileDir = $destination;
			self::$lastTableName = $tableName;

			return array(true);
		}
		catch (Exception $e)
		{
			return array(false, $e->getMessage());
		}

	}

	public static function validateFile() {
		$tableName = self::$lastTableName ;
		$query = "SELECT COUNT(*) FROM information_schema.TABLES WHERE TABLE_SCHEMA='panda2' AND TABLE_NAME LIKE '%$tableName%'";
		//echo $query.'<br>';
		$result = DB::query($query)[0];
		if($result>=1) {
			$tmpArray = explode('_', $tableName);
			if(!is_int($tmpArray[count($tmpArray)-1])) {
				$tableName = implode('_',$tmpArray).'_'.$result[0];
			}
			else {
				$tmpArray[count($tmpArray)-1]++;
				$tableName = implode('_',$tmpArray);
			}
		}
		self::$lastTableName = $tableName;
		$file = fopen(self::$lastFileDir, 'r');
		$read = validMySQL(removeSpaces(fgets($file)));
		fclose($file);
		$header = explode(',', $read);
		self::$lastHeader = $header;
		if(in_array('country', $header)) {
			return array(true);
		}
		else {
			return array(false, 'Dane nie zawierają informacji o kraju');
		}
	}

	public static function prepareTable() {
		$header = self::$lastHeader;
		$query = "CREATE TABLE `".self::$lastTableName."` ( $header[0] INT NOT NULL AUTO_INCREMENT, ";
		//echo $header;
		for ($i=1; $i<count($header); $i++) {
			$query .= "$header[$i] VARCHAR(255) NOT NULL, ";
		}
		$query .= "PRIMARY KEY (id))";

		//return $query;
		DB::query($query);
	}

	public static function populateTable() {
		$query = "INSERT INTO `".self::$lastTableName."` (";
		for ($i=0; $i<count(self::$lastHeader); $i++) {
			$query .= self::$lastHeader[$i];
			if($i<count(self::$lastHeader)-1) {
				$query .= ', ';
			}
		}
		$query .= ") VALUES ";
		echo $query;
		$file = fopen(self::$lastFileDir, 'r');
		fgets($file, filesize(self::$lastFileDir));
		while(!feof($file)) {
			$line = fgetcsv($file);
			if(!empty($line)) {
				$query .= arrayToSQL($line);
			}
		}
		$query = substr($query, 0, strlen($query)-2);
		fclose($file);
		unlink(self::$lastFileDir);
		//echo $query;
		DB::query($query);
	}
}