<?php

Route::set('', function(){
	Home::createView('Home');
});

Route::set('upload', function (){
	if(!Upload::receiveFile()[0]) {
		Upload::createView('UploadError', array('data' => Upload::receiveFile()[1]));
	}
	else {
		Upload::prepareTable();
		Upload::populateTable();
		header('Location:'.BASEDIR.'present');
		//Upload::createView('Upload', array('data' => 'ok'));
	}
});

Route::set('present', function(){
	Present::createView('Present');
});