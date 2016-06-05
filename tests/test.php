<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Session\SessionContainer;
$container = SessionContainer::getInstance();

$testsession = array ();
$testsession[1] = $container->getSession(1);
$testsession[2] = $container->getSession(1);
$testsession[3] = $container->getSession(2, 1);
$testsession[4] = $container->getSession(3);

if ($testsession[1] === $testsession[2])
{
	echo "Test 1 OK\r\n";
} else {
	echo "Test 1 Failed\r\n";
}

if ($testsession[1] === $testsession[3])
{
	echo "Test 2 Failed\r\n";
} else {
	echo "Test 2 OK\r\n";
}

$testsession[1]->set ("Test1", "Value1");
$testsession[2]->set ("Test2", "Value2");
$testsession[3]->set ("Test3", "Value3");
$testsession[4]->set ("Testa", "Value1");
$testsession[4]->set ("Testb", "Value2");
$testsession[4]->set ("Testc", "Value3");
$testsession[4]->set ("Testd", "Value4");

if ($testsession[1]->get("Test2") === "Value2")
{
	echo "Test 3 OK\r\n";
} else {
	echo "Test 3 Failed\r\n";
}

if ($testsession[2]->get("Test1") === "Value1")
{
	echo "Test 4 OK\r\n";
} else {
	echo "Test 4 Failed\r\n";
}

if ($testsession[3]->get("Test3") === "Value3")
{
	echo "Test 5 OK\r\n";
} else {
	echo "Test 5 Failed\r\n";
}

if ($testsession[3]->get("Test1") === "Value1")
{
	echo "Test 6 Failed\r\n";
} else {
	echo "Test 6 OK\r\n";
}

if ($testsession[1]->get("Test3") === "Value3")
{
	echo "Test 7 Failed\r\n";
} else {
	echo "Test 7 OK\r\n";
}

sleep (3);

if ($container->existsSession (2))
{
	$container->cleanupInvalidSessions ();
	if ($container->existsSession (2))
	{
		echo "Test 8 Failed\r\n";
	} else {
		echo "Test 8 OK\r\n";
	}
} else {
	echo "Test 8 Failed\r\n";
}

try {
	$testsession[3]->get("Test3");
	echo "Test 9 Failed\r\n";
} catch (Session\SessionException $e)
{
	echo "Test 9 OK\r\n";
}

$testsession[3] = $container->getSession(2, 1);

if ($testsession[3]->get("Test3") === "Value3")
{
	echo "Test 10 Failed\r\n";
} else {
	echo "Test 10 OK\r\n";
}

$sessionIds = $container->getSessionIds();
if (count ($sessionIds) == 3)
{
	echo "Test 11 OK\r\n";
} else {
	echo "Test 11 Failed\r\n";
}

$container->cleanupInvalidSessions ();

$container->deleteSession($sessionIds[0]);
$sessionIds = $container->getSessionIds();
if (count ($sessionIds) == 2)
{
	echo "Test 12 OK\r\n";
} else {
	echo "Test 12 Failed\r\n";
}

$created = $container->getSession(3)->getCreationTime();
$now = time ();
if ($now - $created >= 3)
{
	echo "Test 13 OK (" . ($now - $created) . ")\r\n";
} else {
	echo "Test 13 Failed (" . $created . " " . $now . ")\r\n";
}

$names = $container->getSession(3)->getNames ();
if (count($names) == 4)
{
	echo "Test 14 OK\r\n";
} else {
	echo "Test 13 Failed (" . count($names) . ")\r\n";
}
?>
