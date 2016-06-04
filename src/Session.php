<?php 

namespace Session;

class Session { 

	private $id;
	private $data;
	private $timeout;
	private $lastAccess;

	function __construct($id, $timeout = -1) 
	{ 
		$this->id = $id;
		$this->data = array ();
		$this->timeout = $timeout;
		$this->lastAccess = time();
	} 

	function isValid ()
	{
		if ($this->timeout < 0) return true; // Always valid
		$now = time ();
		if (($now - $this->lastAccess) > $this->timeout)
		{
			return false; // Timeout
		} else {
			return true; // Timeout
		}
	}

	function updateLastAccess()
	{
		if (!$this->isValid())
		{
			throw new SessionException('Session timeout');
		}
		$this->lastAccess = time();
	}

	function getTimeout ()
	{
		if (!$this->isValid())
		{
			throw new SessionException('Session timeout');
		}
		$this->updateLastAccess();
		return $this->timeout;
	}

	function setTimeout ($timeout)
	{
		if (!$this->isValid())
		{
			throw new SessionException('Session timeout');
		}
		$this->updateLastAccess();
		$this->timeout = $timeout;
	}

	function get ($key, $default = null)
	{
		if (!$this->isValid())
		{
			throw new SessionException('Session timeout');
		}
		$this->updateLastAccess();
		if (isset ($this->data[$key]))
		{
			return $this->data[$key];
		} else {
			return $default;
		}
	}

	function set ($key, $value)
	{
		if (!$this->isValid())
		{
			throw new SessionException('Session timeout');
		}
		$this->updateLastAccess();
		$this->data[$key] = $value;
	}

} 

