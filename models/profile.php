<?php
/**
 * 
 * Clase para obtner informacion de usuario y agregar un nuevo usuario
 *  
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/

include_once dirname(__file__,2)."/models/user.php";

class Profile extends User
{
	public $path;
	public $extension;

	function __construct()
	{
		parent::__construct();
		$this->db   = new Conexion();
		$this->message = '';
		$this->type = 'green';
		$this->time = true;
		$this->data = array();
		$this->path = "../misc/img/usuario/";
		$this->extension = array("image/jpg", "image/jpeg", "image/png", "image/gif");
	}

	private function resetCookie($id):void
	{
		setcookie("_data0U", "", time() - 10);
		$inUser = $this->db->infoUser($id);
		setcookie("_data0U", json_encode($inUser),'', "/");
	}

	private function validaPassword($id,$psw){
		$query0 = "SELECT Contrasena
			FROM usuario_acceso WHERE Id_Usuario_Acceso = '".$id."' ";
            $val = $this->db->get_row($query0);
            if( $val ){
            	if ( password_verify($psw, $val->Contrasena) ) {
            		return true;
            	}else{
            		return false;
            	}
            }else{
            	return false;
            }
	}


	//valida que ningun campo este vacio, aplica formato correspondiente a cada campo
	public function validData($post,$option=null):bool 
	{
		session_start();
		if ( empty($_SESSION['Id_Empleado']) || empty($_SESSION['Id_Usuario']) ){//valida que el campo Id tenga un valor
			$this->message = '<strong>Error [1006]</strong>: Los datos no fueron procesados correctamente. Notifique el error.';
			$this->type = 'red';
			$this->time = false;
			return false;
		}
		$this->data['Id'] = (isIntN( $_SESSION['Id_Empleado']) )? $this->db->escape($_SESSION['Id_Empleado']) :'';
		$this->data['IdUser'] = (isIntN($_SESSION['Id_Usuario']))?$this->db->escape($_SESSION['Id_Usuario']):'';

		$this->data['name'] = ( !empty($post['name']) )? camelCase( $this->db->escape($post['name']) ) : '' ;
		$this->data['lastName'] = ( !empty($post['lname']) )? camelCase( $this->db->escape($post['lname']) ) : '';
		$this->data['phone'] = ( !empty($post['phone']) )? $this->db->escape($post['phone']) : '';
		$this->data['emailP'] = ( !empty($post['email']) )? lowerCase($this->db->escape($post['email'])) : '';
		$this->data['user'] = ( !empty($post['user']) )? upperCase($this->db->escape($post['user'])) : '';
		$this->data['emailU'] = ( !empty($post['emailU']) )? lowerCase( $this->db->escape($post['emailU']) ) : '';

		if (isset($post['changepsw']) && $post['changepsw']) {//si el campo no esta definido o checked realiza la validación
			$this->data['lastPass'] = ( !empty($post['lPsw']))? $this->db->escape($post['lPsw']) : '';
			$this->data['newPass'] = ( !empty($post['newPsw']) && $post['newPsw'] === $post['cPsw'] )? password_hash($this->db->escape($post['newPsw']), PASSWORD_DEFAULT) : '';
		}
		if (!empty($_FILES['avatar'])) {
			$this->data['img'] = 'avatar';//name of input file
		}
		foreach ($this->data as $key => $value) {
			if (empty($value)) {
				break;
				$this->message = '<strong>Error [1001]</strong>: Un campo del formulario esta vació o no cumple con el formato correcto. Revise los valores ingresados';
				$this->type = 'red';
				return false;
			}
		}
		$this->data['nit'] = (!empty($post['nit']))? upperCase($this->db->escape( $post['nit'] )) : '';
		$this->data['address'] = (!empty($post['address']))? camelCase($this->db->escape( $post['address'] )) : '';

		return $this->editUser($this->data);
	}
	
	private function setUpdate($array):bool
	{
		$set =  '';
		$duplicate =  '';
		$stored = $this->getEmployeeById($array['Id']);

		if ($stored->Nombre != $array['name']) {
			$set .= "T0.Nombre = '".$array['name']."',";
		}
		if ($stored->Apellido != $array['lastName']) {
			$set .= "T0.Apellido = '".$array['lastName']."',";
		}
		if ($stored->Telefono != $array['phone']) {
			$set .= "T0.Telefono = '".$array['phone']."',";
		}
		if ($stored->CorreoP != $array['emailP']) {
			$set .= "T0.Correo = '".$array['emailP']."',";
		}
		if ($stored->NIT != $array['nit']) {
			$set .= "T0.NIT = '".$array['nit']."',";
		}
		if ($stored->Direccion != $array['address']) {
			$set .= "T0.Direccion = '".$array['address']."',";
		}
		if ($stored->Usuario != $array['user']) {
			if ( !$this->isDuplicate($array['user'])) {
				$set .= "T1.Usuario = '".$array['user']."',";
			}else{
				$duplicate .= "<br>Error [1002]:El usuario <strong>".$array['user']."</strong> ya existe, ingresa un valor distinto.";
			}
		}
		if ($stored->CorreoU != $array['emailU']) {
			if ( !$this->isDuplicate($array['emailU'])) {
				$set .= "T1.Correo = '".$array['emailU']."',";
			}else{
				$duplicate .= "<br>Error [1002]:El correo <strong>".$array['emailU']."</strong> ya existe, ingresa un valor distinto.";
			}
		}
		if ( isset($array['newPass']) ) {
			if ( $this->validaPassword($array['IdUser'],$array['lastPass']) ) {
				$set .= "T1.Contrasena = '".$array['newPass']."',";
			}else{
				$duplicate .= "<br>Error [1504]:La contraseña no se ha actualizado el valor ingresado no coinciden, vuelva a intentarlo";
			}
		}
		if ( isset($array['img']) ) {
			if ( $this->addImg($array['img'],$array['IdUser']) ) {
				$duplicate .= $this->message;
			}else{
				$duplicate .= $this->message;
			}
		}
		$set = trim($set, ',');//Elimina el ultimo caracter definido ','
		$this->data = array();//reset array
		$this->data['set'] = $set;
		$this->data['duplicate'] = $duplicate;

		if ( empty($set) ) {
			return false;
		}else{
			return true;
		}
	}

	//Modifica el usuario
	private function editUser($array):bool
	{
		if( $this->setUpdate($array) ){//verifica si hay cambios para aplicar
				$query0 = "UPDATE usuario T0 
					INNER JOIN usuario_acceso T1 ON (T0.Id_Usuario = T1.Id_Usuario)
					SET ".$this->data['set']."
					WHERE T0.Id_Usuario = '".$array['Id']."' ";
				if($this->db->query($query0)){
					//new Sincronizacion($query_Data,2,"",$codigo_Usuario);
					if ( !empty($this->data['duplicate']) ) {
						$this->message = "El usuario se ha modificado correctamente. Con algunas excepciones: "
							.$this->data['duplicate'];
						$this->time = false;
						$this->type = 'green';
						//Finaliza If retorna valor verdadero
					}
					$this->resetCookie($array['Id']);
					$result = true;
				}else{
					$this->message = '<strong>Error [1003]</strong>: Los datos no fueron guardados debido a un erro interno. Intentelo de nuevo.';
					$this->type = 'red';
					$result = false;
				}
		}else{
			if ( !empty($this->data['duplicate']) ) {
				$this->message = "No se ha aplicado ningun cambio: ".$this->data['duplicate'];
				$this->type = 'orange';
				$this->time = false;
				$result = false;
			}else{
				$this->message = 'No se ha detectado ningun cambio'.print_r($array);
				$this->type = 'orange';
				$result = false;
			}
		}
		return $result;
	}

	public function addImg($file,$key):bool
	{
		$name = $_FILES[$file]['name'];
		$tmp_img = $_FILES[$file]['tmp_name'];
		$size = ($_FILES[$file]['size']/1024/1024);
		$type = $_FILES[$file]['type'];
		$extension = explode('.', $name);
		$extension = end($extension);
		$new_name = $key.'_'.date("Ymd_Hi").'.'.$extension;

		$query0 = "UPDATE usuario_config SET Img_Perfil = '".$new_name."'
			WHERE Id_Usuario_Acceso = '".$key."' ";
		if(!$_FILES[$file]['error']){
			if (in_array($type , $this->extension)){
				if($size < (10.05)){
					if ($this->db->query($query0)) {
						if(move_uploaded_file($tmp_img, $this->path.$new_name)){
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
			$this->message = "La imagen no se ha subido por el siguiente error: ".$_FILES[$file]['error'] ."<br>";
			$result = false;
		}
		return $result;
	}

}