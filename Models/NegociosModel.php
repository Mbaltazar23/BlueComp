<?php

class NegociosModel extends Mysql {

    private $intIdNegocio;
    private $intIdDetailNegocio;
    private $intIdPersona;
    private $nameNegocio;
    private $descricionNegocio;
    private $statusNegocio;

    public function __construct() {
        parent::__construct();
    }

    public function selectNegocios() {
        $sql = "SELECT * FROM negocio WHERE idNegocio !=" . SINNEGOCIO;
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectNegocio(int $idnegocio) {
        $this->intIdNegocio = $idnegocio;
        $sql = "SELECT * FROM negocio WHERE idNegocio ='{$this->intIdNegocio}'";
        $request = $this->select($sql);
        return $request;
    }

    public function insertNegocio(string $nombre, string $descripcion, int $status) {
        $this->nameNegocio = $nombre;
        $this->descricionNegocio = $descripcion;
        $this->statusNegocio = $status;
        $return = 0;
        $sql = "SELECT * FROM negocio WHERE negocioNombre ='{$this->nameNegocio}' AND estadoNegocio = 1";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO negocio(negocioNombre,negocioDescripcion,estadoNegocio) VALUES(?,?,?)";
            $arrData = array($this->nameNegocio,
                $this->descricionNegocio,
                $this->statusNegocio);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateNegocio(int $idnegocio, string $nombre, string $descripcion, int $status) {
        $this->nameNegocio = $nombre;
        $this->descricionNegocio = $descripcion;
        $this->statusNegocio = $status;
        $this->intIdNegocio = $idnegocio;
        $return = 0;
        $sql = "SELECT * FROM negocio WHERE negocioNombre ='{$this->nameNegocio}' AND idNegocio != $this->intIdNegocio";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sqlUpdate = "UPDATE negocio SET negocioNombre=?, negocioDescripcion=? WHERE idNegocio = $this->intIdNegocio";
            $arrData = array($this->nameNegocio,
                $this->descricionNegocio);
            $request_update = $this->update($sqlUpdate, $arrData);
            $return = $request_update;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function insertDetailNegocio(int $idpersona, int $idnegocio, string $descripcionCargo) {
        $this->intIdPersona = $idpersona;
        $this->intIdNegocio = $idnegocio;
        $this->descricionNegocio = $descripcionCargo;
        $return = 0;
        $sql = "SELECT * FROM detallecargocliente WHERE negocio_idDetalle = '{$this->intIdNegocio}' "
                . "AND perdona_idDetalle = '{$this->intIdPersona}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO detallecargocliente(negocio_idDetalle,perdona_idDetalle,descripcionCargo) VALUES(?,?,?)";
            $arrData = array($this->intIdNegocio,
                $this->intIdPersona,
                $this->descricionNegocio);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateDetailNegocio(int $idpersona, int $idnegocio, string $descripcionCargo, int $idDetailNegocio) {
        $this->intIdPersona = $idpersona;
        $this->intIdNegocio = $idnegocio;
        $this->descricionNegocio = $descripcionCargo;
        $this->intIdDetailNegocio = $idDetailNegocio;
        $return = 0;
        $sql = "SELECT * FROM detallecargocliente WHERE negocio_idDetalle = '{$this->intIdNegocio}' "
                . "AND id_detalleCargoCliente != '{$this->intIdDetailNegocio}' AND perdona_idDetalle = '{$this->intIdPersona}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sqlUpdate = "UPDATE detallecargocliente SET negocio_idDetalle=? ,descripcionCargo=?,perdona_idDetalle= ?"
                    . "WHERE id_detalleCargoCliente ='{$this->intIdDetailNegocio}'";
            $arrData = array($this->intIdNegocio,
                $this->descricionNegocio,
                $this->intIdPersona);
            $request_update = $this->update($sqlUpdate, $arrData);
            $return = $request_update;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function getDetailNegocio(int $idpersona) {
        $this->intIdPersona = $idpersona;
        $sql = "SELECT * FROM detallecargocliente WHERE perdona_idDetalle ='{$this->intIdPersona}'";
        $request = $this->select($sql);
        return $request;
    }

    public function updateCargoCliente(int $intIdpersona, int $status) {
        $this->intIdPersona = $intIdpersona;
        $sql = "UPDATE persona SET estadoPersona = ? WHERE idpersona = $this->intIdPersona ";
        $arrData = array($status);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    public function updateStatusNegocio(int $idNegocio, int $status) {
        $this->intIdNegocio = $idNegocio;
        $this->statusNegocio = $status;
        $sql = "UPDATE negocio SET estadoNegocio=? WHERE idNegocio = $this->intIdNegocio";
        $arrData = array($this->statusNegocio);
        $request = $this->update($sql, $arrData);
        return $request;
    }

}

?>