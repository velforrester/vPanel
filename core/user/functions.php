<?php

	function login(){
		$userId = $_POST['userId'];
		$password = $_POST['password'];
		if(isset($userId) || isset($password)){
			$query = "SELECT * FROM users WHERE userId='" . $userId . "' AND password='" . $password . "'";
			$query = str_replace("\'","",$query);
			include_once 'core/database/db_connect.php';
			if($result = $mysqli->query($query)){
				if($result_a = mysqli_fetch_assoc($result)){
					session_start();
					include 'core/user/session.php';
					header('Location: http://192.168.10.107/vPanel/');
					exit;
				}else{
					header('Location: http://192.168.10.107/vPanel/?status=1');
					exit;
				}
			}
		}else{
			include_once 'themes/default/layout/login/index.php';
		} 
	}
	
?>