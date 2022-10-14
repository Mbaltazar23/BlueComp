<!--Este sera el modal para el detalle del recibo del pedido-->
<div class="modal fade" id="modalReciboView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title" id="myModalLabel">Recibo del Cliente - N°<label id="idOrdenRecibo"></label></h4></center>
            </div>
            <div class="modal-body">
                <div id="ReciboCliente">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <p><strong>Nombre:</strong>&nbsp;&nbsp;<label id="nombreCliRe"></label></p>
                                <p><strong>Telefono:</strong> &nbsp;&nbsp;<label id="telefonoCliR"></label></p>
                                <p><strong>SubTotal:</strong> &nbsp;<label id="SubTotalR"></label></p>
                                <p><strong>Costo-Envio:</strong> &nbsp;<label id="CostoEnvio"></label></p>  
                                <p><strong>Total:</strong> &nbsp; &nbsp;<label id="TotalR"></label></p>
                            </div>
                            <div class="form-group col-md-6">
                                <p><strong>Fecha:</strong>&nbsp;&nbsp;<label id="FechaR"></label></p> 
                                <p><strong>Hora:</strong>&nbsp;&nbsp;<label id="HoraR"></label></p> 
                                <p><strong>Cuidad:</strong> &nbsp; &nbsp;<label id="CuidadR"></label></p>
                                <p><strong>Direccion:</strong> &nbsp;<label id="DireccionR"></label></p>
                                <p><strong>Cupon-Aplicado:</strong> &nbsp;<label id="CuponValid"></label></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar"><i class="fa fa-close"></i>&nbsp;Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Este sera el modal para el detalle de los productos del recibo del pedido-->
<div class="modal fade" id="modalReciboProducts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <center><h4 class="modal-title">Detalle del Recibo del Cliente - N°<label id="idReciboCli"></label></h4></center>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <p><strong>Nombre:</strong>&nbsp; &nbsp;<label id="nombrePago"></label></p>
                            <p><strong>Telefono:</strong>&nbsp;<label id="telefonoP"></label></p>
                            <p><strong>Fecha:</strong>&nbsp; &nbsp;<label id="fechaPago"></label></p>
                            <p><strong>Hora:</strong>&nbsp; &nbsp;<label id="horaPago"></label></p>
                        </div>
                        <div class="form-group col-md-6">
                            <p><strong>Cantidad-Productos:</strong>&nbsp; &nbsp;<label id="cantPago"></label></p>
                            <p><strong>Total-Productos:</strong>&nbsp;&nbsp;<label id="totalP"></label></p>
                            <p><strong>Medio-Pago:</strong>&nbsp;<label id="medioPago"></label></p>
                            <p><strong>Status:</strong>&nbsp;&nbsp;<label id="estadoP"></label></p>
                        </div>
                    </div>
                    <table class="table" id="tableDetalleP">
                        <thead>
                            <tr>
                                <th>NOMBRE</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO</th>
                                <th>SUBTOTAL</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
