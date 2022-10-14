<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUsuario" name="formUsuario" class="form-horizontal">
                    <input type="hidden" id="idUsuario" name="idUsuario" value="">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="txtNombre">Nombres</label>
                            <input type="text" class="form-control" id="txtNombre" name="txtNombre" required="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtApellido">Apellidos</label>
                            <input type="text" class="form-control" id="txtApellido" name="txtApellido" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txtTelefono">Teléfono</label>
                        <input type="text" class="form-control" id="txtTelefono" name="txtTelefono" required="" maxlength="12">
                    </div>
                    <div class="form-group">
                        <label class="txtComentario">Comentario</label>
                        <textarea class="form-control" id="txtComentario" name="txtComentario" rows="2"></textarea>
                    </div> 
                    <div class="form-group">
                        <label for="txtEmail">Email</label>
                        <input type="email" class="form-control" id="txtEmail" name="txtEmail">
                    </div>
                    <div class="modal-footer">
                        <button id="btnActionForm" class="btn" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText"></span></button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->

<div class="modal fade" id="modalCargoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header Header-Rol headerRegister">
                <center><h4 class="modal-title" id="titleModalRol"></h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form id="formCargoCliente" method="Post">
                        <input type="hidden" id="idUser" name="idUser" value=""/>
                        <input type="hidden" id="idDetailNegocio" name="idDetailNegocio" value=""/>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Nombre:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nombre" id="nombre" readonly/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Correo:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="correo" id="correo" readonly/>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:7px;">Telefono:</label>
                            </div>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="telefono" id="telefono" readonly=""/>
                            </div>
                        </div>
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Negocio:</legend>
                                <div class="col-sm-7">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="opcionNegocio" id="opcionNegocio" value="1" onclick="cargarNegocio(this.value)">
                                        <label class="form-check-label" for="opcionNegocio">
                                            Si tiene
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="opcionNegocio" id="opcionNegocio" value="2" onclick="cargarNegocio(this.value)">
                                        <label class="form-check-label" for="opcionNegocio">
                                            No tiene
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="row form-group" id="comboNegocio">
                            <div class="col-sm-2">
                                <label class="control-label" style="position:relative; top:4px;">Tipo de Negocio:</label>
                            </div>
                            <div class="col-sm-10 selectNegocios">
                                <select id="negocioTipo" name="negocioTipo" class="form-control">

                                </select>
                            </div>
                        </div>
                        <div class="row form-group" id="DescribCargo">
                            <div class='col-sm-2'>
                                <label class='control-label' style='position:relative;top:7px;'>Cargo:</label>
                            </div>
                            <div class='col-sm-10'>
                                <textarea class="form-control" id="descripcionCargo"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar"><i class="fas fa-power-off"></i>&nbsp;Cancelar</button>
                            <button id="btnNegocio" type="submit" class="btn btn-primary"><i class="fas fa-link"></i>&nbsp;&nbsp;<span id="btnNegocioCli"></span></button>
                        </div>
                    </form>
                </div> 
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del usuario</h5>
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
                            <td>Apellidos:</td>
                            <td id="celApellido"></td>
                        </tr>
                        <tr>
                            <td>Teléfono:</td>
                            <td id="celTelefono"></td>
                        </tr>
                        <tr>
                            <td>Email (Usuario):</td>
                            <td id="celEmail"></td>
                        </tr>
                        <tr>
                            <td>Estado:</td>
                            <td id="celEstado">Larry</td>
                        </tr>
                        <tr>
                            <td>Fecha registro:</td>
                            <td id="celFechaRegistro">Larry</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

