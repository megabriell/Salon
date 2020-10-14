<?php
	include_once dirname(__file__,2).'/models/reserve.php';
	session_start();
	$reserve = new Reserve();
	$contentMessage = '';
	$timeMessage = '';
	$typeMessage = '';//type of menssage: red|green|orange|blue|purple|dark
	$infoUser = json_decode( $_COOKIE["_data0U"],true);

	if(isset($_POST['create']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		$_POST['client'] = $_SESSION['Id_Empleado'];
		if($reserve->validData($_POST)){
			$contentMessage = 'El registro se ha creado correctamente';
			$typeMessage = $reserve->type;
			echo $_POST['modal'].".modal('hide');";//oculta el modal 
		}else{
			if (!empty($reserve->message)) {
				$contentMessage = $reserve->message;
				$typeMessage = $reserve->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($reserve->time)? "autoClose: 'Ok|10000'," : '';
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
		if( $reserve->validData($_POST,'edit') ){
			$contentMessage = 'El registro se ha modificado correctamente';
			if (!empty($reserve->message)) $contentMessage = $reserve->message;
			$typeMessage = $reserve->type;
			echo $_POST['modal'].".modal('hide');";//oculta el modal $('id').modal('hide')
		}else{
			if (!empty($reserve->message)) {
				$contentMessage = $reserve->message;
				$typeMessage = $reserve->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($reserve->time)? "autoClose: 'Ok|10000'," : '';
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

	if(isset($_POST['canceled']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($reserve->changeState($_POST['id'],2)){
			$contentMessage = 'El registro se ha cancelado correctamente';
			$typeMessage = $reserve->type;
		}else{
			if (!empty($reserve->message)) {
				$contentMessage = $reserve->message;
				$typeMessage = $reserve->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($reserve->time)? "autoClose: 'Ok|10000'," : '';
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

	if(isset($_POST['completed']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if( $reserve->changeState($_POST['id'],1) ){
			$contentMessage = 'El registro se ha finalizado correctamente';
			$typeMessage = $reserve->type;
		}else{
			if (!empty($reserve->message)) {
				$contentMessage = $reserve->message;
				$typeMessage = $reserve->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($reserve->time)? "autoClose: 'Ok|10000'," : '';
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
		$idReserva = ($_SESSION['Id_Empleado'] != 1)?$_SESSION['Id_Empleado']:'';
	    $rows = $reserve->getReserve($idReserva);
	    $json['data']=[];
	    if ($rows) {
	        foreach ( $rows as $row ){
	        	$btnDisable = '';
	        	$btnEdit = '';
	            $id = $row->Id_Reserva;
	            if ($row->Estado == 0) {
	           		$btnEdit = '<button type="button" class="btn btn-danger btn-sm" title="Cancelar Reserva" onclick="cancel(\''.$id.'\')"> <i class="fa fa-ban"></i> Cancelar</button>';
	           	}
	           	
	            if ($infoUser['sistema'] != 3) {
		            if ($row->Estado == 0) {
		                $btnDisable = '<button type="button" class="btn btn-success btn-sm" title="Finalizar reserva" onclick="complete(\''.$id.'\',0)"> <i class="fa fa-check"></i> Finalizar</button>';
		            }
		        }

	            $json['data'][] = [
	                'ID'=>$id,
	                'Col1'=>$row->Cliente,
	                'Col2'=>$row->Descripcion,
	                'Col3'=>$row->Cantidad,
	                'Col4'=>['display'=>formatDateTime($row->Fecha,'d/m/Y'),'order'=>strtotime($row->Fecha)],
	                'Col5'=>reserveVar2($row->Estado),
	                'btns'=>$btnEdit.$btnDisable
	            ];
	        }
	        echo json_encode($json);
	    }else{
	        echo json_encode($json);
	    }
	}
?>