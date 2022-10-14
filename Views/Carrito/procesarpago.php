<?php
headerTienda($data);
$subtotal = 0;
foreach ($_SESSION['arrCarrito'] as $producto) {
    if ($producto["categoria"] != IDCATCUPON) {
        $subtotal += $producto['precio'] * $producto['cantidad'];
    }
}
$total = $subtotal + COSTOENVIO;
?>
<div class="page-section section mt-90 mb-30">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form class="checkout-form">
                    <!-- Checkout Form s-->
                    <div class="row row-40">
                        <div class="col-lg-7 mb-20">
                            <!-- Billing Address -->
                            <div id="billing-form" class="mb-40">
                                <h4 class="checkout-title">Direccion de Envio</h4>
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-20">
                                        <label>Comuna*</label>
                                        <select id="selectComuna" class="nice-select" onchange="seleccionarDireccion(this.value)">
                                            <option value="0">Seleccione comuna</option>
                                            <?php
                                            if (count($data["comunas"]) > 0) {
                                                foreach ($data["comunas"] as $comuna) {
                                                    ?>
                                                    <option value="<?= $comuna["idComuna"] ?>"><?= $comuna["nombreComuna"] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-12 mb-20" id="Direcciones">
                                        <label>Direccion*</label>
                                        <select class="selecDireccion" id="listDirecciones" onchange="mostrarTerminos(this.value)">
                                        </select>
                                    </div>
                                    <div class="col-12 mb-20" id="terminos">
                                        <div class="check-box">
                                            <input type="checkbox" id="shiping_address" data-shipping id="btnTerminos">
                                            <label for="shiping_address">Acepte los Terminos y Condiciones</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div id="shipping-form" class="mb-40">
                                <h4 class="checkout-title">Medios de pago</h4>
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-20">
                                        <select class="nice-select" id="selectMedioPago">
                                            <option value="0">Seleccione uno</option>
                                            <?php
                                            if (count($data['tiposPago']) > 0) {
                                                foreach ($data['tiposPago'] as $tipopago) {
                                                    ?>
                                                    <option value="<?= $tipopago["idTipoPago"] ?>"><?= $tipopago["nombrePago"] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <button class="place-order" id="btnComprar">Procesar</button>                                    
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="row">
                                <!-- Cart Total -->
                                <div class="col-12 mb-60">
                                    <h4 class="checkout-title">Total del Carrito</h4>
                                    <div class="checkout-cart-total">
                                        <h4>Productos <span>Total</span></h4>
                                        <ul>
                                            <?php
                                            $totalProducto = 0;
                                            foreach ($_SESSION['arrCarrito'] as $producto) {
                                                if (empty($producto["imagen"])) {
                                                    continue;
                                                }
                                                if ($producto["categoria"] != IDCATCUPON) {
                                                    $totalProducto = $producto["precio"] * $producto['cantidad'];
                                                }
                                                ?>
                                                <li><?= $producto["producto"] ?> <span><?= SMONEY . formatMoney($totalProducto) ?></span></li>
                                            <?php } ?>
                                        </ul>
                                        <?php
                                        if (isset($_SESSION["totalDescount"]) && isset($_SESSION["nameCupon"])) {
                                            $descount = $_SESSION["totalDescount"] - $subtotal;
                                            $Desc = $descount < 0 ? -1 * $descount : $descount;
                                            ?>
                                            <p>SubTotal<span><?= SMONEY . formatMoney($subtotal) ?></span></p>
                                            <p>Descontado<span><?= SMONEY . formatMoney($Desc) ?></span></p>
                                            <p>Nuevo SubTotal<span><?= SMONEY . formatMoney($_SESSION["totalDescount"]) ?></span></p>
                                        <?php } else { ?>
                                            <p>SubTotal<span><?= SMONEY . formatMoney($subtotal) ?></span></p>
                                        <?php } ?>
                                        <p>Costo-Envio <span><?= SMONEY . formatMoney(COSTOENVIO) ?></span></p>

                                        <h4>Total:  <span><?= !isset($_SESSION["totalDescount"]) ? SMONEY . formatMoney($total) : SMONEY . formatMoney($_SESSION["totalDescount"] + COSTOENVIO) ?></span></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
footerTienda($data);
?>
	