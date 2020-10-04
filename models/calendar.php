<?php
/**
 * 
 * Clase para obtner informacion de servicios y agregar un nuevo servicio
 *  
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/

include_once dirname(__file__,2)."/config/conexion.php";
class Calendar
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

	public function getCalendar():?array
	{
		$rows = $this->db->get_results("SELECT T0.Id_Agenda, T0.Fecha, T0.Comentario, T0.Estado,
			CONCAT(T1.Nombre, ' ',T1.Apellido) AS Estilista,
			T2.Descripcion as Servicio, T2.Duracion
			FROM agenda T0
			INNER JOIN usuario T1 ON (T1.Id_Usuario = T0.Id_Estilista)
			INNER JOIN servicios T2 ON (T2.Id_Servicio = T0.Id_Servicio) ");
		if ( !$rows ) return NULL;
		return $rows;
	}

	public function getCalendarByUser($id):?array
	{
		if( isIntN($id) ){
			$rows = $this->db->get_results("SELECT T0.Id_Agenda, T0.Fecha, T0.Comentario, T0.Estado,
				CONCAT(T1.Nombre, ' ',T1.Apellido) AS Estilista,
				T2.Descripcion as Servicio, T2.Duracion
				FROM agenda T0
				INNER JOIN usuario T1 ON (T1.Id_Usuario = T0.Id_Estilista)
				INNER JOIN servicios T2 ON (T2.Id_Servicio = T0.Id_Servicio)
				WHERE T0.Id_Cliente = '$id' ");
			if ( !$rows ) return NULL;
			return $rows;
		}else{
			return NULL;
		}
	}

	public function getCalendarByEvent($id):?OBJECT
	{
		if( isIntN($id) ){
			$rows = $this->db->get_row("SELECT T0.Id_Agenda, T0.Fecha, T0.Comentario, T0.Estado,
				CONCAT(T1.Nombre, ' ',T1.Apellido) AS Estilista,
				T2.Descripcion as Servicio, T2.Duracion
				FROM agenda T0
				INNER JOIN usuario T1 ON (T1.Id_Usuario = T0.Id_Estilista)
				INNER JOIN servicios T2 ON (T2.Id_Servicio = T0.Id_Servicio)
				WHERE T0.Id_Agenda = '$id' ");
			if ( !$rows ) return NULL;
			return $rows;
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
		$this->data['user'] = ( isIntN($post['user']) )? $this->db->escape($post['user']) : '' ;
		$this->data['stylist'] = ( !empty($post['stylist']) )? $this->db->escape($post['stylist']) : '' ;
		$this->data['service'] = ( !empty($post['service']) )? $this->db->escape($post['service']) : '';
		if ( !empty($post['date']) ) {
			$d = $this->db->escape($post['date']);
			$this->data['date'] =  DateTime::createFromFormat("d/m/Y H:i", $d)->format('Y-m-d H:i');
		}else{
			$this->data['date'] = '';
		}
		
		foreach ($this->data as $key => $value) {
			if (empty($value)) {
				break;
				$this->message = '<strong>Error [1001]</strong>: Un campo del formulario esta vació o no cumple con el formato correcto. Revise los valores ingresados';
				$this->type = 'red';
				return false;
			}
		}
		if (isset($post['comment'])) {
			$this->data['comment'] = ( !empty($post['comment']) )? $this->db->escape($post['comment']) : '';
		}

		if ( !empty($option) ) {
			return $this->editData($this->data); //Update User
		}else{
			return $this->newData($this->data) ;//New User
		}
	}

	private function newData($insert):bool
	{
		$query1 = "INSERT INTO agenda
			(Id_Agenda, Id_Cliente, Id_Estilista, Id_Servicio, Fecha, Comentario, Estado) 
			VALUES
			(NULL,'".$insert['user']."','".$insert['stylist']."','".$insert['service']."','".$insert['date']."', '".$insert['comment']."', '0' )";	
		if ( $this->db->query($query1) ) {//guarda informacion de empleado
			$result = true;
		}else{
			$this->message = '<strong>Error [1003]</strong>: Los datos no fueron guardados debido a un erro interno. Intentelo de nuevo.';
			$this->type = 'red';
			$result = false;
		}
		return $result;
	}
}