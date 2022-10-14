<?php
headerTienda($data);
getModal("modalSesion-Registro", $data);
$arrProductos = $data['productos'];
?>
<div class="product-section section mt-90 mb-90">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-40">
                <div class="section-title-one"><h1>Todos los productos adquiridos de la Categoria - <?= $data['page_title'] ?></h1></div>
            </div>
            <div class="col-12">
                <div class="shop-product-wrap grid row">
                    <?php
                    if (count($arrProductos) > 0) {
                        for ($p = 0; $p < count($arrProductos); $p++) {
                            $ruta = $arrProductos[$p]['rutaPro'];
                            if (count($arrProductos[$p]['images']) > 0) {
                                $portada = $arrProductos[$p]['images'][0]['url_image'];
                            } else {
                                $portada = media() . '/images/uploads/product.png';
                            }
                            ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-12 pb-30 pt-10">
                                <!-- Product Start -->
                                <div class="ee-product">
                                    <!-- Image -->
                                    <div class="image">
                                        <a href="<?= base_url() . '/tienda/producto/' . $arrProductos[$p]['idproducto'] . '/' . $ruta; ?>" class="img"><img src="<?= $portada ?>" alt="<?= $arrProductos[$p]['nombre'] ?>" width="210" height="310"></a>
                                        <div class="wishlist-compare">
                                            <?php if (isset($_SESSION['login'])) { ?>
                                                <a id="<?= openssl_encrypt($arrProductos[$p]['idproducto'], METHODENCRIPT, KEY); ?>" class="js-addpreference-detail" data-tooltip="Preferidos" style="background: white"><i class="ti-heart"></i></a>
                                            <?php } else { ?>
                                                <a onclick="openModalSesion('prefefer')" data-tooltip="Preferidos" style="background: white"><i class="ti-heart"></i></a>
                                            <?php } ?>
                                        </div>
                                        <a id="<?= openssl_encrypt($arrProductos[$p]['idproducto'], METHODENCRIPT, KEY); ?>" class="js-addcart-detail add-to-cart"><i class="ti-shopping-cart"></i><span>Añadir al Carrito</span></a>
                                    </div>
                                    <!-- Content -->
                                    <div class="content">
                                        <!-- Category & Title -->
                                        <div class="category-title">
                                            <a href="<?= base_url() . '/tienda/categoria/' . $arrProductos[$p]['categoriaPro'] ?>" class="cat"><?= $arrProductos[$p]["categoria"] ?></a>
                                            <h5 class="title"><a href="<?= base_url() . '/tienda/producto/' . $arrProductos[$p]['idproducto'] . '/' . $ruta; ?>"><span class="js-name-detail"><?= $arrProductos[$p]["nombrePro"] ?></span></a></h5>
                                        </div>
                                        <!-- Price & Ratting -->
                                        <div class="price-ratting">
                                            <h5 class="price"><?= SMONEY . formatMoney($arrProductos[$p]["precioPro"]) ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <!-- Product End -->
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <p class="textcenter">No hay productos para mostrar <a href="<?= base_url() ?>/tienda"> Ver productos</a></p>
                    <?php } ?>
                </div><!-- Shop Product Wrap End -->  
            </div>
        </div>
    </div>
</div>
<?php
footerTienda($data);
?>