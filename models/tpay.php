<?php
/**
 * 
 * Clase para obtner de los tipos de pago y agrer un nuevo tipo de pago
 *  
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/

include_once dirname(__file__,2)."/config/conexion.php";
class TPay
{
	private $db;
	private $data;//array of form post
	public $message;//message of result
	public $type;//type of menssage: red|green|orange|blue|purple|dark
	public $time;//set stopwatch

	function __construct()
	{
		$this->db   = new Conexion();
		$this->message = '';
		$this->type = 'green';
		$this->time = true;
		$this->data = array();
	}

	public function getTPays():?array
	{
		$rows = $this->db->get_results("SELECT * FROM tipo_pago ");
		if ( !$rows ) return NULL;
		return $rows;
	}

	public function getTPayById($id):?OBJECT
	{
		if( isIntN($id) ){
			$row = $this->db->get_row("SELECT * FROM tipo_pago
				WHERE Id_Tipo_Pago = '$id' ");
			if (!$row) return NULL;
			return $row;
		}else{
			return NULL;
		}
	}

	//valida que ningun campo este vacio, aplica formato correspondiente a cada campo
	public function validData($post,$option=null):bool 
	{
		if( !empty($option) ){
			if ( empty($post['id']) ) {//valida que el campo Id tenga un valor
				$this->message = '<strong>Error [1006]</strong>: Los datos no fueron procesados correctamente. Notifique el error.';
				$this->type = 'red';
				$this->time = false;
				return false;
			}
			$this->data['Id'] = (isIntN( $post['id']) )? $this->db->escape($post['id']) :'';
		}
		$this->data['descripction'] = ( !empty($post['descripction']) )? camelCase( $this->db->escape($post['descripction']) ) : '' ;
		$this->data['discount'] = ( isset($post['discount']) )? $this->db->escape($post['discount']) : '' ;
		
		foreach ($this->data as $key => $value) {
			if (empty($value)) {
				break;
				$this->message = '<strong>Error [1001]</strong>: Un campo del formulario esta vació o no cumple con el formato correcto. Revise los valores ingresados';
				$this->type = 'red';
				return false;
			}
		}

		if ( !empty($option) ) {
			return $this->editData($this->data);
		}else{
			return $this->newData($this->data) ;
		}
	}

	private function newData($insert):bool
	{
		$query1 = "INSERT INTO tipo_pago
			(Id_Tipo_Pago, Descripcion, Descuento) 
			VALUES
			(NULL,'".$insert['descripction']."','".$insert['discount']."' )";	
		if ( $this->db->query($query1) ) {
			$result = true;
		}else{
			$this->message = '<strong>Error [1003]</strong>: Los datos no fueron guardados debido a un erro interno. Intentelo de nuevo.';
			$this->type = 'red';
			$result = false;
		}
		return $result;
	}

	private function setUpdate($array):bool
	{
		$stored = $this->getTPayById($array['Id']);
		$set =  '';
		if ($stored->Descripcion != $array['descripction']) {
			$set .= "Descripcion = '".$array['descripction']."',";
		}
		if ($stored->Descuento != $array['discount']) {
			$set .= "Descuento = '".$array['discount']."',";
		}
		$set = trim($set, ',');//Elimina el ultimo caracter definido ','
		$this->data = array();//reset array
		$this->data['set'] = $set;

		if ( empty($set) ) {
			return false;
		}else{
			return true;
		}
	}

	private function editData($array):bool
	{
		if( $this->setUpdate($array) ){//verifica si hay cambios para aplicar
				$query0 = "UPDATE tipo_pago  
					SET ".$this->data['set']."
					WHERE Id_Tipo_Pago = '".$array['Id']."' ";
				if($this->db->query($query0)){
					$result = true;
				}else{
					$this->message = '<strong>Error [1003]</strong>: Los datos no fueron guardados debido a un erro interno. Intentelo de nuevo.';
					$this->type = 'red';
					$result = false;
				}
		}else{
			
			$this->message = 'No se ha detectado ningun cambio';
			$this->type = 'orange';
			$result = false;
		}
		return $result;
	}

	private function deleteTPay( $id ):bool
	{
		if ( isIntN($id) ) {
			$query0 = "DELETE FROM tipo_pago WHERE Id_Tipo_Pago = '$id' ";
			if( $this->db->query($query0) ){
				$result = true;
			}else{
				$this->message = '<strong>Error [1003]</strong>: Los datos no fueron guardados debido a un erro interno. Intentelo de nuevo.';
				$this->type = 'red';
				$result = false;
			}
		}else{
			$this->message = '<strong>Error [1006]</strong>: Los datos no fueron procesados correctamente. Notifique el error.';
			$this->type = 'red';
			$this->time = false;
			$result = false;
		}
		return $result;
	}

}
?>