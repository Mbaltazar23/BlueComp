<?php
headerTienda($data);
getModal("modalSesion-Registro", $data);
$arrSuscripcion = (isset($data["suscripciones"])) ? $data["suscripciones"] : "";
?>
<div class="page-section section mt-90 mb-90">
    <div class="container">
        <div class="row">
            <div class="section-title-one"><h1>Todos los productos sugeridos para usted Sr(a) <?= $_SESSION['userData']['nombrePersona'] ?></h1></div>
            <div class="col-12">
                <form action="#">		
                    <!-- Compare Table -->
                    <div class="compare-table table-responsive" id="tableSup">
                        <?php if (isset($arrSuscripcion) && !empty($arrSuscripcion)) { ?>
                        <table class="table mb-0" id="tableSuscrip">
                                <tbody>
                                <input type="hidden" id="opcionSuscripion" value="suscripcion"/>
                                <tr>
                                    <td class="first-column">Producto</td>
                                    <?php
                                    for ($p = 0; $p < count($arrSuscripcion); $p++) {
                                        $ruta = $arrSuscripcion[$p]["rutaPro"];
                                        if (count($arrSuscripcion[$p]['images']) > 0) {
                                            $portada = $arrSuscripcion[$p]['images'][0]['url_image'];
                                        } else {
                                            continue;
                                        }
                                        ?>
                                        <td class="product-image-title">
                                            <a href="<?= base_url() . '/tienda/producto/' . $arrSuscripcion[$p]['productoSuscrito'] . '/' . $ruta; ?>" class="image"><img src="<?= $portada ?>" alt="<?= $arrSuscripcion[$p]['nombrePro'] ?>" width="108" height="138"></a>
                                            <a href="<?= base_url() . '/tienda/categoria/' . $arrSuscripcion[$p]['categoriaPro'] ?>" class="category"><?= $arrSuscripcion[$p]['Categoria'] ?></a>
                                            <a href="<?= base_url() . '/tienda/producto/' . $arrSuscripcion[$p]['productoSuscrito'] . '/' . $ruta; ?>" class="title"><?= $arrSuscripcion[$p]['nombrePro'] ?></a>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td class="first-column">Stock</td>
                                    <?php for ($r = 0; $r < count($arrSuscripcion); $r++) { ?>
                                        <td class="pro-stock"><?= $arrSuscripcion[$r]["cantidadProSuscrito"] ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td class="first-column">Precio</td>
                                    <?php
                                    for ($o = 0; $o < count($arrSuscripcion); $o++) {
                                        $idDetailSus = openssl_encrypt($arrSuscripcion[$o]['idDetalleSuscripcion'], METHODENCRIPT, KEY)
                                        ?>
                                        <td class="pro-price"><?= SMONEY . formatMoney($arrSuscripcion[$o]['precioProSuscrito']) ?><input type="hidden" class="js-name-suscripciones" value="<?= $idDetailSus ?>"/></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td class="first-column">Subtotal</td>
                                    <?php
                                    for ($d = 0; $d < count($arrSuscripcion); $d++) {
                                        $totalProducto = $arrSuscripcion[$d]['precioProSuscrito'] * $arrSuscripcion[$d]['cantidadProSuscrito'];
                                        ?>
                                        <td class="pro-price"><?= SMONEY . formatMoney($totalProducto) ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td class="first-column">Añadir al carrito</td>
                                    <?php for ($u = 0; $u < count($arrSuscripcion); $u++) { ?>
                                        <td class="pro-addtocart"><a id="<?= openssl_encrypt($arrSuscripcion[$u]['productoSuscrito'], METHODENCRIPT, KEY); ?>" cant="<?= $arrSuscripcion[$u]["cantidadProSuscrito"] ?>" class="add-to-cart js-addcart-detail" tabindex="<?= ($u + 1) ?>"><i class="ti-shopping-cart"></i><span>Añadir</span></a></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td class="first-column">Remover</td>
                                    <?php
                                    for ($c = 0; $c < count($arrSuscripcion); $c++) {
                                        $idProducto = openssl_encrypt($arrSuscripcion[$c]['productoSuscrito'], METHODENCRIPT, KEY);
                                        ?>
                                        <td class="pro-remove"><a idpr="<?= $idProducto ?>" onclick="delItemSuscripcionPro(this)"><i class="fa fa-trash-o"></i></a></td>
                                            <?php } ?>
                                </tr>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </form>	
            </div>
        </div>
    </div>
</div>
<?php
footerTienda($data);
?>

