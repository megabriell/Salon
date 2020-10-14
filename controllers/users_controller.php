<?php
	include_once dirname(__file__,2).'/models/user.php';
	$users = new User();
	$contentMessage = '';
	$timeMessage = '';
	$typeMessage = '';//type of menssage: red|green|orange|blue|purple|dark

	//Request: creacion de nuevo usuario
	if(isset($_POST['create']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($users->validData($_POST)){
			$contentMessage = 'El usuario se ha creado correctamente';
			$typeMessage = $users->type;
			echo $_POST['modal'].".modal('hide');";//oculta el modal 
		}else{
			if (!empty($users->message)) {
				$contentMessage = $users->message;
				$typeMessage = $users->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($users->time)? "autoClose: 'Ok|10000'," : '';
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

	//Request: creacion de nuevo usuario
	if(isset($_POST['register']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($users->validData2($_POST)){
			$contentMessage = 'El usuario se ha creado correctamente';
			$typeMessage = $users->type;
		}else{
			if (!empty($users->message)) {
				$contentMessage = $users->message;
				$typeMessage = $users->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($users->time)? "autoClose: 'Ok|10000'," : '';
		echo "$('#userForm').bootstrapValidator('resetForm',true); ";
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

	//Request: editar usuario
	if(isset($_POST['edit']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if( $users->validData($_POST,'edit') ){
			$contentMessage = 'El usuario se ha modificado correctamente';
			if (!empty($users->message)) $contentMessage = $users->message;
			$typeMessage = $users->type;
			echo $_POST['modal'].".modal('hide');";//oculta el modal $('id').modal('hide')
		}else{
			if (!empty($users->message)) {
				$contentMessage = $users->message;
				$typeMessage = $users->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($users->time)? "autoClose: 'Ok|10000'," : '';
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

	//Request: desactiva al usuario
	if(isset($_POST['disable']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($users->disableUser($_POST['id'])){
			$contentMessage = 'El usuario se ha desactivado correctamente';
			$typeMessage = $users->type;
		}else{
			if (!empty($users->message)) {
				$contentMessage = $users->message;
				$typeMessage = $users->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($users->time)? "autoClose: 'Ok|10000'," : '';
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

	//Request: Activa al usuario
	if(isset($_POST['enable']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if( $users->disableUser($_POST['id'],'enable') ){
			$contentMessage = 'El usuario se ha activado correctamente';
			$typeMessage = $users->type;
		}else{
			if (!empty($users->message)) {
				$contentMessage = $users->message;
				$typeMessage = $users->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($users->time)? "autoClose: 'Ok|10000'," : '';
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

	//Request: eliminar usuario
	if(isset($_POST['delete']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($users->deleteUser($_POST['id'])){
			$contentMessage = 'El usuario se ha eliminado correctamente';
			$typeMessage = $users->type;
		}else{
			if (!empty($users->message)) {
				$contentMessage = $users->message;
				$typeMessage = $users->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($users->time)? "autoClose: 'Ok|10000'," : '';
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

	///Request: Otiene datos para tabla respuesta: json
	if ( isset($_POST['getData']) ) {
		header("content-type: application/json");//tipo de respuesta devuelta: javascript
		$rows = $users->getUsers();
	    if ($rows) {
		    $json['data']=[];
	        foreach ( $rows as $row ){
	            $id = $row->Id_Usuario;

	            $btnEdit = '<button type="button" class="btn btn-primary btn-sm" title="Editar usuario" onclick="edit(\''.$id.'\')"> <i class="fa fa-edit"></i> Editar</button>';
	            if ($row->Estado) {
	                $btnDisable = '<button type="button" class="btn btn-default btn-sm" title="Desactivar usuario" onclick="disable(\''.$id.'\')"> <i class="fa fa-times-circle-o"></i> Desactivar</button>';
	            }else{
	                $btnDisable = '<button type="button" class="btn btn-default btn-sm" title="Activar usuario" onclick="enable(\''.$id.'\')"> <i class="fa fa-check-circle-o"></i> Activar</button>';
	            }
	            
	            $label = rolSis($row->Sistema);
	           	            
	            $json['data'][] = [
	                'IdEmpleado'=>$row->Id_Usuario,
	                'nombre'=>$row->Nombre . " " . $row->Apellido,
	                'usuario'=>$row->Usuario,
	                'correo'=>$row->CorreoP,
	                'sistema'=>$label,
	                'boton'=>$btnEdit.' '.$btnDisable
	            ];
	        }
	        echo json_encode($json);
	    }else{
	        echo "{}";
	    }
	}
?>