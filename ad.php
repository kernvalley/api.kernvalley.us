<?php

namespace ad;

require __DIR__ . DIRECTORY_SEPARATOR . 'functions.php';

use function Functions\{save_upload_image};

header('Content-Type: application/json');

if (array_key_exists('logo', $_FILES)) {
	$ad = new \StdClass();
	$ad->template = 'ad-template';
	$ad->title = $_POST['title'];
	$ad->content = $_POST['content'];
	$ad->backgroundColor = $_POST['background-color'];
	$ad->color = $_POST['color'];
	$ad->link = $_POST['link'];
	$ad->email = $_POST['email'];
	$ad->telephone = $_POST['telephone'];
	$ad->logo = save_upload_image('logo');
	$ad->logo->animation = $_POST['animation'];

	if (array_key_exists('background-image', $_FILES)) {
		$ad->backgroundImage = save_upload_image('background-image');
		$ad->backgroundX = $_POST['background-x'];
		$ad->backgroundY = $_POST['background-y'];
	}

	echo json_encode($ad);
} else {
	http_response_code(400);
}
