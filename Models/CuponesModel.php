<?php

class CuponesModel extends Mysql {

    private $idproducto;
    private $nombrePro;
    private $rutaPro;
    private $precioPro;
    private $fechaPro;
    private $stockPro;
    private $estadoPro;
    private $categoriaPro;

    public function __construct() {
        parent::__construct();
    }

    public function selectCupons() {
        $this->categoriaPro = IDCATCUPON;
        $sql = "SELECT producto.idproducto, producto.nombrePro,producto.rutaPro,"
                . "producto.precioPro, producto.stockPro, producto.estadoPro, categoria.nombreCategoria "
                . "FROM producto INNER JOIN categoria ON producto.categoriaPro = categoria.idcategoria WHERE idcategoria = $this->categoriaPro";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertCupon(string $codigo, string $ruta, float $descuento, string $fecha, int $cantidad, int $status) {
        $this->nombrePro = $codigo;
        $this->rutaPro = $ruta;
        $this->precioPro = $descuento;
        $this->fechaPro = $fecha;
        $this->stockPro = $cantidad;
        $this->estadoPro = $status;
        $this->categoriaPro = IDCATCUPON;
        $return = 0;
        $sql = "SELECT * FROM producto WHERE nombrePro = '{$this->nombrePro}' AND categoriaPro ='{$this->categoriaPro}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO producto(nombrePro,precioPro,stockPro,"
                    . "fechaPro,estadoPro,categoriaPro,rutaPro) VALUES (?,?,?,?,?,?,?)";
            $arrData = array($this->nombrePro,
                $this->precioPro,
                $this->stockPro,
                $this->fechaPro,
                $this->estadoPro,
                $this->categoriaPro,
                $this->rutaPro);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateCupon(string $codigo, string $ruta, float $descuento, string $fecha, int $cantidad, int $status, int $idproduct) {
        $this->nombrePro = $codigo;
        $this->rutaPro = $ruta;
        $this->precioPro = $descuento;
        $this->fechaPro = $fecha;
        $this->stockPro = $cantidad;
        $this->estadoPro = $status;
        $this->categoriaPro = IDCATCUPON;
        $this->idproducto = $idproduct;
        $return = 0;
        $sql = "SELECT * FROM producto WHERE nombrePro = '{$this->nombrePro}' AND idproducto != {$this->idproducto} "
                . " AND categoriaPro ='{$this->categoriaPro}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sqlUpdate = "UPDATE producto SET nombrePro=?, precioPro=?, stockPro=?, estadoPro=?, rutaPro=?,categoriaPro=?, fechaPro=?  "
                    . "WHERE idproducto = $this->idproducto";
            $arrData = array($this->nombrePro,
                $this->precioPro,
                $this->stockPro,
                $this->estadoPro,
                $this->rutaPro,
                $this->categoriaPro,
                $this->fechaPro);
            $request = $this->update($sqlUpdate, $arrData);
            $return = $request;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function selectCupon(int $idproducto) {
        $this->idproducto = $idproducto;
        $this->categoriaPro = IDCATCUPON;
        $sql = "SELECT producto.idproducto,producto.nombrePro,producto.precioPro, producto.stockPro,DATE_FORMAT(producto.fechaPro,'%d-%m-%Y') AS fechaCup,"
                . "DATE_FORMAT(producto.fechaPro, '%H:%i:%s') AS horaCup, producto.estadoPro FROM producto INNER JOIN categoria "
                . "ON producto.categoriaPro = categoria.idcategoria WHERE idproducto = $this->idproducto AND categoriaPro = $this->categoriaPro";
        $request = $this->select($sql);
        return $request;
    }

    public function updateStatusCupon(int $idproducto, int $status) {
        $this->idproducto = $idproducto;
        $this->estadoPro = $status;
        $sql = "SELECT * FROM preferencia WHERE productoPreferencia = $this->idproducto AND estadoPreferencia = 2";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE producto SET estadoPro = ? WHERE idproducto = $this->idproducto";
            $arrData = array($this->estadoPro);
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

}
