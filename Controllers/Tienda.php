<?php

require_once("Models/TCategoria.php");
require_once("Models/TProducto.php");
require_once("Models/TCliente.php");
require_once("Models/LoginModel.php");
require_once("Models/TPreferido.php");
require_once("Models/TSuscripcion.php");

class Tienda extends Controllers {

    use TCategoria,
        TProducto,
        TCliente,
        TPreferido,
        TSuscripcion;

    public $login;

    public function __construct() {
        parent::__construct();
        session_start();
        $this->login = new LoginModel();
    }

    public function tienda() {
        $data['page_tag'] = NOMBRE_EMPESA . " - Productos";
        $data['page_title'] = NOMBRE_EMPESA;
        $data['page_name'] = "tienda";
        $data['productos'] = $this->getProductosT();
        $pagina = 1;
        $ProductosPrefer = $this->cantProductos();
        $total_registro = count($ProductosPrefer);
        $desde = ($pagina - 1) * PROPORPAGINA;
        $total_paginas = ceil($total_registro / PROPORPAGINA);
        $data['productos'] = $this->getProductosPage($desde, PROPORPAGINA);
        $data['slider'] = $this->getCategoriasT(MENUCAT);
        $data['searchCat'] = $this->getCategorias();
        if (isset($_SESSION['rol']) && $_SESSION['rol'] == "Cliente") {
            $request_pref = $this->selectPreferenciasCliente($_SESSION['idUser']);
            $request_suscrip = $this->selectSuscripcionCliente($_SESSION['idUser']);
            if (count($request_pref) > 0) {
                $data["preferidos"] = $request_pref;
                $data["cantPreferencias"] = count($request_pref);
            } else {
                $data["preferidos"] = "";
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
        //dep($data['productos']);exit;
        $data['pagina'] = $pagina;
        $data['total_paginas'] = $total_paginas;
        $data['categorias'] = $this->getCategorias();
        $this->views->getView($this, "tienda", $data);
    }

    public function verOrdenes() {
        $data['page_tag'] = NOMBRE_EMPESA . "- Ordenes";
        $data['page_title'] = NOMBRE_EMPESA;
        $data['page_name'] = "ordenes";
        if (isset($_SESSION['rol']) && $_SESSION['rol'] == "Cliente") {
            $request_pref = $this->selectPreferenciasCliente($_SESSION['idUser']);
            $request_suscrip = $this->selectSuscripcionCliente($_SESSION['idUser']);
            if (count($request_pref) > 0) {
                $data["preferidos"] = $request_pref;
                $data["cantPreferencias"] = count($request_pref);
            } else {
                $data["preferidos"] = "";
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
        $data['pedidos'] = $this->selectPedidos($_SESSION['idUser']);
        $this->views->getView($this, "verOrdenes", $data);
    }

    public function categoria($params) {
        $idcategoria = intval($params);
        if (isset($_SESSION['rol']) && $_SESSION['rol'] == ROLCLI) {
            $request_pref = $this->selectPreferenciasCliente($_SESSION['idUser']);
            $request_suscrip = $this->selectSuscripcionCliente($_SESSION['idUser']);
            if (count($request_pref) > 0) {
                $data["preferidos"] = $request_pref;
                $data["cantPreferencias"] = count($request_pref);
            } else {
                $data["preferidos"] = "";
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
        $pagina = 1;
        $infoCategoria = $this->getProductosT($idcategoria);
        $strCat = $this->getNameCategoria($idcategoria);
        $ProductosCategoria = $this->cantProductos($idcategoria);
        $total_registro = count($ProductosCategoria);
        $desde = ($pagina - 1) * PROPORPAGINA;
        $total_paginas = ceil($total_registro / PROPORPAGINA);
        $data['page_tag'] = NOMBRE_EMPESA . " - " . $strCat;
        $data['page_title'] = $strCat;
        $data['page_name'] = "categoria";
        $data['productos'] = $infoCategoria;
        $data['slider'] = $this->getCategoriasT(MENUCAT);
        $data['searchCat'] = $this->getCategorias();
        $this->views->getView($this, "categoria", $data);
    }

    public function search() {
        if (empty($_REQUEST['search']) || empty($_REQUEST["selectCatS"])) {
            header("Location: " . base_url());
        } else {
            $busqueda = strClean($_REQUEST['search']);
            $idcategoria = intval($_REQUEST["selectCatS"]);
            $pagina = empty($_REQUEST['p']) ? 1 : intval($_REQUEST['p']);
            $cantProductos = $this->cantProdSearch($busqueda);
            $total_registro = $cantProductos['total_registro'];
            $desde = ($pagina - 1) * PROBUSCAR;
            $total_paginas = ceil($total_registro / PROBUSCAR);
            $data['productos'] = $this->getProdSearch($busqueda, $desde, PROBUSCAR, $idcategoria);
            $data['page_tag'] = NOMBRE_EMPESA;
            $data['page_title'] = "Resultado de: " . $busqueda;
            $data['page_name'] = "tienda";
            $data['pagina'] = $pagina;
            $data['total_paginas'] = $total_paginas;
            $data['busqueda'] = $busqueda;
            $data['slider'] = $this->getCategoriasT(MENUCAT);
            $data['searchCat'] = $this->getCategorias();
            $this->views->getView($this, "search", $data);
        }
    }

    public function preferencias() {
        $data['page_tag'] = NOMBRE_EMPESA . "- Preferidos";
        $data['page_title'] = NOMBRE_EMPESA;
        $data['page_name'] = "preferidos";
        $data['slider'] = $this->getCategoriasT(MENUCAT);
        if (isset($_SESSION['rol']) && $_SESSION['rol'] == ROLCLI) {
            $request_pref = $this->selectPreferenciasCliente($_SESSION['idUser']);
            $request_suscrip = $this->selectSuscripcionCliente($_SESSION['idUser']);
            if (count($request_pref) > 0) {
                $data["preferidos"] = $request_pref;
                $data["cantPreferencias"] = count($request_pref);
            } else {
                $data["preferidos"] = "";
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
        if (empty($data["preferidos"])) {
            header("Location: " . base_url());
        } else {
            $data['searchCat'] = $this->getCategorias();
            $this->views->getView($this, "preferencias", $data);
        }
    }

    public function suscripciones() {
        $data['page_tag'] = NOMBRE_EMPESA . " - Productos Suscritos";
        $data['page_title'] = NOMBRE_EMPESA;
        $data['page_name'] = "productos suscritos";
        $data['slider'] = $this->getCategoriasT(MENUCAT);
        if (isset($_SESSION['rol']) && $_SESSION['rol'] == ROLCLI) {
            $request_pref = $this->selectPreferenciasCliente($_SESSION['idUser']);
            $request_suscrip = $this->selectSuscripcionCliente($_SESSION['idUser']);
            if (count($request_pref) > 0) {
                $data["preferidos"] = $request_pref;
                $data["cantPreferencias"] = count($request_pref);
            } else {
                $data["preferidos"] = "";
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
        $data['searchCat'] = $this->getCategorias();
        $this->views->getView($this, "suscripciones", $data);
    }

    public function producto($params) {
        if (isset($_SESSION['rol']) && $_SESSION['rol'] == ROLCLI) {
            $request_pref = $this->selectPreferenciasCliente($_SESSION['idUser']);
            $request_suscrip = $this->selectSuscripcionCliente($_SESSION['idUser']);
            if (count($request_pref) > 0) {
                $data["preferidos"] = $request_pref;
                $data["cantPreferencias"] = count($request_pref);
            } else {
                $data["preferidos"] = "";
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
        if (empty($params)) {
            header("Location:" . base_url());
        } else {
            $arrParams = explode(",", $params);
            $idproducto = intval($arrParams[0]);
            $ruta = strClean($arrParams[1]);
            $infoProducto = $this->getProductoT($idproducto, $ruta);
            if (empty($infoProducto)) {
                header("Location:" . base_url());
            }
            $data['slider'] = $this->getCategoriasT(MENUCAT);
            $data['searchCat'] = $this->getCategorias();
            $data['page_tag'] = NOMBRE_EMPESA . " - " . $infoProducto['nombrePro'];
            $data['page_title'] = $infoProducto['nombrePro'];
            $data['page_name'] = "producto";
            $data['producto'] = $infoProducto;
            $data['productos'] = $this->getProductosRandom($infoProducto['categoriaPro'], 3, "r");
            $this->views->getView($this, "producto", $data);
        }
    }

    public function page($pagina = null) {
        $pagina = is_numeric($pagina) ? $pagina : 1;
        $ProductosPrefer = $this->cantProductos();
        $total_registro = count($ProductosPrefer);
        $desde = ($pagina - 1) * PROPORPAGINA;
        $total_paginas = ceil($total_registro / PROPORPAGINA);
        $data['productos'] = $this->getProductosPage($desde, PROPORPAGINA);
        $data['slider'] = $this->getCategoriasT(MENUCAT);
        $data['searchCat'] = $this->getCategorias();
        if (isset($_SESSION['rol']) && $_SESSION['rol'] == "Cliente") {
            $request_pref = $this->selectPreferenciasCliente($_SESSION['idUser']);
            $request_suscrip = $this->selectSuscripcionCliente($_SESSION['idUser']);
            if (count($request_pref) > 0) {
                $data["preferidos"] = $request_pref;
                $data["cantPreferencias"] = count($request_pref);
            } else {
                $data["preferidos"] = "";
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
        //dep($data['productos']);exit;
        $data['page_tag'] = NOMBRE_EMPESA . " -  Pagina N°" . $pagina;
        $data['page_title'] = NOMBRE_EMPESA;
        $data['page_name'] = "tienda";
        $data['pagina'] = $pagina;
        $data['total_paginas'] = $total_paginas;
        $this->views->getView($this, "tienda", $data);
    }

    public function addCarrito() {
        if ($_POST) {
            if (isset($_SESSION['rol']) || !isset($_SESSION['idUser']) || $_SESSION['rol'] == ROL) {
                //unset($_SESSION['arrCarrito']);exit;
                $arrCarrito = array();
                $cantCarrito = 0;
                $montoDescount = 0;
                $totalDescount = 0;
                $idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
                $cantidad = $_POST['cant'];
                $idpref = (isset($_POST['Pref'])) ? $_POST['Pref'] : "";
                $idDetailSus = (isset($_POST['Suscript'])) ? $_POST['Suscript'] : "";
                if (is_numeric($idproducto) and is_numeric($cantidad)) {
                    $arrInfoProducto = $this->getProductoIDT($idproducto);
                    if (!empty($arrInfoProducto)) {
                        $arrProducto = array('idproducto' => $idproducto,
                            'producto' => $arrInfoProducto['nombrePro'],
                            'cantidad' => $cantidad,
                            'categoria' => $arrInfoProducto["categoriaPro"],
                            'ruta' => $arrInfoProducto['rutaPro'],
                            'precio' => $arrInfoProducto['precioPro'],
                            'imagen' => $arrInfoProducto['images'][0]['url_image']
                        );
                        if (isset($_SESSION['arrCarrito'])) {
                            $on = true;
                            $arrCarrito = $_SESSION['arrCarrito'];
                            for ($pr = 0; $pr < count($arrCarrito); $pr++) {
                                if ($arrCarrito[$pr]['idproducto'] == $idproducto) {
                                    $arrCarrito[$pr]['cantidad'] += $cantidad;
                                    $on = false;
                                }
                            }
                            if ($on) {
                                array_push($arrCarrito, $arrProducto);
                            }
                            $_SESSION['arrCarrito'] = $arrCarrito;
                        } else {
                            array_push($arrCarrito, $arrProducto);
                            $_SESSION['arrCarrito'] = $arrCarrito;
                        }

                        $subtotal = 0;
                        $porcentaje = 0;
                        foreach ($_SESSION['arrCarrito'] as $pro) {
                            if ($pro["categoria"] != IDCATCUPON) {
                                $cantCarrito += $pro['cantidad'];
                                $subtotal += $pro['cantidad'] * $pro['precio'];
                            } else {
                                $porcentaje = $pro["precio"];
                            }
                        }
                        $montoDescount = $subtotal * ($porcentaje / 100);
                        $_SESSION["totalDescount"] = $totalDescount = $subtotal - $montoDescount;
                        $htmlCarrito = getFile('Template/Modals/modalCarrito', $_SESSION['arrCarrito']);
                        $resultPrefe = "";
                        $resultSuscrip = "";
                        if (!empty($idpref)) {
                            $productoPrefer = $this->searchProductPreference($idproducto, $_SESSION['idUser']);
                            $resultPrefe = $this->UpdateStatusPreferido($productoPrefer["idPreferencia"], 0);
                            $requestCant = $this->selectPreferenciasCliente($_SESSION['idUser']);
                            $cantPreferencias = count($requestCant);
                            $arrResponse = array("status" => true,
                                "msg" => '¡Se agrego al carrito!',
                                "nameProduct" => $arrInfoProducto['nombrePro'],
                                "cantCarrito" => $cantCarrito,
                                "cantPreferencias" => $cantPreferencias,
                                "htmlCarrito" => $htmlCarrito,
                                "respuestaPref" => $resultPrefe
                            );
                        } else if (!empty($idDetailSus)) {
                                $productoSuscript = $this->getProductSuscript($idproducto, $_SESSION['idUser']);
                            $resultSuscrip = $this->removeProductoSuscrip($productoSuscript["idDetalleSuscripcion"]);
                            $requestCantSus = $this->selectSuscripcionCliente($_SESSION['idUser']);
                            if (count($requestCantSus) == 0) {
                                $this->removeSuscripcionCliente($_SESSION['idUser']);
                            }
                            $cantSuscripcion = count($requestCantSus);
                            $arrResponse = array("status" => true,
                                "msg" => '¡Se agrego al carrito!',
                                "nameProduct" => $arrInfoProducto['nombrePro'],
                                "cantCarrito" => $cantCarrito,
                                "cantSuscripciones" => $cantSuscripcion,
                                "htmlCarrito" => $htmlCarrito,
                                "respuestaSus" => $resultSuscrip
                            );
                        } else {
                            $arrResponse = array("status" => true,
                                "msg" => '¡Se agrego al carrito!',
                                "nameProduct" => $arrInfoProducto['nombrePro'],
                                "cantCarrito" => $cantCarrito,
                                "htmlCarrito" => $htmlCarrito
                            );
                        }
                    } else {
                        $arrResponse = array("status" => false, "msg" => 'Producto no existente.');
                    }
                } else {
                    $arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
                }
            } else {
                $arrResponse = array("status" => false, "msg" => 'No puede agregar al carrito por no ser Cliente...');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delCarrito() {
        if ($_POST) {
            $arrCarrito = array();
            $subtotal = 0;
            $montoDescount = 0;
            $totalDescount = 0;
            $cantCarrito = 0;
            $idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
            $option = $_POST['option'];
            if (is_numeric($idproducto) and ( $option == 1 or $option == 2)) {
                $arrCarrito = $_SESSION['arrCarrito'];
                for ($pr = 0; $pr < count($arrCarrito); $pr++) {
                    if ($arrCarrito[$pr]['idproducto'] == $idproducto) {
                        unset($arrCarrito[$pr]);
                    }
                }
                sort($arrCarrito);
                $_SESSION['arrCarrito'] = $arrCarrito;
                $porcentaje = 0;
                foreach ($_SESSION['arrCarrito'] as $pro) {
                    if ($pro["categoria"] != IDCATCUPON) {
                        $cantCarrito += $pro['cantidad'];
                        $subtotal += $pro['cantidad'] * $pro['precio'];
                    } else {
                        $porcentaje = $pro["precio"];
                    }
                }
                $montoDescount = $subtotal * ($porcentaje / 100);
                $totalDescount = $subtotal - $montoDescount;
                $_SESSION["totalDescount"] = $totalDescount;
                $htmlCarrito = "";
                if ($option == 1) {
                    $htmlCarrito = getFile('Template/Modals/modalCarrito', $_SESSION['arrCarrito']);
                }

                if (isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) == 1) {
                    foreach ($_SESSION['arrCarrito'] as $pro) {
                        if ($pro["categoria"] == IDCATCUPON) {
                            unset($_SESSION['arrCarrito']);
                            unset($_SESSION["totalDescount"]);
                            unset($_SESSION["nameCupon"]);
                        }
                    }
                }

                $arrResponse = array("status" => true,
                    "msg" => '¡Producto eliminado!',
                    "cantCarrito" => $cantCarrito,
                    "htmlCarrito" => $htmlCarrito,
                    "subTotal" => SMONEY . formatMoney($subtotal),
                    "newSubtotal" => (!empty($totalDescount)) ? SMONEY . formatMoney($totalDescount) : 0,
                    "montoDescount" => (!empty($montoDescount)) ? SMONEY . formatMoney($montoDescount) : 0,
                    "total" => SMONEY . formatMoney((!empty($totalDescount) ? $totalDescount : $subtotal) + COSTOENVIO)
                );
            } else {
                $arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function updCarrito() {
        if ($_POST) {
            $arrCarrito = array();
            $totalProducto = 0;
            $subtotal = 0;
            $cantCarrito = 0;
            $montoDescount = 0;
            $totalDescount = 0;
            $idproducto = openssl_decrypt($_POST['id'], METHODENCRIPT, KEY);
            $cantidad = intval($_POST['cantidad']);
            if (is_numeric($idproducto) and $cantidad > 0) {
                $arrCarrito = $_SESSION['arrCarrito'];
                for ($p = 0; $p < count($arrCarrito); $p++) {
                    if ($arrCarrito[$p]['idproducto'] == $idproducto) {
                        $arrCarrito[$p]['cantidad'] = $cantidad;
                        $totalProducto = $arrCarrito[$p]['precio'] * $cantidad;
                        break;
                    }
                }
                $_SESSION['arrCarrito'] = $arrCarrito;
                $porcentaje = 0;
                foreach ($_SESSION['arrCarrito'] as $pro) {
                    if ($pro["categoria"] != IDCATCUPON) {
                        $cantCarrito += $pro['cantidad'];
                        $subtotal += $pro['cantidad'] * $pro['precio'];
                    } else {
                        $porcentaje = $pro["precio"];
                    }
                }
                $montoDescount = $subtotal * ($porcentaje / 100);
                $totalDescount = $subtotal - $montoDescount;
                $_SESSION["totalDescount"] = $totalDescount;

                $arrResponse = array("status" => true,
                    "msg" => '¡Producto actualizado!',
                    "totalProducto" => SMONEY . formatMoney($totalProducto),
                    "subTotal" => SMONEY . formatMoney($subtotal),
                    "newSubtotal" => (!empty($totalDescount)) ? SMONEY . formatMoney($totalDescount) : 0,
                    "montoDescount" => (!empty($montoDescount)) ? SMONEY . formatMoney($montoDescount) : 0,
                    "total" => SMONEY . formatMoney((!empty($totalDescount) ? $totalDescount : $subtotal) + COSTOENVIO)
                );
            } else {
                $arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function addCupon() {
        if ($_POST) {
            //unset($_SESSION['arrCarrito']);exit;
            $arrCarrito = array();
            $subtotal = 0;
            $montoDescount = 0;
            $totalDescount = 0;
            $cantidad = $_POST['cantCupon'];
            $codigoCup = strtoupper(strClean($_POST["txtCodeDescount"]));
            if (is_numeric($cantidad) and is_string($codigoCup) and isset($_SESSION['arrCarrito'])) {
                $arrInfoCupon = $this->getCuponDescount($codigoCup);
                if (!empty($arrInfoCupon)) {
                    $arrCupon = array('idproducto' => $arrInfoCupon["idproducto"],
                        'producto' => $arrInfoCupon['nombrePro'],
                        'cantidad' => $cantidad,
                        'categoria' => $arrInfoCupon["categoriaPro"],
                        'ruta' => $arrInfoCupon['rutaPro'],
                        'precio' => $arrInfoCupon['precioPro'],
                        'imagen' => ""
                    );
                    if (isset($_SESSION['arrCarrito'])) {
                        $on = true;
                        $arrCarrito = $_SESSION['arrCarrito'];
                        for ($pr = 0; $pr < count($arrCarrito); $pr++) {
                            if ($arrCarrito[$pr]['categoria'] == IDCATCUPON) {
                                $on = false;
                            }
                        }
                        if ($on) {
                            array_push($arrCarrito, $arrCupon);
                        }
                        $_SESSION['arrCarrito'] = $arrCarrito;
                    } else {
                        $arrResponse = array("status" => false, "msg" => 'El carrito no esta definido...');
                    }
                    foreach ($_SESSION['arrCarrito'] as $pro) {
                        if ($pro["categoria"] != IDCATCUPON) {
                            $subtotal += $pro['cantidad'] * $pro['precio'];
                        }
                    }
                    $montoDescount = $subtotal * ($arrInfoCupon['precioPro'] / 100);
                    $_SESSION["totalDescount"] = $totalDescount = $subtotal - $montoDescount;
                    $_SESSION["nameCupon"] = $arrInfoCupon['nombrePro'];
                    $htmlCarrito = getFile('Template/Modals/modalCarrito', $_SESSION['arrCarrito']);
                    if ($on) {
                        $arrResponse = array("status" => true,
                            "msg" => '¡Cupon agregado Exitosamente!',
                            "subTotal" => SMONEY . formatMoney($totalDescount),
                            "total" => SMONEY . formatMoney($totalDescount + COSTOENVIO),
                            "htmlCarrito" => $htmlCarrito
                        );
                    } else {
                        $arrResponse = array("status" => false, "msg" => 'Ya hay un cupon ingresado..');
                    }
                } else {
                    $arrResponse = array("status" => false, "msg" => 'Cupon no existente.');
                }
            } else {
                $arrResponse = array("status" => false, "msg" => 'El carrito esta vacio !!');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delCupon() {
        if ($_POST) {
            //unset($_SESSION['arrCarrito']);exit;
            $arrCarrito = array();
            $subtotal = 0;
            $idproducto = 0;
            $codigoCup = strtoupper(strClean($_POST["txtCodeDescount"]));
            if (is_string($codigoCup)) {
                $arrInfoCupon = $this->getCuponDescount($codigoCup);
                if (!empty($arrInfoCupon)) {
                    $idproducto = $arrInfoCupon["idproducto"];
                    $arrCarrito = $_SESSION['arrCarrito'];
                    for ($pr = 0; $pr < count($arrCarrito); $pr++) {
                        if ($arrCarrito[$pr]['idproducto'] == $idproducto) {
                            unset($arrCarrito[$pr]);
                        }
                    }
                    sort($arrCarrito);
                    $_SESSION['arrCarrito'] = $arrCarrito;
                    foreach ($_SESSION['arrCarrito'] as $pro) {
                        $subtotal += $pro['cantidad'] * $pro['precio'];
                    }
                    $arrResponse = array("status" => true,
                        "msg" => 'Cupon Elimado Exitosamente !!',
                        "subTotal" => SMONEY . formatMoney($subtotal),
                        "total" => SMONEY . formatMoney($subtotal + COSTOENVIO)
                    );
                    unset($_SESSION["nameCupon"]);
                    unset($_SESSION["totalDescount"]);
                } else {
                    $arrResponse = array("status" => false, "msg" => 'EL cupon no esta registrado..');
                }
            } else {
                $arrResponse = array("status" => false, "msg" => 'Dato incorrecto.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function procesarVenta() {
        if ($_POST) {
            $personaid = $_SESSION['idUser'];
            $montoTotal = 0;
            $tipopagoid = intval($_POST['inttipopago']);
            $direccionP = intval($_POST['direccion']);
            $status = "Pendiente";
            $subtotal = 0;
            $totalDescount = 0;
            $montoDescount = 0;
            $costo_envio = COSTOENVIO;
            $request_pedido = "";
            //recorremos el carrito y sumamos el total de los productos que tenga
            $porcentaje = 0;
            if (!empty($_SESSION['arrCarrito'])) {
                foreach ($_SESSION['arrCarrito'] as $pro) {
                    if ($pro["categoria"] != IDCATCUPON) {
                        $subtotal += $pro['cantidad'] * $pro['precio'];
                    } else {
                        $porcentaje = $pro["precio"];
                    }
                }
                $montoDescount = $subtotal * ($porcentaje / 100);
                $totalDescount = $subtotal - $montoDescount;
                $montoTotal = (empty($totalDescount) ? $subtotal : $totalDescount) + COSTOENVIO;

                //insertamos los datos del pedidos
                $request_pedido = $this->insertPedido($personaid, $costo_envio, empty($totalDescount) ? $subtotal : $totalDescount, $montoTotal, $tipopagoid, $status, $direccionP, 1); //el 1 representa que sera visible en el dashboard

                if ($request_pedido > 0) {
                    foreach ($_SESSION['arrCarrito'] as $producto) {
                        $productoid = $producto['idproducto'];
                        $precio = $producto['precio'];
                        $cantidad = $producto['cantidad'];
                        //insertamos los productos que fueron almacenados en el carrito
                        $this->insertDetalle($request_pedido, $productoid, $precio, $cantidad);

                        //actualizamos el stock de los productos que formaran parte del pedido
                        $productoUpdate = $this->updateCantProducto($productoid, $cantidad);

                        //cambiamos el status si esta como preferido el producto para que quede como evidencia de que es lo que mas quieren
                        $productoTendencia = $this->UpdateTendenciaProducto($productoid, $personaid, 2); // el 2 representa que sera el producto mas adquirido
                    }
                    if ($productoUpdate > 0 && $productoTendencia > 0) {
                        $cantPedidos = $this->cantPedidosCliente($personaid);

                        $arrResponse = array("status" => true, "msg" =>
                            'Su pedido N°' . count($cantPedidos) . ' fue registrado exitosamente...',
                            "userName" => $_SESSION['userData']["nombrePersona"]);

                        unset($_SESSION['arrCarrito']);
                        if (isset($_SESSION["totalDescount"])) {
                            unset($_SESSION["totalDescount"]);
                            unset($_SESSION["nameCupon"]);
                        }
                        //session_regenerate_id(true);
                    } else {
                        $arrResponse = array("status" => false, "msg" => "El pedido no fue procesado...");
                    }
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
                }
            } else {
                $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
            }
        } else {
            $arrResponse = array("status" => false, "msg" => 'No es posible procesar el pedido.');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function setSuscripcion() {
        if ($_POST) {
            if (empty($_POST["txtCorreoSuscripcion"]) || !isset($_SESSION["login"])) {
                $arrResponse = array("status" => false, "msg" => 'No esta iniciada su sesion..');
            } else {
                $request_suscrip = "";
                $strEmail = ucwords(strClean($_POST["txtCorreoSuscripcion"]));
                $Cliente = $this->getSuscripcionCliente($strEmail);
                $selectCliente = $this->getCorreoCliente($strEmail, $_SESSION['idUser']);

                if (empty($Cliente) && $_SESSION['rol'] == ROLCLI) {
                    $opcion = 1;
                    $request_suscrip = $this->insertSuscripcion($selectCliente["idPersona"], 1);
                } else {
                    $opcion = 2;
                    $request_suscrip = $this->updateSuscripcion($strEmail, 1);
                }

                if ($request_suscrip > 0) {
                    suscripcionCli($_SESSION['idUser']);
                    if ($opcion == 1) {
                        $arrResponse = array("status" => true, "msg" => "Su sucripcion se registro exitosamente...");
                    } else {
                        $arrResponse = array("status" => true, "msg" => "Su sucripcion se volvio a activar exitosamente...");
                    }
                } else if ($request_suscrip == "exist") {
                    $arrResponse = array("status" => false, "msg" => "Su correo ya fue registrado anteriormente..");
                } else if ($_SESSION['rol'] != ROLCLI) {
                    $arrResponse = array("status" => false, "msg" => "Su correo no esta registrado como Cliente..");
                } else {
                    $arrResponse = array("status" => false, "msg" => 'El correo no fue identificado..');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function delSuscripcion() {
        if ($_POST) {
            if (empty($_POST["txtCorreoDesuscripcion"]) || !isset($_SESSION["login"])) {
                $arrResponse = array("status" => false, "msg" => 'No esta iniciada su sesion..');
            } else {
                $request_suscrip = "";
                $strEmail = ucwords(strClean($_POST["txtCorreoDesuscripcion"]));
                $Cliente = $this->getSuscripcionCliente($strEmail);
                $selectCliente = $this->getCorreoCliente($strEmail);

                if (!empty($Cliente) && $_SESSION['rol'] == ROLCLI) {
                    $request_suscrip = $this->removeSuscripcionCliente($selectCliente["idPersona"]);
                }

                if ($request_suscrip > 0) {
                    $this->removeProductosFromCliente($Cliente["idSuscripcion"]);
                    unset($_SESSION["suscripcion"]);
                    $arrResponse = array("status" => true, "msg" => "Su suscripcion fue removida Exitosamente..");
                } else if ($request_suscrip == "exist") {
                    $arrResponse = array("status" => false, "msg" => "Su suscripcion ya fue eliminadad anteriormente..");
                } else if ($_SESSION['rol'] != ROLCLI) {
                    $arrResponse = array("status" => false, "msg" => "Su correo no esta registrado como Cliente..");
                } else {
                    $arrResponse = array("status" => false, "msg" => 'El correo no fue identificado..');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function delProductSuscript() {
        if ($_POST) {
            $idprod = openssl_decrypt($_POST['idproducto'], METHODENCRIPT, KEY);
            if (!empty($idprod)) {
                $idProduct = intval($idprod);
                $request_suscript = "";
                if ($idProduct > 0) {
                    $request_suscript = $this->removeProductSuscript($idProduct);
                }
                if ($request_suscript) {
                    $requestCant = $this->selectSuscripcionCliente($_SESSION['idUser']);
                    $cantSuscripciones = count($requestCant);
                    $arrResponse = array('status' => true, 'cantSuscripciones' => $cantSuscripciones, 'msg' => 'Producto suscrito eliminado exitosamente...');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se elimino el producto de preferidos');
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el producto suscrito');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delPedido() {
        if ($_POST) {
            $idped = openssl_decrypt($_POST['idpedido'], METHODENCRIPT, KEY);
            if (!empty($idped)) {
                $idpedido = intval($idped);
                $request_pedido = "";
                if ($idpedido > 0) {
                    $request_pedido = $this->updateStatusPedido($idpedido, 0, "Cancelado");
                }
                if ($request_pedido > 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Pedido Eliminado Exitosamente !!');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se elimino el pedido');
                }
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el pedido');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

}

?>
