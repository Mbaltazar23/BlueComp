<div class="subscribe-section section bg-gray pt-55 pb-55">
    <div class="container">
        <div class="row align-items-center" id="containerFormSuscript">
            <!-- Mailchimp Subscribe Content Start -->
            <?php if (isset($_SESSION["suscripcion"]) and ! empty($_SESSION["suscripcion"])) { ?>
                <div class="col-lg-6 col-12 mb-15 mt-15">
                    <div class="subscribe-content">
                        <h2>ESTA SUSCRITO<span> PARA RECIBIR</span></h2>
                        <h2><span>OFERTAS DE</span> PRODUCTOS NUEVOS</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-12 mb-15 mt-15">
                    <form class="subscribe-form" id="formDesuscripcion">
                        <input id="txtCorreoDesuscripcion" name="txtCorreoDesuscripcion"  autocomplete="off" value="<?= lcfirst($_SESSION['userData']["emailPersona"]) ?>" disabled/>
                        <button type="submit">desuscribirse</button>
                    </form>
                </div>
            <?php } else { ?>
                <div class="col-lg-6 col-12 mb-15 mt-15">
                    <div class="subscribe-content">
                        <h2>SUBSCRIBASE<span> PARA RECIBIR</span></h2>
                        <h2><span>OFERTAS DE</span> PRODUCTOS NUEVOS</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-12 mb-15 mt-15">
                    <form class="subscribe-form" id="formSuscripcion">
                        <input id="txtCorreoSuscripcion" name="txtCorreoSuscripcion"  autocomplete="off" placeholder="Ingrese su correo.." />
                        <button type="submit">subscribase</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</div>


<div class="footer-section section bg-ivory">
    <!-- Footer Bottom Section Start -->
    <div class="footer-section section bg-ivory">
        <!-- Footer Bottom Section Start -->
        <div class="footer-bottom-section section">
            <div class="container">
                <div class="row">
                    <!-- Footer Copyright -->
                    <div class="col-lg-6 col-12">
                        <div class="footer-copyright"><p>© Copyright, 2021 Todo derecho Reservado</p></div>
                    </div>
                </div>
            </div>
        </div><!-- Footer Bottom Section Start -->
    </div>
    <!-- Footer Bottom Section Start -->
</div><!-- Footer Section End -->

<script>
    const base_url = "<?= base_url(); ?>";
    const smony = "<?= SMONEY; ?>";
</script>
<!-- jQuery JS -->
<script src="<?= media() ?>/tienda/js/jquery-3.5.1.js" type="text/javascript"></script>
<!-- Popper JS -->
<script src="<?= media() ?>/tienda/js/popper.min.js" type="text/javascript"></script>
<!-- Bootstrap JS -->
<script src="<?= media() ?>/tienda/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= media() ?>/js/plugins/sweetalert.min.js" type="text/javascript"></script>
<!-- Plugins JS -->
<script src="<?= media() ?>/tienda/js/plugins.js" type="text/javascript"></script>
<!-- Main JS -->
<script src="<?= media() ?>/tienda/js/main.js" type="text/javascript"></script>

<script src="<?= media() ?>/js/functions_tienda.js"></script>

</body>
</html>