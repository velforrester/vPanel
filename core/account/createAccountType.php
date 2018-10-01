<?php
	session_start();
	$data = array();
	$data['vpaneltheme'] = $_SESSION['vpaneltheme'];
	$id = md5(uniqid());
	$name = $_POST['name'];
	$plugins = array();
	$plugins = implode(',', $_POST['plugins']);
	$admin = 1;
	$query = "SELECT * FROM account_types WHERE name = '$name'";
	$query = str_replace("\'","",$query);
	require_once $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/core/database/db_connect.php';
	if($result = $mysqli->query($query)){
		if(mysqli_num_rows($result) == 0) {
			$query = "INSERT INTO account_types
				(id, name, plugins, admin)
				VALUES ('$id', '$name', '$plugins', '$admin')";
			$query = str_replace("\'","",$query);
			require_once $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/core/database/db_connect.php';
			if($result = $mysqli->query($query)){
				$data['success'] = true;
				$data['message'] = 'Account type created successfully!';
			}else{
				$data['success'] = false;
				$data['message']  = 'Error entering account type into database';
			}
		}else{
			$data['duplicate'] = true;
		}
	}
	$mysqli->close();
	echo json_encode($data);
?>