# PHP Session Library

Version 1.2.0
Add new functions to Session (getNames(),getCreationTime(),getLastAccessedTime()) and new functions (existsSession(), cleanupInvalidSessions()) to SessionContainer. Add API doc generated with ApiGen

Version 1.1.0
Add new functions (getSessionIds(), deleteSession()) to SessionContainer.

Version 1.0.1
Fix in composer.json

Version 1.0.0
First Version of PHP Session Library

This session library is designed for PHP Applications without http interface. 
It can be uesed if you have a running PHP service and you need to handle multiple sessions.

Full PAI doc is available at [http://www.dieletztedomain.de/php-session-library-api-docs/](http://www.dieletztedomain.de/php-session-library-api-docs/)

You can use composer to add it to your project:

```
composer require msoftware/session-library
```

Latest stable version at: [https://packagist.org/packages/msoftware/session-library](https://packagist.org/packages/msoftware/session-library)
