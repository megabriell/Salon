<?php
/**
 * 
 * Clase que valida el acceso a usuario registrados
 *  
 * @author Manuel Gabriel <ingmanuelgabriel@gmail.com|ingmanuelgabriel@hotmail.com>
 * @copyright Copyright (c) 2020, Manuel Gabriel | WELMASTER
 *
 *
**/

include_once dirname(__file__,2)."/config/conexion.php";
class Login {
    private $db;
    private $data;//array of form post
    public $message;//message of result
    public $type;//type of menssage: red|green|orange|blue|purple|dark
    public $time;//set stopwatch

    public function __construct(){
        $this->db = new Conexion();
        $this->message = '';
        $this->type = 'green';
        $this->time = true;
        $this->data = array();
    }

    public function doLogout(){
        session_start();
        $_SESSION = array();// Destruir todas las variables de sesión.
        session_destroy();
        setcookie("_data0U", "", time() - 10);
        setcookie("_data1C", "", time() - 10);
        header("location:../views/login/login");
    }
    
    public function validData($post):bool
    {
        $this->data['correo'] = ( !empty($post['correo']) )? $this->db->escape($post['correo']) : '' ;
        $this->data['contrasena'] = ( !empty($post['contrasena']) )? $this->db->escape($post['contrasena']) : '';
        foreach ($this->data as $key => $value) {
            if ( empty($value) ) {
                $this->message = '<strong>Error [1001]</strong>: Un campo del formulario esta vació o no cumple con el formato correcto. Revise los valores ingresados';
                $this->type = 'red';
                break;
                return false;
            }
        }
        return ( $this->Login($this->data) )?  true : false;
    }   

    private function Login($data):bool
    {
        try{
            $query0 = "SELECT T0.Id_Usuario, T0.Id_Usuario_Acceso, T0.Contrasena, T1.Estado
                FROM usuario_acceso T0
                INNER JOIN usuario_config T1 ON (T0.Id_Usuario_Acceso = T1.Id_Usuario_Acceso)
                    WHERE T0.Usuario = '".$this->data['correo']."' OR T0.Correo = '".$this->data['correo']."' ";
            $user = $this->db->get_row($query0);
            if( $user ){
                if ( $user->Estado == 1 ) {
                    if ( password_verify($this->data['contrasena'], $user->Contrasena) ) {
                        session_start();
                        $_SESSION['Id_Empleado'] = $user->Id_Usuario;
                        $_SESSION['Id_Usuario'] = $user->Id_Usuario_Acceso;
                        $_SESSION['session'] = (2156463);

                        $inUser = $this->db->infoUser($user->Id_Usuario);
                        setcookie("_data0U", json_encode($inUser),'', "/");//Create-Cookie data of user

                        $inCompany = $this->db->infoCompany();
                        setcookie("_data1C", json_encode($inCompany),'', "/");//Create-Cookie data of company

                        //new infoDevice($_SESSION['Id_Usuario'],'Inicio de Sesion');

                        return true;
                    } else {
                        throw new Exception("La contraseña no coinciden.");
                    }
                } else {
                    throw new Exception("El Usuario esta desactivado");
                }
            } else {
                throw new Exception("Usuario o correo no coinciden.");
            }
        }catch(Exception $e){
            $this->message = $e->getMessage();
        }
        return false;
    }
}
?>
