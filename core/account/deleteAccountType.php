<?php
	session_start();
	$data['vpaneltheme'] = $_SESSION['vpaneltheme'];
	$id = $_POST['id'];
	$query = "SELECT * FROM account_types WHERE id = '$id'";
	$query = str_replace("\'","",$query);
	require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $_SESSION['vpanelroot'] . '/core/database/db_connect.php';
	if($result = $mysqli->query($query)){
		$result_a = mysqli_fetch_assoc($result);
		$userLevel = $result_a['name'];
	}else{
		echo 'Error getting account type.';
	}
	$query = "UPDATE users SET userLevel ='' WHERE userLevel = '$userLevel'";
	$query = str_replace("\'","",$query);
	require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $_SESSION['vpanelroot'] . '/core/database/db_connect.php';
	if($result = $mysqli->query($query)){
	}else{
		echo 'Error removing account type from users.';
	}
	$query = "DELETE FROM account_types WHERE id = '$id'";
	$query = str_replace("\'","",$query);
	require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $_SESSION['vpanelroot'] . '/core/database/db_connect.php';
	if($result = $mysqli->query($query)){
	}else{
		echo 'Error removing from database.';
	}
	$mysqli->close();
	echo json_encode($data);
?>