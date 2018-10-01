<?php
	if($_SESSION['background'] != NULL){
		echo "<style> body {background:url('media/users/" . $_SESSION['background'] . "') !important; background-repeat: no-repeat !important; background-attachment: fixed !important; background-position: center !important; background-size: cover !important;}</style>";
	}
?>
<header>
	<div class="vpLogo">
		<a href=""><img src="themes/<?php echo $_SESSION['vpaneltheme'];?>/graphics/vPanelLogo.png" class="icon" alt="vPanel by Vel Forrester" /></a>
	</div>
	<ul class="icons">
		
		<?php include 'plugins/index.php';?>
		
	</ul>
	<ul class="account">
		
		<?php if($_SESSION['admin'] == 0){
			include 'themes/'. $_SESSION['vpaneltheme'] .'/layout/vPanel/index.php';
			}
		?>
		
		<li class="menu profile">
			<span class="name"><?php echo $_SESSION['fullName']; ?> &nbsp; </span>
			<img src="media/users/<?php echo $_SESSION['image'];?>" class="profileIcon icon logout" />
			<ul class="dropdown">
				<li><a href="javascript:void(0)" onClick=ajaxLoadPage("POST","themes/<?php echo $_SESSION['vpaneltheme'];?>/layout/vPanel/users/editUser.php","<?php echo $_SESSION['userId'];?>")>Account Settings</a></li>
				<li><a href="core/user/logout.php">Log Out</a></li>
			</ul>
		</li>
	</ul>
</header>