<?php
	session_start();
	$id = $_POST['id'];
	$name = $_POST['name'];
	$plugins = array();
	$plugins = implode(',', $_POST['plugins']);
	$admin = 1;
	$data = array();
	$query = $query = "UPDATE account_types SET name = '$name', plugins = '$plugins', admin = '$admin' WHERE id = '$id'";
	$query = str_replace("\'","",$query);
	require_once $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/core/database/db_connect.php';
	if($result = $mysqli->query($query)){
		$data['success'] = true;
		$data['message'] = 'Account type created successfully!';
	}else{
		$data['success'] = false;
		$data['message']  = 'Error entering account type into database';
	}
	$mysqli->close();
	echo json_encode($data);
?>