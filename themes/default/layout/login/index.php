<div class="login">
	<img src="themes/default/graphics/vPanelLogo.png" />
	<?php if(isset($_GET['status'])){$status = $_GET['status']; if($status == 1){echo '<span class="loginFailure">Incorrect username or password!</span>';} if($status == 2){echo '<span class="loggedOut">You have been logged out!</span>';}}?>
	<h3>Log in to continue</h3>
    <form id="login" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		Username: &nbsp;<input type="text" class="input" name="userId" autofocus>
		<br/><br/>
		Password: &nbsp;&nbsp;<input type="password" class="input" name="password">
		<br/><br/>
		<input type="submit" class="button" name="submit" value="Log In">
	</form>
</div>