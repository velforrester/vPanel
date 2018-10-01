<?php session_start(); ?>

<div class="container">
	<div class=" closeback">
		<a href="javascript:void(0)" onClick = "loadPage('themes/<?php echo $_SESSION['vpaneltheme'];?>/layout/vPanel/accountTypes/editAccountTypes.php')" id="back">back</a>
		<a href="javascript:void(0)" onClick="closePage()" id="close">close</a>
	</div>
	<h1>Create Account Type</h1>
	<p>Complete this form to create a new account type.</p>
	<form id="createAccountType" action="" method="post" enctype="multipart/form-data">
		<div class="nameLabel">Name:</div> <input type="text" name="name" id="accounttypename" autofocus />
		<p>Privelages:</p>	
<?php
		if(file_exists('../../../../../plugins/plugins.xml')){
			$plugins = simplexml_load_file('../../../../../plugins/plugins.xml');
			foreach ($plugins->plugin as $plugin){
?>
			<div class="privelagebox">
				<input type="checkbox" name="plugins[]" value="<?php echo $plugin->id;?>"/> <i><?php echo $plugin->title;?></i>
			</div>
<?php
			}
		}else{
			echo 'No configuration file found!';
		}
?>
		<input type="hidden" name="sitesettings" value="true" />
		<br/>
		<div class="submit"><input type="submit" id="submitCreateAccountType" name="submit" value="Create Account Type" /></div>
	</form>
</div>
<script>
	$(document).ready(function(){
		$('input[name=name]').focus();
	});
</script>