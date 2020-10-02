<?php
/**
 * 
 * Clase para configurar datos del sistema
 *  
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/

include_once dirname(__file__,2)."/config/conexion.php";
class Configuration
{
	private $db;
	private $data;//array of form post

	public $message;//message of result
	public $type;//type of menssage: red|green|orange|blue|purple|dark
	public $time;//set stopwatch
	public $path;
	public $extension;
	public $extra;

	function __construct()
	{
		$this->db   = new Conexion();
		$this->message = '';
		$this->type = 'green';
		$this->time = true;
		$this->data = array();
		$this->path = "../misc/img/sistema/";
		$this->extension = array("image/jpg", "image/jpeg", "image/png", "image/x-icon", "image/gif");
		$this->extra = [];
	}

	private function resetCookie():void
	{
		setcookie("_data1C", "", time() - 10);
		$inCompany = $this->db->infoCompany();
		setcookie("_data1C", json_encode($inCompany),'', "/");
	}

	public function getCompany($id)
	{
		if( isIntN($id) ){
			$row = $this->db->get_row("SELECT Nombre, Direccion, Telefono, Correo, NIT FROM empresa 
				WHERE Id_Empresa = '$id' ", ARRAY_N);
			if (!$row) return false;
			$this->extra = $row;
			return true;
		}else{
			return false;
		}
	}

	public function deleteImg($file,$key,$option):bool
	{
		switch ($option) {
			case 0:
				$set = " Logo = '' ";
				break;
			case 1:
				$set = " Logo2 = '' ";
				break;
			case 2:
				$set = " Favicon = '' ";
				break;
			default:
				$set = NULL;
				break;
		}

		if (empty($file) && empty($set)) {
			$this->message = '<strong>Error [1001]</strong>: Se ha recibido un valor nulo, vuelva a intentarlo.';
			return false;
		}
		$query0 = "UPDATE empresa SET ".$set." WHERE Id_Empresa = '".$key."' ";
		if ($this->db->query($query0)) {
			if( unlink($this->path.$file) ){
				$this->resetCookie();
				$result = true;
			}else{
				$this->message = '<strong>Error [1502]</strong>: El archivo no se ha eliminado por completo.';
				$result = false;
			}
		}else{
			$this->message = '<strong>Error [1003]</strong>: No se ha podido eliminar la imagen, intentelo de nuevo.';
			$result = false;
		}

		return $result;
	}

	public function addImg($array,$key):bool
	{
		$inpt = array_keys($array);
		$inpt = $inpt[0];
		$name = $_FILES[$inpt]['name'];
		$tmp_img = $_FILES[$inpt]['tmp_name'];
		$size = ($_FILES[$inpt]['size']/1024/1024);
		$type = $_FILES[$inpt]['type'];
		$extension = explode('.', $name);
		$extension = end($extension);
		$new_name = $key.'_'.date("Ymd_Hi").'.'.$extension;

		switch ($inpt) {
			case 'imgP':
				$keyExtra = 0;
				$val = " Logo = '".$new_name."' ";
				break;
			case 'imgS':
				$keyExtra = 1;
				$val = " Logo2 = '".$new_name."' ";
				break;
			case 'favicon':
				$keyExtra = 2;
				$val = " Favicon = '".$new_name."' ";
				break;
			default:
				$val = NULL;
				break;
		}
		if ( empty($val) ) {
			$this->message = '<strong>Error [1001]</strong>: Se ha recibido un valor nulo, vuelva a intentarlo.';
			return false;
		}
		
		$query0 = "UPDATE empresa SET ".$val." WHERE Id_Empresa = '".$key."' ";
		if(!$_FILES[$inpt]['error']){
			if (in_array($type , $this->extension)){
				if($size < (10.05)){
					if ($this->db->query($query0)) {
						if(move_uploaded_file($tmp_img, $this->path.$new_name)){
							$this->extra = [
								'Preview' => "<img src='/misc/img/sistema/".$new_name."' class='img-responsive'>",
								'PreviewConfig' => [
									'caption'=>$new_name, 
									'url'=> 'controllers/config_controller.php',
									'key'=> $keyExtra,
									'extra'=> ['delete' => '']
								]
							];	
							$this->resetCookie();
							$this->message = "La imagen ".$name." se ha guardado cocrrectamente.";
							$result = true;
						}else{
							$this->message = '<strong>Error [1503]</strong>: La imagen no se cargado.';
							$result = false;
						}
					}else{
						$this->message = '<strong>Error [1003]</strong>: No se ha podido agregar la imagen, intentelo de nuevo.';
						$result = false;
					}
				}else{
					$this->message = "La imagen ".$name."no se ha guardado. supera el limite de 10MB(Megabytes), tiene un tamaño de ".$size."MB";
					$result = false;
				}
			}else{
				$this->message = "La imagen ".$name." no se ha guardado, tiene un formato desconocido";
				$result = false;
			}
		}else{
			$this->message = "La imagen no se ha subido por el siguiente error: ".$_FILES[$inpt]['error'] ."<br>";
			$result = false;
		}
		return $result;
	}

	public function validData($post):bool 
	{
		if ( empty($post['id']) ) {//valida que el campo Id tenga un valor
			$this->message = '<strong>Error [1006]</strong>: Los datos no fueron procesados correctamente. Notifique el error.';
			$this->type = 'red';
			$this->time = false;
			return false;
		}
		$this->data['Id'] = (isIntN( $post['id']) )? $this->db->escape($post['id']) :'';
		$this->data['name'] = ( !empty($post['company']) )? upperCase($this->db->escape($post['company'])) :'' ;
		$this->data['address'] = ( !empty($post['address']) )? camelCase( $this->db->escape($post['address']) ) : '';
		$this->data['tel'] = ( !empty($post['tel']) )? $this->db->escape($post['tel']) : '';
		$this->data['email'] = ( !empty($post['email']) )? lowerCase($this->db->escape($post['email'])) : '';
		$this->data['nit'] = ( !empty($post['nit']) )? $this->db->escape($post['nit']) : '';

		foreach ($this->data as $key => $value) {
			if (empty($value)) {
				break;
				$this->message = '<strong>Error [1001]</strong>: Un campo del formulario esta vació o no cumple con el formato correcto. Revise los valores ingresados';
				$this->type = 'red';
				return false;
			}
		}

		return $this->updateCompany($this->data) ;//update information of company
	}

	private function setUpdate($array):bool
	{
		$this->getCompany($array['Id']);
		$stored = $this->extra;  
		$set =  '';

		if ($stored[0] != $array['name']) {
			$set .= "Nombre = '".$array['name']."',";
		}
		if ($stored[1] != $array['address']) {
			$set .= "Direccion = '".$array['address']."',";
		}
		if ($stored[2] != $array['tel']) {
			$set .= "Telefono = '".$array['tel']."',";
		}
		if ($stored[3] != $array['email']) {
			$set .= "Correo = '".$array['email']."',";
		}
		if ($stored[4] != $array['nit']) {
			$set .= "NIT = '".$array['nit']."',";
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

	//Modifica el usuario
	private function updateCompany($array):bool
	{
		if( $this->setUpdate($array) ){//verifica si hay cambios para aplicar
				$query0 = "UPDATE empresa 
					SET ".$this->data['set']."
					WHERE Id_Empresa = '".$array['Id']."' ";
				if($this->db->query($query0)){
					//new Sincronizacion($query_Data,2,"",$codigo_Usuario);
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

}