<?php
	include_once dirname(__file__,2).'/models/tpay.php';
	$pay = new TPay();
	$contentMessage = '';
	$timeMessage = '';
	$typeMessage = '';//type of menssage: red|green|orange|blue|purple|dark

	if(isset($_POST['create']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if($pay->validData($_POST)){
			$contentMessage = 'El registro se ha creado correctamente';
			$typeMessage = $pay->type;
			echo $_POST['modal'].".modal('hide');";//oculta el modal 
		}else{
			if (!empty($pay->message)) {
				$contentMessage = $pay->message;
				$typeMessage = $pay->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($pay->time)? "autoClose: 'Ok|10000'," : '';
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
		if( $pay->validData($_POST,'edit') ){
			$contentMessage = 'El registro se ha modificado correctamente';
			if (!empty($pay->message)) $contentMessage = $pay->message;
			$typeMessage = $pay->type;
			echo $_POST['modal'].".modal('hide');";//oculta el modal $('id').modal('hide')
		}else{
			if (!empty($pay->message)) {
				$contentMessage = $pay->message;
				$typeMessage = $pay->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($pay->time)? "autoClose: 'Ok|10000'," : '';
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
	    $rows = $pay->getTPays();
	    $json['data']=[];
	    if ($rows) {
	        foreach ( $rows as $row ){

	            $id = $row->Id_Tipo_Pago;

	            $btnEdit = '<button type="button" class="btn btn-primary btn-sm" title="Editar registro" onclick="edit(\''.$id.'\')" id="btn_12"> <i class="fa fa-edit"></i> Editar</button>';
	           
	            $json['data'][] = [
	                'ID'=>$id,
	                'Col1'=>$row->Descripcion,
	                'Col2'=>$row->Descuento,
	                'btns'=>$btnEdit
	            ];
	        }
	        echo json_encode($json);
	    }else{
	        echo json_encode($json);
	    }
	}
?>