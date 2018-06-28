<?php

class File implements \JSONSerializable
{
	private $_path = '';

	public function __construct(String $fname)
	{
		$this->_path = $fname;
	}

	public function jsonSerialize(): Array
	{
		return [];
	}
}
