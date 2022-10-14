<?php

require_once("Libraries/Core/Mysql.php");

trait TSuscripcion {

    private $idDetalleSus;
    private $statusSuscripcion;
    private $cantProductSuscript;
    private $Idpersona;
    private $intTipoRolId;
    private $intIdCategoria;
    private $IdSuscript;
    private $Idproducto;
    private $correoCliente;
    private $EstadoSus;

    public function selectSuscripcionCliente(int $idpersona) {
        $this->con = new Mysql();
        $this->Idpersona = $idpersona;
        $sql = "SELECT detallesuscripcion.idDetalleSuscripcion,detallesuscripcion.productoSuscrito,producto.nombrePro, categoria.nombreCategoria as Categoria,producto.rutaPro,"
                . "producto.categoriaPro,detallesuscripcion.cantidadProSuscrito, detallesuscripcion.precioProSuscrito FROM detallesuscripcion INNER JOIN suscripcion "
                . "ON detallesuscripcion.suscripcionDetalle = suscripcion.idSuscripcion INNER JOIN persona ON suscripcion.personaSuscripcion = persona.idPersona INNER JOIN producto ON detallesuscripcion.productoSuscrito = producto.idproducto "
                . "INNER JOIN categoria ON producto.categoriaPro = categoria.idcategoria WHERE suscripcion.estadoSuscripcion != 0 "
                . "AND persona.idPersona = '{$this->Idpersona}'";
        $request = $this->con->select_all($sql);
        if (count($request) > 0) {
            for ($pro = 0; $pro < count($request); $pro++) {
                $intIdProducto = $request[$pro]['productoSuscrito'];
                $sqlImg = "SELECT img FROM imagen WHERE productoIDImg = $intIdProducto";
                $arrImg = $this->con->select_all($sqlImg);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }
                $request[$pro]['images'] = $arrImg;
            }
        }
        return $request;
    }

    public function insertSuscripcion(int $idpersona, int $status) {
        $this->con = new Mysql();
        $this->Idpersona = $idpersona;
        $this->statusSuscripcion = $status;
        $this->intTipoRolId = ROLCLIENTE;
        $return = 0;
        $sql = "SELECT suscripcion.idSuscripcion, suscripcion.personaSuscripcion, persona.rolPersona "
                . "FROM suscripcion INNER JOIN persona ON suscripcion.personaSuscripcion = persona.idPersona "
                . "WHERE persona.rolPersona = '{$this->intTipoRolId}' AND persona.idPersona = '{$this->Idpersona}'";
        $request = $this->con->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO suscripcion(personaSuscripcion,estadoSuscripcion) VALUES(?,?)";
            $arrData = array($this->Idpersona,
                $this->statusSuscripcion);
            $request_insert = $this->con->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function removeProductoSuscrip(int $idDetailSus) {
        $this->con = new Mysql();
        $this->idDetalleSus = $idDetailSus;
        $sql = "DELETE FROM detallesuscripcion WHERE idDetalleSuscripcion = '{$this->idDetalleSus}'";
        $request = $this->con->delete($sql);
        return $request;
    }

    public function removeSuscripcionCliente(int $idpersona) {
        $this->con = new Mysql();
        $this->Idpersona = $idpersona;
        $sql = "SELECT suscripcion.idSuscripcion, suscripcion.estadoSuscripcion, persona.idPersona, persona.nombrePersona,"
                . "persona.apellidoPersona FROM suscripcion INNER JOIN persona ON suscripcion.personaSuscripcion = persona.idPersona "
                . "WHERE persona.idPersona = '{$this->Idpersona}'";
        $request = $this->con->select($sql);
        if (!empty($request)) {
            $this->IdSuscript = $request["idSuscripcion"];
            $sqlUpdate = "UPDATE suscripcion SET estadoSuscripcion = ? WHERE idSuscripcion ='{$this->IdSuscript}'";
            $arrData = array(0);
            $request = $this->con->update($sqlUpdate, $arrData);
            $return = $request;
        }
        return $return;
    }

    public function removeProductosFromCliente(int $idSuscripcion) {
        $this->con = new Mysql();
        $this->IdSuscript = $idSuscripcion;
        $sql = "DELETE FROM detallesuscripcion WHERE suscripcionDetalle = '{$this->IdSuscript}'";
        $request = $this->con->delete($sql);
        return $request;
    }

    public function removeProductSuscript(int $idproducto) {
        $this->con = new Mysql();
        $this->idProducto = $idproducto;
        $sql = "DELETE FROM detallesuscripcion WHERE productoSuscrito ='{$this->idProducto}'";
        $request = $this->con->delete($sql);
        return $request;
    }

    public function getSuscripcionCliente(string $email) {
        $this->con = new Mysql();
        $this->correoCliente = $email;
        $sql = "SELECT suscripcion.idSuscripcion, suscripcion.estadoSuscripcion, persona.idPersona, persona.nombrePersona,"
                . "persona.apellidoPersona FROM suscripcion INNER JOIN persona ON suscripcion.personaSuscripcion = persona.idPersona "
                . "WHERE persona.emailPersona = '{$this->correoCliente}'";
        $request = $this->con->select($sql);
        return $request;
    }

    public function updateSuscripcion(string $correo, int $status) {
        $this->con = new Mysql();
        $this->correoCliente = $correo;
        $this->statusSuscripcion = $status;
        $sql = "SELECT idPersona, nombrePersona, apellidoPersona, rolPersona FROM persona "
                . "WHERE estadoPersona != 0 AND emailPersona = '{$this->correoCliente}'";
        $request = $this->con->select($sql);
        if (!empty($request)) {
            $this->Idpersona = $request["idPersona"];
            $sqlUpdate = "UPDATE suscripcion SET estadoSuscripcion = ? WHERE personaSuscripcion = '{$this->Idpersona}'";
            $arrData = array($this->statusSuscripcion);
            $request = $this->con->update($sqlUpdate, $arrData);
            $return = $request;
        }
        return $return;
    }

    public function getProductSuscript(int $idproducto, int $idpersona) {
        $this->con = new Mysql();
        $this->Idpersona = $idpersona;
        $this->Idproducto = $idproducto;
        $sql = "SELECT p.nombrePersona,p.apellidoPersona, ds.idDetalleSuscripcion, s.personaSuscripcion, ds.productoSuscrito, "
                . "ds.cantidadProSuscrito FROM detallesuscripcion ds INNER JOIN suscripcion s ON ds.suscripcionDetalle = s.idSuscripcion "
                . "INNER JOIN persona p ON s.personaSuscripcion = p.idPersona WHERE ds.productoSuscrito = '{$this->Idproducto}' "
                . "AND p.idPersona = '{$this->Idpersona}'";
        $request = $this->con->select($sql);
        return $request;
    }

}
