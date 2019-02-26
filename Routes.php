<?php

Route::set('', function(){
	Home::createView('Home');
});

Route::set('upload', function (){
	$recv = Upload::receiveFile();
	if(!$recv[0]) {
		Upload::createView('Error', array('data' => $recv[1]));
	}
	else {
		$result = Upload::validateFile();
		if(!$result[0]) {
			Upload::createView('Error', array('data' => $result[1]));
		}
		else {
			Upload::prepareTable();
			Upload::populateTable();
			header( 'Location:' . BASEDIR . 'present?table=' . Upload::getLastTableName() );
			//Upload::createView('Upload', array('data' => 'ok'));
		}
	}
});

Route::set('present', function(){
	if(!isset($_GET['table'])) {
		header('Location:'.BASEDIR);
	}
	$numbers = Present::numbers($_GET['table']);
	if($numbers[0]) {
		Present::createView('Present', array('array' => $numbers));
	}
	else {
		Present::createView('Error', array('data' => $numbers[1]));
	}
});