<?php

class Negocios extends Controllers {

    public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login']) || empty($_SESSION['rol']) && $_SESSION['rol'] != ROLJEFA) {
            header('Location: ' . base_url() . '/home');
            die();
        }
    }

    public function negocios() {
        $data['page_tag'] = TITLE_ADMIN . " - Negocios";
        $data['page_title'] = "Negocios";
        $data['page_name'] = "negocios";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_negocios.js";
        $this->views->getView($this, "negocios", $data);
    }

    public function getNegocios() {
        $arrData = $this->model->selectNegocios();
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            if ($arrData[$i]['estadoNegocio'] == 1) {
                $arrData[$i]['estadoNegocio'] = '<span class="badge badge-success">Activo</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idNegocio'] . ')" title="Ver Negocio"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['idNegocio'] . ')" title="Editar Negocio"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['idNegocio'] . ')" title="Inhabilitar Negocio"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]['estadoNegocio'] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" title="Ver Negocio" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm" title="Editar Negocio" disabled><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-dark btn-sm" onClick="fntActiveInfo(' . $arrData[$i]['idNegocio'] . ')" title="Activar Negocio"><i class="fas fa-toggle-on"></i></button>';
            }
            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function setNegocio() {
        if ($_POST) {
            if (empty($_POST['txtNameNegocio']) || empty($_POST['txtDescripcionNegocio'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdNegocio = intval($_POST['idNegocio']);
                $strNegocio = ucfirst(strClean($_POST['txtNameNegocio']));
                $strDescipcionNegocio = ucfirst(strClean($_POST['txtDescripcionNegocio']));
                $intStatus = 1;
                $request_negocio = "";
                if ($intIdNegocio == 0) {
                    //Crear
                    $request_negocio = $this->model->insertNegocio($strNegocio, $strDescipcionNegocio, $intStatus);
                    $option = 1;
                } else {
                    //Actualizar
                    $request_negocio = $this->model->updateNegocio($intIdNegocio, $strNegocio, $strDescipcionNegocio, $intStatus);
                    $option = 2;
                }
                if ($request_negocio > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Negocio registrado correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Negocio Actualizado correctamente.');
                    }
                } else if ($request_negocio == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! el negocio ya existe.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos del negocio');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getNegocio($id) {
        $idnegocio = intval($id);
        if ($idnegocio > 0) {
            $arrData = $this->model->selectNegocio($idnegocio);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            }
            $arrResponse = array('status' => true, 'data' => $arrData);
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setStatusNegocio() {
        if ($_POST) {
            $intIdNegocio = intval($_POST['idNegocio']);
            $status = intval($_POST["status"]);
            $requestDelete = $this->model->updateStatusNegocio($intIdNegocio, $status);
            if ($requestDelete) {
                if ($status == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha activado el negocio');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha inhabilitado el negocio');
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el cupon.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getSelectNegocios() {
        $htmlOptions = "";
        $arrData = $this->model->selectNegocios();
        echo '<option value="0">Seleccione un Negocio</option>';
        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['estadoNegocio'] == 1) {
                    $htmlOptions .= '<option value="' . $arrData[$i]['idNegocio'] . '">' . $arrData[$i]['negocioNombre'] . '</option>';
                }
            }
        }
        echo $htmlOptions;
        die();
    }

    public function setDetailNegocio() {
        if ($_POST) {
            if (empty($_POST['idUser'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idUsuario = intval($_POST['idUser']);
                $description = (isset($_POST["descripCargo"])) ? $_POST["descripCargo"] : "";
                $idNegocio = (!empty($_POST["idNegocio"])) ? $_POST["idNegocio"] : "";
                $idDetailNegocio = intval($_POST["idDetailNegocio"]);
                $request_negocio = "";
                if ($idDetailNegocio == 0) {
                    $request_negocio = $this->model->insertDetailNegocio($idUsuario, !empty($idNegocio) ? $idNegocio : SINNEGOCIO, $description);
                } else {
                    $option = 2;
                    $request_negocio = $this->model->updateDetailNegocio($idUsuario, !empty($idNegocio) ? $idNegocio : SINNEGOCIO, $description, $idDetailNegocio);
                }

                if ($idNegocio > 0) {
                    $option = 1;
                    $this->model->updateCargoCliente($idUsuario, 2);
                } else {
                    $option = 2;
                    $this->model->updateCargoCliente($idUsuario, 1);
                    $request_negocio = $this->model->updateDetailNegocio($idUsuario, !empty($idNegocio) ? $idNegocio : SINNEGOCIO, "", $idDetailNegocio);
                }

                if ($request_negocio > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Cargo registrado Exitosamente....');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Cargo Actualizado Exitosamentee.');
                    }
                } else if ($request_negocio == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe este cargo en este Cliente Ingresado.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos del Cargo.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}
