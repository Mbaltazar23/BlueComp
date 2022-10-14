<?php
headerTienda($data);
getModal("modalSesion-Registro", $data);
$arrPedidos = (isset($data['pedidos'])) ? $data['pedidos'] : "";
?>
<div class="page-section section mt-90 mb-90">
    <div class="container">
        <div class="row">
            <?php if (isset($arrPedidos) && !empty($arrPedidos)) { ?>
                <div class="col-12 mb-40">
                    <div class="section-title-one"><h1>Todos los pedidos del usted Sr(a) <?= $_SESSION['userData']['nombrePersona'] ?></h1></div>
                </div>
                <div class="col-12">
                    <form action="#">				
                        <div class="cart-table table-responsive" id="OrdenesCliente">
                            <table class="table tableOrdenes">
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">Nro</th>
                                        <th class="pro-title">Fecha</th>
                                        <th class="pro-price">Total</th>
                                        <th class="pro-subtotal">Status</th>
                                        <th class="pro-subtotal">Impresion</th>
                                        <th class="pro-remove">Remover</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($p = 0; $p < count($arrPedidos); $p++) {
                                        $idPedido = openssl_encrypt($arrPedidos[$p]['idPedido'], METHODENCRIPT, KEY);
                                        ?>
                                        <tr>
                                            <td class="pro-thumbnail"><span><?= ($p + 1) ?></span></td>
                                            <td class="pro-title"><span><?= $arrPedidos[$p]["fecha"] ?></span></td>
                                            <td class="pro-price"><span><?= SMONEY . formatMoney($arrPedidos[$p]["montoTotalPedido"]) ?></span></td>
                                            <td class="pro-addtocart"><span><?= $arrPedidos[$p]["statusPedido"] ?></span></td>
                                            <td class="pro-remove"><a href="<?= base_url() . '/factura/generarFactura/' . $arrPedidos[$p]['idPedido']; ?>" target="_blanck"><i class="fa fa-file-pdf-o"></i></a></td>
                                            <td class="pro-remove"><a idpdo="<?= $idPedido ?>" onclick="delItemPedido(this)"><i class="fa fa-trash-o"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table> 
                            <?php
                        } else {
                            ?> 
                            <div class="text-center">No tiene algun pedido realizado...</div>
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

