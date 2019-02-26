<?php

Route::set('', function(){
	Home::createView('Home');
});

Route::set('upload', function (){
	if(!Upload::receiveFile()) {
		Upload::createView('UploadError');
	}
	else {
		//Upload::prepareTable();
		Upload::prepareTable();
		Upload::populateTable();
		Upload::createView('Upload', array('data' => 'ok'));
	}
});