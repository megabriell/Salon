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
	session_start();
	$factura = new Invoice();

	$contentMessage = '';
	$timeMessage = '';
	$typeMessage = '';//type of menssage: red|green|orange|blue|purple|dark
	$idUser = $_SESSION['Id_Empleado'];
	//$infoUser = json_decode( $_COOKIE["_data0U"],true);

	if ( isset($_POST['getData']) ) {
		header('Content-Type: application/json');
	    $rows = $factura->getInvoicesByStylist($_SESSION['Id_Empleado']);
	    $json['data']=[];
	    if ($rows) {
	        foreach ( $rows as $row ){
	            $id = $row->Id_Enca_Factura;
	            $reward = $row->Propina;
	            $percent = 0;
	            if ( !empty($row->Descuento) ) {
	            	$discount = explode("%", $row->Descuento);
	            	$percent = $discount[0];
	            }
	            $disReward = ( (($reward*1)*($percent*1))/100 );

	            $btnEdit = '<button type="button" class="btn btn-success btn-sm" title="Ver registro" onclick="view(\''.$id.'\')" id="btn2"> <i class="fa fa-eye"></i> Ver</button>
	            	';

	            $json['data'][] = [
	                'ID'=>$id,
	                'Col1'=>$row->Cliente,
	                'Col2'=>['display'=>formatDateTime($row->Fecha,'d/m/Y'),'order'=>strtotime($row->Fecha)],
	                'Col3'=>'Q '.$row->Total,
	                'Col4'=>$row->Descripcion,
	                'Col5'=> ($reward-$disReward),
	                'btns'=>$btnEdit
	            ];
	        }
	        echo json_encode($json);
	    }else{
	        echo json_encode($json);
	    }
	}