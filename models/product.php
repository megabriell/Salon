<?php
/**
 * 
 * Clase para obtner informacion de productos y agregar un nuevo producto
 *  
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/

include_once dirname(__file__,2)."/config/conexion.php";
class Product
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

	public function getProductsAct():?array
	{
		$rows = $this->db->get_results("SELECT T0.Id_Producto, T0.Descripcion, T0.Costo, T0.Precio, T0.Stock, T0.Estado,
			T1.Descripcion AS Categoria,
			T2.Descripcion AS Proveedor
			FROM producto T0
			INNER JOIN categoria T1 ON (T1.Id_Categoria = T0.Id_Categoria)
			INNER JOIN proveedor T2 ON (T2.Id_Proveedor = T0.Id_Proveedor)
			WHERE Estado = 1 ");
		if ( !$rows ) return NULL;
		return $rows;
	}

	public function getProducts():?array
	{
		$rows = $this->db->get_results("SELECT T0.Id_Producto, T0.Descripcion, T0.Costo, T0.Precio, T0.Stock, T0.Estado,
			T1.Descripcion AS Categoria,
			T2.Descripcion AS Proveedor
			FROM producto T0
			INNER JOIN categoria T1 ON (T1.Id_Categoria = T0.Id_Categoria)
			INNER JOIN proveedor T2 ON (T2.Id_Proveedor = T0.Id_Proveedor) ");
		if ( !$rows ) return NULL;
		return $rows;
	}

	public function getProductById($id):?OBJECT
	{
		if( isIntN($id) ){
			$row = $this->db->get_row("SELECT * FROM producto
				WHERE Id_Producto = '$id' ");
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
			if ( empty($post['id_2']) ) {//valida que el campo Id tenga un valor
				$this->message = '<strong>Error [1006]</strong>: Los datos no fueron procesados correctamente. Notifique el error.';
				$this->type = 'red';
				$this->time = false;
				return false;
			}
			$this->data['Id'] = (isIntN( $post['id_2']) )? $this->db->escape($post['id_2']) :'';
		}
		
		$this->data['descripction'] = ( !empty($post['descripction_2']) )? camelCase( $this->db->escape($post['descripction_2']) ) : '' ;
		$this->data['IdCategory'] = ( !empty($post['category']) )? $this->db->escape($post['category']) : '';
		$this->data['IdProvider'] = ( !empty($post['provider']) )? $this->db->escape($post['provider']) : '';
		$this->data['cost'] = ( !empty($post['cost']) )? $this->db->escape($post['cost']) : '';
		$this->data['price'] = ( !empty($post['price']) )? $this->db->escape($post['price']) : '';
		$this->data['stock'] = ( !empty($post['stock']) )? $this->db->escape($post['stock']) : '';
		
		foreach ($this->data as $key => $value) {
			if (empty($value)) {
				break;
				$this->message = '<strong>Error [1001]</strong>: Un campo del formulario esta vació o no cumple con el formato correcto. Revise los valores ingresados';
				$this->type = 'red';
				return false;
			}
		}
		if (isset($post['state_2'])) {
			$this->data['state'] = ( $post['state_2'] )? 1 : 0;
		}

		if ( !empty($option) ) {
			return $this->editData($this->data); //Update User
		}else{
			return $this->newData($this->data) ;//New User
		}
	}

	private function newData($insert):bool
	{
		$query1 = "INSERT INTO producto
			(Id_Producto, Id_Categoria, Id_Proveedor, Descripcion, Costo, Precio, Stock, Estado) 
			VALUES
			(NULL,'".$insert['IdCategory']."','".$insert['IdProvider']."','".$insert['descripction']."','".$insert['cost']."','".$insert['price']."','".$insert['stock']."', '1' )";	
		if ( $this->db->query($query1) ) {//guarda informacion de empleado
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
		$stored = $this->getProductById($array['Id']);
		$set =  '';

		if ($stored->Descripcion != $array['descripction']) {
			$set .= "Descripcion = '".$array['descripction']."',";
		}
		if ($stored->Id_Categoria != $array['IdCategory']) {
			$set .= "Id_Categoria = '".$array['IdCategory']."',";
		}
		if ($stored->Id_Proveedor != $array['IdProvider']) {
			$set .= "Id_Proveedor = '".$array['IdProvider']."',";
		}
		if ($stored->Precio != $array['price']) {
			$set .= "Precio = '".$array['price']."',";
		}
		if ($stored->Costo != $array['cost']) {
			$set .= "Costo = '".$array['cost']."',";
		}
		if ($stored->Stock != $array['stock']) {
			$set .= "Stock = '".$array['stock']."',";
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
				$query0 = "UPDATE producto  
					SET ".$this->data['set']."
					WHERE Id_Producto = '".$array['Id']."' ";
				if($this->db->query($query0)){
					$result = true;
				}else{
					$this->message = '<strong>Error [1003]</strong>: Los datos no fueron guardados debido a un erro interno. Intentelo de nuevo.';
					$this->type = 'red';
					$result = false;
				}
				//$this->db->debug();
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
			$query0 = "DELETE FROM producto WHERE Id_Producto = '$id' ";
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
			$query0 = "UPDATE producto 
				SET Estado = $state
				WHERE Id_Producto = '$id' ";
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