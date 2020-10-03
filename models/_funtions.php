<?php
/**
 *
 * Implementacion de funciones a utilizar en todo el sistema
 *
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
**/

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
			case '1':
			$estado = 'Administrador';
			break;
			case '2':
			$estado = 'Estilista';
			break;
			case '3':
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

	function stateColorVar5($value){//estado 5 variables
		switch ($value) {
			case 0:
				$estado = 'event-warning';//pendiente
				break;
			case 1:
				$estado = 'event-success';//completado
				break;
			case 2:
				$estado = 'event-important';//Cancelado
				break;
			case 2:
				$estado = 'event-special';//Pospuesto
				break;
			default:
				$estado = 'event-info';
				break;
		}
		return $estado;
	}

	function stateVar5($value){//estado 5 variables
		switch ($value) {
			case 0:
				$estado = 'pendiente';
				break;
			case 1:
				$estado = 'completado';
				break;
			case 2:
				$estado = 'Cancelado';
				break;
			case 2:
				$estado = 'Pospuesto';
				break;
			default:
				$estado = 'No Definido';
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