<?php
	include_once dirname(__file__,2).'/models/login.php';

	if(isset($_POST['login']))
	{
		header("content-type: application/javascript");
		$login = new Login();
		if ( $login->validData($_POST) ) {
			echo "window.location.href = '../../';";
		}else{
			if (!empty($login->message)) {
				echo "alert('".$login->message."');";
			}else{
				echo "alert('Usuario y/o contraseña incorrectossss');";
			}
		}
	}

	if(isset($_GET['logout']))
	{
		Login::doLogout();
	}

	
?>