<?php
/**
 * Archivo de conexion a la base de datos, haciendo uso de la libreria ezSQL_pdo - Author:Justin Vincent - http://justinvincent.com/ezsql
 * 
 *	
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/

include_once dirname(__file__,2).'/config/ezSQL/ez_sql_core.php';
include_once dirname(__file__,2).'/config/ezSQL/ez_sql_pdo.php';
include_once dirname(__file__,2).'/models/_funtions.php';
include_once dirname(__file__,2).'/models/_cache.php';
//include_once dirname(__file__,2).'/models/ssss.php';
//include_once dirname(__file__,2).'/models/dddd.php';



class Conexion extends ezSQL_pdo
{
	private $dsn = 'mysql:host=localhost;dbname=dbsalon';
	private $user = 'root';
	private $password = 'databaseacces';
	private $configdb = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES  \'UTF8\'');

	public $cache;
	Public $device;
	Public $sync;
	public $messageDB;

	function __construct()
	{
		date_default_timezone_set('America/Guatemala');
		try {
			$this->hide_errors();
			$this->cache = new Cache();

			if ( !empty($this->dsn) && !empty($this->user) && !empty($this->password) && !empty($this->configdb) ) {
				if( $this->connect($this->dsn, $this->user, $this->password, $this->configdb) ){
				}else{
					throw new Exception("Errro interno: se ha detectado un problema con las credenciales ingresadas");
				}
			}else{
				throw new Exception("Errro interno: Uno de los valore de conexion no es valido");
			}
			//$this->vardump($this->conexion->captured_errors);
			//$this->last_error;
		}catch (Exception $e){
			//trigger_error($this->last_error.' -- '.$e->getMessage(),E_USER_WARNING);
			$this->messageDB = $e->getMessage();
		}
	}

	public function session():?array//Return function array or null "?array" -- Function to validate session of user
	{
		session_start();
		$array = [];
		$array['idEmployee'] = (isset($_SESSION['Id_Empleado']))? $_SESSION['Id_Empleado'] : '';
		$array['idUser'] = (isset($_SESSION['Id_Usuario']))? $_SESSION['Id_Usuario'] : '';
		$array['idLogged'] = (isset($_SESSION['session']))? $_SESSION['session'] : '';
		if (empty( $array['idLogged'] ) || $array['idLogged'] != (2156463)){
			$array = NULL;
		}
		return $array;//getValue: echo $array['idEmployee']
	}

	public function infoUser($id):?array//Return function array or null "?array"
    {
        $array = [];
        if( isIntN($id) ){
	        $query0 = "SELECT
	            T0.Nombre,
	            T0.Apellido,
	            T0.Telefono,
	            T0.Correo AS CorreoPersonal,
	            T0.NIT,
	            T0.Direccion,
	            T2.Sistema,
	            T2.Usuario,
	            T2.Correo AS CorreAcceso,
	            T3.Img_Perfil,
	            T3.Img_Portada
	            FROM usuario T0
	            INNER JOIN usuario_acceso T2 ON T0.Id_Usuario = T2.Id_Usuario
	            INNER JOIN usuario_config T3 ON T2.Id_Usuario_Acceso = T3.Id_Usuario_Acceso
	            WHERE T0.Id_Usuario = '$id' ";
	        $row = $this->get_row($query0);
	        if ( $row ) {
	        	if ($row->Sistema == 1) {
		        	$label = 'Entrenador';
		        }elseif ($row->Sistema == 2) {
		        	$label = 'Alumno';
		        }else{
		        	$label = 'Sin acceso';
		        }
		        $array['Nombre'] = $row->Nombre;
		        $array['Apellido'] = $row->Apellido;
		        $array['NIT'] = $row->NIT;
		        $array['Direccion'] = $row->Direccion;
		        $array['Telefono'] = $row->Telefono;
		        $array['CorreoP'] = $row->CorreoPersonal;
		        $array['CorreoA'] = $row->CorreAcceso;
		        $array['sistema'] = $label;
		        $array['Usuario'] = $row->Usuario;
		        $array['imgPerfil'] = ( !empty($row->Img_Perfil) )? $row->Img_Perfil : 'default-avatar.png';
		        $array['imgPortada'] = $row->Img_Portada;
		    }else{
		    	$array = NULL;
		    }
		}else{
			$array = NULL;
		}
        return $array;

	}

    public function infoCompany():?array//Return function array or null "?array"
    {
        $array = [];
        $query0 = "SELECT * FROM empresa WHERE Activo = 1";
        $row = $this->get_row($query0);
        if ($row) {
	        $array['IdEmpresa'] = $row->Id_Empresa;
	        $array['imgPrincipal'] = $row->Logo;
	        $array['imgSegundaria'] = $row->Logo2;
	        $array['favicon'] = $row->Favicon;
	        $array['Empresa'] = $row->Nombre;
	    }else{
	    	$array = NULL;
	    }
        return $array;
    }

}