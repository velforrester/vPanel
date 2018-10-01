<?php session_start();?>
<div class="container">
	<div class=" closeback">
		<a href="javascript:void(0)" onClick="closePage()" id="close">close</a>
	</div>
	<h1>Edit Account Types</h1>
	<p>Account types can be used to control the privelages of specific user groups.</p>
	<p class="italic">* The administrator account type has full privelages and can not be edited.</p>
	<p><span class="bold">Account types:</span> &nbsp; <a class="create" href="javascript:void(0)" onClick="loadPage('themes/<?php echo $_SESSION['vpaneltheme']?>/layout/vPanel/accountTypes/createAccountType.php')"></a></p>
	
	<?php
		$query = "SELECT * FROM account_types";
		$query = str_replace("\'","",$query);
		require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $_SESSION['vpanelroot'] . '/core/database/db_connect.php';
		if($result = $mysqli->query($query)){
			while($result_a = mysqli_fetch_assoc($result)){
				$htmlname = $result_a['name'];
				$htmlname = str_replace(' ','&nbsp;', $htmlname);
				if($result_a['name'] != 'Administrator'){
					echo '<div class="accounttypelist">' . $result_a['name'];
					echo '<span class="editdelete"><a class="edit" href="javascript:void(0)" onClick=ajaxLoadPage("POST","themes/'. $_SESSION['vpaneltheme'] . '/layout/vPanel/accountTypes/editAccountType.php","' . $result_a['id'] . '")>edit</a>';
					echo '<a class="delete" href="javascript:void(0)" onClick=deleteAccountType("' . $result_a["id"] . '","' . $htmlname . '")>delete</a></span></div>';	
				}
			}
		}else{
			echo 'error getting account types';
		}
		$mysqli->close();
	?>

</div>