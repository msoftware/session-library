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
		return $this->sessions[$id];
	}

	private function __clone() {}
	private function __wakeup() {}

}

class SessionFactory {
	public static function create($id, $timeout = -1)
    {
        return new Session($id, $timeout);
    }
}

class Session { 

	private $id;
	private $data;
	private $timeout;

	function __construct($id, $timeout = -1) 
	{ 
		$this->id = $id;
		$this->data = array ();
		$this->timeout = $timeout;
	} 

	function getTimeout ()
	{
		return $this->timeout;
	}

	function setTimeout ($timeout)
	{
		$this->timeout = $timeout;
	}

	function get ($key, $default = null)
	{
		if (isset ($this->data[$key]))
		{
			return $this->data[$key];
		} else {
			return $default;
		}
	}

	function set ($key, $value)
	{
		$this->data[$key] = $value;
	}

} 

?> 
