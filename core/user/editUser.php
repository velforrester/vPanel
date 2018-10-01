<?php
	session_start();
	$userId = $_POST['oldUserId'];
	$newUserId = $_POST['userId'];
	$password = $_POST['password'];
	$fullName = $_POST['fullName'];
	$email = $_POST['email'];
	$userLevel = $_POST['accountType'];
	$userIcon = $_POST['userIcon'];
	$userBg = $_POST['userBg'];
	$created = $_POST['created'];
	$lastLogin = $_POST['created'];
	$errors = array();
	$data = array();
	$query = "SELECT * FROM users WHERE userId = '$userId'";
	require_once $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/core/database/db_connect.php';
	$query = str_replace("\'","",$query);
	if($result = $mysqli->query($query)){
		while($result_a = mysqli_fetch_assoc($result)){
			$oldUserIcon = $result_a['image'];
			$oldUserBg = $result_a['background'];
			$oldpassword = $result_a['password'];
		}
	}
	if($password != $oldpassword){
		$password = password_hash($password, PASSWORD_DEFAULT);
	}
	if($_POST['userIconDelete'] == 'true' && $oldUserIcon != ''){
		$image = $oldUserIcon;
		$target_path = $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/media/users/' . $image;
		unlink($target_path);
		$oldUserIcon = NULL;
	}
	if($_POST['userBgDelete'] == 'true' && $oldUserBg != ''){
		$background = $oldUserBg;
		$target_path = $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/media/users/' . $background;
		unlink($target_path);
		$oldUserBg = NULL;
	}
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
				// success
				$file = compress($_FILES['userIcon']['tmp_name'], $target_path, 25);
			}elseif($_FILES['userIcon']['size'] > 200000){
				// success
				$file = compress($_FILES['userIcon']['tmp_name'], $target_path, 40);
			}elseif(move_uploaded_file($file, $target_path)){
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
	}else{
		$userIcon = $oldUserIcon;
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
			}elseif(move_uploaded_file($file, $target_path)){
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
	}else{
		$userBg = $oldUserBg;
	}
    if(!empty($errors)){
        $data['success'] = 'false';
        $data['errors']  = $errors;
    }else{
		$query = "UPDATE users SET userId = '$newUserId', password = '$password', fullName = '$fullName', email = '$email', userLevel = '$userLevel', image = '$userIcon', background = '$userBg', created = '$created', lastLogin = '$lastLogin' WHERE userId = '$userId'";
		$query = str_replace("\'","",$query);
		if($result = $mysqli->query($query)){
			$data['success'] = true;
			$data['message'] = 'User edited successfully!';
			if($_SESSION['userId'] == $userId){
				$_SESSION['userId'] = $newUserId;
				$_SESSION['fullName'] = $fullName;
				if($userIcon == NULL){
					$_SESSION['image'] = 'default.jpg';
				}else{
					$_SESSION['image'] = $userIcon;
				}
				$_SESSION['background'] = $userBg;
				$data['reload'] = 1;
			}
		}else{
			$data['success'] = false;
			$data['message']  = 'Error editing user';
		}
		$mysqli->close();
    }
    echo json_encode($data);
?>