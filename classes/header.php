<?php

class Header
{
	private static $_requestHeaders = [];

	final public static function set(String $key, String $value): Void
	{
		header("{$key}: {$value}");
	}

	final public static function get(String $key): String
	{
		$headers = static::getAll();
		return $headers[strtolower($key)];
	}

	final public static function getAll(Bool $refresh = false): Array
	{
		if ($refresh or empty(static::$_requestHeaders)) {
			$headers = getallheaders();
			$keys = array_map('strtolower', array_keys($headers));
			$values = array_values($headers);
			static::$_requestHeaders = array_combine($keys, $values);
		}

		return static::$_requestHeaders;
	}

	final public static function has(String $key): Bool
	{
		$headers = static::getAll();
		return array_key_exists(strtolower($key), $headers);
	}

	final public static function status(Int $code): Void
	{
		http_response_code($code);
	}
}
