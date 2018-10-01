<?php session_start(); ?>

<div class="container">
	<div class=" closeback">
		<a href="javascript:void(0)" onClick = "loadPage('themes/<?php echo $_SESSION['vpaneltheme'];?>/layout/vPanel/users/editUsers.php')" id="back">back</a>
		<a href="javascript:void(0)" onClick="closePage()" id="close">close</a>
	</div>
	<h1>Create User Account</h1>
	<p>Complete this form to create a new user account.</p>
	<form id="addUser" action="" method="post" enctype="multipart/form-data">
		<div class="col">
			<div class="idLabel">User Id: <span style="font-style:italic; font-size:.8em;">(no spaces)</span></div> <input type="text" name="userId" autofocus />
			<div class="passwordLabel">Password:</div> <input type="password" name="password" />
			<div class="confirmLabel">Confirm Password:</div> <input type="password" name="confirmPassword" />
		</div>
		<div class="col">
			Full Name: <input type="text" name="fullName" />
			Email: <input type="text" name="email" />
			Account Type: 
			<select name="accountType">
			<option>Select account type...</option>
			
			<?php
				$query = "SELECT * FROM account_types";
				$query = str_replace("\'","",$query);
				require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $_SESSION['vpanelroot'] . '/core/database/db_connect.php';
				if($result = $mysqli->query($query)){
					while($result_a = mysqli_fetch_assoc($result)){
						echo '<option>' . $result_a['name'] . '</option>';
					}
				}else{
					echo 'error getting account types';
				}
				$mysqli->close();
			?>
			
			</select>
		</div>
		<hr/>
		<div class="editImg">
			<img class="hide" id="userIcon" src="" alt="...">
			User Icon:
			<i><a href="javascript:void(0)" id="userIconDelete" class="hide">delete</a></i>
			<input name="userIcon" type="file" id="image" onchange="previewFile('userIcon','image','#userIconDelete','#userIcon')"/>
		</div>
		<hr style="margin-top:18px;"/>
		<div class="editImg">
			<img class="hide" id="userBg" src="" alt="...">
			Background Image:
			<i><a href="javascript:void(0)" id="userBgDelete" class="hide">delete</a></i>
			<input name="userBg" type="file" id="background" onchange="previewFile('userBg','background','#userBgDelete','#userBg')"/>
		</div>
		<p class="imagenotice">Images must be jpg, gif or png. Large images will be compressed.</p>
		<input type="hidden" name="created" value="<?php echo date("Y-m-d"); ?>" />
		<div class="submit"><input type="submit" id="submitAddUser" name="submit" value="Create User Account" /></div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('input[name=userId]').focus();
	});
</script>