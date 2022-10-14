<?php

require_once("Models/TCategoria.php");
require_once("Models/TCliente.php");
require_once("Models/TProducto.php");
require_once("Models/LoginModel.php");
require_once("Models/TPreferido.php");
require_once("Models/TSuscripcion.php");

class Home extends Controllers {

    use TCategoria,
        TCliente,
        TProducto,
        TPreferido,
        TSuscripcion;

    public $login;

    public function __construct() {
        parent::__construct();
        session_start();
        $this->login = new LoginModel();
    }

    public function home() {
        $data['page_tag'] = NOMBRE_EMPESA . " - Inicio";
        $data['page_title'] = NOMBRE_EMPESA;
        $data['page_name'] = "home";
        if (isset($_SESSION['rol']) && $_SESSION['rol'] == ROLCLI) {
            $request_pref = $this->selectPreferenciasCliente($_SESSION['idUser']);
            $request_suscrip = $this->selectSuscripcionCliente($_SESSION['idUser']);
            if (count($request_pref) > 0) {
                $data["preferencias"] = $request_pref;
                $data["cantPreferencias"] = count($request_pref);
            } else {
                $data["preferencias"] = "";
                $data["cantPreferencias"] = 0;
            }

            if (count($request_suscrip) > 0) {
                $data["suscripciones"] = $request_suscrip;
                $data["cantSuscritos"] = count($request_suscrip);
            } else {
                $data["suscripciones"] = "";
                $data["cantSuscritos"] = 0;
            }
        }
        $data['cupones'] = $this->getCuponesPreferidos();
        $data['slider'] = $this->getCategoriasT(MENUCAT);
        $data['searchCat'] = $this->getCategorias();
        $data['productos'] = $this->getProductosT();
        $data['bannerProductos'] = $this->getLastProductosT(LASTPRODUCTOS);
        $this->views->getView($this, "home", $data);
    }

    public function registerUser() {
        if ($_POST) {
            if (empty($_POST['txtNombreRegister']) || empty($_POST['txtApellidoRegister']) || empty($_POST['txtTelefonoRegister']) || empty($_POST['txtEmailRegister']) || empty($_POST['txtPassRegister'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $strNombre = ucwords(strClean($_POST['txtNombreRegister']));
                $strApellido = ucwords(strClean($_POST['txtApellidoRegister']));
                $strEmail = ucwords(strClean($_POST['txtEmailRegister']));
                $intTelefono = $_POST['txtTelefonoRegister'];
                $strPass = ucwords(strClean($_POST['txtPassRegister']));
                $intRolId = ROLCLIENTE;
                $estadoCliente = 1;
                $strComentario = "";
                if (!empty($_POST['txtComentRegister'])) {
                    $strComentario = ucwords(strClean($_POST['txtComentRegister']));
                }
                $strPassEncrypt = md5($strPass);
                $request_user = $this->insertCliente($strNombre, $strApellido, $intTelefono, $strEmail, $strPassEncrypt, $intRolId, $strComentario, $estadoCliente);
                if ($request_user > 0) {
                    $_SESSION['idUser'] = $request_user;
                    $_SESSION['login'] = true;
                    $_SESSION['rol'] = ROLCLI;
                    $arrData = $this->login->sessionLogin($request_user);
                    $this->insertNegocioDefault($_SESSION['idUser'], SINNEGOCIO, "");
                    sessionUser($_SESSION['idUser']);
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.', 'userData' => $arrData);
                } else if ($request_user == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! el email ya existe, ingrese otro.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}

?>