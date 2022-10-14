<?php

class SuscripcionesModel extends Mysql {

    private $intIdSuscrip;
    private $idProducto;
    private $idPersona;
    private $precioProducto;
    private $cantidadProducto;
    private $statusSuscrip;

    public function __construct() {
        parent::__construct();
    }

    public function selectSuscripciones() {
        $sql = "SELECT suscripcion.idSuscripcion,persona.emailPersona, DATE_FORMAT(suscripcion.fechaSuscripcion,'%d-%m-%Y') AS fechaSus, "
                . "DATE_FORMAT(suscripcion.fechaSuscripcion, '%H:%i:%s') AS horaSus, suscripcion.estadoSuscripcion FROM suscripcion "
                . "INNER JOIN persona ON suscripcion.personaSuscripcion = persona.idPersona";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertDetalleSuscripcion(int $idsuscription, int $idproducto, int $cantidad, float $precio) {
        $this->intIdSuscrip = $idsuscription;
        $this->idProducto = $idproducto;
        $this->cantidadProducto = $cantidad;
        $this->precioProducto = $precio;
        $query = "INSERT INTO detallesuscripcion(suscripcionDetalle,productoSuscrito,cantidadProSuscrito,precioProSuscrito) "
                . "VALUES(?,?,?,?)";
        $arrData = array($this->intIdSuscrip,
            $this->idProducto,
            $this->cantidadProducto,
            $this->precioProducto);
        $request_insert = $this->insert($query, $arrData);
        $return = $request_insert;
        return $return;
    }

    public function updateStatusSuscripcion(int $idsuscripcion, int $status) {
        $this->intIdSuscrip = $idsuscripcion;
        $this->statusSuscrip = $status;
        $sql = "UPDATE suscripcion SET estadoSuscripcion = ? WHERE idSuscripcion ='{$this->intIdSuscrip}'";
        $arrData = array($this->statusSuscrip);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function selectSuscripcion(int $idsuscripcion) {
        $this->intIdSuscrip = $idsuscripcion;
        $sql = "SELECT suscripcion.idSuscripcion,persona.emailPersona,DATE_FORMAT(suscripcion.fechaSuscripcion,'%d-%m-%Y') AS fechaSus, "
                . "DATE_FORMAT(suscripcion.fechaSuscripcion, '%H:%i:%s') AS horaSus, suscripcion.estadoSuscripcion FROM suscripcion "
                . "INNER JOIN persona ON suscripcion.personaSuscripcion = persona.idPersona WHERE suscripcion.idSuscripcion = '{$this->intIdSuscrip}'";
        $request = $this->select($sql);
        return $request;
    }

    public function selectAllProductsSuscripcion(int $idsuscripcion) {
        $this->intIdSuscrip = $idsuscripcion;
        $sql = "SELECT detallesuscripcion.idDetalleSuscripcion, detallesuscripcion.suscripcionDetalle, detallesuscripcion.productoSuscrito, "
                . "detallesuscripcion.cantidadProSuscrito, producto.nombrePro, detallesuscripcion.precioProSuscrito FROM detallesuscripcion "
                . "INNER JOIN producto WHERE detallesuscripcion.productoSuscrito = producto.idproducto "
                . "AND detallesuscripcion.suscripcionDetalle='{$this->intIdSuscrip}'";
        $request = $this->select_all($sql);
        return $request;
    }

    public function removeProductsSuscripcion(int $idsuscripcion) {
        $this->intIdSuscrip = $idsuscripcion;
        $sql = "DELETE FROM detallesuscripcion WHERE suscripcionDetalle = '{$this->intIdSuscrip}'";
        $request_delete = $this->delete($sql);
        return $request_delete;
    }

    public function getSuscripcionCliente(int $idpersona) {
        $this->idPersona = $idpersona;
        $sql = "SELECT suscripcion.idSuscripcion, suscripcion.estadoSuscripcion, persona.idPersona, persona.nombrePersona,"
                . "persona.apellidoPersona FROM suscripcion INNER JOIN persona ON suscripcion.personaSuscripcion = persona.idPersona "
                . "WHERE persona.idPersona = '{$this->idPersona}' AND suscripcion.estadoSuscripcion != 0";
        $request = $this->select($sql);
        if (!empty($request)) {
            $_SESSION["suscripcion"] = $request;
        } else {
            $_SESSION["suscripcion"] = "";
        }
        return $request;
    }

    public function selectCategoriasSus() {
        $sql = "SELECT categoria.idcategoria, producto.stockPro,categoria.nombreCategoria,categoria.descripcionCategoria, "
                . "DATE_FORMAT(categoria.fechaCategoria, '%d-%m-%Y') as fechaCat,categoria.estadoCategoria FROM categoria "
                . "INNER JOIN producto ON categoria.idcategoria = producto.categoriaPro WHERE producto.stockPro != 0 "
                . "AND categoria.estadoCategoria !=0 AND categoria.idcategoria != '" . IDCATCUPON . "' GROUP BY categoria.idcategoria";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectProductsCat(int $idcategoria) {
        $this->intIdCategoria = $idcategoria;
        $sql = "SELECT * FROM producto WHERE estadoPro != 0 AND categoriaPro =  $this->intIdCategoria";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectProductoSus(int $idproducto) {
        $this->Idproducto = $idproducto;
        $sql = "SELECT producto.idproducto,producto.nombrePro, producto.descripcionPro, producto.precioPro, "
                . "producto.stockPro, producto.estadoPro,producto.categoriaPro, categoria.nombreCategoria as categoria FROM producto "
                . "INNER JOIN categoria ON producto.categoriaPro = categoria.idcategoria WHERE idproducto = $this->Idproducto";
        $request = $this->select($sql);
        return $request;
    }

}
