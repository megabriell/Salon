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

include_once dirname(__file__,2)."/config/conexion.php";
class User
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

	public function getTypeUsers($type=null):?array
	{	
		$where = (isIntN($type))? "WHERE T1.Sistema = '".$type."'" : '';
		$rows = $this->db->get_results("SELECT T0.Id_Usuario, T0.Nombre, T0.Apellido, T0.Telefono, T0.Correo, T0.NIT, T0.Direccion
			FROM usuario T0 
			INNER JOIN usuario_acceso T1 ON (T0.Id_Usuario = T1.Id_Usuario)
			INNER JOIN usuario_config T2 ON (T1.Id_Usuario_Acceso = T2.Id_Usuario_Acceso) 
			$where ");
		if ( !$rows ) return NULL;
		return $rows;
		
	}

	//Trae todos los usuarios registrados
	public function getUsers():?array
	{
		$rows = $this->db->get_results("SELECT T0.Id_Usuario, T0.Nombre, T0.Apellido, T0.Telefono, T0.Correo AS CorreoP, T0.NIT, T0.Direccion, T1.Id_Usuario_Acceso, T1.Usuario, T1.Correo AS CorreoU, T1.Sistema, T2.Estado
			FROM usuario T0 
			LEFT JOIN usuario_acceso T1 ON (T0.Id_Usuario = T1.Id_Usuario)
			LEFT JOIN usuario_config T2 ON (T1.Id_Usuario_Acceso = T2.Id_Usuario_Acceso) ");
		if ( !$rows ) return NULL;
		return $rows;
	}

	//Obtiene el usuario por IdUsuario
	public function getUserById($id):?OBJECT
	{
		if( isIntN($id) ){
			$row = $this->db->get_row("SELECT T1.Id_Usuario, T1.Nombre, T1.Apellido, T1.Telefono, T1.Correo AS CorreoP, T1.NIT, T1.Direccion, T1.Salario, T0.Id_Usuario_Acceso, T0.Usuario, T0.Correo AS CorreoU, T0.Sistema
			FROM usuario_acceso T0
			INNER JOIN usuario T1 ON (T0.Id_Usuario = T1.Id_Usuario)
				WHERE T0.Id_Usuario_Acceso = '$id' ");

			if (!$row) return NULL;
			return $row;
		}else{
			return NULL;
		}
	}

	//Obtiene el usuario por IdEmpleado
	public function getEmployeeById( $id ):?OBJECT
	{
		if( isIntN($id) ){
			$row = $this->db->get_row("SELECT T0.Id_Usuario, T0.Nombre, T0.Apellido, T0.Telefono, T0.Correo AS CorreoP, T0.NIT, T0.Direccion, T0.Salario,
				T1.Id_Usuario_Acceso, T1.Usuario, T1.Correo AS CorreoU, T1.Sistema
			FROM usuario T0 
			INNER JOIN usuario_acceso T1 ON (T0.Id_Usuario = T1.Id_Usuario)
				WHERE T0.Id_Usuario = '$id' ");

			if (!$row) return NULL;
			return $row;
		}else{
			return false;
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

	//valida que el valor no existan en la base de datos
	public function isDuplicate($data=NULL):bool
	{
		if( !empty($data) ){
			$query0 = $this->db->get_row("SELECT T0.Correo, T1.Usuario, T1.Correo as CorreoU FROM 
			usuario T0
			LEFT JOIN usuario_acceso T1
			ON T0.Id_Usuario = T1.Id_Usuario
			WHERE T0.Correo = '$data' OR T1.Usuario = '$data' OR T1.Correo = '$data'" );
			if ( $query0 ) {
				return true;
			}else{
				return false;
			}
		}
	}

	//valida que ningun campo este vacio, aplica formato correspondiente a cada campo
	public function validData($post,$option=null):bool 
	{
		if( !empty($option) ){
			if ( empty($post['id0']) || empty($post['id1']) ) {//valida que el campo Id tenga un valor
				$this->message = '<strong>Error [1006]</strong>: Los datos no fueron procesados correctamente. Notifique el error.';
				$this->type = 'red';
				$this->time = false;
				return false;
			}
			$this->data['Id'] = (isIntN( $post['id0']) )? $this->db->escape($post['id0']) :'';
			$this->data['IdUser'] = ( isIntN($post['id1']) )? $this->db->escape($post['id1']):'';
		}

		if (!isset($post['rememberPass']) || !$post['rememberPass']) {//si el campo no esta definido o checked realiza la validación
			$this->data['pass'] = ( !empty($post['pass']) && $post['pass'] === $post['confirPass'] )? password_hash($this->db->escape($post['pass']), PASSWORD_DEFAULT) : '';
		}
		$this->data['name'] = ( !empty($post['name']) )? camelCase( $this->db->escape($post['name']) ) : '' ;
		$this->data['lastName'] = ( !empty($post['lname']) )? camelCase( $this->db->escape($post['lname']) ) : '';
		$this->data['phone'] = ( !empty($post['phone']) )? $this->db->escape($post['phone']) : '';
		$this->data['emailP'] = ( !empty($post['emailP']) )? lowerCase($this->db->escape($post['emailP'])) : '';
		$this->data['user'] = ( !empty($post['user']) )? upperCase($this->db->escape($post['user'])) : '';
		$this->data['emailU'] = ( !empty($post['emailU']) )? lowerCase( $this->db->escape($post['emailU']) ) : '';
		$this->data['TSistema'] = ( is_numeric($post['sistema']) )? $this->db->escape($post['sistema']) : '';
		$this->data['permission'] = ( !empty($post['permission']) )? $this->db->escape($post['permission']) : '';

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
		$this->data['salary'] = (!empty($post['salary']))? $this->db->escape( $post['salary'] ) : 0;

		if ( isset($this->data['Id'])  && isset($this->data['IdUser']) ) {
			return $this->editUser($this->data) ; //Update User
		}else{
			return $this->newUser($this->data);//New User
		}
		
	}

	//Crea un nuevo usuario
	private function newUser($insert):bool
	{
		if ( !$this->isDuplicate($insert['user']) && !$this->isDuplicate($insert['emailU']) ) { //Valida que el correo o usuario no exista(repetido)
			$query1 = "INSERT INTO usuario
			(Id_Usuario, Nombre, Apellido, NIT, Telefono, Correo, Direccion, Salario) 
			VALUES
			(NULL,'".$insert['name']."','".$insert['lastName']."','".$insert['nit']."','".$insert['phone']."','".$insert['emailP']."','".$insert['address']."', '".$insert['salary']."' )";	
			if ( $this->db->query($query1) ) {//guarda informacion de empleado
				$Last_Id = $this->db->insert_id;

				$query2 = "INSERT INTO usuario_acceso
				(Id_Usuario_Acceso, Id_Usuario, Usuario, Correo, Contrasena, Sistema)
				VALUES
				(NULL, '$Last_Id', '".$insert['user']."', '".$insert['emailU']."', '".$insert['pass']."', '".$insert['TSistema']."') ";	

				if ( $this->db->query($query2) ) {//guarda datos de acceso para empleado
					$Last_Id = $this->db->insert_id;
					$query3 = "INSERT INTO usuario_config
					(Id_Config_Usuario, Id_Usuario_Acceso, Img_Perfil, Img_Portada, Estado)
					VALUES
					(NULL, $Last_Id, '', '', 1) ";
					if ( $this->db->query($query3) ) {//guarda datos de configuracion de usuario
						$this->addPermission($insert['permission'],$Last_Id);
						$result = true;
					}else{
						$this->message = '<strong>Advertencia [1501]</strong>: Algunos datos complemetarios no fueron guaradados. Notifique el error.';
						$this->type = 'orange';
						$this->time = false;
						$result = false;
					}
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
		}else{
			$this->message = '<strong>Error [1002]</strong>: El usuario/correo ya existe, ingresa un valor distinto.';
			$this->type = 'red';
			$result = false;
		}
		return $result;
	}
	
	private function setUpdate($array):bool
	{
		$stored = $this->getEmployeeById($array['Id']);
		$set =  '';
		$duplicate =  '';

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
		if ($stored->Salario != $array['salary']) {
			$set .= "T0.Salario = '".$array['salary']."',";
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
		if ($stored->Sistema != $array['TSistema']) {
			$set .= "T1.Sistema = '".$array['TSistema']."',";
		}
		if ( isset($array['pass']) ) {
			$set .= "T1.Contrasena = '".$array['pass']."',";
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
		$result = true;
		$this->addPermission($array['permission'],$array['IdUser'],true);//actualiza los permisos de usuario
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
				}else{
					$this->message = '<strong>Error [1003]</strong>: Los datos no fueron guardados debido a un erro interno. Intentelo de nuevo.';
					$this->type = 'red';
					$result = false;
				}
		}else{
			if ( !empty($this->data['duplicate']) ) {//Valida que el correo o usuario no exista(repetido)
				$this->message = "No se ha aplicado ningun cambio: ".$this->data['duplicate'];
				$this->type = 'orange';
				$this->time = false;
				$result = false;
			}else{
				$this->message = 'No se ha detectado ningun cambio';
				$this->type = 'orange';
				$result = false;
			}
		}
		return $result;
	}

	/*Borra el usuario por id. Al borrar el registro de empreado tambien se elimina se elimina de:
	* usuario_acceso, usuario_config, permiso
	*/
	private function deleteUser( $id ):bool
	{
		$result = true;
		if ( isIntN($id) ) {
			$query0 = "DELETE FROM usuario WHERE Id_Usuario = '$id' ";
			if( $this->db->query($query0) ){
				//new Sincronizacion($queryDelete3,1,"",$codigo_Usuario);
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

	//Desactiva el acceso al sistema al usuario
	public function disableUser($id,$option=null):bool
	{
		$result = true;
		if ( isIntN($id) ) {
			$state = ( !empty($option) )? 1 : 0 ;
			$query0 = "UPDATE usuario_acceso T0
			INNER JOIN usuario_config T1 ON (T0.Id_Usuario_Acceso = T1.Id_Usuario_Acceso)
				SET T1.Estado = $state
				WHERE T0.Id_Usuario = '$id' ";
			if( $this->db->query($query0) ){
				//new Sincronizacion($queryDelete3,1,"",$codigo_Usuario);
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



	/**#############################	Registro de usuario 	#########################**/
	//valida que ningun campo este vacio, aplica formato correspondiente a cada campo
	public function validData2($post):bool 
	{
		
	$this->data['pass'] = ( !empty($post['pass']) && $post['pass'] === $post['confirPass'] )? password_hash($this->db->escape($post['pass']), PASSWORD_DEFAULT) : '';

		$this->data['name'] = ( !empty($post['name']) )? camelCase( $this->db->escape($post['name']) ) : '' ;
		$this->data['lastName'] = ( !empty($post['lName']) )? camelCase( $this->db->escape($post['lName']) ) : '';
		$this->data['user'] = ( !empty($post['user']) )? upperCase($this->db->escape($post['user'])) : '';
		$this->data['emailU'] = ( !empty($post['emailU']) )? lowerCase( $this->db->escape($post['emailU']) ) : '';
		
		foreach ($this->data as $key => $value) {
			if (empty($value)) {
				break;
				$this->message = '<strong>Error [1001]</strong>: Un campo del formulario esta vació o no cumple con el formato correcto. Revise los valores ingresados';
				$this->type = 'red';
				return false;
			}
		}
		return $this->registUser($this->data);//New User		
	}

	//Crea un nuevo usuario
	private function registUser($insert):bool
	{
		if ( !$this->isDuplicate($insert['user']) && !$this->isDuplicate($insert['emailU']) ) { //Valida que el correo o usuario no exista(repetido)
			$query1 = "INSERT INTO usuario
			(Id_Usuario, Nombre, Apellido,Telefono,Correo) 
			VALUES
			(NULL,'".$insert['name']."','".$insert['lastName']."', '','' )";	
			if ( $this->db->query($query1) ) {//guarda informacion de empleado
				$Last_Id = $this->db->insert_id;

				$query2 = "INSERT INTO usuario_acceso
				(Id_Usuario_Acceso, Id_Usuario, Usuario, Correo, Contrasena, Sistema)
				VALUES
				(NULL, '$Last_Id', '".$insert['user']."', '".$insert['emailU']."', '".$insert['pass']."', '3') ";	

				if ( $this->db->query($query2) ) {//guarda datos de acceso para empleado
					$Last_Id = $this->db->insert_id;
					$query3 = "INSERT INTO usuario_config
					(Id_Config_Usuario, Id_Usuario_Acceso, Img_Perfil, Img_Portada, Estado)
					VALUES
					(NULL, $Last_Id, '', '', 1) ";
					if ( $this->db->query($query3) ) {//guarda datos de configuracion de usuario
						$idUsuarioAcceso = $this->db->insert_id;
						$this->db->query("INSERT INTO permiso
							(Id_Permiso, Id_Pagina, Id_Usuario_Acceso)
							VALUES
							(NULL,'5','$idUsuarioAcceso'),
							(NULL,'6','$idUsuarioAcceso'),
							(NULL,'10','$idUsuarioAcceso')
							");
						$result = true;
					}else{
						$this->message = '<strong>Advertencia [1501]</strong>: Algunos datos complemetarios no fueron guaradados. Notifique el error.';
						$this->type = 'orange';
						$this->time = false;
						$result = false;
					}
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
		}else{
			$this->message = '<strong>Error [1002]</strong>: El usuario/correo ya existe, ingresa un valor distinto.';
			$this->type = 'red';
			$result = false;
		}
		return $result;
	}
}