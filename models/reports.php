<?php
/**
 * 
 * Clase para obtner que genera reportes
 *  
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/

include_once dirname(__file__,2)."/config/conexion.php";
class Reports
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

	public function report0():?array//Producto mas vendido
	{
		$rows = $this->db->get_results("SELECT Id_Articulo, Tipo_Articulo, SUM(Cantidad) as Ventas
			FROM detalle_factura
			GROUP BY Id_Articulo,Tipo_Articulo
			ORDER BY  SUM(Cantidad) DESC
			LIMIT 0 , 10");
		if ( !$rows ) return NULL;
		return $rows;
	}

	public function report1():?array//Producto menos vendido
	{
		$rows = $this->db->get_results("SELECT Id_Articulo, Tipo_Articulo, SUM(Cantidad) as Ventas
			FROM detalle_factura
			GROUP BY Id_Articulo,Tipo_Articulo
			ORDER BY  SUM(Cantidad) ASC
			LIMIT 0 , 10");
		if ( !$rows ) return NULL;
		return $rows;
	}

	public function report3():?array//Producto menos vendido
	{
		$rows = $this->db->get_results("SELECT Id_Cliente, COUNT(Id_Cliente) AS Veces
			FROM agenda
			WHERE Estado = 1
			GROUP BY Id_Cliente
			ORDER BY COUNT(Id_Cliente) DESC
			LIMIT 0 , 10 ");
		if ( !$rows ) return NULL;
		return $rows;
	}

	public function report4():?array//Producto menos vendido
	{
		$rows = $this->db->get_results("SELECT Id_Cliente, COUNT(Id_Cliente) AS Veces
			FROM agenda
			WHERE Estado = 1
			GROUP BY Id_Cliente
			ORDER BY COUNT(Id_Cliente) DESC
			LIMIT 0 , 10 ");
		if ( !$rows ) return NULL;
		return $rows;
	}

}