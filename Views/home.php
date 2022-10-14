<?php
headerTienda($data);
getModal("modalSesion-Registro", $data);
$arrBanner = $data['bannerProductos'];
$arrProductos = $data['productos'];
?>
<!-- Seccion banner dinamico donde saldran los productos de mas renombre -->
<div class="hero-section section mb-30">
    <div class="container">
        <div class="row">
            <div class="col">
                <!-- Hero Slider Start -->
                <div class="hero-slider hero-slider-one">

                    <!-- Hero Item Start -->
                    <?php
                    for ($p = 0; $p < count($arrBanner); $p++) {
                        $rutaProducto = $arrBanner[$p]['rutaPro'];
                        if (count($arrBanner[$p]['images']) > 0) {
                            $portada = $arrBanner[$p]['images'][0]['url_image'];
                        } else {
                            $portada = media() . '/images/uploads/product.png';
                        }
                        ?>
                        <div class="hero-item">
                            <div class="row align-items-center justify-content-between">
                                <!-- Hero Content -->
                                <div class="hero-content col">
                                    <h3><?= $arrBanner[$p]["descripcionPro"] ?>!</h3>
                                    <h1><span><?= $arrBanner[$p]["nombrePro"] ?></span></h1>
                                    <a href="<?= base_url() . '/tienda/producto/' . $arrBanner[$p]['idproducto'] . '/' . $rutaProducto; ?>">vealo ahora !!</a>
                                </div>
                                <!-- Hero Image -->
                                <div class="hero-image col">
                                    <img src="<?= $portada ?>" alt="<?= $arrBanner[$p]["nombrePro"] ?>" width="270" height="347">
                                </div>
                            </div>     
                        </div>
                        <!-- Hero Item End -->
                    <?php } ?>
                </div><!-- Hero Slider End -->
            </div>
        </div>
    </div>
</div>

<!--Seccion donde salen las sugerencias para adquirir productos -->
<div class="feature-section section mb-60">
    <div class="container">
        <div class="row">

            <div class="col-lg-4 col-md-6 col-12 mb-30">
                <!-- Feature Start -->
                <div class="feature feature-shipping">
                    <div class="feature-wrap">
                        <div class="icon"><img src="<?= media() ?>/tienda/images/icons/feature-van.png" alt="Feature"></div>
                        <h4>Delivery economico</h4>
                        <p>Sera con un costo de $1500</p>
                    </div>
                </div><!-- Feature End -->
            </div>

            <div class="col-lg-4 col-md-6 col-12 mb-30">
                <!-- Feature Start -->
                <div class="feature feature-guarantee">
                    <div class="feature-wrap">
                        <div class="icon"><img src="<?= media() ?>/tienda/images/icons/feature-walet.png" alt="Feature"></div>
                        <h4>Ahorros aplicados con descuento</h4>
                        <p>Tenemos cupones disponibles para disminuir el valor total</p>
                    </div>
                </div><!-- Feature End -->
            </div>

            <div class="col-lg-4 col-md-6 col-12 mb-30">
                <!-- Feature Start -->
                <div class="feature feature-security">
                    <div class="feature-wrap">
                        <div class="icon"><img src="<?= media() ?>/tienda/images/icons/feature-shield.png" alt="Feature"></div>
                        <h4>Pago viable</h4>
                        <p>Contamos con los medios de pago mas usados del pais</p>
                    </div>
                </div><!-- Feature End -->
            </div>
        </div>
    </div>
</div>

<!--Seccion de los productos mas novedosos-->
<div class="product-section section mb-60">
    <div class="container">
        <div class="row">
            <!-- Section Title Start -->
            <div class="col-12 mb-40">
                <div class="section-title-one" data-title="PRODUCTOS MAS NOVEDOSOS"><h1>Productos mas novedosos</h1></div>
            </div><!-- Section Title End -->
            <div class="col-12">
                <div class="row">
                    <?php
                    if (count($arrProductos) > 0) {
                        for ($p = 0; $p < count($arrProductos); $p++) {
                            $ruta = $arrProductos[$p]['rutaPro'];
                            if (count($arrProductos[$p]['images']) > 0) {
                                $portada = $arrProductos[$p]['images'][0]['url_image'];
                            } else {
                                continue;
                            }
                            ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-12 pb-30 pt-10">
                                <!-- Descripcion del producto -->
                                <div class="ee-product">
                                    <!-- Image -->
                                    <div class="image">
                                        <a href="<?= base_url() . '/tienda/producto/' . $arrProductos[$p]['idproducto'] . '/' . $ruta; ?>" class="img"><img src="<?= $portada ?>" alt="<?= $arrProductos[$p]['nombrePro'] ?>" width="210" height="310"></a>
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
                                            <h5 class="title"><a href="<?= base_url() . '/tienda/producto/' . $arrProductos[$p]['idproducto'] . '/' . $ruta; ?>" class="js-name-detail" id="nameProduct"><?= $arrProductos[$p]["nombrePro"] ?></a></h5>
                                        </div>
                                        <!-- Price & Ratting -->
                                        <div class="price-ratting">
                                            <h5 class="price"><?= SMONEY . formatMoney($arrProductos[$p]["precioPro"]) ?></h5>
                                        </div>
                                    </div>
                                </div><!-- Product End -->
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div><!-- Shop Product Wrap End -->  
            </div>
        </div>
    </div>
</div>
<?php
footerTienda($data);
?>