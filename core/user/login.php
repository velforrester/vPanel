<?php
	if(isset($_POST['userId']) || isset($_POST['password'])){
		$userId = $_POST['userId'];
		$password = $_POST['password'];
		$query = "SELECT * FROM users WHERE userId='$userId'";
		$query = str_replace("\'","",$query);
		require_once 'core/database/db_connect.php';
		if($result = $mysqli->query($query)){
			if($result_a = mysqli_fetch_assoc($result)){
				$hash = $result_a['password'];
				if(password_verify($password, $hash)){
					date_default_timezone_set('America/New_York');
					$loginDate = date("Y-m-d");
					$query = "UPDATE users SET lastLogin = '$loginDate' WHERE userId = '$userId'";
					$query = str_replace("\'","",$query);
					if($result = $mysqli->query($query)){
					}else{
						echo 'Error logging date';
					}
					require_once 'core/user/session.php';
					header('Location: http://' . $_SERVER['SERVER_NAME'].'/'.$vpanelroot . '/');
					exit;
				}else{
					header('Location: http://' . $_SERVER['SERVER_NAME'].'/'.$vpanelroot . '/?status=1');
				exit;
				}
			}else{
				header('Location: http://' . $_SERVER['SERVER_NAME'].'/'.$vpanelroot . '/?status=1');
				exit;
			}
		}
		$mysqli->close();
	}else{
		require_once 'themes/'. $vpaneltheme . '/layout/login/index.php';
		
	} 
?>