<?php

class Image implements \JSONSerializable
{
	const TYPE = 'ImageObject';
	const CONTEXT = 'http://schema.org';

	private $_type = '';

	private $_size = 0;

	private $_width = 0;

	private $_height = 0;

	private $_path = '';

	final public function __construct(String $fname)
	{
		//
	}

	public function jsonSerialize(): Array
	{
		return [
			'@type'    => self::TYPE,
			'@context' => self::CONTEXT,
			'type'     => $this->getType(),
			'size'     => $this->getSize(),
			'width'    => $this->getWidth(),
			'height'   => $this->getHeight(),
		];
	}

	final public function getPath(): String
	{
		return $this->_path;
	}

	final public function _setPath(String $path): Void
	{
		$this->_path = $path;
	}

	final public function getWidth(): Int
	{
		return $this->_width;
	}

	final protected function _setWidth(Int $width): Void
	{
		$this->_width = $width;
	}

	final public function getHeight(): Int
	{
		return $this->_height;
	}

	final protected function setHeight(Int $height): Void
	{
		$this->_height = $height;
	}

	final public function getType(): String
	{
		return $this->_type;
	}

	final protected function _setType(String $type): Void
	{
		$this->_type = $type;
	}

	final public function getSize(): Int
	{
		return $this->_size;
	}

	final public function _setSize(Int $size): Void
	{
		$this->_size = $size;
	}
}
