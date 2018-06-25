<?php
namespace Consts;

const BASE = __DIR__ . DIRECTORY_SEPARATOR;
const COMPONENTS_DIR = BASE . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR;

const CSP = [
	'default-src' => [
		"'self'",
	],
	'style-src'   => [
		"'self'",
		'https://shgysk8zer0.github.io',
		"'nonce-%STYLE_NONCE%'",
	],
	'script-src'  => [
		"'self'",
		'https://shgysk8zer0.github.io',
		"'nonce-%SCRIPT_NONCE%'",
	],
	'img-src'     => [
		"'self'",
		'https://secure.gravatar.com',
		'data:',
		'blob:',
	],
	'font-src'    => [
		"'self'",
		'https://shgysk8zer0.github.io',
	],
];
