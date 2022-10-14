<?php

require_once("Models/LoginModel.php");
require_once("Models/TPreferido.php");

class Preferencias extends Controllers {

    use TPreferido;

    function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/home');
            die();
        }
        $this->login = new LoginModel();
    }

    public function setPreferencia() {
        if ($_POST) {
            $cantPreferencias = 0;
            $idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
            if (is_numeric($idproducto)) {
                $idpersona = (isset($_SESSION['idUser'])) ? $_SESSION['idUser'] : "";
                $status = 1;
                $request_preferencia = "";
                $perfilPersona = $this->login->sessionLogin($idpersona);
                $preferenciExist = $this->searchProductPreference($idproducto, $idpersona);
                if ($perfilPersona["nombreRol"] == ROLCLI && empty($preferenciExist)) {
                    $opcion = 1;
                    $request_preferencia = $this->insertPreferido($idpersona, $idproducto, $status);
                } else if (!empty($preferenciExist) && ($preferenciExist["estadoPreferencia"] == 0 || $preferenciExist["estadoPreferencia"] == 2)) {
                    $opcion = 2;
                    $request_preferencia = $this->UpdateStatusPreferido($preferenciExist["idPreferencia"], 1);
                    $this->insertPreferido($idpersona, $idproducto, 2);
                }
                if ($request_preferencia > 0) {
                    $requestCant = $this->selectPreferenciasCliente($_SESSION['idUser']);
                    $cantPreferencias = count($requestCant);
                    if ($opcion == 1) {
                        $arrResponse = array('status' => true, 'cantPreferencias' => $cantPreferencias, 'msg' => 'Producto agregado exitosamente...');
                    } else {
                        $arrResponse = array('status' => true, 'cantPreferencias' => $cantPreferencias, 'msg' => 'Producto preferido nuevamente agregado...');
                    }
                } else if ($request_preferencia == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Este producto ya esta registrado en preferidos!');
                } else if ($perfilPersona["nombreRol"] != ROLCLI) {
                    $arrResponse = array('status' => false, 'msg' => '¡No tiene usted acceso porque no es un cliente !!');
                }
            } else {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delPreferencia() {
        if ($_POST) {
            $idpr = openssl_decrypt($_POST['idpref'], METHODENCRIPT, KEY);
            if (!empty($idpr)) {
                $idpreferido = intval($idpr);
                $request_pref = "";
                if ($idpreferido > 0) {
                    $selectPreferer = $this->getProductPreference($idpreferido);
                    $listProducts = $this->CheckProductTendence($selectPreferer["productoPreferencia"]);
                    if (empty($listProducts)) {
                        $request_pref = $this->UpdateStatusPreferido($idpreferido, 0);
                    } else {
                        $request_pref = $this->UpdateStatusPreferido($idpreferido, 2);
                    }
                }
                if ($request_pref) {
                    $requestCant = $this->selectPreferenciasCliente($_SESSION['idUser']);
                    $cantPreferencias = count($requestCant);
                    $arrResponse = array('status' => true, 'cantPreferencias' => $cantPreferencias, 'msg' => 'Producto preferido eliminado exitosamente...');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se elimino el producto de preferidos');
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar la preferencia');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

}
