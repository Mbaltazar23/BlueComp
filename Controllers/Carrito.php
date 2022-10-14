<?php

require_once("Models/TCategoria.php");
require_once("Models/TProducto.php");
require_once("Models/TTipoPago.php");
require_once("Models/TCliente.php");
require_once("Models/TPreferido.php");
require_once("Models/TSuscripcion.php");

class Carrito extends Controllers {

    use TCategoria,
        TProducto,
        TCliente,
        TPreferido,
        TTipoPago,
        TSuscripcion;

    public function __construct() {
        parent::__construct();
        session_start();
    }

    public function carrito() {
        if (!isset($_SESSION['arrCarrito'])) {
            header("Location: " . base_url());
        }
        $data['page_tag'] = NOMBRE_EMPESA . ' - Carrito';
        $data['page_title'] = 'Carrito de compras';
        $data['page_name'] = "carrito";
        if (isset($_SESSION['rol']) && $_SESSION['rol'] == "Cliente") {
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
        $data['slider'] = $this->getCategoriasT(MENUCAT);
        $data['searchCat'] = $this->getCategorias();
        $this->views->getView($this, "carrito", $data);
    }

    public function procesarpago() {
        if (empty($_SESSION['arrCarrito'])) {
            header("Location: " . base_url());
            die();
        }
        if (isset($_SESSION['rol']) && $_SESSION['rol'] == "Cliente") {
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
        $data['slider'] = $this->getCategoriasT(MENUCAT);
        $data['searchCat'] = $this->getCategorias();
        $data['page_tag'] = NOMBRE_EMPESA . ' - Procesar Pago';
        $data['page_title'] = 'Procesar Pago';
        $data['page_name'] = "procesarpago";
        $data['tiposPago'] = $this->getTiposPagoT();
        $data["comunas"] = $this->getComunasAll();
        $this->views->getView($this, "procesarpago", $data);
    }

    public function selectDirecciones() {
        $idComuna = isset($_POST["idComuna"]) ? $_POST["idComuna"] : "";
        $htmlOptions = "";
        $listDirecciones = $this->getDireccionesForComuna($idComuna);
        echo '<option value="0">Seleccione direccion</option>';
        for ($i = 0; $i < count($listDirecciones); $i++) {
            $htmlOptions .= '<option value="' . $listDirecciones[$i]['idDireccion'] . '">' . $listDirecciones[$i]['nombreDireccion'] . '</option>';
        }
        echo $htmlOptions;
        die();
    }

}

?>
