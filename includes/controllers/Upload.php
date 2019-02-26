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
			$destination = getcwd().'\\files\\'.basename($file['name']);
			if(!move_uploaded_file($file['tmp_name'], $destination)) {
				return array(false, 'File arleady');
			}
			self::$lastFileDir = $destination;
			self::$lastTableName = explode('.', $file['name'])[0];
			//self::$lastTableName = $chartName;
			return array(true);
		}
		catch (Exception $e)
		{
			return array(false, $e->getMessage());
		}

	}

	public static function prepareTable() {
		$file = fopen(self::$lastFileDir, 'r');
		$read = fgets($file, filesize(self::$lastFileDir));
		fclose($file);
		$header = explode(',', $read);
		self::$lastHeader = $header;
		$query = "CREATE TABLE ".self::$lastTableName." ( $header[0] INT NOT NULL AUTO_INCREMENT, ";
		for ($i=1; $i<count($header); $i++) {
			$query .= "$header[$i] VARCHAR(255) NOT NULL, ";
		}
		$query .= "PRIMARY KEY (id))";

		//return $query;
		DB::query($query);
	}

	public static function populateTable() {
		$query = "INSERT INTO ".self::$lastTableName." (";
		for ($i=0; $i<count(self::$lastHeader); $i++) {
			$query .= self::$lastHeader[$i];
			if($i<count(self::$lastHeader)-1) {
				$query .= ', ';
			}
		}
		$query .= ") VALUES ";

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

		//echo $query;
		DB::query($query);
	}
}