<?php
	session_start();
	/*if($_SERVER['SERVER_PORT'] != '443'){
		header('Location: https://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
		exit();
	}*/
	include_once 'core/vPanel.php';
	$vPanel = new vPanel;
	$vpanelroot = (string)$vPanel->getRoot();
	$vpaneltheme = (string)$vPanel->getTheme();
	$vpanelversion = (string)$vPanel->getVersion();
	$vpanelorganization = (string)$vPanel->getOrganization();
	$siteUrl = (string)$vPanel->getSiteUrl();
?>
<!DOCTYPE html>
<html lang="en-us">
	<title>vPanel Admin</title>
	<base href="//<?php echo $_SERVER['SERVER_NAME'].'/'.$vpanelroot;?>/">
	<meta charset="utf-8">
	<link rel="stylesheet" href="themes/<?php echo $vpaneltheme;?>/css/styles.css" type="text/css">
	<link rel="stylesheet" href="plugins/css/styles.css" type="text/css">
	<link rel="icon" href="themes/<?php echo $vpaneltheme;?>/graphics/favicon.png" type="image/png"/><link rel="shortcut icon" href="themes/<?php echo $vpaneltheme;?>/graphics/favicon.png" type="image/png"/>
	<meta name="robots" content="noindex">
	<meta name=viewport content="width=device-width, initial-scale=1">
	<?php
		if(!isset($_SESSION['userId'])){
			require_once 'core/user/login.php';
		}else{
			require_once 'themes/'. $vpaneltheme . '/layout/index.php';
		}
	?>
	<!--[if lt IE 9]>
		<script src="//html5shiv.googlecode.com/svn/trunk/html5.js">
		</script>
		<style type="text/css"></style>
	<![endif]-->
	<script src="core/js/jquery-1.7.2.min.js"></script>
	<script src="core/js/functions.js"></script>
</html>