<?php
headerTienda($data);
getModal("modalSesion-Registro", $data);
$arrPreferidos = (isset($data["preferidos"])) ? $data["preferidos"] : "";
?>
<div class="page-section section mt-90 mb-90">
    <div class="container">
        <div class="row">
            <?php if (isset($arrPreferidos) && !empty($arrPreferidos)) { ?>
                <div class="col-12 mb-40">
                    <div class="section-title-one"><h1>Todos los productos preferidos del usted Sr(a) <?= $_SESSION['userData']['nombrePersona'] ?></h1></div>
                </div>
                <div class="col-12">
                    <form action="#">				
                        <div class="cart-table table-responsive" id="preferenciasClient">
                            <table class="table tablePreferencias">
                                <thead>
                                    <tr>
                                        <th class="pro-thumbnail">Imagen</th>
                                        <th class="pro-title">Producto</th>
                                        <th class="pro-price">Precio</th>
                                        <th class="pro-subtotal">Carrito</th>
                                        <th class="pro-remove">Remover</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <input type="hidden" id="opcionCarrito" value="preferido"/>
                                <?php
                                for ($p = 0; $p < count($arrPreferidos); $p++) {
                                    $idPreferencia = openssl_encrypt($arrPreferidos[$p]['idPreferencia'], METHODENCRIPT, KEY);
                                    $ruta = $arrPreferidos[$p]["rutaPro"];
                                    //print_r($ruta);
                                    if (count($arrPreferidos[$p]['images']) > 0) {
                                        $portada = $arrPreferidos[$p]['images'][0]['url_image'];
                                    } else {
                                        continue;
                                    }
                                    ?>
                                    <tr>
                                        <td class="pro-thumbnail"><a href="<?= base_url() . '/tienda/producto/' . $arrPreferidos[$p]['idproducto'] . '/' . $ruta; ?>"><img src="<?= $portada ?>" alt="<?= $arrPreferidos[$p]['nombrePro'] ?>"></a></td>
                                        <td class="pro-title"><span class="js-name-detail"><?= $arrPreferidos[$p]["nombrePro"] ?></span><input type="hidden" class="js-name-preferences" value="<?= $idPreferencia ?>"/></td>
                                        <td class="pro-price"><span><?= SMONEY . formatMoney($arrPreferidos[$p]["precioPro"]) ?></span></td>
                                        <td class="pro-addtocart"><button id="<?= openssl_encrypt($arrPreferidos[$p]['idproducto'], METHODENCRIPT, KEY); ?>" class="js-addcart-detail">Añadir</button></td>
                                        <td class="pro-remove"><a idpref="<?= $idPreferencia ?>" onclick="delItemPreferido(this)"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table> 
                            <?php
                        } else {
                            ?> 
                            <div class="text-center">No tiene algun producto en preferidos...</div>
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
