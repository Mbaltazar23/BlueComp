<?php

require_once("Models/TSuscripcion.php");

class Suscripciones extends Controllers {

    use TSuscripcion;

    public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login']) || empty($_SESSION['rol']) ||
                ($_SESSION['rol'] != ROLCONTAUD && $_SESSION['rol'] != ROLADMINEMP && $_SESSION['rol'] != ROLANALIST && $_SESSION['rol'] != ROLJEFA)) {
            header('Location: ' . base_url() . '/home');
            die();
        }
    }

    public function suscripciones() {
        $data['page_tag'] = TITLE_ADMIN . "- Suscripciones";
        $data['page_title'] = "Suscripciones";
        $data['page_name'] = "suscripciones";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_suscripciones.js";
        $this->views->getView($this, "suscripciones", $data);
    }

    public function getSuscripciones() {
        $arrData = $this->model->selectSuscripciones();
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            if ($arrData[$i]["estadoSuscripcion"] == 1) {
                $arrData[$i]["estadoSuscripcion"] = '<span class="badge badge-success">Pendiente</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idSuscripcion'] . ')" title="Ver Suscripcion" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntViewSuscrip(this,' . $arrData[$i]['idSuscripcion'] . ')" title="Agregar productos"><i class="fas fa-cart-plus"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['idSuscripcion'] . ')" title="Inhabilitar Suscripcion"><i class="far fa-trash-alt"></i></button>';
            } else if ($arrData[$i]["estadoSuscripcion"] == 2) {
                $arrData[$i]["estadoSuscripcion"] = '<span class="badge badge-primary">Activa</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idSuscripcion'] . ')" title="Ver Suscripcion"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-dark  btn-sm" onClick="fntEditSuscrip(this,' . $arrData[$i]['idSuscripcion'] . ')" title="Actualizar productos"><i class="fas fa-edit"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['idSuscripcion'] . ')" title="Inhabilitar Suscripcion"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]["estadoSuscripcion"] = '<span class="badge badge-danger">Inactiva</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idSuscripcion'] . ')" title="Ver Suscripcion" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm" onClick="fntViewSuscrip(this,' . $arrData[$i]['idSuscripcion'] . ')" title="Agregar productos" disabled><i class="fas fa-cart-plus"></i></button>';
                $btnDelete = '<button class="btn btn-dark btn-sm" onClick="fntActivateInfo(' . $arrData[$i]['idSuscripcion'] . ')" title="Habilitar Suscripcion"><i class="fas fa-toggle-on"></i></button>';
            }
            $arrData[$i]["emailPersona"] = strtolower($arrData[$i]["emailPersona"]);
            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function getSuscripcion($id) {
        $idSuscripcion = intval($id);
        if ($idSuscripcion > 0) {
            $arrData = $this->model->selectSuscripcion($idSuscripcion);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrProducts = $this->model->selectAllProductsSuscripcion($idSuscripcion);
                if (count($arrProducts) > 0) {

                    $arrData["products"] = $arrProducts;
                }
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setDetailSuscripcion() {
        if ($_POST) {
            if (empty($_POST["arregloProducts"]) || empty($_POST["idSuscrip"]) || empty($_POST["opcionSentencia"])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $arrProducts = $_POST["arregloProducts"];
                $idSuscrip = intval($_POST["idSuscrip"]);
                $opcionTxt = strClean($_POST["opcionSentencia"]);
                $request_statusSus = "";
                $request_products = "";
                if ($idSuscrip > 0) {
                    $arrSuscripcion = $this->model->selectSuscripcion($idSuscrip);
                    if (empty($arrSuscripcion)) {
                        $arrResponse = array("status" => false, "msg" => 'La suscripcion no esta registrada...');
                    } else {
                        $request_statusSus = $this->model->updateStatusSuscripcion($idSuscrip, 2); //el 2 representara que tendra productos registrados 

                        if ($request_statusSus > 0) {
                            if ($opcionTxt == "create") {
                                foreach ($arrProducts as $product) {
                                    $idproduct = $product["idProducto"];
                                    $cantidad = $product["cantidad"];
                                    $precio = $product["precio"];
                                    $request_products = $this->model->insertDetalleSuscripcion($arrSuscripcion["idSuscripcion"], $idproduct, $cantidad, $precio);
                                }
                                $arrResponse = array("status" => true, "msg" => 'Suscripcion Activada Exitosamente...', "statusPro" => $request_products);
                            } else {
                                $removeProducts = $this->model->removeProductsSuscripcion($idSuscrip);
                                if ($removeProducts > 0) {
                                    foreach ($arrProducts as $product) {
                                        $idproduct = $product["idProducto"];
                                        $cantidad = $product["cantidad"];
                                        $precio = $product["precio"];
                                        $request_products = $this->model->insertDetalleSuscripcion($arrSuscripcion["idSuscripcion"], $idproduct, $cantidad, $precio);
                                    }
                                }
                                $arrResponse = array("status" => true, "msg" => 'Suscripcion Actualizada Exitosamente...', "statusPro" => $request_products);
                            }
                        } else {
                            $arrResponse = array("status" => false, "msg" => 'la suscripcion no fue se pudo actualizar...');
                        }
                    }
                } else {
                    $arrResponse = array("status" => false, "msg" => 'la suscripcion no fue hayada...');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function setStatusSuscripcion() {
        if ($_POST) {
            $intIdSuscripcion = intval($_POST['idSuscripcion']);
            $status = intval($_POST["status"]);
            $requestDeleteProducts = $this->model->updateStatusSuscripcion($intIdSuscripcion, $status);
            if ($requestDeleteProducts) {
                if ($status == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Suscripcion Habilitada Exitosamente...');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha inhabilitado la Suscripcion');
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el cupon.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getSelectCategorias() {
        $htmlOptions = "";
        $arrData = $this->model->selectCategoriasSus();
        echo '<option value="0">Seleccione una categoria</option>';
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['estadoCategoria'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['idcategoria'] . '">' . $arrData[$i]['nombreCategoria'] . '</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }

    public function getSelectProductsCat($id) {
        $htmlOptions = "";
        $idCategoria = intval($id);
        if ($idCategoria > 0) {
            $arrData = $this->model->selectProductsCat($idCategoria);
            echo '<option value="0">Seleccione un producto</option>';
            if (count($arrData) > 0) {
                for ($i = 0; $i < count($arrData); $i++) {
                    if ($arrData[$i]["estadoPro"] == 1) {
                        $htmlOptions .= '<option value="' . $arrData[$i]["idproducto"] . '">' . $arrData[$i]["nombrePro"] . '</option>';
                    }
                }
            }
            echo $htmlOptions;
            die();
        }
    }

    public function getProductoSuscript($id) {
        $idproducto = intval($id);
        if ($idproducto > 0) {
            $arrData = $this->model->selectProductoSus($idproducto);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrData['precio'] = SMONEY . formatMoney($arrData['precioPro']);
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}
