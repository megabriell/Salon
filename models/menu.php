<?php
/**
 *
 * Clase que obtiene el menu de todo el sistema desde la base de datos y la almacena en cache(archivo temporal)
 *
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
**/

include_once dirname(__file__,2)."/config/conexion.php";
class Menu
{
	private $db;
    private $data;//array of form post
    public $message;//message of result
    public $type;//type of menssage: red|green|orange|blue|purple|dark
    public $time;//set stopwatch

	function __construct()
	{
		$this->db = new Conexion();
		$message = '';
	}

	//Obtener menu completo
	public function getMenu()
	{
		/*	#####structure#####
		*	[KeyParent] => Array
		*       (
		*            [keyChild] => value
		*            [keyChild] => value
		*            [keyChild] => value
		*			 ......
		*            [iconParent] => value
		*        )
		*/
		$this->getSubMenu();
		$menu = $this->setMenu();
		$array = [];
		foreach ( $menu as $key => $value ){
			$id = $value->Id_Menu_Sitio;
			$description = $value->Descripcion;
			$icon = $value->Icono;

			/*
			*	array_keys — Return all the keys or a subset of the keys of an array
			*	array_column — Devuelve los valores de una sola columna del array de entrada
			*	array_combine — Crea un nuevo array, usando una matriz para las claves y otra para sus valores
			*/
			$keys = array_keys( array_combine(array_keys($this->data), array_column($this->data, 'IdMenu')) , $id);
			
			foreach ( $keys as $val ){
				$idPage = $val;
				$desPage = $this->data[$val]['Descripcion'];
				//KeyParent: $array[$description];  [$idPage]: is a iteration 
				$array[$description][$idPage] = $desPage;//keyChild = value
			}

			$array[$description]['icon'] = $icon;//iconParent = value
		}
		return $array;
	}

	public function getSubMenu()
	{
		/*	#####structure#####
		*	[KeyParent] => Array
		*       (
		*            [IdMenu] => value,
		*            [Descripcion] => value,
		*            [Contenido] => value,
		*            [Link] => value,
		*            [Nombre] => value
		*        )
		*/
		$array = [];
		$rows = $this->setSubMenu();
		foreach ($rows as $key => $value) {
			//KeyParent: $array[$value->Id_Pagina]
			$array[$value->Id_Pagina] = [
				"IdMenu"=>$value->Id_Menu_Sitio,
				"Descripcion"=>$value->Descripcion,
				"Contenido"=>$value->Contenido,
				"Nombre"=>$value->Nombre
			];
		}
		$this->data = $array;
		return $array;
	}

	//Obtener menu principal
	public function setMenu()
	{
		$menu = $this->db->get_results("SELECT Id_Menu_Sitio, Descripcion, Icono
			FROM menu_sitio ORDER BY Posicion");
		return $menu;
	}

	//Obtener subMenu
	public function setSubMenu($id=null)
	{
		$where = ( !empty($id) ) ? " WHERE Id_Menu_Sitio = '$id' " : "" ;
		$subMenu = $this->db->get_results("SELECT * FROM menu_pagina $where ");
		return $subMenu;
	}

	public function readMenu():?array
	{
    	$data = $this->db->cache->readCache('Menu');//get data of cache
    	$row = $this->db->cache->readCache('SubMenu');//get data of cache

		if (!$data || !$row){
			$allMenu = $this->getMenu();//Get all menu of database
				$this->db->cache->addCache("Menu",$allMenu);//Create cache
			$subMenu = $this->getSubMenu();//Get all subMenu of database
				$this->db->cache->addCache("SubMenu",$subMenu);//Create cache
			return $this->readMenu();
		}
		return array($data,$row);
    }

}

/***
########### 	structure of menu 	###############
Array
(
    [Factura] => Array
        (
            [5] => Nueva
            [22] => Ver Factura
            [35] => Editar
            [icon] => fa-clone
        )

    [Productos] => Array
        (
            [9] => Modelos
            [10] => Marcas
            [11] => Tipos
            [icon] => fa-tag
        )

    [Inventario] => Array
        (
            [21] => Existencia
            [23] => Agregar existencia
            [29] => Movimiento Inv.
            [32] => Conteo
            [36] => otro
            [icon] => fa-clipboard
        )

    [Reportes] => Array
        (
            [24] => Productos
            [25] => Embarque
            [27] => Ventas
            [28] => Exportar
            [icon] => fa-line-chart
        )

	.....

)

########### 	structure of subMenu 	###############
Array
(
	[35] => Array //---Id SubMenu---
        (
            [IdMenu] => 3 //---Id Menu---
            [Descripcion] => Editar
            [Contenido] => 
            [Link] => ../invoicedit/
            [Nombre] => factura
        )

    [22] => Array
        (
            [IdMenu] => 3
            [Descripcion] => Ver Factura
            [Contenido] => 
            [Link] => ../invoiceview/
            [Nombre] => verf
        )

    [9] => Array
        (
            [IdMenu] => 6
            [Descripcion] => Modelos
            [Contenido] => 
            [Link] => ../product/
            [Nombre] => lista
        )

    [10] => Array
        (
            [IdMenu] => 6
            [Descripcion] => Marcas
            [Contenido] => 
            [Link] => ../mark/
            [Nombre] => marca
        )

    [21] => Array
        (
            [IdMenu] => 13
            [Descripcion] => Existencia
            [Contenido] => 
            [Link] => ../stock/
            [Nombre] => existencia
        )
	
	...

)
***/