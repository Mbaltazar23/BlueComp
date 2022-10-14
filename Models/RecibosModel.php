<?php

class RecibosModel extends Mysql {

    private $idpedido;
    private $idpersona;
    private $statusPedido;
    private $estadoPedido;

    public function __construct() {
        parent::__construct();
    }

    public function selectRecibos($idpersona = NULL) {
        $this->idpersona = $idpersona;
        $where = "";
        if ($idpersona != null) {
            $where = " WHERE p.personaIdPedido = $this->idpersona ORDER BY p.fechaPedido";
        }
        $sql = "SELECT per.nombrePersona, per.telefonoPersona, p.idPedido, DATE_FORMAT(p.fechaPedido, '%d/%m/%Y') as fecha, "
                . "DATE_FORMAT(p.fechaPedido, '%H:%i:%s') AS hora,p.montoTotalPedido, tp.nombrePago, p.statusPedido, p.estadoPedido,d.nombreDireccion, "
                . "c.nombreComuna FROM pedido p INNER JOIN tipopago tp ON p.tipopagoPedido = tp.idTipoPago INNER JOIN direccion d "
                . "ON p.direccionPedido = d.idDireccion INNER JOIN comuna c ON d.comunaIdDireccion = c.idComuna "
                . "INNER JOIN persona per ON p.personaIdPedido = per.idPersona $where";
        $request = $this->select_all($sql);
        return $request;
    }

    public function selectRecibo(int $idpedido, $idpersona = NULL) {
        $this->idpedido = $idpedido;
        $this->idpersona = $idpersona;
        $busqueda = "";
        if ($this->idpersona != "") {
            $busqueda = " AND p.personaIdPedido = $this->idpersona";
        }
        $request = array();
        $sql = "SELECT p.idPedido,p.personaIdPedido,DATE_FORMAT(p.fechaPedido, '%d/%m/%Y') as fecha, "
                . "DATE_FORMAT(p.fechaPedido, '%H:%i:%s') AS hora,p.subtotalPedido, p.montoTotalPedido, tp.nombrePago, "
                . "tp.idTipoPago, p.statusPedido,p.costoEnvioPedido,d.nombreDireccion, c.nombreComuna FROM pedido p INNER JOIN tipopago tp "
                . "ON p.tipopagoPedido = tp.idTipoPago INNER JOIN direccion d ON p.direccionPedido = d.idDireccion "
                . "INNER JOIN comuna c ON d.comunaIdDireccion = c.idComuna WHERE p.idPedido = $this->idpedido " . $busqueda;
        $requestPedido = $this->select($sql);
        if (!empty($requestPedido)) {
            $this->idpersona = $requestPedido['personaIdPedido'];
            $sql_cliente = "SELECT idPersona,
                                   nombrePersona,
                                   apellidoPersona,
                                   telefonoPersona,
                                   emailPersona 
			     FROM persona WHERE idPersona = $this->idpersona";
            $requestcliente = $this->select($sql_cliente);
            $sql_detalle = "SELECT p.idproducto,
				   p.nombrePro as producto,
                                   p.categoriaPro,
				   d.precioDetalle,
                                   d.cantidadDetalle
			           FROM detallepedido d
				   INNER JOIN producto p
				   ON d.productoIdDetalle = p.idproducto
			    WHERE d.pedidoIdDetalle = $this->idpedido";
            $requestProductos = $this->select_all($sql_detalle);
            //buscamos el identificador del pedido segun el que se haya seleccionado 
            $sqlPedidos = "SELECT * FROM pedido WHERE estadoPedido != 0 AND personaIdPedido = $this->idpersona";
            $requestPedidosTemo = $this->select_all($sqlPedidos);
            $idTemp = "";
            for ($i = 0; $i < count($requestPedidosTemo); $i++) {
                if ($idpedido == $requestPedidosTemo[$i]["idPedido"]) {
                    $idTemp = ($i + 1);
                }
            }
            $requestPedido["idCliPed"] = $idTemp;

            $request = array('cliente' => $requestcliente,
                'orden' => $requestPedido,
                'detalle' => $requestProductos
            );
        }
        return $request;
    }

    public function updateStatusRecibo(int $idpedido, string $estadoPedido, int $status) {
        $this->idpedido = $idpedido;
        $this->statusPedido = $estadoPedido;
        $this->estadoPedido = $status;
        $query_insert = "UPDATE pedido SET statusPedido = ?, estadoPedido= ?  WHERE idPedido = $idpedido ";
        $arrData = array($this->statusPedido, $this->estadoPedido);
        $request_insert = $this->update($query_insert, $arrData);
        return $request_insert;
    }

}
