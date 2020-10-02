<?php
	include_once dirname(__file__,2).'/models/profile.php';
	$user = new Profile();
	$contentMessage = '';
	$timeMessage = '';
	$typeMessage = '';//type of menssage: red|green|orange|blue|purple|dark
	$infoUser = json_decode( $_COOKIE["_data0U"], true);//COOKIE

	//Request: get information of input
	if(isset($_POST['getInf']))
	{	
		header('Content-Type: application/json');
		$json = [];
		$json = $infoUser;
		echo json_encode($json);
	}

	//Request: Update information of user
	if(isset($_POST['update']))
	{	
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if( $user->validData($_POST) ){
			$contentMessage = 'El usuario se ha modificado correctamente. Deberá refrescar la pagina para ver los cambios';
			if (!empty($user->message)) $contentMessage = $user->message;
			$typeMessage = $user->type;
		}else{
			if (!empty($user->message)) {
				$contentMessage = $user->message;
				$typeMessage = $user->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($user->time)? "autoClose: 'Ok|10000'," : '';
		echo "$.alert({
			title: false,
			content: '".$contentMessage."',
			".$timeMessage."
			type: '".$typeMessage."',
			typeAnimated: true,
			buttons: {
				Ok: function () {}
				}
		});";
	}
?>