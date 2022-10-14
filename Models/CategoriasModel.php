<?php

class CategoriasModel extends Mysql {

    public $intIdcategoria;
    public $NombreCategoria;
    public $strDescripcion;
    public $strfecha;
    public $intStatus;

    public function __construct() {
        parent::__construct();
    }

    public function selectCategorias() {
        $this->intIdcategoria = IDCATCUPON;
        $sql = "SELECT categoria.idcategoria, categoria.nombreCategoria,"
                . "categoria.descripcionCategoria, DATE_FORMAT(categoria.fechaCategoria, '%d-%m-%Y') as fechaCat,"
                . "categoria.estadoCategoria FROM categoria WHERE idcategoria != $this->intIdcategoria";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectCategoria(int $idcategoria) {
        $this->intIdcategoria = $idcategoria;
        $sql = "SELECT categoria.idcategoria, categoria.nombreCategoria,"
                . "categoria.descripcionCategoria, DATE_FORMAT(categoria.fechaCategoria, '%d-%m-%Y') as fechaCat,"
                . "categoria.estadoCategoria FROM categoria WHERE idcategoria = $this->intIdcategoria";
        $request = $this->select($sql);
        return $request;
    }

    public function inserCategoria(string $nombre, string $descripcion, int $status, string $fecha) {
        $return = 0;
        $this->NombreCategoria = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;
        $this->strfecha = $fecha;
        $sql = "SELECT * FROM categoria WHERE nombreCategoria = '{$this->NombreCategoria}' ";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO categoria(nombreCategoria,descripcionCategoria,estadoCategoria,fechaCategoria) VALUES(?,?,?,?)";
            $arrData = array($this->NombreCategoria,
                $this->strDescripcion,
                $this->intStatus,
                $this->strfecha);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateCategoria(int $idcategoria, string $categoria, string $descripcion, int $status, string $fecha) {
        $this->intIdcategoria = $idcategoria;
        $this->NombreCategoria = $categoria;
        $this->strDescripcion = $descripcion;
        $this->intStatus = $status;
        $this->strfecha = $fecha;
        $sql = "SELECT * FROM categoria WHERE nombreCategoria = '{$this->NombreCategoria}' AND idcategoria != $this->intIdcategoria";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE categoria SET nombreCategoria = ?, descripcionCategoria = ? , fechaCategoria=?  WHERE idcategoria = $this->intIdcategoria ";
            $arrData = array($this->NombreCategoria,
                $this->strDescripcion,
                $this->strfecha);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function updateStatusCategoria(int $idcategoria, int $status) {
        $this->intIdcategoria = $idcategoria;
        $this->intStatus = $status;
        $sql = "SELECT * FROM producto WHERE categoriaPro = $this->intIdcategoria";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE categoria SET estadoCategoria = ? WHERE idcategoria = $this->intIdcategoria ";
            $arrData = array($this->intStatus);
            $request = $this->update($sql, $arrData);
            if ($request) {
                $request = 'ok';
            } else {
                $request = 'error';
            }
        } else {
            $request = 'exist';
        }
        return $request;
    }

    public function selectCategoriasPro() {
        $this->intIdcategoria = IDCATCUPON;
        $sql = "SELECT categoria.idcategoria, categoria.nombreCategoria,"
                . "categoria.descripcionCategoria, DATE_FORMAT(categoria.fechaCategoria, '%d-%m-%Y') as fechaCat,"
                . "categoria.estadoCategoria FROM categoria WHERE idcategoria != $this->intIdcategoria AND categoria.estadoCategoria != 0";
        $request = $this->select_all($sql);
        return $request;
    }

}

?>