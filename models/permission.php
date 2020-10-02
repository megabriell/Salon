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
			$rows = $this->db->get_results("SELECT T0.Descripcion, T0.Icono,
				T1.Descripcion AS Descripcion2, T1.Id_Pagina, T1.Id_Menu_Sitio, T1.Nombre
				FROM menu_sitio T0
				INNER JOIN menu_pagina T1 ON (T0.Id_Menu_Sitio = T1.Id_Menu_Sitio)
				LEFT JOIN permiso T2 ON (T1.Id_Pagina = T2.Id_Pagina)
					WHERE T2.Id_Usuario_Acceso = '$id'
					ORDER BY T0.Posicion ");
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