<?php

namespace Register;

require __DIR__ . DIRECTORY_SEPARATOR . 'autoloader.php';

use \Header;
use function Functions\{array_keys_exist};

function validate(Array $data): Bool
{
	if (array_keys_exist($data, 'name', 'email', 'password')) {
		return filter_var($data['email'], FILTER_VALIDATE_EMAIL);
	} else {
		return false;
	}
}

Header::set('Content-Type', 'application/json');

if (array_key_exists('Person', $_POST) and is_array($_POST['Person']) and validate($_POST['Person'])) {
	$person = $_POST['Person'];

	$person['password'] = password_hash($person['password'], PASSWORD_DEFAULT);
	// https://secure.gravatar.com/avatar/314fe5e355732b0a15b18053d318cf37?s=256&d=mm
	$person['gravatar'] = 'https://secure.gravatar.com/avatar/' . md5($person['email']);
	echo json_encode(['Person' => $person]);
} else {
	Header::status(400);
	echo json_encode(['error' => 'Missing or invalid input']);
}
