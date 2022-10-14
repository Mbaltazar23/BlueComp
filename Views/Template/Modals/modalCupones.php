<!-- Modal formCupon -->
<div class="modal fade" id="modalFormCupones" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCupones" name="formCupones" class="form-horizontal">
                    <input type="hidden" id="idProducto" name="idProducto" value="">
                    <div class="form-group">
                        <label class="control-label">Codigo<span class="required">*</span></label>
                        <input class="form-control" id="txtCodigo" name="txtCodigo" type="text">
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Descuento <span class="required">*</span></label>
                            <input class="form-control" id="txtDescuento" name="txtDescuento" type="text">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Stock <span class="required">*</span></label>
                            <input class="form-control" id="txtStockCup" name="txtStockCup" type="text">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewCupon" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Cupon</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Codigo:</td>
                            <td id="celCodCup"></td>
                        </tr>
                        <tr>
                            <td>Descuento:</td>
                            <td id="celDesc"></td>
                        </tr>
                        <tr>
                            <td>Stock:</td>
                            <td id="celStockCup"></td>
                        </tr>
                        <tr>
                            <td>Fecha:</td>
                            <td id="celFechaCup"></td>
                        </tr>
                        <tr>
                            <td>Hora:</td>
                            <td id="celHoraCup"></td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td id="celStatusCup"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>