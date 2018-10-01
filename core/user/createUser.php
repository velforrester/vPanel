<?php
	session_start();
	$data = array();
	$data['vpaneltheme'] = $_SESSION['vpaneltheme'];
	$userId = $_POST['userId'];
	$password = $_POST['password'];
	$password = password_hash($password, PASSWORD_DEFAULT);
	$fullName = $_POST['fullName'];
	$email = $_POST['email'];
	$userLevel = $_POST['userLevel'];
	$userIcon = $_POST['userIcon'];
	$userBg = $_POST['userBg'];
	$created = $_POST['created'];
	$lastLogin = $_POST['created'];
	$errors = array();
	$query = "SELECT * FROM users WHERE userId = '$userId'";
	$query = str_replace("\'","",$query);
	require_once $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/core/database/db_connect.php';
	if($result = $mysqli->query($query)){
		if(mysqli_num_rows($result) == 0) {
			function compress($source, $destination, $quality) {
				$info = getimagesize($source);
				if ($info['mime'] == 'image/jpeg')
				$image = imagecreatefromjpeg($source);
				elseif ($info['mime'] == 'image/gif')
				$image = imagecreatefromgif($source);
				elseif ($info['mime'] == 'image/png')
				$image = imagecreatefrompng($source);
				imagejpeg($image, $destination, $quality);
				return $destination;
			}
			function uploadUserIcon(){
				$id = md5(uniqid());
				$target_path = $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/media/users/';
				$file_name = $_FILES['userIcon']['name'];
				$file = $_FILES['userIcon']['tmp_name'];
				$validextensions = array('jpeg', 'jpg', 'png', 'gif');
				$ext = explode('.', basename($_FILES['userIcon']['name']));
				$file_extension = end($ext);
				$userIcon = $id . '.' . $file_extension;
				$target_path = $target_path . $id . '.' . $file_extension;
				if(in_array($file_extension, $validextensions)){
					if($_FILES['userIcon']['size'] > 500000){
						$file = compress($_FILES['userIcon']['tmp_name'], $target_path, 25);
						// success
					}elseif($_FILES['userIcon']['size'] > 200000){
						// success
						$file = compress($_FILES['userIcon']['tmp_name'], $target_path, 40);
					}
					elseif(move_uploaded_file($file, $target_path)){
						// success
					}else{
						$data['error'] = '[User Icon] Duplicate file name!';
						echo json_encode($data);
						exit;
					}
				}else{
					$data['error'] = '[User Icon] Invalid file type! Must be jpg, gif or png.';
					echo json_encode($data);
					exit;
				}
				return $userIcon;
			}
			if(!empty($userIcon)){
				$userIcon = uploadUserIcon();
			}
			function uploadUserBg(){
				$id = md5(uniqid());
				$target_path = $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/media/users/';
				$file_name = $_FILES['userBg']['name'];
				$file = $_FILES['userBg']['tmp_name'];
				$validextensions = array('jpeg', 'jpg', 'png', 'gif');
				$ext = explode('.', basename($_FILES['userBg']['name']));
				$file_extension = end($ext);
				$userBg = $id . '.' . $file_extension;
				$target_path = $target_path . $id . '.' . $file_extension;
				if(in_array($file_extension, $validextensions)){
					if($_FILES['userBg']['size'] > 500000){
						// success
						$file = compress($_FILES['userBg']['tmp_name'], $target_path, 25);
					}elseif($_FILES['userBg']['size'] > 200000){
						// success
						$file = compress($_FILES['userBg']['tmp_name'], $target_path, 40);
					}
					elseif(move_uploaded_file($file, $target_path)){
						// success
					}else{
						$data['error'] = '[User Background] Duplicate file name!';
						echo json_encode($data);
						exit;
					}
				}else{
					$data['error'] = '[User Background] Invalid file type! Must be jpg, gif or png.';
					echo json_encode($data);
					exit;
				}
				return $userBg;
			}
			if(!empty($userBg)){
				$userBg = uploadUserBg();
			}
			if(!empty($errors)){
				$data['success'] = 'false';
				$data['errors']  = $errors;
			}else{
				$query = "INSERT INTO users
					(userId, password, fullName, email, userLevel, image, background, created, lastLogin)
					VALUES ('$userId', '$password', '$fullName', '$email', '$userLevel', '$userIcon', '$userBg', '$created', '$lastLogin')";
				$query = str_replace("\'","",$query);
				require_once $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/core/database/db_connect.php';
				if($result = $mysqli->query($query)){
					$data['success'] = true;
					$data['message'] = 'User created successfully!';
				}else{
					$data['success'] = false;
					$data['message']  = 'Error entering user into database';
				}
				$mysqli->close();
			}
		}else{
			$data['duplicate'] = true;
		}
	}
    echo json_encode($data);
?>