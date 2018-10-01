<?php
	if(isset($_SESSION['vpanelroot'])){
		$vpanelroot = $_SESSION['vpanelroot'];
	}
	if(file_exists($_SERVER['DOCUMENT_ROOT'] .'/'. $vpanelroot .'/config.xml')) {
		$config = simplexml_load_file($_SERVER['DOCUMENT_ROOT'] .'/'. $vpanelroot .'/config.xml');
		$host = $config->database->host;
		$user = $config->database->username;
		$pass = $config->database->password;
		$db = $config->database->dbName;
	} else {
		exit('No configuration file found!');
	}
	$mysqli = new mysqli($host, $user, $pass);
	if (mysqli_connect_errno()) {
		die("Could not connect to database: " . mysqli_connect_error());
	}
	$mysqli->select_db($db);
?>