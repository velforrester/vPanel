<?php 
	session_start();
	$id = $_POST['data'];
	$query = "SELECT * FROM account_types WHERE id = '$id'";
	$query = str_replace("\'","",$query);
	require_once $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/core/database/db_connect.php';
	if($result = $mysqli->query($query)){
		while($result_a = mysqli_fetch_assoc($result)){
			$name = $result_a['name'];
			$htmlname = $result_a['name'];
			$htmlname = str_replace(' ','&nbsp;', $htmlname);
			$allowedplugins = $result_a['plugins'];
			$allowedplugins = explode(',', $allowedplugins);
		}
	}
?>

<div class="container">
	<div class=" closeback">
		<a href="javascript:void(0)" onClick = "loadPage('themes/<?php echo $_SESSION['vpaneltheme'];?>/layout/vPanel/accountTypes/editAccountTypes.php')" id="back">back</a>
		<a href="javascript:void(0)" onClick="closePage()" id="close">close</a>
	</div>
	<h1>Edit Account Type</h1>
	<p id="message">Use this form to edit the selected account type.</p>
	<a class="delete" href="javascript:void(0)" onClick=deleteAccountType("<?php echo $id;?>","<?php echo $htmlname;?>")>delete</a><br/>
	<form class="clearfix" id="editAccountType" action="" method="post" enctype="multipart/form-data">
		<div class="nameLabel">Name:</div> <input id="accounttypename" type="text" name="name" value="<?php echo $name;?>" /><input type="hidden" name="id" value="<?php echo $id;?>" />
		<p>Privelages:</p>
<?php
		if(file_exists('../../../../../plugins/plugins.xml')){
			$plugins = simplexml_load_file('../../../../../plugins/plugins.xml');
			foreach ($plugins->plugin as $plugin){
				if(in_array($plugin->id, $allowedplugins)){
					$checked = 'checked';
				}else{
					$checked = '';
				}
?>
				<div class="privelagebox">
					<input type="checkbox" name="plugins[]" value="<?php echo $plugin->id;?>" <?php echo $checked;?>/> <i><?php echo $plugin->title;?></i>
				</div>
<?php
			}
		}else{
			echo 'No configuration file found!';
		}
?>
		<br/>
		<div class="submit"><input type="submit" id="submiteditAccountType" name="submit" value="Update Account Type" /></div>
	</form>
</div>