<?php
/**
 * 
 * Clase para obtener todos los permisos de usuario
 *  
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/

include_once dirname(__file__,2)."/config/conexion.php";
class Permission
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

	//Trae todos los permisos de usuario
	public function getPermissions($id):?array
	{	
		if( isIntN($id) )
		{
			$rows = $this->db->get_results("SELECT * FROM permiso T0 WHERE T0.Id_Usuario_Acceso = '$id' ");
			if( !$rows )return NULL;
			return $rows;
		}else{
			return NULL;
		}
	}

	public function addPermission($array,$id,$del=false){
		if ($del) {
			$this->db->query("DELETE FROM permiso WHERE Id_Usuario_Acceso = '$id' ");
		}
		$values = "";
		foreach($array as $val) {
			$values .= "(NULL, '$val', '$id'),";
		}
		if ($values != "") {
			$values = trim($values, ',');
			$this->db->query("ALTER TABLE permiso AUTO_INCREMENT = 1");
			$this->db->query("INSERT INTO permiso (Id_Permiso, Id_Pagina, Id_Usuario_Acceso) VALUES $values");
		}
	}

}