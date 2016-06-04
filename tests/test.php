<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use Session\SessionContainer;
$container = SessionContainer::getInstance();

$testsession = array ();
$testsession[1] = $container->getSession(1);
$testsession[2] = $container->getSession(1);
$testsession[3] = $container->getSession(2, 1);

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

try {
	$testsession[3]->get("Test3");
	echo "Test 8 Failed\r\n";
} catch (Session\SessionException $e)
{
	echo "Test 8 OK\r\n";
}

$testsession[3] = $container->getSession(2, 1);

if ($testsession[3]->get("Test3") === "Value3")
{
	echo "Test 9 Failed\r\n";
} else {
	echo "Test 9 OK\r\n";
}

$sessionIds = $container->getSessionIds();
if (count ($sessionIds) == 2)
{
	echo "Test 10 OK\r\n";
} else {
	echo "Test 10 Failed\r\n";
}

$container->deleteSession($sessionIds[0]);
$sessionIds = $container->getSessionIds();
if (count ($sessionIds) == 1)
{
	echo "Test 11 OK\r\n";
} else {
	echo "Test 11 Failed\r\n";
}

?>
