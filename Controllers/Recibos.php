<?php

class Recibos extends Controllers {

    public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login']) || empty($_SESSION['rol']) ||
                ($_SESSION['rol'] != ROLCONTAUD && $_SESSION['rol'] != ROLADMINEMP && $_SESSION['rol'] != ROLANALIST)) {
            $rutaDefecto = '/dashboard';
            header('Location: ' . base_url() . $rutaDefecto);
            die();
        }
    }

    public function recibos() {
        $data['page_tag'] = TITLE_ADMIN . "- Recibos";
        $data['page_title'] = "Recibos";
        $data['page_name'] = "recibos";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_recibos.js";
        $this->views->getView($this, "recibos", $data);
    }

    public function getRecibos() {
        $arrData = $this->model->selectRecibos();
        //dep($arrData);
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnProducts = '';
            $btnPrintRecibo = '';
            $btnDeleteActiv = '';
            if ($arrData[$i]["estadoPedido"] == 1) {
                $arrData[$i]["estadoPedido"] = '<span class="badge badge-success">Activo</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idPedido'] . ')" title="Ver Recibo"><i class="far fa-eye"></i></button>';
                $btnProducts = '<button class="btn btn-primary btn-sm" onClick="fntViewProducts(' . $arrData[$i]['idPedido'] . ')" title="Ver Productos"><i class="fas fa-store-alt"></i></button>';
                $btnPrintRecibo = '<a title="Imprimir Recibo" href="' . base_url() . '/factura/generarFactura/' . $arrData[$i]['idPedido'] . '" target="_blanck" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i></a> ';
                $btnDeleteActiv = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['idPedido'] . ')" title="Inhabilitar Recibo"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]["estadoPedido"] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" disabled><i class="far fa-eye"></i></button>';
                $btnProducts = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-store-alt"></i></button>';
                $btnPrintRecibo = '<a title="Imprimir Recibo" class="btn btn-secondary btn-sm" disabled><i class="fas fa-file-pdf"></i></a> ';
                $btnDeleteActiv = '<button class="btn btn-dark btn-sm" onClick="fntActInfo(' . $arrData[$i]['idPedido'] . ')" title="Habilitar Recibo"><i class="fas fa-toggle-on"></i></button>';
            }

            $arrData[$i]["montoTotalPedido"] = SMONEY . formatMoney($arrData[$i]["montoTotalPedido"]);

            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnProducts . ' ' . $btnPrintRecibo . ' ' . $btnDeleteActiv . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);

        die();
    }

    public function getRecibo($id) {
        $idrecibo = intval($id);
        if ($idrecibo > 0) {
            $arrData = $this->model->selectRecibo($idrecibo);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrData['orden']["montoTotalPedido"] = SMONEY . formatMoney($arrData['orden']["montoTotalPedido"]);
                $arrData['orden']["costoEnvioPedido"] = SMONEY . formatMoney($arrData['orden']["costoEnvioPedido"]);
                $arrData['orden']["subtotalPedido"] = SMONEY . formatMoney($arrData['orden']["subtotalPedido"]);
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setStatusRecibo() {
        if ($_POST) {
            $intIdrecibo = intval($_POST['idRecibo']);
            $status = intval($_POST["status"]);
            if ($status == 1) {
                $requestDelete = $this->model->updateStatusRecibo($intIdrecibo, "Pendiente", $status);
            } else {
                $requestDelete = $this->model->updateStatusRecibo($intIdrecibo, "Cancelado", $status);
            }
            if ($requestDelete) {
                if ($status == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha activado el recibo');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha inhabilitado el recibo');
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el recibo.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}
