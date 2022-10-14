<?php

require_once("Libraries/Core/Mysql.php");

trait TCategoria {

    private $con;

    public function getCategoriasT(string $categorias) {
        $this->con = new Mysql();
        $sql = "SELECT idcategoria, nombreCategoria,descripcionCategoria FROM categoria "
                . "WHERE estadoCategoria != 0 AND idcategoria != " . IDCATCUPON . " AND idcategoria LIMIT $categorias";
        $request = $this->con->select_all($sql);
        return $request;
    }

    public function getCategorias() {
        $this->con = new Mysql();
        $sql = "SELECT idcategoria,nombreCategoria,descripcionCategoria FROM categoria WHERE estadoCategoria != 0 AND idcategoria != " . IDCATCUPON . " ";
        $request = $this->con->select_all($sql);
        return $request;
    }

    public function getNameCategoria(int $idcategoria) {
        $this->con = new Mysql();
        $sql = "SELECT idcategoria,nombreCategoria,descripcionCategoria FROM categoria WHERE estadoCategoria != 0 AND idcategoria = $idcategoria";
        $request = $this->con->select($sql);
        $name = $request["nombreCategoria"];
        return $name;
    }

    
}

?>