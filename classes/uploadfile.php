<?php
// @see https://secure.php.net/manual/en/features.file-upload.php
use \File;

class UploadFile implements \JSONSerializable
{
	private $_tmpname = '';

	private $_contentSize = 0;

	private $_encodingFormat = '';

	private $_name = '';

	private $_uploadDate = null;

	public function __construct(String $key)
	{
		if (array_key_exists($key, $_FILES)) {
			$upload = $_FILES[$key];
			if ($upload['error'] === UPLOAD_ERR_OK) {
				$this->_uploadDate = new \DateTime();
				$this->_tmpname = $upload['tmp_name'];
				$this->_contentSize = $upload['size'];
				$this->_encodingFormat = mime_content_type($this->tmpname);
				$this->_name = $upload['name'];
			}
		} else {
			throw new \RuntimeException('Error with uploaded file');
		}
	}

	public function jsonSerialize(): Array
	{
		return [
			'name' => $this->getName(),
			'tmp_name' => $this->_getTempName(),
			'encodingFormat' => $this->getEncodingFormat(),
			'contentSize' => $this->getContentSize(),
			'uploadDate' => $this->getUploadDate(),
		];
	}

	final public function getName(): String
	{
		return $this->_name;
	}

	final protected function _getTempName(): String
	{
		return $this->_tmpname;
	}

	final public getEncodingFormat(): String
	{
		return $this->_encodingFormat;
	}

	final public function getContentSize(): Int
	{
		return $this->_contentSize;
	}

	final public function getUploadDate(): \DateTime
	{
		return $this->_uploadDate;
	}

	final public function getExt(): String
	{
		return pathinfo($this->getName(), PATHINFO_EXTENSION)
	}

	final public function move(String $to): File
	{
		move_upload_file($this->_getTempName(), $to);
		return new File($to);
	}

	final public static function isUploadFile(String $path): Bool
	{
		return is_uploaded_file($path);
	}
}
