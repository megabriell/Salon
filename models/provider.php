<?php
/**
 * 
 * Clase para obtner informacion de proveedor registrados para productos y administrar tabla de proveedore
 *  
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/

include_once dirname(__file__,2)."/config/conexion.php";
class Provider
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

	public function getProvidersAct():?array
	{
		$rows = $this->db->get_results("SELECT * FROM proveedor WHERE Estado = 1 ");
		if ( !$rows ) return NULL;
		return $rows;
	}

	public function getProviders():?array
	{
		$rows = $this->db->get_results("SELECT * FROM proveedor ");
		if ( !$rows ) return NULL;
		return $rows;
	}

	public function getProviderById($id):?OBJECT
	{
		if( isIntN($id) ){
			$row = $this->db->get_row("SELECT * FROM proveedor
				WHERE Id_Proveedor = '$id' ");
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
			if ( empty($post['id_0']) ) {//valida que el campo Id tenga un valor
				$this->message = '<strong>Error [1006]</strong>: Los datos no fueron procesados correctamente. Notifique el error.';
				$this->type = 'red';
				$this->time = false;
				return false;
			}
			$this->data['Id'] = (isIntN( $post['id_0']) )? $this->db->escape($post['id_0']) :'';
		}
		$this->data['descripction'] = ( !empty($post['descripction_0']) )? camelCase( $this->db->escape($post['descripction_0']) ) : '' ;
		
		foreach ($this->data as $key => $value) {
			if (empty($value)) {
				break;
				$this->message = '<strong>Error [1001]</strong>: Un campo del formulario esta vació o no cumple con el formato correcto. Revise los valores ingresados';
				$this->type = 'red';
				return false;
			}
		}
		if (isset($post['state_0'])) {
			$this->data['state'] = ( $post['state_0'] )? 1 : 0;
		}

		if ( !empty($option) ) {
			return $this->editData($this->data); //Update User
		}else{
			return $this->newData($this->data) ;//New User
		}
	}

	private function newData($insert):bool
	{
		$query1 = "INSERT INTO proveedor
			(Id_Proveedor, Descripcion, Estado) 
			VALUES
			(NULL,'".$insert['descripction']."','1' )";	
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
		$stored = $this->getProviderById($array['Id']);
		$set =  '';

		if ($stored->Descripcion != $array['descripction']) {
			$set .= "Descripcion = '".$array['descripction']."',";
		}
		if ($stored->Estado != $array['state']) {
			$set .= "Estado = '".$array['state']."',";
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
				$query0 = "UPDATE proveedor  
					SET ".$this->data['set']."
					WHERE Id_Proveedor = '".$array['Id']."' ";
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

	private function deleteUser( $id ):bool
	{
		if ( isIntN($id) ) {
			$query0 = "DELETE FROM proveedor WHERE Id_Proveedor = '$id' ";
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

	public function disableEnable($id,$option=null):bool
	{
		if ( isIntN($id) ) {
			$state = ( !empty($option) )? 1 : 0 ;
			$query0 = "UPDATE proveedor 
				SET Estado = $state
				WHERE Id_Proveedor = '$id' ";
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