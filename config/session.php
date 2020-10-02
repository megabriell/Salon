<?php
	require_once dirname(__file__,2).'/config/Conexion.php';
	$href = $_SERVER['SERVER_NAME'];
	if(  !Conexion::session() )
		echo '<script type="text/javascript">window.location.href = "http://'.$href.'/views/login/login";</script>';
?>