<?php

class Categorias extends Controllers {

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

    public function Categorias() {
        $data['page_tag'] = TITLE_ADMIN . "- Categorias";
        $data['page_title'] = "Categorias";
        $data['page_name'] = "Categorias";
        $data['rol-personal'] = $_SESSION['rol'];

        $data['page_functions_js'] = "functions_categorias.js";
        $this->views->getView($this, "categorias", $data);
    }

    public function setCategoria() {
        if ($_POST) {
            if (empty($_POST['txtNombre']) || empty($_POST['txtDescripcion'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $intIdcategoria = intval($_POST['idCategoria']);
                $strCategoria = ucwords(strClean($_POST['txtNombre']));
                $strDescipcion = ucwords(strClean($_POST['txtDescripcion']));
                $intStatus = 1;
                $fecha = date("Y-m-d H:i:s");
                $request_categoria = "";
                if ($intIdcategoria == 0) {
                    //Crear
                    $request_categoria = $this->model->inserCategoria($strCategoria, $strDescipcion, $intStatus, $fecha);
                    $option = 1;
                } else {
                    //Actualizar
                    $request_categoria = $this->model->updateCategoria($intIdcategoria, $strCategoria, $strDescipcion, $intStatus, $fecha);
                    $option = 2;
                }
                if ($request_categoria > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                    }
                } else if ($request_categoria == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! La categoría ya existe.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getCategorias() {
        $arrData = $this->model->selectCategorias();
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';

            if ($arrData[$i]['estadoCategoria'] == 1) {
                $arrData[$i]['estadoCategoria'] = '<span class="badge badge-success">Activo</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idcategoria'] . ')" title="Ver categoría"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['idcategoria'] . ')" title="Editar categoría"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['idcategoria'] . ')" title="Eliminar categoría"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]['estadoCategoria'] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idcategoria'] . ')" title="Ver categoría" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['idcategoria'] . ')" title="Editar categoría" disabled><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-dark btn-sm" onClick="fntActivateInfo(' . $arrData[$i]['idcategoria'] . ')" title="Activar categoría"><i class="fas fa-toggle-on"></i></button>';
            }

            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . '  ' . $btnEdit . '  ' . $btnDelete . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function getCategoria($idcategoria) {
        $intIdcategoria = intval($idcategoria);
        if ($intIdcategoria > 0) {
            $arrData = $this->model->selectCategoria($intIdcategoria);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function setStatusCategoria() {
        if ($_POST) {
            $intIdcategoria = intval($_POST['idCategoria']);
            $status = intval($_POST['status']);
            $requestDelete = $this->model->updateStatusCategoria($intIdcategoria, $status);
            if ($requestDelete == 'ok') {
                if ($status == 0) {
                    $arrResponse = array('status' => true, 'msg' => "Categoria Inhabilitada Exitosamente...");
                } else {
                    $arrResponse = array('status' => true, 'msg' => "Categoria Habiitada Exitosamente...");
                }
            } else if ($requestDelete == 'exist') {
                $arrResponse = array('status' => false, 'msg' => 'No es posible inhabilitar esta categoría..');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar/activar la categoría.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getSelectCategorias() {
        $htmlOptions = "";
        $arrData = $this->model->selectCategoriasPro();
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

}

?>