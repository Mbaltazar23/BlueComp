<!-- Modal FormCategorias-->
<div class="modal fade" id="modalFormNegocios" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Negocio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formNegocio" name="formNegocio" class="form-horizontal">
                    <input type="hidden" id="idNegocio" name="idNegocio" value="">
                    <div class="form-group">
                        <label class="control-label">Nombre <span class="required">*</span></label>
                        <input class="form-control" id="txtNameNegocio" name="txtNameNegocio" type="text"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Descripción <span class="required">*</span></label>
                        <textarea class="form-control" id="txtDescripcionNegocio" name="txtDescripcionNegocio" rows="2"></textarea>
                    </div> 
                    <div class="modal-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewNegocio" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Negocio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Nombres:</td>
                            <td id="celNameNegocio"></td>
                        </tr>
                        <tr>
                            <td>Descripción:</td>
                            <td id="celNegocioDescripcion"></td>
                        </tr>
                        <tr>
                            <td>Estado:</td>
                            <td id="celEstadoNegocio"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

