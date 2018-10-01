<?php
	session_start();
	$vpanelroot = $_SESSION['vpanelroot'];
	session_unset();
    header('Location: http://'.$_SERVER["SERVER_NAME"].'/'.$vpanelroot.'/?status=2');
	exit;
?>