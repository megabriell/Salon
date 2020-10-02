<?php
	include_once dirname(__file__,2).'/models/provider.php';
	$provider = new Provider();
	$contentMessage = '';
	$timeMessage = '';
	$typeMessage = '';//type of menssage: red|green|orange|blue|purple|dark

	if(isset($_POST['create']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($provider->validData($_POST)){
			$contentMessage = 'El registro se ha creado correctamente';
			$typeMessage = $provider->type;
			echo $_POST['modal'].".modal('hide');";//oculta el modal 
		}else{
			if (!empty($provider->message)) {
				$contentMessage = $provider->message;
				$typeMessage = $provider->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($provider->time)? "autoClose: 'Ok|10000'," : '';
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

	if(isset($_POST['edit']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if( $provider->validData($_POST,'edit') ){
			$contentMessage = 'El registro se ha modificado correctamente';
			if (!empty($provider->message)) $contentMessage = $provider->message;
			$typeMessage = $provider->type;
			echo $_POST['modal'].".modal('hide');";//oculta el modal $('id').modal('hide')
		}else{
			if (!empty($provider->message)) {
				$contentMessage = $provider->message;
				$typeMessage = $provider->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($provider->time)? "autoClose: 'Ok|10000'," : '';
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

	if(isset($_POST['disable']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($provider->disableEnable($_POST['id'])){
			$contentMessage = 'El registro se ha desactivado correctamente';
			$typeMessage = $provider->type;
		}else{
			if (!empty($provider->message)) {
				$contentMessage = $provider->message;
				$typeMessage = $provider->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($provider->time)? "autoClose: 'Ok|10000'," : '';
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

	if(isset($_POST['enable']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if( $provider->disableEnable($_POST['id'],'enable') ){
			$contentMessage = 'El registro se ha activado correctamente';
			$typeMessage = $provider->type;
		}else{
			if (!empty($provider->message)) {
				$contentMessage = $provider->message;
				$typeMessage = $provider->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($provider->time)? "autoClose: 'Ok|10000'," : '';
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
	
	if ( isset($_POST['getData']) ) {
		header('Content-Type: application/json');
	    $rows = $provider->getProviders();
	    $json['data']=[];
	    if ($rows) {
	        foreach ( $rows as $row ){

	            $id = $row->Id_Proveedor;

	            $btnEdit = '<button type="button" class="btn btn-primary btn-sm" title="Editar registro" onclick="edit_0(\''.$id.'\')" id="btn_02"> <i class="fa fa-edit"></i> Editar</button>';
	            if ($row->Estado) {
	                $btnDisable = '<button type="button" class="btn btn-default btn-sm" title="Inhabilitar registro" onclick="disable_0(\''.$id.'\',0)" id="btn_03"> <i class="fa fa-times-circle-o"></i> Desactivar</button>';
	            }else{
	                $btnDisable = '<button type="button" class="btn btn-default btn-sm" title="Habilitar registro" onclick="disable_0(\''.$id.'\',1)" id="btn_03"> <i class="fa fa-check-circle-o"></i> Activar</button>';
	            }

	            $json['data'][] = [
	                'ID'=>$id,
	                'Col1'=>$row->Descripcion,
	                'Col2'=>stateVar2($row->Estado),
	                'btns'=>$btnEdit.' '.$btnDisable
	            ];
	        }
	        echo json_encode($json);
	    }else{
	        echo json_encode($json);
	    }
	}
?>