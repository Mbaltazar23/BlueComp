<!-- Modal -->
<div class="modal fade" id="modalFormProductos" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nueva Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formProductos" name="formProductos" class="form-horizontal">
                    <input type="hidden" id="idProducto" name="idProducto" value="">
                    <div class="contenidoD bodyForm">
                        <div class="celdas fila">
                            <div class="form-group">
                                <label class="control-label">Nombre Producto<span class="required">*</span></label>
                                <input class="form-control" id="txtNombre" name="txtNombre" type="text">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Descripción Producto</label>
                                <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" ></textarea>
                            </div>
                            <div class="form-group selectCategoria">
                                <label for="listCategoria">Categoría <span class="required">*</span></label>
                                <select class="form-control" id="listCategoria" name="listCategoria">
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">Precio <span class="required">*</span></label>
                                    <input class="form-control" id="txtPrecio" name="txtPrecio" type="text">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">Stock <span class="required">*</span></label>
                                    <input class="form-control" id="txtStock" name="txtStock" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="containerGallery">
                                <span>Agregar foto</span>
                                <button class="btnAddImage btn btn-info" type="button">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <hr>
                            <div id="containerImages">

                            </div>
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
<div class="modal fade" id="modalViewProducto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Nombres:</td>
                            <td id="celNombre"></td>
                        </tr>
                        <tr>
                            <td>Precio:</td>
                            <td id="celPrecio"></td>
                        </tr>
                        <tr>
                            <td>Stock:</td>
                            <td id="celStock"></td>
                        </tr>
                        <tr>
                            <td>Categoría:</td>
                            <td id="celCategoria"></td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td id="celStatus"></td>
                        </tr>
                        <tr>
                            <td>Descripción:</td>
                            <td id="celDescripcion"></td>
                        </tr>
                        <tr>
                            <td>Fotos de referencia:</td>
                            <td id="celFotos">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

