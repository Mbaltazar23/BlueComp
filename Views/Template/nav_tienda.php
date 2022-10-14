<!-- Header Section Start -->
<div class="header-section section">
    <!-- Header Top Start -->
    <div class="header-top header-top-one header-top-border pt-10 pb-10">
        <div class="container">
            <div class="row align-items-center justify-content-between">

                <div class="col mt-10 mb-10">
                    <!-- Header Links Start -->
                    <div class="header-links">
                        <?php if (isset($_SESSION['login'])) { ?>
                            <a href="<?= base_url() ?>/tienda/verOrdenes"><img src="<?= media() ?>/tienda/images/icons/car.png" alt="Car Icon"> <span>Verifique sus ordenes</span></a>
                        <?php } else { ?> 
                            <a id="btnOrdenes" onclick="openModalSesion('pedidos')"><img src="<?= media() ?>/tienda/images/icons/car.png" alt="Car Icon"> <span>Verifique sus ordenes</span></a>
                        <?php } ?>   
                    </div><!-- Header Links End -->
                </div>

                <div class="col order-12 order-xs-12 order-lg-2 mt-10 mb-10">
                    <!-- Header Advance Search Start -->
                    <div class="header-advance-search">

                        <form method="get" action="<?= base_url() ?>/tienda/search">
                            <div class="input"><input name="search" type="text" placeholder="Ingrese nombre del producto..."></div>
                            <input type="hidden" name="p" value="1">
                            <div class="select">
                                <select class="nice-select" name="selectCatS">
                                    <option value="">Categorias</option>
                                    <?php for ($i = 0; $i < count($arrSelectCat); $i++) { ?>
                                        <option value="<?= $arrSelectCat[$i]["idcategoria"] ?>"><?= $arrSelectCat[$i]["nombreCategoria"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="submit"><button><i class="icofont icofont-search-alt-1"></i></button></div>
                        </form>

                    </div><!-- Header Advance Search End -->
                </div>

                <div class="col order-2 order-xs-2 order-lg-12 mt-10 mb-10">
                    <!-- Header Account Links Start -->
                    <div class="header-account-links">
                        <?php if (isset($_SESSION['login'])) { ?>
                            <a href="#"><i class="icofont icofont-user-alt-7"></i><span>bienvenido <?= $_SESSION['userData']['nombrePersona'] ?></span></a>
                            <a onclick="cerrarSesionTienda()"><i class="icofont icofont-login d-none"></i> <span>cerrar sesion</span></a>
                        <?php } else { ?>
                            <a href="#" hidden=""><i class="icofont icofont-user-alt-7"></i> <span>mi cuenta</span></a>
                            <a onclick="openModalSesion('')"><i class="icofont icofont-login d-none"></i> <span>iniciar sesion</span></a>
                        <?php } ?>
                    </div><!-- Header Account Links End -->
                </div>

            </div>
        </div>
    </div><!-- Header Top End -->

    <!-- Header Bottom Start -->
    <div class="header-bottom header-bottom-one header-sticky">
        <div class="container">
            <div class="row align-items-center justify-content-between">

                <div class="col mt-15 mb-15">
                    <!-- Logo Start -->
                    <div class="header-logo">
                        <a href="<?= isset($_SESSION['userData']) && $_SESSION['userData']["nombreRol"] != "Cliente" ? base_url() . "/dashboard" : base_url() ?>">
                            <img src="<?= media() ?>/tienda/images/logo.jpg" alt="<?= TITLE ?>">
                            <img class="theme-dark" src="<?= media() ?>/tienda/images/logo-light.png" alt="<?= TITLE ?>">
                        </a>
                    </div><!-- Logo End -->
                </div>

                <div class="col order-12 order-lg-2 order-xl-2 d-none d-lg-block">
                    <!-- Main Menu Start -->
                    <div class="main-menu">
                        <nav>
                            <ul>
                                <?php if (isset($arrCupones) && !empty($arrCupones)) { ?>
                                    <li class="active menu-item-has-children"><a>Cupones mas ocupados</a>
                                        <ul class="sub-menu">
                                            <li class="menu-item-has-children"><a>Codigos</a>
                                                <ul class="sub-menu" id="listasCupones">
                                                    <?php for ($i = 0; $i < count($arrCupones); $i++) { ?>
                                                        <li><a nameCu="<?= $arrCupones[$i]["nombrePro"] ?>"><?= $arrCupones[$i]["nombrePro"] ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                <?php } else if ($data['page_name'] == "home") { ?>
                                    <li class="active menu-item-has-children"><a>No hay cupones disponibles</a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </nav>
                    </div>
                </div>

                <div class="col order-2 order-lg-12 order-xl-12">
                    <!-- Header Shop Links Start -->
                    <div class="header-shop-links">
                        <?php if (isset($arrSuscripcion) && !empty($cantSuscripciones)) { ?>
                            <a href="<?= base_url() ?>/tienda/suscripciones" class="header-compare"><i class="ti-control-shuffle"></i> <span class="cantSuscripciones number"><?= $cantSuscripciones ?></span></a>
                        <?php } ?>
                        <!-- Wishlist -->
                        <?php if (isset($_SESSION['login']) && $_SESSION['rol'] == ROLCLI) { ?>
                            <a href="<?= base_url() ?>/tienda/preferencias/" class="header-wishlist"><i class="ti-heart"></i> <span class="cantPreferencias number"><?= $cantPreferencias ?></span></a>
                        <?php } else { ?>
                            <a onclick="openModalSesion('prefefer')" class="header-wishlist"><i class="ti-heart"></i> <span class="number">0</span></a>
                        <?php } ?>
                        <!-- Cart -->
                        <?php if ($data['page_name'] != "carrito" and $data['page_name'] != "procesarpago") { ?>
                            <a class="header-cart"><i class="ti-shopping-cart"></i><span class="cantCarrito number"><?= $cantCarrito ?></span></a>
                        <?php } ?>
                    </div><!-- Header Shop Links End -->
                </div>
                <!-- Mobile Menu -->
                <div class="mobile-menu order-12 d-block d-lg-none col"></div>
            </div>
        </div>
    </div><!-- Header Bottom End -->

    <!-- Header Category Start -->
    <div class="header-category-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <!-- Header Category -->
                    <div class="header-category">

                        <!-- Category Toggle Wrap -->
                        <div class="category-toggle-wrap d-block d-lg-none">
                            <!-- Category Toggle -->
                            <button class="category-toggle">Categorias<i class="ti-menu"></i></button>
                        </div>

                        <!-- Category Menu -->
                        <nav class="category-menu">
                            <ul>
                                <li><a href="<?= base_url() ?>/tienda">Catalogo completo</a></li>
                                <?php for ($i = 0; $i < count($arrSlider); $i++) { ?>

                                    <li><a href="<?= base_url() ?>/tienda/categoria/<?= $arrSlider[$i]["idcategoria"] ?>"><?= $arrSlider[$i]["nombreCategoria"] ?></a></li>
                                <?php } ?>
                            </ul>
                        </nav>

                    </div>

                </div>
            </div>
        </div>
    </div><!-- Header Category End -->

</div><!-- Header Section End -->
<!--seccion donde el carro se podra procesar-->
<div class="mini-cart-wrap" id="productosCarrito">
    <?php getModal('modalCarrito', $data); ?>
</div>
<!-- Mini Cart Wrap End --> 
<!-- Cart Overlay -->
<div class="cart-overlay"></div>

