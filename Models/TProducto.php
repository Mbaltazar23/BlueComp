<?php

require_once("Libraries/Core/Mysql.php");

trait TProducto {

    private $con;
    private $strCategoria;
    private $intIdcategoria;
    private $intIdProducto;
    private $strProducto;
    private $cant;
    private $option;
    private $codigoCupon;
    private $strRuta;

    public function getLastProductosT(int $cantidadProductos) {
        $this->con = new Mysql();
        $this->intIdcategoria = IDCATCUPON;
        $sql = "SELECT p.idproducto,
		       p.nombrePro,
		       p.descripcionPro,
		       p.categoriaPro,
		       c.nombreCategoria as categoria,
		       p.precioPro,
		       p.rutaPro,
		       p.stockPro,
                       pre.estadoPreferencia
		FROM producto p 
		INNER JOIN categoria c
		ON p.categoriaPro = c.idcategoria INNER JOIN preferencia pre 
        ON pre.productoPreferencia = p.idproducto 
        WHERE p.estadoPro = 1 AND pre.estadoPreferencia = 2 AND categoriaPro != $this->intIdcategoria "
                . "GROUP BY p.idproducto ORDER BY p.idproducto DESC LIMIT " . $cantidadProductos;
        $request = $this->con->select_all($sql);
        if (count($request) > 0) {
            for ($c = 0; $c < count($request); $c++) {
                $intIdProducto = $request[$c]['idproducto'];
                $sqlImg = "SELECT img FROM imagen WHERE productoIDImg = $intIdProducto";
                $arrImg = $this->con->select_all($sqlImg);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }
                $request[$c]['images'] = $arrImg;
            }
        }
        return $request;
    }

    public function getProductosT(int $idcat = null) {
        $this->con = new Mysql();
        $this->intIdcategoria = IDCATCUPON;
        $where = " AND p.categoriaPro != $this->intIdcategoria AND pre.estadoPreferencia = 2";
        if ($idcat != null) {
            $this->intIdcategoria = $idcat;
            $where = " AND p.categoriaPro = $this->intIdcategoria AND pre.estadoPreferencia = 2";
        }
        $sql = "SELECT p.idproducto,
		       p.nombrePro,
		       p.descripcionPro,
		       p.categoriaPro,
		       c.nombreCategoria as categoria,
		       p.precioPro,
		       p.rutaPro,
		       p.stockPro,
                       pre.estadoPreferencia
		FROM producto p 
		INNER JOIN categoria c
		ON p.categoriaPro = c.idcategoria INNER JOIN preferencia pre 
        ON pre.productoPreferencia = p.idproducto 
        WHERE p.estadoPro = 1 $where GROUP BY p.idproducto ORDER BY p.idproducto DESC LIMIT " . CANTPORDHOME;
        $request = $this->con->select_all($sql);
        if (count($request) > 0) {
            for ($c = 0; $c < count($request); $c++) {
                $intIdProducto = $request[$c]['idproducto'];
                $sqlImg = "SELECT img FROM imagen WHERE productoIDImg = $intIdProducto";
                $arrImg = $this->con->select_all($sqlImg);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }
                $request[$c]['images'] = $arrImg;
            }
        }
        return $request;
    }

    public function getProductosPage($desde, $porpagina, int $categoria = null) {
        $this->con = new Mysql();
        $this->intIdcategoria = IDCATCUPON;
        $where = " AND p.categoriaPro != $this->intIdcategoria AND pre.estadoPreferencia = 2";
        if ($categoria != null) {
            $this->intIdcategoria = $categoria;
            $where = " AND p.categoriaPro = $this->intIdcategoria AND pre.estadoPreferencia = 2";
        }
        $sql = "SELECT p.idproducto,
		       p.nombrePro,
		       p.descripcionPro,
		       p.categoriaPro,
		       c.nombreCategoria as categoria,
		       p.precioPro,
		       p.rutaPro,
		       p.stockPro,
                       pre.estadoPreferencia
		       FROM producto p 
		       INNER JOIN categoria c
		       ON p.categoriaPro = c.idcategoria INNER JOIN preferencia pre 
                       ON pre.productoPreferencia = p.idproducto
		       WHERE p.estadoPro = 1 AND pre.estadoPreferencia = 2 $where"
                . " GROUP BY p.idproducto ORDER BY p.idproducto DESC LIMIT $desde,$porpagina";
        $request = $this->con->select_all($sql);
        if (count($request) > 0) {
            for ($c = 0; $c < count($request); $c++) {
                $intIdProducto = $request[$c]['idproducto'];
                $sqlImg = "SELECT img FROM imagen WHERE productoIDImg = $intIdProducto";
                $arrImg = $this->con->select_all($sqlImg);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }
                $request[$c]['images'] = $arrImg;
            }
        }
        return $request;
    }

    public function getProductoT(int $idproducto, string $ruta) {
        $this->con = new Mysql();
        $this->intIdProducto = $idproducto;
        $this->strRuta = $ruta;
        $sql = "SELECT p.idproducto,
		       p.nombrePro,
		       p.descripcionPro,
		       p.categoriaPro,
		       c.nombreCategoria as categoria,
		       p.precioPro,
		       p.rutaPro,
		       p.stockPro
		       FROM producto p 
		       INNER JOIN categoria c
		       ON p.categoriaPro = c.idcategoria
		       WHERE p.estadoPro != 0 AND p.idproducto = '{$this->intIdProducto}' AND p.rutaPro = '{$this->strRuta}' ";
        $request = $this->con->select($sql);
        if (!empty($request)) {
            $intIdProducto = $request['idproducto'];
            $sqlImg = "SELECT img FROM imagen WHERE productoIDImg = $intIdProducto";
            $arrImg = $this->con->select_all($sqlImg);
            if (count($arrImg) > 0) {
                for ($i = 0; $i < count($arrImg); $i++) {
                    $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                }
            } else {
                $arrImg[0]['url_image'] = media() . '/images/uploads/product.png';
            }
            $request['images'] = $arrImg;
        }
        return $request;
    }

    public function getProductosRandom(int $idcategoria, int $cant, string $option) {
        $this->intIdcategoria = $idcategoria;
        $this->cant = $cant;
        $this->option = $option;

        if ($option == "r") {
            $this->option = " RAND() ";
        } else if ($option == "a") {
            $this->option = " idproducto ASC ";
        } else {
            $this->option = " idproducto DESC ";
        }

        $this->con = new Mysql();
        $sql = "SELECT p.idproducto,
		       p.nombrePro,
		       p.descripcionPro,
		       p.categoriaPro,
		       c.nombreCategoria as categoria,
		       p.precioPro,
		       p.rutaPro,
		       p.stockPro,
		       pre.estadoPreferencia
		       FROM producto p 
		       INNER JOIN categoria c
		       ON p.categoriaPro = c.idcategoria INNER JOIN preferencia pre 
                       ON pre.productoPreferencia = p.idproducto
		       WHERE p.estadoPro != 0 AND pre.estadoPreferencia = 2 AND p.categoriaPro = $this->intIdcategoria
		       GROUP BY p.idproducto ORDER BY $this->option LIMIT  $this->cant ";
        $request = $this->con->select_all($sql);
        if (count($request) > 0) {
            for ($c = 0; $c < count($request); $c++) {
                $intIdProducto = $request[$c]['idproducto'];
                $sqlImg = "SELECT img FROM imagen WHERE productoIDImg = $intIdProducto";
                $arrImg = $this->con->select_all($sqlImg);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }
                $request[$c]['images'] = $arrImg;
            }
        }
        return $request;
    }

    public function getProductoIDT(int $idproducto) {
        $this->con = new Mysql();
        $this->intIdProducto = $idproducto;
        $sql = "SELECT p.idproducto,
		       p.nombrePro,
		       p.descripcionPro,
		       p.categoriaPro,
		       c.nombreCategoria as categoria,
		       p.precioPro,
		       p.rutaPro,
		       p.stockPro
		       FROM producto p 
		       INNER JOIN categoria c
		       ON p.categoriaPro = c.idcategoria
		       WHERE p.estadoPro != 0 AND p.idproducto = '{$this->intIdProducto}' ";
        $request = $this->con->select($sql);
        if (!empty($request)) {
            $intIdProducto = $request['idproducto'];
            $sqlImg = "SELECT img FROM imagen WHERE productoIDImg = $intIdProducto";
            $arrImg = $this->con->select_all($sqlImg);
            if (count($arrImg) > 0) {
                for ($i = 0; $i < count($arrImg); $i++) {
                    $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                }
            } else {
                $arrImg[0]['url_image'] = media() . '/images/uploads/product.png';
            }
            $request['images'] = $arrImg;
        }
        return $request;
    }

    public function cantProductos($categoria = null) {
        $this->con = new Mysql();
        $this->intIdcategoria = IDCATCUPON;
        $where = " AND p.categoriaPro != $this->intIdcategoria AND pre.estadoPreferencia = 2";
        if ($categoria != null) {
            $this->intIdcategoria = $categoria;
            $where = " AND p.categoriaPro = $this->intIdcategoria AND pre.estadoPreferencia = 2";
        }
        $sql = "SELECT p.idproducto,
		       p.nombrePro,
		       p.descripcionPro,
		       p.categoriaPro,
		       c.nombreCategoria as categoria,
		       p.precioPro,
		       p.rutaPro,
		       p.stockPro,
                       pre.estadoPreferencia
		FROM producto p 
		INNER JOIN categoria c
		ON p.categoriaPro = c.idcategoria INNER JOIN preferencia pre 
        ON pre.productoPreferencia = p.idproducto 
        WHERE p.estadoPro = 1 $where GROUP BY p.idproducto ORDER BY p.idproducto DESC LIMIT " . CANTPORDHOME;
        $result_register = $this->con->select($sql);
        $total_registro = "";
        if (!empty($result_register)) {
            $total_registro = $result_register;
        }
        return $total_registro;
    }

    public function cantProdSearch($busqueda) {
        $this->con = new Mysql();
        $this->intIdcategoria = IDCATCUPON;
        $sql = "SELECT COUNT(*) as total_registro FROM producto WHERE nombrePro LIKE '%$busqueda%' AND estadoPro = 1 AND categoriaPro != $this->intIdcategoria";
        $result_register = $this->con->select($sql);
        $total_registro = $result_register;
        return $total_registro;
    }

    public function getProdSearch($busqueda, $desde, $porpagina, int $categoria) {
        $this->con = new Mysql();
        $this->intIdcategoria = $categoria;
        $sql = "SELECT p.idproducto,
		       p.nombrePro,
		       p.descripcionPro,
		       p.categoriaPro,
		       c.nombreCategoria as categoria,
		       p.precioPro,
		       p.rutaPro,
		       p.stockPro,
		       pre.estadoPreferencia
		       FROM producto p 
		       INNER JOIN categoria c
		       ON p.categoriaPro = c.idcategoria INNER JOIN preferencia pre 
                       ON pre.productoPreferencia = p.idproducto
		       WHERE p.estadoPro != 0 AND pre.estadoPreferencia = 2 AND p.nombrePro LIKE '%$busqueda%' "
                . "AND p.categoriaPro = {$this->intIdcategoria} GROUP BY p.idproducto ORDER BY p.idproducto DESC LIMIT $desde,$porpagina";
        $request = $this->con->select_all($sql);
        if (count($request) > 0) {
            for ($c = 0; $c < count($request); $c++) {
                $intIdProducto = $request[$c]['idproducto'];
                $sqlImg = "SELECT img FROM imagen WHERE productoIDImg = $intIdProducto";
                $arrImg = $this->con->select_all($sqlImg);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }
                $request[$c]['images'] = $arrImg;
            }
        }
        return $request;
    }

    public function updateCantProducto(int $idproducto, int $cantidad) {
        $this->con = new Mysql();
        $newCant = 0;
        $this->intIdProducto = $idproducto;
        $this->cant = $cantidad;
        $sql = "SELECT * FROM producto WHERE idproducto ='{$this->intIdProducto}'";
        $requestSelect = $this->con->select($sql);
        if (!empty($requestSelect)) {
            $cantidadActual = intval($requestSelect["stockPro"]);
            $this->cant = $newCant = $cantidadActual - $cantidad;
            $sqlUpdate = "UPDATE producto SET stockPro = ? WHERE idproducto = '{$this->intIdProducto}'";
            $arrData = array($this->cant);
            $request = $this->con->update($sqlUpdate, $arrData);
            $return = $request;
        } else {
            $return = "no exist";
        }
        return $return;
    }

    public function getCuponesPreferidos() {
        $this->con = new Mysql();
        $this->intIdcategoria = IDCATCUPON;
        $sql = "SELECT p.idproducto, p.nombrePro, p.descripcionPro, p.categoriaPro, p.precioPro, p.rutaPro, "
                . "p.stockPro FROM producto p WHERE p.estadoPro = 2 AND categoriaPro = $this->intIdcategoria GROUP BY p.idproducto";
        $request = $this->con->select_all($sql);
        return $request;
    }

    public function getCuponDescount(string $codigo) {
        $this->con = new Mysql();
        $this->codigoCupon = $codigo;
        $sql = "SELECT producto.idproducto,producto.nombrePro, producto.precioPro, producto.stockPro, "
                . "producto.estadoPro,producto.rutaPro,producto.categoriaPro, categoria.nombreCategoria as categoria FROM producto "
                . "INNER JOIN categoria ON producto.categoriaPro = categoria.idcategoria WHERE producto.nombrePro = '{$this->codigoCupon}' "
                . "AND estadoPro = 2";
        $request = $this->con->select($sql);
        return $request;
    }

}

?>