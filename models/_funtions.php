<?php
/**
 *
 * Implementacion de funciones a utilizar en todo el sistema
 *
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
**/
	
	function sumMDate($dataTime, $time):String //Date ad time to sum
	{
		$result = '';
		if ( !empty($dataTime) && !empty($time) ) {
			$times = explode(":", $time);//split string
			$addMinutes = ( ($times[0]*60)+ ($times[1]*1) );//convert hour in minutes
			$date = new DateTime($dataTime);
			$date->add(new DateInterval('PT' . $addMinutes . 'M'));
			$result = $date->format('Y-m-d H:i:s');
		}
		return $result;
	}

	function formatDateTime($dataTime, $format):String //Date ad time to sum
	{
		$result = '';
		if ( !empty($dataTime) && !empty($format) ) {
			$date = new DateTime($dataTime);
	    	$result = $date->format($format);
		}
		return $result;
	}

	function isAlphanumeric($string):bool
	{
		if(empty($string)){
			return false;
		}else{
			if( !is_string($string) ){
				return false;
			}else{
				return true;
			}
		}
	}

	function isIntN($int):bool
	{
		if( empty($int) ){ 
			return false; 
		}else{
			if( !is_numeric($int) || $int <= 0 ){ 
				return false;
			}else{
				return true;
			}
		}
	}

	function rolSis($value){
		switch ($value) {
			case 1:
			$estado = 'Administrador';
			break;
			case 2:
			$estado = 'Estilista';
			break;
			case 3:
			$estado = 'Cliente';
			break;
			default:
			$estado = 'No Definido';
			break;
		}
		return $estado;
	}

	function stateVar2($value){//estado 2 variables
		switch ($value) {
			case 0:
			$estado = 'Inactivo';
			break;
			case 1:
			$estado = 'Activo';
			break;
			default:
			$estado = 'No Definido';
			break;
		}
		return $estado;
	}

	function reserveVar2($value){//estado 2 variables
		switch ($value) {
			case 0:
			$estado = 'Pendiente a facturar';
			break;
			case 1:
			$estado = 'Facturado';
			break;
			case 2:
			$estado = 'Cancelado';
			break;
			default:
			$estado = 'No Definido';
			break;
		}
		return $estado;
	}

	function itemVar2($value){//Tipo articulo 2 variables
		switch ($value) {
			case 1:
			$estado = 'Producto';
			break;
			case 2:
			$estado = 'Servicio';
			break;
			default:
			$estado = 'No Definido';
			break;
		}
		return $estado;
	}

	function stateColorVar5($value){//estado 5 variables
		switch ($value) {
			case 0:
				$estado = 'event-info';//pendiente
				break;
			case 1:
				$estado = 'event-special';//Pospuesto
				break;
			case 2:
				$estado = 'event-success';//completado
				break;
			case 3:
				$estado = 'event-important';//Cancelado
				break;
			default:
				$estado = 'event-warning';//No definido
				break;
		}
		return $estado;
	}

	function stateVar5($value){//estado 5 variables
		switch ($value) {
			case 0:
				$estado = 'Pendiente';
				break;
			case 1:
				$estado = 'Pospuesto';
				break;
			case 2:
				$estado = 'Completado';
				break;
			case 3:
				$estado = 'Cancelado';
				break;
			default:
				$estado = 'No Definido';
				break;
		}
		return $estado;
	}

	function textColor($value){//estado 5 variables
		switch ($value) {
			case 0:
				$estado = '#1e90ff';//pendiente
				break;
			case 1:
				$estado = '#ffe6ff';//Pospuesto
				break;
			case 2:
				$estado = '#006400';//completado
				break;
			case 3:
				$estado = '#ad2121';//Cancelado
				break;
			default:
				$estado = '#e3bc08';//No definido
				break;
		}
		return $estado;
	}

	function formatHM($value){
		$result = new DateTime($value);
		return $result->format('H:i');
	}

	function FormatoNumero($value){
		$value = number_format($value,"2",".",",");
		return $value;
	}

	function FormatoFecha($valor){
		$valor = date('d/m/Y', strtotime($valor));
		return $valor;
	}

	function FormatoFechaHora($valor){
	    $valor = date('d/m/Y - H:m:s', strtotime($valor));
	    return $valor;
	}
	
	function DiasVencido($inicio,$final){
		$dteStart = new DateTime($inicio);
		$dteEnd = new DateTime($final);
		$dteDiff  = $dteEnd->diff($dteStart);

		return $dteDiff->format('%R%a');
	}


	function DiferenciaDias($inicio,$final){
		$label = '';
		$dteStart = new DateTime($inicio);
		$dteEnd = new DateTime($final);
		$dteDiff  = $dteEnd->diff($dteStart);
		if ( $dteDiff->y > 0 ) {
			if ($dteDiff->y == 1) {
				$label .= $dteDiff->y.' año, ';
			}else{
				$label .= $dteDiff->y.' años, ';
			}
		}

		if ($dteDiff->m == 1) {
			$label .= $dteDiff->m.' mes, ';
		}else{
			$label .= $dteDiff->m.' meses, ';
		}

		if ($dteDiff->d == 1) {
			$label .= $dteDiff->d.' dia';
		}else{
			$label .= $dteDiff->d.' dias';
		}

		return $label;
	}

	/* #########################	Formato de texto 	########################### */
	function lowerCase($value)//Texto en minusculas (hola mundo)
	{
		return mb_strtolower($value);
	}

	function upperCase($value)//Texto en mayuscula (HOLA MUNDO)
	{
		return strtoupper($value);
	}

	function camelCase($value)//Primera letra de cada palabra en mayuscula (Hola Mundo)
	{
		return ucwords(mb_strtolower($value), "./- \t\r\n\f\v");
	}

	function sentenceCase($value)//Primera letra en mayuscula (Hola mundo)
	{
		return ucfirst(mb_strtolower($value));
	}
	/* #########################	Formato de texto 	########################*/

?>