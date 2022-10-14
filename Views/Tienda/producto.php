<?php
headerTienda($data);
getModal("modalSesion-Registro", $data);
$arrProducto = $data['producto'];
$arrProductos = $data['productos'];
$arrImages = $arrProducto['images'];
?>
<!-- Single Product Section Start -->
<div class="product-section section mt-90 mb-90">
    <div class="container">

        <div class="row mb-90">

            <div class="col-lg-6 col-12 mb-50">
                <!-- Image -->
                <div class="single-product-image thumb-right">
                    <div class="tab-content">
                        <?php
                        if (!empty($arrImages)) {
                            for ($i = 0; $i < count($arrImages); $i++) {
                                $id = ($i + 1);
                                ?>
                                <div id="single-image-<?= $id ?>" class="tab-pane fade <?= ($id == 1) ? "show active" : " " ?> big-image-slider">
                                    <?php for ($img = 0; $img < count($arrImages); $img++) { ?>
                                        <div class="big-image"><img src="<?= $arrImages[$img]['url_image']; ?>" alt="Big Image <?= $arrProducto['nombrePro']; ?>"><a href="<?= $arrImages[$img]['url_image']; ?>" class="big-image-popup"><i class="fa fa-search-plus"></i></a></div>
                                    <?php } ?>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="thumb-image-slider nav" data-vertical="true">
                        <?php
                        if (!empty($arrImages)) {
                            for ($i = 0; $i < count($arrImages); $i++) {
                                $id = ($i + 1);
                                ?>
                                <a class="thumb-image <?= ($id == 1) ? "active" : " " ?>" data-toggle="tab" href="#single-image-<?= $id ?>"><img src="<?= $arrImages[$i]['url_image']; ?>" alt="Thumbnail Image <?= $arrProducto['nombrePro']; ?>"></a>
                                <?php
                            }
                        }
                        ?>        
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12 mb-50">
                <!-- Content -->
                <div class="single-product-content">
                    <!-- Category & Title -->
                    <div class="head-content">

                        <div class="category-title">
                            <a href="<?= base_url() ?>/tienda/categoria/<?= $arrProducto["categoriaPro"] ?>" class="cat"><?= $arrProducto["categoria"] ?></a>
                            <h5 class="title js-name-detail"><?= $arrProducto["nombrePro"] ?></h5>
                        </div>

                        <h5 class="price"><?= SMONEY . formatMoney($arrProducto["precioPro"]) ?></h5>

                    </div>

                    <div class="single-product-description">
                        <div class="desc">
                            <p><?= $arrProducto["descripcionPro"] ?></p>
                        </div>
                        <div class="quantity-colors">
                            <div class="quantity">
                                <h5>Cantidad</h5>
                                <div class="pro-qty">
                                    <span class="dec qtybtn prev-item">-</span>
                                    <input class="num-product" id="cant-product" type="text" name="num-product" value="1" max="<?= $arrProducto["stockPro"] ?>">
                                    <span class="inc qtybtn next-item">+</span>
                                </div>
                            </div>                            
                        </div> 
                        <div class="actions">
                            <a id="<?= openssl_encrypt($arrProducto['idproducto'], METHODENCRIPT, KEY); ?>" class="js-addcart-detail add-to-cart"><i class="ti-shopping-cart"></i><span>Añadir al Carrito</span></a>
                            <div class="wishlist-compare">
                                <?php if (isset($_SESSION['login'])) { ?>
                                    <a id="<?= openssl_encrypt($arrProducto['idproducto'], METHODENCRIPT, KEY); ?>" class="js-addpreference-detail" data-tooltip="Preferidos" style="background: white"><i class="ti-heart"></i></a>
                                <?php } else { ?>
                                    <a onclick="openModalSesion('prefefer')" data-tooltip="Preferidos" style="background: white"><i class="ti-heart"></i></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- Single Product Section End -->

<!-- Related Product Section Start -->
<div class="product-section section mb-70">
    <div class="container">
        <div class="row">
            <!-- Section Title Start -->
            <div class="col-12 mb-40">
                <div class="section-title-one" data-title="PRODUCTOS SIMILARES"><h1>PRODUCTOS SIMILARES</h1></div>
            </div><!-- Section Title End -->
            <div class="col-12">
                <!-- Product Slider Wrap Start -->
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
                                                <a onclick="openModalSesion()" data-tooltip="Preferidos" style="background: white"><i class="ti-heart"></i></a>
                                            <?php } ?>
                                        </div>
                                        <a id="<?= openssl_encrypt($arrProductos[$p]['idproducto'], METHODENCRIPT, KEY); ?>" class="js-addcart-detail add-to-cart"><i class="ti-shopping-cart"></i><span>Añadir al Carrito</span></a>
                                    </div>
                                    <!-- Content -->
                                    <div class="content">
                                        <!-- Category & Title -->
                                        <div class="category-title">
                                            <a href="#" class="cat"><?= $arrProductos[$p]["categoria"] ?></a>
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
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
footerTienda($data);
?>