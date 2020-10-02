<?php
	include_once dirname(__file__,2).'/models/service.php';
	$service = new Service();
	$contentMessage = '';
	$timeMessage = '';
	$typeMessage = '';//type of menssage: red|green|orange|blue|purple|dark

	//Request: creacion de nuevo usuario
	if(isset($_POST['create']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($service->validData($_POST)){
			$contentMessage = 'El registro se ha creado correctamente';
			$typeMessage = $service->type;
			echo $_POST['modal'].".modal('hide');";//oculta el modal 
		}else{
			if (!empty($service->message)) {
				$contentMessage = $service->message;
				$typeMessage = $service->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($service->time)? "autoClose: 'Ok|10000'," : '';
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
		if( $service->validData($_POST,'edit') ){
			$contentMessage = 'El registro se ha modificado correctamente';
			if (!empty($service->message)) $contentMessage = $service->message;
			$typeMessage = $service->type;
			echo $_POST['modal'].".modal('hide');";//oculta el modal $('id').modal('hide')
		}else{
			if (!empty($service->message)) {
				$contentMessage = $service->message;
				$typeMessage = $service->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($service->time)? "autoClose: 'Ok|10000'," : '';
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
		if($service->disableEnable($_POST['id'])){
			$contentMessage = 'El registro se ha desactivado correctamente';
			$typeMessage = $service->type;
		}else{
			if (!empty($service->message)) {
				$contentMessage = $service->message;
				$typeMessage = $service->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($service->time)? "autoClose: 'Ok|10000'," : '';
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
		if( $service->disableEnable($_POST['id'],'enable') ){
			$contentMessage = 'El registro se ha activado correctamente';
			$typeMessage = $service->type;
		}else{
			if (!empty($service->message)) {
				$contentMessage = $service->message;
				$typeMessage = $service->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($service->time)? "autoClose: 'Ok|10000'," : '';
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
		header('Content-Type: application/json');
	    $rows = $service->getServices();
	    if ($rows) {
	        $json['data']=[];
	        foreach ( $rows as $row ){

	            $id = $row->Id_Servicio;

	            $btnEdit = '<button type="button" class="btn btn-primary btn-sm" title="Editar registro" onclick="edit(\''.$id.'\')" id="btn2"> <i class="fa fa-edit"></i> Editar</button>';
	            if ($row->Estado) {
	                $btnDisable = '<button type="button" class="btn btn-default btn-sm" title="Inhabilitar registro" onclick="disable(\''.$id.'\',0)" id="btn3"> <i class="fa fa-times-circle-o"></i> Desactivar</button>';
	            }else{
	                $btnDisable = '<button type="button" class="btn btn-default btn-sm" title="Habilitar registro" onclick="disable(\''.$id.'\',1)" id="btn3"> <i class="fa fa-check-circle-o"></i> Activar</button>';
	            }

	            $json['data'][] = [
	                'ID'=>$row->Id_Servicio,
	                'Col1'=>$row->Descripcion,
	                'Col2'=>$row->Precio,
	                'Col3'=>$row->Costo,
	                'Col4'=> formatHM($row->Duracion),
	                'Col5'=>stateVar2($row->Estado),
	                'btns'=>$btnEdit.' '.$btnDisable
	            ];
	        }
	        echo json_encode($json);
	    }else{
	        echo json_encode($json);
	    }
	}
?>