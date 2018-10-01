<?php session_start();?>
<div class="container">
	<div class=" closeback">
		<a href="javascript:void(0)" onClick="closePage()" id="close">close</a>
	</div>
	<h1>Edit User Accounts</h1>
	<p>Select the user account you would like to edit.</p>
	<p><span class="bold">Users:</span> &nbsp; <a class="create" href="javascript:void(0)" onClick = "loadPage('themes/<?php echo $_SESSION['vpaneltheme'];?>/layout/vPanel/users/createUser.php')"></a></p>
	
	<?php
		$query = "SELECT * FROM users";
		$query = str_replace("\'","",$query);
		require_once $_SERVER['DOCUMENT_ROOT'] . '/'. $_SESSION['vpanelroot'] .'/core/database/db_connect.php';
		if($result = $mysqli->query($query)){
			while($result_a = mysqli_fetch_assoc($result)){
				$image = $result_a['image'];
				if($image == NULL){
					$image = 'default.jpg';
				}
				echo '<div class="userlist">';
				echo '<img class="profileIcon" src="/'. $_SESSION['vpanelroot'] .'/media/users/' . $image . '" /> ';
				echo $result_a['fullName'];
				if($result_a['userId'] != 'vel' || $_SESSION['userId'] == 'vel'){
					if($result_a['userId'] != 'vel'){
						echo '<span class="editdelete"><a class="edit" href="javascript:void(0)" onClick=ajaxLoadPage("POST","themes/' . $_SESSION['vpaneltheme'] . '/layout/vPanel/users/editUser.php","' . $result_a['userId'] . '")>edit</a>';
						echo '<a class="delete" href="javascript:void(0)" onClick=deleteUser("' . $result_a["userId"] . '")>delete</a>';
						echo '</span></div>';
					}
				}
			}
		}
		$mysqli->close();
	?>
	
</div>