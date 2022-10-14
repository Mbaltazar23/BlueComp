<?php

class UsuariosModel extends Mysql {

    private $intIdUsuario;
    private $strNombre;
    private $strApellido;
    private $intTelefono;
    private $rolUsuario;
    private $strEmail;
    private $comentario;
    private $idNegocio;
    private $description;
    private $strPassword;

    public function __construct() {
        parent::__construct();
    }

    public function selectUsuarios() {
        $this->rolUsuario = ROLCLIENTE;
        $sql = "SELECT p.idPersona,p.nombrePersona,p.apellidoPersona,p.telefonoPersona,
            p.emailPersona,p.estadoPersona FROM persona p WHERE p.rolPersona = $this->rolUsuario";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectUsuarioCargo(int $idpersona) {
        $this->intIdUsuario = $idpersona;
        $sql = "SELECT p.idPersona,p.nombrePersona,p.apellidoPersona,p.comentarioPersona,p.telefonoPersona,p.emailPersona,p.estadoPersona,"
                . "DATE_FORMAT(p.fechaPersona, '%d-%m-%Y') as fechaRegistro, n.idNegocio,n.negocioNombre,dn.descripcionCargo,dn.id_detalleCargoCliente FROM persona p INNER JOIN detallecargocliente dn ON p.idPersona = dn.perdona_idDetalle "
                . "INNER JOIN negocio n ON dn.negocio_idDetalle = n.idNegocio WHERE p.idpersona = $this->intIdUsuario";
        $request = $this->select($sql);
        return $request;
    }

    public function selectUsuario(int $idpersona) {
        $this->intIdUsuario = $idpersona;
        $sql = "SELECT p.idPersona,p.nombrePersona,p.apellidoPersona,p.comentarioPersona,p.telefonoPersona,p.emailPersona,p.estadoPersona,"
                . "DATE_FORMAT(p.fechaPersona, '%d-%m-%Y') as fechaRegistro FROM persona p WHERE p.idpersona = $this->intIdUsuario";
        $request = $this->select($sql);
        return $request;
    }

    public function updateUsuario(int $idUsuario, string $nombre, string $apellido, string $comentario, string $telefono, string $email) {
        $this->intIdUsuario = $idUsuario;
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->comentario = $comentario;
        $sql = "UPDATE persona SET nombrePersona=?, apellidoPersona=?, telefonoPersona=?,comentarioPersona=?, emailPersona=? WHERE idPersona = '{$this->intIdUsuario}' ";
        $arrData = array($this->strNombre,
            $this->strApellido,
            $this->intTelefono,
            $this->comentario,
            $this->strEmail);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function updatePerfil(int $idUsuario, string $email, string $comentario, string $apellido, string $telefono, string $password) {
        $this->intIdUsuario = $idUsuario;
        $this->comentario = $comentario;
        $this->strApellido = $apellido;
        $this->strEmail = $email;
        $this->intTelefono = $telefono;
        $this->strPassword = $password;

        if ($this->strPassword != "") {
            $sql = "UPDATE persona SET apellidoPersona=?, telefonoPersona= ? , emailPersona = ?, passwordPersona= ?, comentarioPersona =?
						WHERE idPersona = $this->intIdUsuario ";
            $arrData = array($this->strApellido,
                $this->intTelefono,
                $this->strEmail,
                $this->strPassword,
                $this->comentario);
        } else {
            $sql = "UPDATE persona SET apellidoPersona=?, telefonoPersona= ? , emailPersona = ?, comentarioPersona =?
						WHERE idPersona = $this->intIdUsuario ";
            $arrData = array($this->strApellido,
                $this->intTelefono,
                $this->strEmail,
                $this->comentario);
        }
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function deleteUsuario(int $intIdpersona, int $status) {
        $this->intIdUsuario = $intIdpersona;
        $sql = "UPDATE persona SET estadoPersona = ? WHERE idPersona = $this->intIdUsuario";
        $arrData = array($status);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function removeCargoClientes(int $idpersona, int $idcargo, string $descrip) {
        $this->intIdUsuario = $idpersona;
        $this->idNegocio = $idcargo;
        $this->description = $descrip;
        $sql = "UPDATE detallecargocliente SET negocio_idDetalle=? ,descripcionCargo=? WHERE perdona_idDetalle = {$this->intIdUsuario}";
        $arrData = array($this->idNegocio,
            $this->description);
        $request = $this->update($sql, $arrData);
        return $request;
    }

}

?>