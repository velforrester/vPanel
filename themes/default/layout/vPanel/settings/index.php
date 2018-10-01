<?php
	$data = $_POST['data'];
	$data = explode('---',$data);
?>

<div class="container">
	<div class=" closeback">
		<a href="javascript:void(0)" onClick="closePage()" id="close">close</a>
	</div>
	<h1>vPanel Info</h1>
	<p class="center">This installation of vPanel has been customized for:</p>
	<p class="center"><b><?php echo $data[1];?></b><br/><a href="https://<?php echo $data[2];?>" target="_blank"><?php echo $data[2];?></a></p>
	<p class="center">vPanel&reg; v<?php echo $data[0];?><br/>&copy; <?php echo date('Y');?> <a href="http://www.velforrester.com" target="_blank">Vel Forrester</a></p>
</div>