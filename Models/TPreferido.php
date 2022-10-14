<?php

require_once("Libraries/Core/Mysql.php");

trait TPreferido {

    private $Idpreferencia;
    private $Idpersona;
    private $Idproducto;
    private $Estadopref;

    public function selectPreferenciasCliente(int $idpersona) {
        $this->con = new Mysql();
        $this->Idpersona = $idpersona;
        $sql = "SELECT preferencia.idPreferencia,producto.idproducto,producto.nombrePro,producto.rutaPro,producto.precioPro,"
                . "categoria.nombreCategoria as categoria, rol.nombreRol, persona.rolPersona FROM preferencia "
                . "INNER JOIN producto ON preferencia.productoPreferencia = producto.idproducto INNER JOIN persona "
                . "ON preferencia.personaPreferencia = persona.idPersona INNER JOIN rol ON persona.rolPersona = rol.idRol "
                . "INNER JOIN categoria ON producto.categoriaPro = categoria.idcategoria WHERE preferencia.estadoPreferencia = 1 "
                . " AND persona.idPersona = '{$this->Idpersona}' AND categoria.idcategoria !=" . IDCATCUPON;
        $request = $this->con->select_all($sql);
        if (count($request) > 0) {
            for ($pre = 0; $pre < count($request); $pre++) {
                $intIdProducto = $request[$pre]['idproducto'];
                $sqlImg = "SELECT img FROM imagen WHERE productoIDImg = $intIdProducto";
                $arrImg = $this->con->select_all($sqlImg);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }
                $request[$pre]['images'] = $arrImg;
            }
        }
        return $request;
    }

    public function insertPreferido(int $idpersona, int $idproducto, int $status) {
        $this->con = new Mysql();
        $this->Idpersona = $idpersona;
        $this->Idproducto = $idproducto;
        $this->Estadopref = $status;
        $return = 0;
        $sql = "SELECT * FROM preferencia WHERE personaPreferencia = '{$this->Idpersona}' AND productoPreferencia = '{$this->Idproducto}' "
                . "AND estadoPreferencia = 1";
        $request = $this->con->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO preferencia(personaPreferencia,productoPreferencia,estadoPreferencia) VALUES (?,?,?)";
            $arrData = array($this->Idpersona,
                $this->Idproducto,
                $this->Estadopref);
            $request_insert = $this->con->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function UpdateStatusPreferido(int $idpreferido, int $status) {
        $this->con = new Mysql();
        $this->Idpreferencia = $idpreferido;
        $this->Estadopref = $status;
        $sql = "UPDATE preferencia SET estadoPreferencia = ? WHERE idPreferencia = '{$this->Idpreferencia}'";
        $arrData = array($status);
        $request = $this->con->update($sql, $arrData);
        return $request;
    }

    public function searchProductPreference(int $idproducto, int $idpersona) {
        $this->con = new Mysql();
        $this->Idproducto = $idproducto;
        $this->Idpersona = $idpersona;
        $sql = "SELECT * FROM preferencia WHERE productoPreferencia = '{$this->Idproducto}' "
                . "AND personaPreferencia = '{$this->Idpersona}' AND (estadoPreferencia = 2 OR estadoPreferencia = 0)";
        $request = $this->con->select($sql);
        return $request;
    }

    public function UpdateTendenciaProducto(int $idproducto, int $idpersona, int $status) {
        $this->con = new Mysql();
        $this->Idproducto = $idproducto;
        $this->Idpersona = $idpersona;
        $this->Estadopref = $status;
        $sql = "SELECT * FROM preferencia WHERE productoPreferencia = '{$this->Idproducto}' AND personaPreferencia = '{$this->Idpersona}'";
        $requestSelect = $this->con->select($sql);
        if (!empty($requestSelect)) {
            $sqlUpdate = "UPDATE preferencia SET estadoPreferencia = ? WHERE productoPreferencia = '{$this->Idproducto}' "
                    . "AND personaPreferencia = '{$this->Idpersona}'";
            $arrData = array($status);
            $request = $this->con->update($sqlUpdate, $arrData);
            $return = $request;
        } else if (empty($requestSelect)) {
            $sqlInsert = "INSERT INTO preferencia(personaPreferencia,productoPreferencia,estadoPreferencia) VALUES (?,?,?)";
            $arrData = array($this->Idpersona,
                $this->Idproducto,
                $this->Estadopref);
            $request_insert = $this->con->insert($sqlInsert, $arrData);
            $return = $request_insert;
        } else {
            $return = 1;
        }
        return $return;
    }

    public function getProductPreference(int $idpreferencia) {
        $this->con = new Mysql();
        $this->Idpreferencia = $idpreferencia;
        $sql = "SELECT * FROM preferencia WHERE idPreferencia = '{$this->Idpreferencia}'";
        $request = $this->con->select($sql);
        return $request;
    }

    public function CheckProductTendence(int $idproducto) {
        $this->con = new Mysql();
        $this->Idproducto = $idproducto;
        $sql = "SELECT * FROM preferencia WHERE productoPreferencia = $this->Idproducto "
                . "AND estadoPreferencia = 2";
        $request = $this->con->select_all($sql);
        return $request;
    }

}
