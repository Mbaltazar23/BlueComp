<!--Modal formSuscripcion-->
<div class="modal fade" id="modalFormSuscripcion" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h4 class="modal-title" id="titleModal" id="myModalLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="row">
                        <input type="hidden" id="opcionSus"/>
                        <input type="hidden" name="id-Sus" id="id-Sus"/>
                        <div class="form-group col-md-4 selectCategoriaSus">
                            <label for="insumo">Categoria</label>
                            <select id="listCategoriaSus" name="listCategoriaSus" class="form-control" onchange="buscarProductos(this.value, 'selectProductos')">

                            </select>
                        </div>
                        <div class="form-group col-md-4 selectProductos">
                            <label for="insumo">Producto</label>
                            <select id="listProductos" name="listProductos" class="form-control">

                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" id="cantidadProduct" name="cantidadProduct" class="form-control" minlength="1"/>
                        </div>
                        <div class="form-group col-md-4" >
                            <button id="btnAgregarProduct" class="btn btn-block" title="Agregar">Agregar</button>
                        </div>
                    </div>
                    <table id="tabla-products" class="table">
                        <thead>
                            <tr>
                                <th>NOMBRE</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO($)</th>
                                <th>SUBTOTAL($)</th>
                                <th>OPERACIONES</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div id="resumenSus" hidden>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Suscripcion -->
<div class="modal fade" id="modalViewSuscripcion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos de la Suscripcion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Cliente:</td>
                            <td id="celCorreo"></td>
                        </tr>
                        <tr>
                            <td>Fecha:</td>
                            <td id="celFecha"></td>
                        </tr>
                        <tr>
                            <td>Hora:</td>
                            <td id="celHora"></td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td id="celStatusSus"></td>
                        </tr>
                        <tr>
                            <td>Productos Registrados:</td>
                            <td id="celProductsSus"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

