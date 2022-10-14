<?php

require_once("Libraries/Core/Mysql.php");

trait TCliente {

    private $con;
    private $intIdUsuario;
    private $intIdPedido;
    private $strNombre;
    private $strApellido;
    private $strStatus;
    private $intTelefono;
    private $strEmail;
    private $strPassword;
    private $intTipoRolId;
    private $intNegocio;
    private $intIdTransaccion;
    private $ComentarioCliente;
    private $estadoCliente;
    private $estadoPedido;

    public function insertCliente(string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, string $comentario, int $estado) {
        $this->con = new Mysql();
        $this->strNombre = $nombre;
        $this->strApellido = $apellido;
        $this->intTelefono = $telefono;
        $this->strEmail = $email;
        $this->strPassword = $password;
        $this->intTipoRolId = $tipoid;
        $this->ComentarioCliente = !empty($comentario) ? $comentario : "";
        $this->estadoCliente = $estado;
        $fechaRegistro = date("Y-m-d H:i:s");
        $return = 0;
        $sql = "SELECT * FROM persona WHERE emailPersona = '{$this->strEmail}' ";
        $request = $this->con->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO persona(nombrePersona,apellidoPersona,telefonoPersona,emailPersona,passwordPersona,fechaPersona,comentarioPersona,rolPersona,estadoPersona) 
							  VALUES(?,?,?,?,?,?,?,?,?)";
            $arrData = array($this->strNombre,
                $this->strApellido,
                $this->intTelefono,
                $this->strEmail,
                $this->strPassword,
                $fechaRegistro,
                $this->ComentarioCliente,
                $this->intTipoRolId,
                $this->estadoCliente);

            $request_insert = $this->con->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function insertPedido(int $personaid, float $costo_envio, float $subtotal, string $monto, int $tipopagoid, string $statusP, int $direccionP, string $status) {
        $this->con = new Mysql();
        $query_insert = "INSERT INTO pedido(personaIdPedido,costoEnvioPedido,subtotalPedido,montoTotalPedido,tipopagoPedido,statusPedido,direccionPedido,estadoPedido) 
							  VALUES(?,?,?,?,?,?,?,?)";
        $arrData = array(
            $personaid,
            $costo_envio,
            $subtotal,
            $monto,
            $tipopagoid,
            $statusP,
            $direccionP,
            $status
        );
        $request_insert = $this->con->insert($query_insert, $arrData);
        $return = $request_insert;
        return $return;
    }

    public function insertDetalle(int $idpedido, int $productoid, float $precio, int $cantidad) {
        $this->con = new Mysql();
        $query_insert = "INSERT INTO detallepedido(pedidoIdDetalle,productoIdDetalle,precioDetalle,cantidadDetalle) 
				          VALUES(?,?,?,?)";
        $arrData = array($idpedido,
            $productoid,
            $precio,
            $cantidad);
        $request_insert = $this->con->insert($query_insert, $arrData);
        $return = $request_insert;
        return $return;
    }

    public function insertNegocioDefault(int $idpersona, int $cargo, string $descrip) {
        $this->con = new Mysql();
        $query_insert = "INSERT INTO detallecargocliente(perdona_idDetalle,negocio_idDetalle,descripcionCargo) VALUES(?,?,?)";
        $arrData = array($idpersona,
            $cargo,
            $descrip);
        $request_insert = $this->con->insert($query_insert, $arrData);
        $return = $request_insert;
        return $return;
    }

    public function cantPedidosCliente(int $idpersona) {
        $this->con = new Mysql();
        $this->intIdUsuario = $idpersona;
        $sqlSelect = "SELECT * FROM pedido WHERE personaIdPedido = '{$this->intIdUsuario}' AND  estadoPedido != 0";
        $request = $this->con->select_all($sqlSelect);
        return $request;
    }

    public function getCorreoCliente(string $correo, int $idpersona) {
        $this->con = new Mysql();
        $this->strEmail = $correo;
        $this->intIdUsuario = $idpersona;
        $sql = "SELECT idPersona, nombrePersona, apellidoPersona, rolPersona FROM persona "
                . "WHERE estadoPersona != 0 AND emailPersona = '{$this->strEmail}' AND idPersona = {$this->intIdUsuario}";
        $request = $this->con->select($sql);
        return $request;
    }

    public function selectPedidos(int $idpersona) {
        $this->con = new Mysql();
        $sql = "SELECT p.idPedido, DATE_FORMAT(p.fechaPedido, '%d/%m/%Y') as fecha,"
                . " p.montoTotalPedido, tp.nombrePago, tp.idTipoPago, p.statusPedido, "
                . "d.nombreDireccion, c.nombreComuna FROM pedido p INNER JOIN tipopago tp "
                . "ON p.tipopagoPedido = tp.idTipoPago INNER JOIN direccion d ON p.direccionPedido = d.idDireccion "
                . "INNER JOIN comuna c ON d.comunaIdDireccion = c.idComuna WHERE p.estadoPedido != 0 AND p.personaIdPedido = " . $idpersona . " ORDER BY p.fechaPedido";
        $request = $this->con->select_all($sql);
        return $request;
    }

    public function updateStatusPedido(int $idpreferido, int $status, string $statusPedido) {
        $this->con = new Mysql();
        $this->intIdPedido = $idpreferido;
        $this->estadoPedido = $status;
        $this->strStatus = $statusPedido;
        $sql = "UPDATE pedido SET statusPedido = ?, estadoPedido = ? WHERE idPedido = '{$this->intIdPedido}'";
        $arrData = array($this->strStatus, $this->estadoPedido);
        $request = $this->con->update($sql, $arrData);
        return $request;
    }

    public function getCuentaCliente(int $idpersona) {
        $this->con = new Mysql();
        $sql = "SELECT * FROM persona WHERE idPersona = " . $idpersona;
        $request = $this->con->select($sql);
        return $request;
    }

}
