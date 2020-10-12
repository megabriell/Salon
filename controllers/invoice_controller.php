<?php
/**
 * 
 * Controlador para la clase de facturacion
 *  
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/
	include_once dirname(__file__,2).'/models/invoice.php';
	include_once dirname(__file__,2).'/models/_cache.php';
	session_start();
	$factura = new Invoice();
	$cache = new Cache();

	$contentMessage = '';
	$timeMessage = '';
	$typeMessage = '';//type of menssage: red|green|orange|blue|purple|dark
	$time = 600;//10min en sugundos
	$idUser = $_SESSION['Id_Empleado'];
	$nameFile = $idUser.'_'.date("dmY");
	//$infoUser = json_decode( $_COOKIE["_data0U"],true);

	/*if ($dato !== end($datos)) {
						$values .= ",";
					}*/
	if ( isset($_POST['additem']) ) {
		$result = true;
		$store = $cache->readCache($nameFile,$time);
	    $array = ( $store )? $store : [];
	    if ( (isIntN($_POST['additem']) || $_POST['additem']==0) && !empty($_POST['tItem']) && !empty($_POST['dItem']) && !empty($_POST['qItem']) && !empty($_POST['pItem']) ) {
	    	$array[$_POST['additem']] = [
	    		'type'=>$_POST['tItem'],
                'idItem'=>$_POST['dItem'],
                'quantity'=>$_POST['qItem'],
                'price'=>$_POST['pItem'],
            ];
            $cache->addCache($nameFile,$array);
	    }else{
	    	$result = false;
	    }
	    echo $result;
	}

	if ( isset($_POST['delitem']) ) {
		$result = true;
		$store = $cache->readCache($nameFile,$time);
	    $array = ( $store )? $store : [];
	    if ( (isIntN($_POST['delitem']) || $_POST['delitem'] == 0) && $store ) {
	    	$index = (int)$_POST['delitem'];
	    	unset($array[$index]);
            $cache->addCache($nameFile,$array);
	    }else{
	    	$result = false;
	    }
	    echo $result;
	}

	if ( isset($_POST['clear']) ) {
		$result = $cache->clear($nameFile);
		echo $result;
	}

	if(isset($_POST['removeItem']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		if( $factura->deleteItem($_POST['id'],$_POST['item'],$_POST['type']) ){
			$contentMessage = 'El registro se ha eliminado correctamente';
			$typeMessage = $factura->type;
		}else{
			if (!empty($factura->message)) {
				$contentMessage = $factura->message;
				$typeMessage = $factura->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($factura->time)? "autoClose: 'Ok|10000'," : '';
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



	if ( isset($_POST['autocomplet']) ) {
		header('Content-Type: application/json');
		$json=[];
		if ( !empty($_POST['item']) && !empty($_POST['type']) ) {
			$rows = '';
			if ($_POST['type'] == 1) {
				include_once dirname(__file__,2).'/models/product.php';
				$producto = new Product();
				$rows = $producto->getProductByDesc($_POST['item']);
				if ($rows) {
					foreach ($rows as $value) {
						$json[] = [
			                'ID'=>$value->Id_Producto,
			                'Val1'=>$value->Descripcion .' - '.$value->Categoria,
			                'Val2'=>$value->Precio
			            ];
			        }
			    }else{
			    	$json[] = [
			    		'ID'=>"",
			    		'Val1'=>"No se ha encontrado un resultado coincidente",
			    		'Val2'=>""
			    	];
			    }
			}elseif ($_POST['type'] == 2) {
				include_once dirname(__file__,2).'/models/service.php';
				$servicio = new Service();
				$rows = $servicio->getServiceByDesc($_POST['item']);
				if ($rows) {
					foreach ($rows as $value) {
						$json[] = [
			                'ID'=>$value->Id_Servicio,
			                'Val1'=>$value->Descripcion,
			                'Val2'=>$value->Precio
			            ];
			        }
			    }else{
			    	$json[] = [
			    		'ID'=>"",
			    		'Val1'=>"No se ha encontrado un resultado coincidente",
			    		'Val2'=>""
			    	];
			    }
			}
		}else{
			$json[] = [
				'ID'=>"",
				'Val1'=>"Seleccione tipo de articulo :(",
				'Val2'=>""
			];
		}
		echo json_encode($json);
	}



	if(isset($_POST['create']))
	{
		header("content-type: application/javascript");//tipo de respuesta devuelta: javascript
		$read = $cache->readCache($nameFile,$time);
		$store = ($read)? $read:[];
		if (!empty($store)) {
			if( $factura->validData($_POST,$store) ){
				$cache->clear($nameFile);
				$contentMessage = 'El registro se ha creado correctamente';
				$typeMessage = $factura->type;
				echo $_POST['modal'].".modal('hide');";//oculta el modal 
			}else{
				if (!empty($factura->message)) {
					$contentMessage = $factura->message;
					$typeMessage = $factura->type;
				}else{
					$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
					$typeMessage = 'red';
				}
			}
		}else{
			echo $_POST['modal'].".modal('hide');";//oculta el modal 
			$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
			$typeMessage = 'red';
		}
		$timeMessage = ($factura->time)? "autoClose: 'Ok|10000'," : '';
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
		$read = $cache->readCache($nameFile,$time);
		$store = ($read)? $read:'';
		if( $factura->validData($_POST,$store,'edit') ){
			$cache->clear($nameFile);
			$contentMessage = 'El registro se ha creado correctamente';
			$typeMessage = $factura->type;
			echo $_POST['modal'].".modal('hide');";//oculta el modal 
		}else{
			if (!empty($factura->message)) {
				$contentMessage = $factura->message;
				$typeMessage = $factura->type;
			}else{
				$contentMessage = '<strong>Error [1005]</strong>: se produjo un error al procesar los datos. Intentelo de nuevo.';
				$typeMessage = 'red';
			}
		}
		$timeMessage = ($factura->time)? "autoClose: 'Ok|10000'," : '';
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
	    $rows = $factura->getInvoices();
	    $json['data']=[];
	    if ($rows) {
	        foreach ( $rows as $row ){

	            $id = $row->Id_Enca_Factura;

	            $btnEdit = '<button type="button" class="btn btn-primary btn-sm" title="Editar registro" onclick="edit(\''.$id.'\')" id="btn2"> <i class="fa fa-edit"></i> Editar</button>
	            	<button type="button" class="btn btn-success btn-sm" title="Ver registro" onclick="view(\''.$id.'\')" id="btn2"> <i class="fa fa-eye"></i> Ver</button>
	            	';

	            $json['data'][] = [
	                'ID'=>$id,
	                'Col1'=>$row->Cliente,
	                'Col2'=>$row->Descripcion,
	                'Col3'=>['display'=>formatDateTime($row->Fecha,'d/m/Y'),'order'=>strtotime($row->Fecha)],
	                'Col4'=> $row->Total,
	                'btns'=>$btnEdit
	            ];
	        }
	        echo json_encode($json);
	    }else{
	        echo json_encode($json);
	    }
	}