<?php
	$userId = $_POST['id'];
	$query = "SELECT * FROM users WHERE userId = '$userId'";
	require_once $_SERVER['DOCUMENT_ROOT'] . '/vPanel/core/database/db_connect.php';
	if($result = $mysqli->query($query)){
		while($result_a = mysqli_fetch_assoc($result)){
			if($result_a['image'] != NULL){
				$image = $result_a['image'];
				$target_path = $_SERVER['DOCUMENT_ROOT'] . '/vPanel/media/users/' . $image;
				unlink($target_path);
			}
			if($result_a['background'] != NULL){
				$background = $result_a['background'];
				$target_path = $_SERVER['DOCUMENT_ROOT'] . '/vPanel/media/users/' . $background;
				unlink($target_path);
			}
		}
	}else{
		echo 'Error getting image path.';
	}
	$query = "DELETE FROM users WHERE userId = '$userId'";
	if($result = $mysqli->query($query)){
	}else{
		echo 'Error removing from database.';
	}
	$mysqli->close();
?>