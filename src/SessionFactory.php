<?php 

namespace Session;

class SessionFactory {
	public static function create($id, $timeout = -1)
    {
        return new Session($id, $timeout);
    }
}

