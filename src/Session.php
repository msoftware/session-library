<?php 

namespace Session;

class Session { 

	private $id;
	private $data;
	private $timeout;
	private $lastAccess;
	private $created;
	private $lastAccessed;

	function __construct($id, $timeout = -1) 
	{ 
		$this->id = $id;
		$this->data = array ();
		$this->timeout = $timeout;
		$this->lastAccess = time();
		$this->created = time ();
	} 

	function getNames()
	{
		if (!$this->isValid())
		{
			throw new SessionException('Session timeout');
		}
		$ret = array ();
		foreach ($this->data as $name => $val)
		{
			$ret [] = $name;
		}
		return $ret;
	}

	function getCreationTime()
	{
		if (!$this->isValid())
		{
			throw new SessionException('Session timeout');
		}
		return $this->created;
	}

	function getLastAccessedTime()
	{
		// No check for isValid here !!
		return $this->lastAccessed;
	}

	function isValid ()
	{
		if ($this->timeout < 0) return true; // Always valid
		$now = time ();
		$this->lastAccessed = $now;
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

