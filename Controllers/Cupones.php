<?php

class Cupones extends Controllers {

    public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login']) || empty($_SESSION['rol']) || $_SESSION['rol'] != ROLJEFA) {
            $rutaDefecto = '';
            if ($_SESSION['rol'] != ROLCLI) {
                $rutaDefecto = '/dashboard';
            }
            header('Location: ' . base_url() . $rutaDefecto);
            die();
        }
    }

    public function cupones() {
        $data['page_tag'] = TITLE_ADMIN . "- Cupones";
        $data['page_title'] = "Cupones";
        $data['page_name'] = "cupones";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_cupones.js";
        $this->views->getView($this, "cupones", $data);
    }

    public function getCupones() {
        $arrData = $this->model->selectCupons();
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $btnTienda = '';
            if ($arrData[$i]['estadoPro'] == 1) {
                $arrData[$i]['estadoPro'] = '<span class="badge badge-success">Activo</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idproducto'] . ')" title="Ver cupon"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['idproducto'] . ')" title="Editar cupon"><i class="fas fa-pencil-alt"></i></button>';
                $btnTienda = '<button class="btn btn-dark  btn-sm" onClick="fntTiendaCuponAc(' . $arrData[$i]['idproducto'] . ')" title="Visualizar Tienda"><i class="fas fa-store"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['idproducto'] . ')" title="Eliminar cupon"><i class="far fa-trash-alt"></i></button>';
            } else if ($arrData[$i]['estadoPro'] == 2) {
                $arrData[$i]['estadoPro'] = '<span class="badge badge-primary">Visible</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idproducto'] . ')" title="Ver cupon"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['idproducto'] . ')" title="Editar cupon"><i class="fas fa-pencil-alt"></i></button>';
                $btnTienda = '<button class="btn btn-warning  btn-sm" onClick="fntTiendaCuponDesc(' . $arrData[$i]['idproducto'] . ')" title="Ocultar Tienda"><i class="fas fa-store-alt-slash"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['idproducto'] . ')" title="Eliminar cupon"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]['estadoPro'] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idproducto'] . ')" title="Ver cupon" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['idproducto'] . ')" title="Editar cupon" disabled><i class="fas fa-pencil-alt"></i></button>';
                $btnTienda = '<button class="btn btn-secondary  btn-sm" onClick="fntTiendaCuponAc(' . $arrData[$i]['idproducto'] . ')" title="Visualizar Tienda" disabled><i class="fas fa-store-alt-slash"></i></button>';
                $btnDelete = '<button class="btn btn-dark btn-sm" onClick="fntActiveInfo(' . $arrData[$i]['idproducto'] . ')" title="Activar cupon"><i class="fas fa-toggle-on"></i></button>';
            }
            $arrData[$i]['precioPro'] = round($arrData[$i]['precioPro']) . "%";


            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnTienda . ' ' . $btnDelete . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function setCupon() {
        if ($_POST) {
            if (empty($_POST["txtCodigo"]) || empty($_POST["txtDescuento"]) || empty($_POST["txtStockCup"])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idCupon = intval($_POST['idProducto']);
                $txtCodigo = strtoupper(strClean($_POST["txtCodigo"]));
                $txtDescuento = intval($_POST["txtDescuento"]);
                $txtStockCup = intval($_POST["txtStockCup"]);
                $ruta = strtolower(clear_cadena($txtCodigo));
                $strRuta = str_replace(" ", "-", $ruta);
                $fecha = date("Y-m-d H:i:s");
                $request_cupon = "";
                if ($idCupon == 0) {
                    $option = 1;
                    $request_cupon = $this->model->insertCupon($txtCodigo, $strRuta, $txtDescuento, $fecha, $txtStockCup, 1);
                } else {
                    $option = 2;
                    $request_cupon = $this->model->updateCupon($txtCodigo, $strRuta, $txtDescuento, $fecha, $txtStockCup, 1, $idCupon);
                }
                if ($request_cupon > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Cupon registrado Exitosamente....');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Cupon Actualizado Exitosamentee.');
                    }
                } else if ($request_cupon == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un cupon con el Código Ingresado.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getCupon($id) {
        $idcupon = intval($id);
        if ($idcupon > 0) {
            $arrData = $this->model->selectCupon($idcupon);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            }
            $arrData["nombrePro"] = strtolower($arrData["nombrePro"]);

            $arrResponse = array('status' => true, 'data' => $arrData);

            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setStatusCupon() {
        if ($_POST) {
            $intIdcupon = intval($_POST['idProducto']);
            $status = intval($_POST["status"]);
            $requestDelete = $this->model->updateStatusCupon($intIdcupon, $status);
            if ($requestDelete == 'ok') {
                if ($status == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha activado el cupon');
                } else if ($status == 2) {
                    $arrResponse = array('status' => true, 'msg' => 'Se visualizara el cupon en la Tienda');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha inhabilitado el cupon');
                }
            } else if ($requestDelete == 'exist') {
                $arrResponse = array('status' => false, 'msg' => 'No se puede eliminar este cupon al ser uno preferido...');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el cupon.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}
