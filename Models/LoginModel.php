<?php

class LoginModel extends Mysql {

    private $intIdUsuario;
    private $strUsuario;
    private $strPassword;

    public function __construct() {
        parent::__construct();
    }

    public function loginUser(string $usuario, string $password) {
        $this->strUsuario = $usuario;
        $this->strPassword = $password;
        $sql = "SELECT idpersona,estadoPersona FROM persona WHERE 
					emailPersona = '$this->strUsuario' and 
					passwordPersona = '$this->strPassword' and 
					estadoPersona != 0 ";
        $request = $this->select($sql);
        return $request;
    }

    public function sessionLogin(int $iduser) {
        $this->intIdUsuario = $iduser;
        //BUSCAR ROLE 
        $sql = "SELECT p.idpersona, p.nombrePersona, p.apellidoPersona,p.telefonoPersona, p.emailPersona,r.idRol,p.comentarioPersona,"
                . "r.nombreRol,p.estadoPersona FROM persona p INNER JOIN rol r ON p.rolPersona = r.idRol WHERE p.idpersona = $this->intIdUsuario";
        $request = $this->select($sql);
        $_SESSION['userData'] = $request;
        return $request;
    }

    public function getUserEmail(string $strEmail) {
        $this->strUsuario = $strEmail;
        $sql = "SELECT idpersona,nombrePersona,apellidoPersona,estadoPersona FROM persona "
                . "WHERE emailPersona = '$this->strUsuario' and estadoPersona = 1 ";
        $request = $this->select($sql);
        return $request;
    }

    public function getUsuario(string $email, string $token) {
        $this->strUsuario = $email;
        $this->strToken = $token;
        $sql = "SELECT idpersona FROM persona WHERE emailPersona = '$this->strUsuario' and estadoPersona = 1 ";
        $request = $this->select($sql);
        return $request;
    }

    public function insertPassword(int $idPersona, string $password) {
        $this->intIdUsuario = $idPersona;
        $this->strPassword = $password;
        $sql = "UPDATE persona SET passwordPersona = ? WHERE idpersona = $this->intIdUsuario ";
        $arrData = array($this->strPassword, "");
        $request = $this->update($sql, $arrData);
        return $request;
    }

}

?>