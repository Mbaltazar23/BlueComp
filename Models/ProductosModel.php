<?php

class ProductosModel extends Mysql {

    private $intIdProducto;
    private $strNombre;
    private $strDescripcion;
    private $intCategoriaId;
    private $intPrecio;
    private $intStock;
    private $strFecha;
    private $intStatus;
    private $strRuta;
    private $strImagen;

    public function __construct() {
        parent::__construct();
    }

    public function selectProductos() {
        $this->intCategoriaId = IDCATCUPON;
        $sql = "SELECT producto.idproducto, producto.nombrePro, producto.descripcionPro, producto.rutaPro,"
                . "producto.precioPro, producto.stockPro, producto.estadoPro, categoria.nombreCategoria "
                . "FROM producto INNER JOIN categoria ON producto.categoriaPro = categoria.idcategoria WHERE idcategoria != $this->intCategoriaId";
        $request = $this->select_all($sql);
        return $request;
    }

    public function insertProducto(string $nombre, string $descripcion, int $categoriaid, int $precio, int $stock, int $status, string $fecha, string $ruta) {
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intCategoriaId = $categoriaid;
        $this->intPrecio = $precio;
        $this->intStock = $stock;
        $this->strFecha = $fecha;
        $this->strRuta = $ruta;
        $this->intStatus = $status;
        $return = 0;
        $sql = "SELECT * FROM producto WHERE nombrePro = '{$this->strNombre}'";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT INTO producto(nombrePro,descripcionPro, precioPro, stockPro,"
                    . "fechaPro,estadoPro,categoriaPro,rutaPro) VALUES (?,?,?,?,?,?,?,?)";
            $arrData = array($this->strNombre,
                $this->strDescripcion,
                $this->intPrecio,
                $this->intStock,
                $this->strFecha,
                $this->intStatus,
                $this->intCategoriaId,
                $this->strRuta);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateProducto(int $idproducto, string $nombre, string $descripcion, int $categoriaid, string $precio, int $stock, int $status, string $ruta) {
        $this->intIdProducto = $idproducto;
        $this->strNombre = $nombre;
        $this->strDescripcion = $descripcion;
        $this->intCategoriaId = $categoriaid;
        $this->intPrecio = $precio;
        $this->intStock = $stock;
        $this->intStatus = $status;
        $this->strRuta = $ruta;
        $return = 0;
        $sql = "SELECT * FROM producto WHERE nombrePro = '{$this->strNombre}' AND idproducto != $this->intIdProducto ";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE producto SET categoriaPro=?,nombrePro=?,descripcionPro=?, precioPro=?, "
                    . "stockPro=?,estadoPro=?,rutaPro=?  WHERE idproducto = $this->intIdProducto ";
            $arrData = array($this->intCategoriaId,
                $this->strNombre,
                $this->strDescripcion,
                $this->intPrecio,
                $this->intStock,
                $this->intStatus,
                $this->strRuta);

            $request = $this->update($sql, $arrData);
            $return = $request;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function selectProducto(int $idproducto) {
        $this->intIdProducto = $idproducto;
        $sql = "SELECT producto.idproducto,producto.nombrePro, producto.descripcionPro, producto.precioPro, "
                . "producto.stockPro,producto.estadoPro,producto.categoriaPro, categoria.nombreCategoria as categoria FROM producto "
                . "INNER JOIN categoria ON producto.categoriaPro = categoria.idcategoria WHERE idproducto = $this->intIdProducto";
        $request = $this->select($sql);
        return $request;
    }

    public function insertImage(int $idproducto, string $imagen) {
        $this->intIdProducto = $idproducto;
        $this->strImagen = $imagen;
        $query_insert = "INSERT INTO imagen(productoIDImg, img) VALUES(?,?)";
        $arrData = array($this->intIdProducto,
            $this->strImagen);
        $request_insert = $this->insert($query_insert, $arrData);
        return $request_insert;
    }

    public function selectImages(int $idproducto) {
        $this->intIdProducto = $idproducto;
        $sql = "SELECT productoIDImg, img FROM imagen WHERE productoIDImg = $this->intIdProducto";
        $request = $this->select_all($sql);
        return $request;
    }

    public function deleteImage(int $idproducto, string $imagen) {
        $this->intIdProducto = $idproducto;
        $this->strImagen = $imagen;
        $query = "DELETE FROM imagen WHERE productoIDImg = $this->intIdProducto AND img = '{$this->strImagen}'";
        $request_delete = $this->delete($query);
        return $request_delete;
    }

    public function updateStatusProducto(int $idproducto, int $status) {
        $this->intIdProducto = $idproducto;
        $this->intStatus = $status;
        $sql = "SELECT * FROM preferencia WHERE productoPreferencia = $this->intIdProducto AND estadoPreferencia = 2";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE producto SET estadoPro = ? WHERE idproducto = $this->intIdProducto";
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

}

?>