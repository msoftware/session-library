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

