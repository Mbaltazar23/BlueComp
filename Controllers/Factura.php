<?php

require 'Libraries/html2pdf/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

class Factura extends Controllers {

    public function __construct() {
        parent::__construct();
        session_start();
        if (empty($_SESSION['login'])) {
            header('Location: ' . base_url() . '/home');
            die();
        }
    }

    public function generarFactura($idpedido) {
        if (is_numeric($idpedido)) {
            $idpersona = "";
            if ($_SESSION['rol'] == ROLCLI) {
                $idpersona = $_SESSION['idUser'];
            }
            $data = $this->model->selectPedido($idpedido, $idpersona);
            if (empty($data)) {
                echo "Datos no encontrados";
            } else {
                $idpedido = $data['orden']['idPedido'];
                ob_end_clean();
                $html = getFile("Template/Modals/comprobantePDF", $data);
                $html2pdf = new Html2Pdf('p', 'A4', 'es', 'true', 'UTF-8');
                $html2pdf->writeHTML($html);
                $html2pdf->output('factura-' . "Pedido N°" . '.pdf');
            }
        } else {
            echo "Dato no válido";
        }
    }

}

?>