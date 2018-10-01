<li  class="menu vpanelSettings">
	<img id="vpanelSettings" src="themes/<?php echo $vpaneltheme;?>/graphics/settings.png"/>
	<!--<span class="name">vPanel Admin</span>-->
	<ul class="dropdown">
		<li><a href="javascript:void(0)" onClick="loadPage('themes/<?php echo $vpaneltheme;?>/layout/vPanel/users/editUsers.php')">User Accounts</a></li>
		<li><a href="javascript:void(0)" onClick="loadPage('themes/<?php echo $vpaneltheme;?>/layout/vPanel/accountTypes/editAccountTypes.php')">Account Types</a></li>
		<li><a href="javascript:void(0)" onClick="ajaxLoadPage('POST','themes/<?php echo $vpaneltheme;?>/layout/vPanel/settings/index.php','<?php echo $vpanelversion. "---" .$vpanelorganization. "---" .$siteUrl;?>')">vPanel Info</a></li>
	</ul>
</li>