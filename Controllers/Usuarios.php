<?php

class Usuarios extends Controllers {

    public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login']) || empty($_SESSION['rol']) && $_SESSION['rol'] == ROLCLI) {
            header('Location: ' . base_url() . '/home');
            die();
        }
    }

    public function usuarios() {
        if (empty($_SESSION['rol']) || $_SESSION['rol'] == ROLCLI) {
            header("Location:" . base_url() . '/home');
        }
        $data['page_tag'] = TITLE_ADMIN . " - Usuarios";
        $data['page_title'] = "Usuarios";
        $data['page_name'] = "usuarios";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_usuarios.js";
        $this->views->getView($this, "usuarios", $data);
    }

    public function setUsuario() {
        if ($_POST) {
            if (empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idUsuario = intval($_POST['idUsuario']);
                $strNombre = ucwords(strClean($_POST['txtNombre']));
                $strApellido = ucwords(strClean($_POST['txtApellido']));
                $intTelefono = strClean($_POST['txtTelefono']);
                $strEmail = strtolower(strClean($_POST['txtEmail']));
                $txtComentario = strClean($_POST["txtComentario"]);
                $request_user = "";
                if ($idUsuario > 0) {
                    $request_user = $this->model->updateUsuario($idUsuario, $strNombre, $strApellido, $txtComentario, $intTelefono, $strEmail);
                }

                if ($request_user > 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getUsuarios() {
        $arrData = $this->model->selectUsuarios();
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            $btnRol = '';
            if ($arrData[$i]['estadoPersona'] == 1) {
                $arrData[$i]['estadoPersona'] = '<span class="badge badge-success">Pendiente</span>';
                $btnEdit = '<button class="btn btn-primary  btn-sm btnEditUsuario" onClick="fntEditUsuario(this,' . $arrData[$i]['idPersona'] . ')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario(' . $arrData[$i]['idPersona'] . ')" title="Eliminar usuario"><i class="far fa-trash-alt"></i></button>';
                $btnRol = '<button class="btn bg-secondary text-white btn-sm" onClick="fntViewRolUsuario(this,' . $arrData[$i]['idPersona'] . ')" title="Ver cargo usuario"><i class="fas fa-user-tag"></i></button>';
                $btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario(' . $arrData[$i]['idPersona'] . ')" title="Ver usuario"><i class="far fa-eye"></i></button>';
            } else if ($arrData[$i]['estadoPersona'] == 2) {
                $arrData[$i]['estadoPersona'] = '<span class="badge badge-primary">Activo</span>';
                $btnEdit = '<button class="btn btn-primary  btn-sm btnEditUsuario" onClick="fntEditUsuario(this,' . $arrData[$i]['idPersona'] . ')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario(' . $arrData[$i]['idPersona'] . ')" title="Eliminar usuario"><i class="far fa-trash-alt"></i></button>';
                $btnRol = '<button class="btn btn-primary active btn-sm" onClick="fntViewRolUsuario(this,' . $arrData[$i]['idPersona'] . ')" title="Editar Rol usuario"><i class="fas fa-user-tag"></i></button>';
                $btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario(' . $arrData[$i]['idPersona'] . ')" title="Ver usuario"><i class="far fa-eye"></i></button>';
            } else {
                $arrData[$i]['estadoPersona'] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm btnViewUsuario" disabled><i class="far fa-eye"></i></button>';
                $btnRol = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-user-tag"></i></button>';
                $btnDelete = '<button class="btn btn-secondary btn-sm" onClick="fntActivateUsuario(' . $arrData[$i]['idPersona'] . ')" title="Habilitar usuario"><i class="fas fa-toggle-on"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm btnEditUsuario" disabled><i class="fas fa-pencil-alt"></i></button>';
            }
            $arrData[$i]["emailPersona"] = lcfirst($arrData[$i]["emailPersona"]);

            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . '  ' . $btnEdit . ' ' . $btnRol . '  ' . $btnDelete . ' </div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function getUsuario($idpersona) {
        $idusuario = intval($idpersona);
        if ($idusuario > 0) {
            $arrData = $this->model->selectUsuario($idusuario);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrData["emailPersona"] = lcfirst($arrData["emailPersona"]);
                $arrData["nombrePersona"] = lcfirst($arrData["nombrePersona"]);
                $arrData["apellidoPersona"] = lcfirst($arrData["apellidoPersona"]);
                $arrData["comentarioPersona"] = strtolower($arrData["comentarioPersona"]);
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getUsuarioCargo($idpersona) {
        $idusuario = intval($idpersona);
        if ($idusuario > 0) {
            $arrData = $this->model->selectUsuarioCargo($idusuario);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrData["emailPersona"] = lcfirst($arrData["emailPersona"]);
                $arrData["nombrePersona"] = lcfirst($arrData["nombrePersona"]);
                $arrData["apellidoPersona"] = lcfirst($arrData["apellidoPersona"]);
                $arrData["comentarioPersona"] = strtolower($arrData["comentarioPersona"]);
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delUsuario() {
        if ($_POST) {
            $intIdpersona = intval($_POST['idUsuario']);
            $requestDelete = $this->model->deleteUsuario($intIdpersona, 0);
            $cargo = "";
            if ($requestDelete) {
                $this->model->removeCargoClientes($intIdpersona, SINNEGOCIO, $cargo);
                $arrResponse = array('status' => true, 'msg' => 'Se ha inhabilitado al Usuario');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function activateUsuario() {
        if ($_POST) {
            $intIdpersona = intval($_POST['idUsuario']);
            $requestDelete = $this->model->deleteUsuario($intIdpersona, 1);
            if ($requestDelete) {
                $arrResponse = array('status' => true, 'msg' => 'Se ha Activado el Usuario');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function perfil() {
        $data['page_tag'] = TITLE_ADMIN . "- Perfil";
        $data['page_title'] = "Perfil de usuario";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_name'] = "perfil";
        $data['page_functions_js'] = "functions_usuarios.js";
        $this->views->getView($this, "perfil", $data);
    }

    public function putPerfil() {
        if ($_POST) {
            if (empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST["txtEmail"])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idUsuario = $_SESSION['idUser'];
                $txtComentario = "";
                $strApellido = ucwords(strClean($_POST['txtApellido']));
                $intTelefono = $_POST['txtTelefono'];
                $txtEmail = ucwords(strClean($_POST["txtEmail"]));
                $strPassword = "";
                if (!empty($_POST['txtPassword'])) {
                    $strPassword = md5($_POST['txtPassword']);
                }
                if (!empty($_POST['txtComentario'])) {
                    $txtComentario = strClean($_POST['txtComentario']);
                }

                $request_user = $this->model->updatePerfil($idUsuario, $txtEmail, $txtComentario, $strApellido, $intTelefono, $strPassword);
                if ($request_user) {
                    sessionUser($_SESSION['idUser']);
                    $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}

?>