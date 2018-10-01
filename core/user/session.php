<?php
	$_SESSION['userId'] = $userId;
	$_SESSION['fullName'] = $result_a['fullName'];
	$_SESSION['userLevel'] = $result_a['userLevel'];
	if($result_a['image'] == NULL){
		$_SESSION['image'] = 'default.jpg';
	}else{
		$_SESSION['image'] = $result_a['image'];
	}
	$_SESSION['background'] = $result_a['background'];
	if($_SESSION['userLevel'] != 'Select account type...' && $_SESSION['userLevel'] != ''){
		$query = "SELECT * FROM account_types WHERE name='" . $_SESSION['userLevel'] . "'";
		$query = str_replace("\'","",$query);
		if($result = $mysqli->query($query)){
			while($result_a = mysqli_fetch_assoc($result)){
				$_SESSION['admin'] = $result_a['admin'];
			}
		}
		$mysqli->close();
	}else{
		$_SESSION['admin'] = 1;
	}
	$_SESSION['vpanelroot'] = $vpanelroot;
	$_SESSION['vpaneltheme'] = $vpaneltheme;
?>