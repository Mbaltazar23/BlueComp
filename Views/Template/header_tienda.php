<?php ?>
<!DOCTYPE html>
<html lang="en">
    <?php
    $arrSlider = $data['slider'];
    $arrSelectCat = $data['searchCat'];
    $arrCupones = isset($data['cupones']) ? $data["cupones"] : "";
    //ajustes para el carrito
    $cantCarrito = 0;
    if (isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0) {
        foreach ($_SESSION['arrCarrito'] as $product) {
            if ($product["categoria"] != IDCATCUPON) {
                $cantCarrito += $product['cantidad'];
            }
        }
    }
    //ajustes para los productos preferidos o suscritos
    $arrPreferidos = "";
    $arrSuscripcion = "";
    $cantPreferencias = 0;
    $cantSuscripciones = 0;
    if (isset($_SESSION['userData']) && $_SESSION['userData']["nombreRol"] == ROLCLI) {
        $arrPreferidos = (isset($data["preferidos"])) ? $data["preferidos"] : "";
        $cantPreferencias = (isset($data["cantPreferencias"])) ? $data["cantPreferencias"] : 0;
        $arrSuscripcion = (isset($data["suscripciones"])) ? $data["suscripciones"] : "";
        $cantSuscripciones = (isset($data["cantSuscritos"])) ? $data["cantSuscritos"] : 0;
        //dep($arrPreferidos);
    }
    ?>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?= $data['page_tag'] ?></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="<?= media() ?>/tienda/css/bootstrap.min.css">

        <!-- Icon Font CSS -->
        <link rel="stylesheet" href="<?= media() ?>/tienda/css/icon-font.min.css">

        <!-- Plugins CSS -->
        <link href="<?= media() ?>/tienda/css/plugins.css" rel="stylesheet" type="text/css"/>

        <!-- Main Style CSS -->
        <link href="<?= media() ?>/tienda/css/style.css" rel="stylesheet" type="text/css"/>
        <!-- Modernizer JS -->
        <script src="<?= media() ?>/tienda/js/vendor/modernizr-2.8.3.min.js" type="text/javascript"></script>
    </head>
    <body>
        <?php include './Views/Template/nav_tienda.php'; ?>
