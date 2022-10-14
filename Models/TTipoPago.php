<?php

require_once("Libraries/Core/Mysql.php");

trait TTipoPago {

    private $con;
    private $IdComuna;

    public function getTiposPagoT() {
        $this->con = new Mysql();
        $sql = "SELECT * FROM tipopago WHERE estadoTipoPago != 0";
        $request = $this->con->select_all($sql);
        return $request;
    }

    public function getComunasAll() {
        $this->con = new Mysql();
        $sql = "SELECT * FROM comuna";
        $request = $this->con->select_all($sql);
        return $request;
    }

    public function getDireccionesForComuna(int $idComuna) {
        $this->con = new Mysql();
        $this->IdComuna = $idComuna;
        $sql = "SELECT * FROM direccion WHERE comunaIdDireccion = '{$this->IdComuna}'";
        $request = $this->con->select_all($sql);
        return $request;
    }

}

?>