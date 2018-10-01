<?php 
	session_start();
	$userId = $_POST['data'];
	if($userId == $_SESSION['userId']){
		$value = 'your';
	}else{
		$value = 'the selected';
	}
?>

<div class="container">
	<div class=" closeback">
		
		<?php if($_SESSION['admin'] == 0){ ?>
			<a href="javascript:void(0)" onClick = "loadPage('themes/<?php echo $_SESSION['vpaneltheme'];?>/layout/vPanel/users/editUsers.php')" id="back">back</a>
		<?php } ?>
		
		<a href="javascript:void(0)" onClick="closePage()" id="close">close</a>
	</div>
	<h1>Edit User Account</h1>
	<p id="message">Use this form to edit <?php echo $value;?> user account.</p>
	
	<?php 
		$query = "SELECT * FROM users WHERE userId = '$userId'";
		$query = str_replace("\'","",$query);
		require_once $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/core/database/db_connect.php';
		if($result = $mysqli->query($query)){
			while($result_a = mysqli_fetch_assoc($result)){
				$password = $result_a['password'];
				$fullName = $result_a['fullName'];
				$email = $result_a['email'];
				$accountType = $result_a['userLevel'];
				$userIcon = $result_a['image'];
				if($userIcon == NULL){
					$userIconImg = 'default.jpg';
				}else{
					$userIconImg = $userIcon;
				}
				$userBg = $result_a['background'];
				$created = $result_a['created'];
				$lastLogin = $result_a['lastLogin'];
			}
		}
		if($_SESSION['admin'] == 0 && $userId != 'vel'){
			echo '<a class="delete" href="javascript:void(0)" onClick=deleteUser("' . $userId . '")>delete</a></span>';
		}
	?>
	
	<form class="clearfix" id="editUser" action="" method="post" enctype="multipart/form-data">
		<div class="col">
			<div class="idLabel">User Id:</div> <input type="text" name="userIdDisabled" value="<?php echo $userId;?>" disabled="disabled" />
			<input type="hidden" name="userId" value="<?php echo $userId;?>" />
			<div class="passwordLabel">Password:</div> <input type="password" name="password" value="<?php echo $password;?>" />
			<div class="confirmLabel">Confirm Password:</div> <input type="password" name="confirmPassword" value="<?php echo $password;?>" />
		</div>
		<div class="col">
			Full Name: <input type="text" name="fullName" value="<?php echo $fullName;?>" />
			Email: <input type="text" name="email" value="<?php echo $email;?>" />
			
			<?php
				if($_SESSION['admin'] == 0 && $userId != 'vel'){
					echo '<span>Account Type: </span><select name="accountType"><option>Select account type...</option>';
				}else{
					echo '<span style="color:grey;">Account Type: </span><input type="hidden" name="accountType" value="' . $accountType . '"/><select name="accountTypeDisabled" disabled="disabled"><option>Select account type...</option>';
				}
				$query = "SELECT * FROM account_types";
				$query = str_replace("\'","",$query);
				require_once $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/core/database/db_connect.php';
				if($result = $mysqli->query($query)){
					while($result_a = mysqli_fetch_assoc($result)){
						echo '<option';
							if($accountType == $result_a['name']){
								echo ' selected';
							}
						echo '>' . $result_a['name'] . '</option>';
					}
				}else{
					echo 'error getting account types';
				}
				$mysqli->close();
				echo '</select>';
			?>
			
		</div>
		<hr/>
		<div class="editImg">
			<?php
				if($userIcon != NULL){
					echo '<img src="/'. $_SESSION['vpanelroot'] .'/media/users/' . $userIconImg . '" id="userIcon" alt="..." />';
				}else{
					echo '<img class="hide" src="" id="userIcon" alt="..." />';
				}
			?>
			
			User Icon: 
			
			<?php
				if($userIcon != NULL){
					echo '<i><a href="javascript:void(0)" id="userIconDelete">delete</a></i>';
				}else{
					echo '<i><a href="javascript:void(0)" id="userIconDelete" class="hide">delete</a></i>';
				}
			?>
			
			<input name="userIcon" type="file" id="image" onchange="previewFile('userIcon','image','#userIconDelete','#userIcon')"/>
			<input name="oldUserIcon" type="hidden" value="<?php echo $userIcon;?>"/>
			<hr style="margin-top:18px;"/>
		</div>
		<div class="editImg">
			
			<?php
				if($userBg != NULL){
					echo '<img src="/'. $_SESSION['vpanelroot'] .'/media/users/' . $userBg . '" id="userBg" alt="..." />';
				}else{
					echo '<img class="hide" src="" id="userBg" alt="..." />';
				}
			?>
			
			Background Image: 
			
			<?php
				if($userBg != NULL){
					echo '<i><a href="javascript:void(0)" id="userBgDelete">delete</a></i>';
				}else{
					echo '<i><a href="javascript:void(0)" id="userBgDelete" class="hide">delete</a></i>';
				}
			?>
			
			<input name="userBg" type="file" id="background" onchange="previewFile('userBg','background','#userBgDelete','#userBg')" />
			<input name="oldUserBg" type="hidden" value="<?php echo $userBg;?>"/>
		</div>
		<p class="imagenotice">Images must be jpg, gif or png. Large images will be compressed.</p>
		<input type="hidden" name="created" value="<?php echo $created;?>" />
		<input type="hidden" name="lastLogin" value="<?php echo $lastLogin;?>" />
		<input type="hidden" name="oldUserId" value="<?php echo $userId;?>" />
		<div class="submit"><input type="submit" id="submitEditUser" name="submit" value="Update Account" /></div>
	</form>
</div>