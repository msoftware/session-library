<?php 

namespace Session;

class SessionContainer {

	private static $instance;

	public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }
	
	private $sessions;

	protected function __construct() 
	{ 
		$this->sessions = array ();
	}

	function existsSession ($id)
	{
		if (isset ($this->sessions[$id]))
		{
			return true;
		} else {
			return false;
		}
	}

	function deleteSession ($id)
	{
		if ($this->existsSession ($id))
		{
			unset($this->sessions[$id]);
		}
	}

	function cleanupInvalidSessions ()
	{
		foreach ($this->sessions as $id => $session)
		{
			if (!$session->isValid ())			
			{
				$this->deleteSession ($id);
			}
		}
	}

	function getSessionIds ()
	{
		$ret = array ();
		foreach ($this->sessions as $id => $session)
		{
			if ($session->isValid ())			
			{
				$ret[] = $id;
			}
		}
		return $ret;
	}

	function getSession ($id, $timeout = -1)
	{
		if (!isset ($this->sessions[$id]))
		{
			$this->sessions[$id] = SessionFactory::create ($id, $timeout);
		}
		$session = $this->sessions[$id];
		if ($session->isValid ())
		{
			return $session;
		} else {
			// create new session because of timeout
			$this->sessions[$id] = SessionFactory::create ($id, $timeout);
			$session = $this->sessions[$id];
			return $session;
		}
	}

	private function __clone() {}
	private function __wakeup() {}

}

