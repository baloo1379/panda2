<?php
/**
 * Created by PhpStorm.
 * User: barte
 * Date: 26.02.2019
 * Time: 14:44
 */

class Upload extends Controller
{
	private static $lastFileDir;

	public static function receiveFile() {

		try {
			$file = Request::file( 'file' );
			$destination = getcwd().'\\files\\'.basename($file['name']);
			if(!move_uploaded_file($file['tmp_name'], $destination)) {
				return false;
			}
			self::$lastFileDir = $destination;
			return true;
		}
		catch (Exception $e)
		{
			return false;
		}

	}

	public static function prepareTable() {
		$file = fopen(self::$lastFileDir, 'r');
		$read = fread($file, filesize(self::$lastFileDir));
		fclose($file);
		return explode('\n', $read)[0];
	}
}