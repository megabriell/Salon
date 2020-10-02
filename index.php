<?php
	include_once './config/Conexion.php';
	$_session = Conexion::session();
	if(  !$_session )echo '<script type="text/javascript">window.location.href = "./views/login/login";</script>';
	
	$infoUser = json_decode( $_COOKIE["_data0U"],true);
	$infoCompany = json_decode( $_COOKIE["_data1C"],true);
	
	include 'views/template/header.php';

	echo '<div id="contentBody">';
	echo '</div>';
	echo '<script type="text/javascript">
		$.post("./views/home/home").done(function( data ){$("#contentBody").html(data)});
	</script>';
	
	include 'views/template/footer.php';
