<?php
namespace Functions;

use const \Consts\{COMPONENTS_DIR};

function load(String ...$components): Void
{
	foreach($components as $component) {
		load_component($component);
	}
}

function load_component(String $component, $dir = COMPONENTS_DIR, $ext = 'phtml'): Void
{
	require "{$dir}{$component}.{$ext}";
}

function save_upload_image(String $key): \StdClass
{
	$saved = new \StdClass();
	$saved->contentType = null;
	$saved->hash = '';
	$saved->width = 0;
	$saved->size = 0;
	$saved->path = '';
	$saved->ext = '';
	$saved->error = new \StdClass();
	$saved->error->code = 0;
	$saved->error->msg = '';

	if (! array_key_exists($key, $_FILES)) {
		$saved->error->code = 404;
		$saved->error->msg = 'Upload not found';
	} elseif ($_FILES[$key]['error'] !== UPLOAD_ERR_OK) {
		$saved->error->code = $_FILES[$key]['error'];
	} else {
		$tmp = $_FILES[$key];
		$fname = $tmp['name'];
		$tmpname = $tmp['tmp_name'];
		$saved->hash = md5_file($tmpname);
		$saved->ext = pathinfo($fname, PATHINFO_EXTENSION);
		$saved->path = "/img/uploads/{$saved->hash}.{$saved->ext}";
		$saved->contentType = $saved->ext === 'svg'
			? 'image/svg+xml'
			: mime_content_type($tmpname);

		if ($saved->contentType !== 'image/svg+xml') {
			$info = getimagesize($outname);
			list($saved->width, $saved->height) = $info;
		} else {
			$dom = \DOMDocument::load($tmpname);
			$saved->width = $dom->documentElement->getAttribute('width');
			$saved->height = $dom->documentElement->getAttribute('height');
			$saved->viewBox = $dom->documentElement->getAttribute('viewBox');
		}

		if (! move_uploaded_file($tmpname, __DIR__ . $saved->path)) {
			$saved->error->code = 500;
			$saved->error->msg = 'Failed to save uploaded file';
		}
	}
	return $saved;
}

function array_keys_exist(Array $data, String ...$keys): Bool
{
	$valid = true;
	foreach($keys as $key) {
		if (! array_key_exists($key, $data)) {
			$valid = false;
			break;
		}
	}
	return $valid;
}

function generate_nonce(Int $len): String
{
	$str = bin2hex(openssl_random_pseudo_bytes($len));
	$strlen = strlen($str);

	if ($strlen < $len) {
		$str .= generate_nonce($len - $strlen);
	}

	return substr($str, $len);
}

function get_nonce(String $for, Int $len = 35): String
{
	static $nonces = [];

	if (! array_key_exists($for, $nonces)) {
		$nonces[$for] = generate_nonce($len);
	}

	return $nonces[$for];
}

function csp(Array $srcs): Void
{
	$csp = join('; ', array_map(
		function(String $type, Array $srcs)
		{
			return $type . ' ' . join(' ', $srcs);
		},
		array_keys($srcs),
		array_values($srcs)
	));

	header(sprintf(
		'Content-Security-Policy: %s',
		str_replace(
			[
				'%STYLE_NONCE%',
				'%SCRIPT_NONCE%',
			], [
				get_nonce('style'),
				get_nonce('script'),
			],
			$csp
		)
	));
}
