<div class="mini-cart-top">    
    <button class="close-cart cerrarCarrito">Cerrar<i class="icofont icofont-close"></i></button>
</div>
<?php
$total = 0;
if (isset($_SESSION['arrCarrito']) and count($_SESSION['arrCarrito']) > 0) {
    ?>
    <!-- Mini Cart Products -->
    <ul class="mini-cart-products">
        <?php
        foreach ($_SESSION['arrCarrito'] as $producto) {
            if ($producto["categoria"] != IDCATCUPON) {
                $total += $producto['cantidad'] * $producto['precio'];
            }
            if (!empty($producto["imagen"])) {
                $portada = $producto["imagen"];
            } else {
                continue;
            }

            $idProducto = openssl_encrypt($producto['idproducto'], METHODENCRIPT, KEY);
            ?>	
            <li>
                <a href="<?= base_url() . '/tienda/producto/' . $producto['idproducto'] . '/' . $producto['ruta']; ?>" class="image"><img src="<?= $portada ?>" alt="<?= $producto['producto'] ?>"></a>
                <div class="content">
                    <a href="<?= base_url() . '/tienda/producto/' . $producto['idproducto'] . '/' . $producto['ruta']; ?>" class="title"><?= $producto['producto'] ?></a>
                    <span class="price">Precio: <?= SMONEY . formatMoney($producto['precio']) ?></span>
                    <span class="qty">Cantidad: <?= $producto['cantidad'] ?></span>
                </div>
                <button class="remove" idpr="<?= $idProducto ?>" op="1" onclick="delItemCart(this)"><i class="fa fa-trash-o"></i></button>
            </li>
        <?php } ?>
    </ul>
    <?php
} else {
    ?>
    <ul class="mini-cart-products">
        <li>
            <div class="content">
                <p class="text-center">El carrito esta vacio...</p>
            </div>
        </li>
    </ul>
<?php } ?>
<!-- Mini Cart Bottom -->
<div class="mini-cart-bottom">    
    <h4 class="sub-total">Total: <span><?= !isset($_SESSION["totalDescount"]) ? SMONEY . formatMoney($total) : SMONEY . formatMoney($_SESSION["totalDescount"]) ?></span></h4>
    <div class="button">
        <a href="<?= base_url() ?>/carrito" id="procesarCart">Ver Carrito</a><br>
        <?php if (isset($_SESSION['login'])) { ?>
            <a href="<?= base_url() ?>/carrito/procesarpago">Procesar Pago</a>
        <?php } else { ?>
            <a onclick="openModalSesion('orden')" id="btnProcesar">Procesar Pago</a>
        <?php } ?>
    </div>
</div>
