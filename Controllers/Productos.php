<?php

class Productos extends Controllers {

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

    public function productos() {
        $data['page_tag'] = TITLE_ADMIN . "- Productos";
        $data['page_title'] = "Productos";
        $data['page_name'] = "productos";
        $data['rol-personal'] = $_SESSION['rol'];
        $data['page_functions_js'] = "functions_productos.js";
        $this->views->getView($this, "productos", $data);
    }

    public function getProductos() {
        $arrData = $this->model->selectProductos();
        for ($i = 0; $i < count($arrData); $i++) {
            $btnView = '';
            $btnEdit = '';
            $btnDelete = '';
            if ($arrData[$i]['estadoPro'] == 1) {
                $arrData[$i]['estadoPro'] = '<span class="badge badge-success">Activo</span>';
                $btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idproducto'] . ')" title="Ver producto"><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['idproducto'] . ')" title="Editar producto"><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo(' . $arrData[$i]['idproducto'] . ')" title="Eliminar producto"><i class="far fa-trash-alt"></i></button>';
            } else {
                $arrData[$i]['estadoPro'] = '<span class="badge badge-danger">Inactivo</span>';
                $btnView = '<button class="btn btn-secondary btn-sm" onClick="fntViewInfo(' . $arrData[$i]['idproducto'] . ')" title="Ver producto" disabled><i class="far fa-eye"></i></button>';
                $btnEdit = '<button class="btn btn-secondary  btn-sm" onClick="fntEditInfo(this,' . $arrData[$i]['idproducto'] . ')" title="Editar producto" disabled><i class="fas fa-pencil-alt"></i></button>';
                $btnDelete = '<button class="btn btn-dark btn-sm" onClick="fntActiveInfo(' . $arrData[$i]['idproducto'] . ')" title="Activar producto"><i class="fas fa-toggle-on"></i></button>';
            }
            $arrData[$i]['precioPro'] = SMONEY . '' . formatMoney($arrData[$i]['precioPro']);


            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
    }

    public function setProducto() {
        if ($_POST) {
            if (empty($_POST['txtNombre']) || empty($_POST['listCategoria']) || empty($_POST['txtPrecio']) || empty($_POST['txtStock'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idProducto = intval($_POST['idProducto']);
                $strNombre = ucwords(strClean($_POST['txtNombre']));
                $strDescripcion = ucwords(strClean($_POST['txtDescripcion']));
                $intCategoriaId = intval($_POST['listCategoria']);
                $strPrecio = intval($_POST['txtPrecio']);
                $intStock = intval($_POST['txtStock']);
                $ruta = strtolower(clear_cadena($strNombre));
                $strRuta = str_replace(" ", "-", $ruta);
                $fecha = date("Y-m-d H:i:s");
                $request_producto = "";

                if ($idProducto == 0) {
                    $option = 1;
                    $request_producto = $this->model->insertProducto($strNombre, $strDescripcion, $intCategoriaId, $strPrecio, $intStock, 1, $fecha, $strRuta);
                } else {
                    $option = 2;
                    $request_producto = $this->model->updateProducto($idProducto, $strNombre, $strDescripcion, $intCategoriaId, $strPrecio, $intStock, 1, $strRuta);
                }
                if ($request_producto > 0) {
                    if ($option == 1) {
                        $arrResponse = array('status' => true, 'idproducto' => $request_producto, 'msg' => 'Datos del producto guardados correctamente.');
                    } else {
                        $arrResponse = array('status' => true, 'idproducto' => $idProducto, 'msg' => 'Datos Actualizados correctamente.');
                    }
                } else if ($request_producto == 'exist') {
                    $arrResponse = array('status' => false, 'msg' => '¡Atención! ya existe un producto con el Código Ingresado.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    public function getProducto($id) {
        $idproducto = intval($id);
        if ($idproducto > 0) {
            $arrData = $this->model->selectProducto($idproducto);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrImg = $this->model->selectImages($idproducto);
                if (count($arrImg) > 0) {
                    for ($i = 0; $i < count($arrImg); $i++) {
                        $arrImg[$i]['url_image'] = media() . '/images/uploads/' . $arrImg[$i]['img'];
                    }
                }
                $arrData['images'] = $arrImg;
                $arrData['precio'] = SMONEY . formatMoney($arrData['precioPro']);
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setImage() {
        if ($_POST) {
            if (empty($_POST['idproducto'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de dato.');
            } else {
                $idProducto = intval($_POST['idproducto']);
                $foto = $_FILES['foto'];
                $imgNombre = 'pro_' . md5(date('d-m-Y H:m:s')) . '.jpg';
                $request_image = $this->model->insertImage($idProducto, $imgNombre);
                if ($request_image) {
                    $uploadImage = uploadImage($foto, $imgNombre);
                    $arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Archivo cargado.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error de carga.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function delFile() {
        if ($_POST) {
            if (empty($_POST['idproducto']) || empty($_POST['file'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                //Eliminar de la DB
                $idProducto = intval($_POST['idproducto']);
                $imgNombre = strClean($_POST['file']);
                $request_image = $this->model->deleteImage($idProducto, $imgNombre);

                if ($request_image) {
                    $deleteFile = deleteFile($imgNombre);
                    $arrResponse = array('status' => true, 'msg' => 'Archivo eliminado');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function setStatusProducto() {
        if ($_POST) {
            $intIdproducto = intval($_POST['idProducto']);
            $status = intval($_POST["status"]);
            $requestDelete = $this->model->updateStatusProducto($intIdproducto, $status);
            if ($requestDelete == 'ok') {
                if ($status == 1) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha activado el producto');
                } else {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha inhabilitado el producto');
                }
            } else if ($requestDelete == 'exist') {
                $arrResponse = array('status' => false, 'msg' => 'No se puede eliminar este producto al ser uno preferido...');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'No es posible inhabilitar este produccto..');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

}

?>