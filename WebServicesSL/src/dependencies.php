<?php

$container = $app->getContainer();
$container['db'] = function ($c) {

	$settings = $c->get('settings')['db'];

	$user = $settings['user'];
	$pass = $settings['pass'];
	$dsn = $settings['driver'].':host='.$settings['host']."; dbname=".$settings['dbname']."; charset=".$settings['charset'];

	try {
		$pdo = new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT=>TRUE));
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	} catch (PDOException $ex) {
		die('Error: '.$ex->getMessage());
	}
	
	return $pdo;
};

$container["jwt"] = function($container) {
	return new StdClass;
};