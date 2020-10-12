<?php
/**
 * 
 * Clase para obtner informacion de facturas guardadas y crear nueva factura
 *  
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/

include_once dirname(__file__,2)."/config/conexion.php";
class Invoice
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

	public function getInvoices():?array
	{
		
		$rows = $this->db->get_results("SELECT T0.Id_Enca_Factura, T0.Id_Tipo_Pago, T0.Id_cliente,
			T0.Id_Employee, T0.Fecha, T0.Total, T1.Descripcion,
			CONCAT(T2.Nombre, ' ',T2.Apellido) AS Cliente
			FROM enca_factura T0
			INNER JOIN tipo_pago T1 ON (T1.Id_Tipo_Pago = T0.Id_Tipo_Pago )
			INNER JOIN usuario T2 ON (T2.Id_Usuario = T0.Id_cliente) ");
		if ( !$rows ) return NULL;
		return $rows;
	}

	public function getInvoicesByStylist($id):?array
	{
		if( isIntN($id) ){
			$rows = $this->db->get_results("SELECT T0.Id_Enca_Factura, T0.Id_Tipo_Pago, T0.Id_cliente, T0.Fecha, T0.Total, T0.Propina, T1.Descripcion, T1.Descuento,
				CONCAT(T2.Nombre, ' ',T2.Apellido) AS Cliente
				FROM enca_factura T0
				INNER JOIN tipo_pago T1 ON (T1.Id_Tipo_Pago = T0.Id_Tipo_Pago )
				INNER JOIN usuario T2 ON (T2.Id_Usuario = T0.Id_cliente)
				WHERE T0.Id_Employee = '$id'
				AND MONTH(T0.Fecha) = MONTH(CURRENT_DATE()) ");
			if ( !$rows ) return NULL;
			return $rows;
		}else{
			return NULL;
		}
	}

	public function getInvoiceById($id):?OBJECT
	{
		if( isIntN($id) ){
			$row = $this->db->get_row("SELECT T0.Id_Enca_Factura, T0.Id_Tipo_Pago, T0.Id_cliente,
				T0.Id_Employee, T0.Fecha, T0.Total, T0.Propina, T0.Descuento, T0.Comentario
				FROM enca_factura T0
				WHERE T0.Id_Enca_Factura = '$id' ");
			if (!$row) return NULL;
			return $row;
		}else{
			return NULL;
		}
	}

	public function getItemsById($id):?array
	{
		if( isIntN($id) ){
			$row = $this->db->get_results("SELECT T0.Id_Enca_Factura, T0.Tipo_Articulo, T0.Id_Articulo, T0.Precio, T0.Cantidad
				FROM detalle_factura T0
				WHERE T0.Id_Enca_Factura = '$id' ");
			if (!$row) return NULL;
			return $row;
		}else{
			return NULL;
		}
	}
	
	//valida que ningun campo este vacio, aplica formato correspondiente a cada campo
	public function validData($post,$row=null,$option=null):bool 
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
		$this->data['pay'] = ( isIntN($post['tpay']) )? $this->db->escape($post['tpay']) : '' ;
		$this->data['client'] = ( isIntN($post['client']) )? $this->db->escape($post['client']) : '' ;
		if ( !empty($post['dateInv']) ) {
			$d = $this->db->escape($post['dateInv']);
			$this->data['date'] =  DateTime::createFromFormat("d/m/Y", $d)->format('Y-m-d');
		}else{
			$this->data['date'] = '';
		}
		$this->data['total'] = ( !empty($post['total']) )? $this->db->escape($post['total']) : '';
		$this->data['discount'] = ( !empty($post['discount']) )? $this->db->escape($post['discount']) : 0;
		$this->data['reward'] = ( !empty($post['reward']) )? $this->db->escape($post['reward']) : 0;
		
		foreach ($this->data as $key => $value) {
			if (empty($value)) {
				break;
				$this->message = '<strong>Error [1001]</strong>: Un campo del formulario esta vació o no cumple con el formato correcto. Revise los valores ingresados';
				$this->type = 'red';
				return false;
			}
		}

		$this->data['stylist'] = ( !empty($post['stylist']) )? $this->db->escape($post['stylist']) : 0;
		$this->data['commentary'] = ( !empty($post['comment']) )? $this->db->escape($post['comment']) :'';

		if ( !empty($option) ) {
			return $this->editData($this->data,$row); //Update User
		}else{
			return $this->newData($this->data,$row) ;//New User
		}
	}

	private function newData($insert,$items):bool
	{
		$detail = '';
		$UpStock = '';
		$query0 = "INSERT INTO enca_factura
			(Id_Enca_Factura, Id_Tipo_Pago, Id_cliente, Id_Employee, DIngreso, Fecha, Total, Propina, Descuento, Comentario, Estado) 
			VALUES
			(NULL,'".$insert['pay']."','".$insert['client']."','".$insert['stylist']."',NOW(), '".$insert['date']."', '".$insert['total']."', '".$insert['reward']."', '".$insert['discount']."', '".$insert['commentary']."',  '1' )";	
		if ( $this->db->query($query0) ) {//guarda informacion de empleado

			$Last_Id = $this->db->insert_id;//Obtinee Id de producto ingresado
			foreach ($items as $value) {
				$detail .= "(NULL,'".$Last_Id."','".$value['type']."','".$value['idItem']."','".$value['price']."','".$value['quantity']."' ),";
				if ($value['type'] == 1) {
					$UpStock .= "UPDATE producto SET Stock = (Stock-".$value['quantity'].") 
						WHERE Id_Producto = '".$value['idItem']."' ;";
				}
			}
			$detail = trim($detail, ',');//Elimina el ultimo caracter definido ','

			$query1 = "INSERT INTO detalle_factura
				(Id_Detalle_Factura, Id_Enca_Factura, Tipo_Articulo, Id_Articulo, Precio, Cantidad)
				VALUES
				$detail ";	
			if ( $this->db->query($query1) ) {//Guarda datos de detalle de factura
				$this->db->query($UpStock);
				$result = true;
			}else{
				$this->message = '<strong>Error [1004]</strong>: Los datos fueron guardados parciamente. Notifique el error.';
				$this->type = 'red';
				$this->time = false;
				$result = false;
			}
		}else{
			//$this->db->debug();
			$this->message = '<strong>Error [1003]</strong>: Los datos no fueron guardados debido a un erro interno. Intentelo de nuevo.';
			$this->type = 'red';
			$result = false;
		}
		return $result;
	}

	private function setUpdate($array,$array2):bool
	{
		$stored = $this->getInvoiceById($array['Id']);
		$set =  '';
		$newItem = '';
		$UpStock = '';

		if ($stored->Id_Tipo_Pago != $array['pay']) {
			$set .= "Id_Tipo_Pago = '".$array['pay']."',";
		}
		if ($stored->Id_cliente != $array['client']) {
			$set .= "Id_cliente = '".$array['client']."',";
		}
		if ($stored->Fecha != $array['date']) {
			$set .= "Fecha = '".$array['date']."',";
		}
		if ($stored->Total != $array['total']) {
			$set .= "Total = '".$array['total']."',";
		}
		if ($stored->Propina != $array['reward']) {
			$set .= "Propina = '".$array['reward']."',";
		}
		if ($stored->Descuento != $array['discount']) {
			$set .= "Descuento = '".$array['discount']."',";
		}
		if ($stored->Comentario != $array['comment']) {
			$set .= "Comentario = '".$array['comment']."',";
		}
		if ($stored->Id_Employee != $array['stylist']) {
			$set .= "Id_Employee = '".$array['stylist']."',";
		}
		if ( !empty($array2) ) {
			foreach ($array2 as $value) {
				$newItem .= "(NULL,'".$array['Id']."','".$value['type']."','".$value['idItem']."','".$value['price']."','".$value['quantity']."' ),";
				if ( $value['type'] == 1 ) {
					$UpStock .= "UPDATE producto SET Stock = (Stock-".$value['quantity'].") 
						WHERE Id_Producto = '".$value['idItem']."' ;";
				}
			}
			$newItem = trim($newItem, ',');//Elimina el ultimo caracter definido ','
		}
		
		/*if ($stored->Estado != $array['state']) {
			$set .= "Estado = '".$array['state']."',";
		}*/
		$set = trim($set, ',');//Elimina el ultimo caracter definido ','
		$this->data = array();//reset array
		$this->data['set'] = $set;
		$this->data['set0'] = $newItem;
		$this->data['set1'] = $UpStock;
		
		if ( empty($set) && empty($newItem) ) {
			return false;
		}else{
			return true;
		}
	}

	private function editData($array,$items=null):bool
	{
		if( $this->setUpdate($array,$items) ){//verifica si hay cambios para aplicar
			if ( !empty($this->data['set']) ) {
				$query0 = "UPDATE enca_factura  
					SET ".$this->data['set']."
					WHERE Id_Enca_Factura = '".$array['Id']."' ";
				if($this->db->query($query0)){
					$result = true;
				}else{
					$this->message = '<strong>Error [1003]</strong>: Los datos no fueron guardados debido a un erro interno. Intentelo de nuevo.';
					$this->type = 'red';
					$result = false;
				}
				//$this->db->debug();
			}
			if ( !empty($this->data['set0']) ) {
				$query1 = "INSERT INTO detalle_factura
					(Id_Detalle_Factura, Id_Enca_Factura, Tipo_Articulo, Id_Articulo, Precio, Cantidad)
					VALUES ".$this->data['set0'];	
				if ( $this->db->query($query1) ) {//Guarda datos de detalle de factura
					$result = true;
				}else{
					$this->message = '<strong>Error [1004]</strong>: Los datos no fueron guardados debido a un erro interno. Intentelo de nuevo..';
					$this->type = 'red';
					$result = false;
				}
			}
			if ( !empty($this->data['set1']) ) {
				$this->db->query($this->data['set1']);
			}
		}else{
			$this->message = 'No se ha detectado ningun cambio';
			$this->type = 'orange';
			$result = false;
		}
		return $result;
	}

	public function deleteEnca( $id ):bool
	{
		$result = true;
		if ( isIntN($id) ) {
			$query0 = "DELETE FROM enca_factura WHERE Id_Enca_Factura = '$id' ";
			if( $this->db->query($query0) ){
				$result = true;
			}else{
				$this->message = '<strong>Error [1003]</strong>: Los datos no fueron eliminados debido a un erro interno. Intentelo de nuevo.';
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

	public function deleteItem( $idE,$idP,$type):bool
	{
		$result = true;
		if ( isIntN($idE) && isIntN($idP) && isIntN($type) ) {
			$query0 = "DELETE FROM detalle_factura
				WHERE Id_Enca_Factura = '$idE' AND  Id_Articulo = '$idP' AND Tipo_Articulo = '$type' ";
			if( $this->db->query($query0) ){
				$result = true;
			}else{
				$this->message = '<strong>Error [1003]</strong>: Los datos no fueron eliminados debido a un erro interno. Intentelo de nuevo.';
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