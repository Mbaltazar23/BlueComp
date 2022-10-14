<?php

class Dashboard extends Controllers {

    public function __construct() {
        parent::__construct();
    }

    public function dashboard() {
        if (empty($_SESSION['login']) || $_SESSION['rol'] == ROLCLI) {
            header('Location: ' . base_url() . '/home');
            die();
        }
        $data['page_tag'] = "Dashboard -" . TITLE_ADMIN;
        $data['page_title'] = "Dashboard -" . TITLE_ADMIN;
        $anio = date('Y');
        $mes = date('m');
        $data['pagosMes'] = $this->model->selectPagosMes($anio, $mes);
        $data["idGrafica01"] = $this->model->verificarId01GraficaPersonal($_SESSION['rol']);
        $data["idGrafica02"] = $this->model->verificarId02GraficaPersonal($_SESSION['rol']);
        $data["titleGrafica01"] = $this->model->verificarTitle01GraficaPersonal($_SESSION['rol']);
        $data["titleGrafica02"] = $this->model->verificarTitle02GraficaPersonal($_SESSION['rol']);
        $data["clientes"] = $this->model->cantClientes();
        $data["ganancias"] = $this->model->ganaciasPedidos();
        $data["productos"] = $this->model->cantProductos();
        $data["pedidos"] = $this->model->cantPedidos();
        $data["preferidos"] = $this->model->productsPrefers();
        $data['ventasMDia'] = $this->model->selectVentasMes($anio, $mes);
        $data['ventasAnio'] = $this->model->selectVentasAnio($anio);
        $data['page_name'] = "dashboard";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_dashboard.js";
        $this->views->getView($this, "dashboard", $data);
    }

    public function setGraficaClientes() {
        $graficClienes = $this->model->graficaClientes();
        echo json_encode($graficClienes);
    }

    public function setGraficaProductos() {
        $graficProductos = $this->model->graficaProductosVendidos();
        echo json_encode($graficProductos);
    }

    public function setGraficaGanacias() {
        $graficaGanacias = $this->model->graficaGananciasPedidos();
        for ($i = 0; $i < count($graficaGanacias); $i++) {
            $graficaGanacias[$i]["totalP"] = SMONEY . formatMoney($graficaGanacias[$i]["totalP"]);
        }
        echo json_encode($graficaGanacias);
    }

    public function setGraficaCantPedidosCli() {
        $graficaCantPedidosCli = $this->model->graficaCantPedidosClientes();
        echo json_encode($graficaCantPedidosCli);
    }

    public function setGraficaCantPedidosMes() {
        $graficaCantPedidosM = $this->model->graficaCantPedidosMes();
        echo json_encode($graficaCantPedidosM);
    }

    public function setGraficaCantProductsPedidos() {
        $graficaCantProductosP = $this->model->graficaCantProductsPedidos();
        echo json_encode($graficaCantProductosP);
    }

    public function tipoPagoMes() {
        if ($_POST) {
            $grafica = "tipoPagoMes";
            $nFecha = str_replace(" ", "", $_POST['fecha']);
            $arrFecha = explode('-', $nFecha);
            $mes = $arrFecha[0];
            $anio = $arrFecha[1];
            $pagos = $this->model->selectPagosMes($anio, $mes);
            $script = getFile("Template/Modals/Graficas/graficaTipoPago", $pagos);
            echo $script;
            die();
        }
    }

    public function ventasMes() {
        if ($_POST) {
            $grafica = "ventasMes";
            $nFecha = str_replace(" ", "", $_POST['fecha']);
            $arrFecha = explode('-', $nFecha);
            $mes = $arrFecha[0];
            $anio = $arrFecha[1];
            $pagos = $this->model->selectVentasMes($anio, $mes);
            $script = getFile("Template/Modals/Graficas/graficaMes", $pagos);
            echo $script;
            die();
        }
    }

    public function ventasAnio() {
        if ($_POST) {
            $grafica = "ventasAnio";
            $anio = intval($_POST['anio']);
            $pagos = $this->model->selectVentasAnio($anio);
            $script = getFile("Template/Modals/Graficas/graficaAnio", $pagos);
            echo $script;
            die();
        }
    }

}

?>