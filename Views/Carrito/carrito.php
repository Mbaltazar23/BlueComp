<?php
getModal("modalSesion-Registro", $data);
$subtotal = 0;
$total = 0;
headerTienda($data);
?>	
<div class="page-section section pt-90 pb-50">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if (isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0) { ?>
                    <!-- Cart Table -->
                    <div class="cart-table table-responsive mb-40">
                        <table class="table" id="tblCarrito">
                            <thead>
                                <tr>
                                    <th class="pro-thumbnail">Imagen</th>
                                    <th class="pro-title">Producto</th>
                                    <th class="pro-price">Precio</th>
                                    <th class="pro-quantity">Cantidad</th>
                                    <th class="pro-subtotal">Total</th>
                                    <th class="pro-remove">Remover</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($_SESSION['arrCarrito'] as $producto) {
                                    if ($producto["categoria"] != IDCATCUPON) {
                                        $totalProducto = $producto['precio'] * $producto['cantidad'];
                                        $subtotal += $totalProducto;
                                    }

                                    $idProducto = openssl_encrypt($producto['idproducto'], METHODENCRIPT, KEY);
                                    if (!empty($producto["imagen"])) {
                                        $portada = $producto["imagen"];
                                    } else {
                                        continue;
                                    }
                                    ?>
                                    <tr class="table_row <?= $idProducto ?>">
                                        <td class="pro-thumbnail"><a href="<?= base_url() . '/tienda/producto/' . $producto['idproducto'] . '/' . $producto['ruta']; ?>" ><img src="<?= $portada ?>" alt="<?= $producto['producto'] ?>"></a></td>
                                        <td class="pro-title"><a><?= $producto['producto'] ?></a></td>
                                        <td class="pro-price"><span><?= SMONEY . formatMoney($producto['precio']) ?></span></td>
                                        <td class="pro-quantity">
                                            <div class="pro-qty">
                                                <span class="dec qtybtn prev-item" idpr="<?= $idProducto ?>">-</span>
                                                <input class="num-product" type="text" value="<?= $producto['cantidad'] ?>" idpr="<?= $idProducto ?>">
                                                <span class="inc qtybtn next-item" idpr="<?= $idProducto ?>">+</span>
                                            </div>
                                        </td>
                                        <td class="pro-subtotal"><span><?= SMONEY . formatMoney($totalProducto) ?></span></td>
                                        <td class="pro-remove"><a idpr="<?= $idProducto ?>" op="2" onclick="delItemCart(this)"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                </tbody>
                            <?php } ?>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-12 mb-15">
                            <!-- Discount Coupon -->
                            <div class="discount-coupon" id="descount">
                                <h4><?= isset($_SESSION["nameCupon"]) ? "Codigo de Descuento Aplicado" : "Codigo de cupon de Descuento" ?></h4>
                                <form id="formCupon">
                                    <div class="row">
                                        <div class="col-md-6 col-12 mb-25">
                                            <input type="hidden" name="cantCupon" id="cantCupon" value="1" opcion="<?= !isset($_SESSION["nameCupon"]) ? 1 : 2 ?>"/>
                                            <input type="text" id="txtCodeDescount" name="txtCodeDescount" <?= isset($_SESSION["nameCupon"]) ? "value=" . $_SESSION["nameCupon"] : "placeholder='Ingrese el codigo'" ?> <?= isset($_SESSION["nameCupon"]) ? "disabled" : " " ?>>
                                        </div>
                                        <div class="col-md-6 col-12 mb-25">
                                            <input type="submit" value="<?= !isset($_SESSION["nameCupon"]) ? "Aplicar" : "Remover" ?>" id="btnCupon"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Cart Summary -->
                        <div class="col-lg-6 col-12 mb-40 d-flex">
                            <div class="cart-summary">
                                <div class="cart-summary-wrap">
                                    <h4>Costo total del Carrito</h4>
                                    <?php
                                    if (isset($_SESSION["totalDescount"]) && isset($_SESSION["nameCupon"])) {
                                        $descount = $_SESSION["totalDescount"] - $subtotal;
                                        $Desc = $descount < 0 ? -1 * $descount : $descount;
                                        ?>
                                        <p>SubTotal<span id="subTotalCompra"><?= SMONEY . formatMoney($subtotal) ?></span></p>
                                        <p>Descontado<span id="montoDescount"><?= SMONEY . formatMoney($Desc) ?></span></p>
                                        <p>Nuevo SubTotal<span id="newsubTotalCompra"><?= SMONEY . formatMoney($_SESSION["totalDescount"]) ?></span></p>
                                    <?php } else { ?>
                                        <p>SubTotal<span id="subTotalCompra"><?= SMONEY . formatMoney($subtotal) ?></span></p>
                                    <?php } ?>
                                    <p>Costo de Envio <span><?= SMONEY . formatMoney(COSTOENVIO) ?></span></p>
                                    <h2>Total <span id="totalCompra"><?= !isset($_SESSION["totalDescount"]) ? SMONEY . formatMoney($subtotal + COSTOENVIO) : SMONEY . formatMoney($_SESSION["totalDescount"] + COSTOENVIO) ?></span></h2>
                                </div>
                                <div class="cart-summary-button">
                                    <?php if (isset($_SESSION['login'])) { ?>
                                        <button class="checkout-btn" id="btnProcesar"><a href="<?= base_url() ?>/carrito/procesarpago" style="color: inherit;">Procesar</a></button>
                                    <?php } else { ?>
                                        <button class="checkout-btn"><a onclick="openModalSesion('orden')" style="color: inherit;">Procesar</a></button>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="container col-12">
                            <p class="text-center">No hay producto en el carrito <a href="<?= base_url() ?>/tienda"> Ver productos</a></p>
                        </div> 
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
footerTienda($data);
?>