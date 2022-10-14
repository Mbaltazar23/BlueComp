let tableUsuarios;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function () {
    tableUsuarios = $('#tableUsuarios').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax": {
            "url": " " + base_url + "/Usuarios/getUsuarios",
            "dataSrc": ""
        },
        "columns": [
            {"data": "nombrePersona"},
            {"data": "apellidoPersona"},
            {"data": "emailPersona"},
            {"data": "telefonoPersona"},
            {"data": "estadoPersona"},
            {"data": "options"}
        ],
        "resonsieve": "true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order": [[0, "desc"]]
    });

    if (document.querySelector("#formUsuario")) {
        let formUsuario = document.querySelector("#formUsuario");
        formUsuario.onsubmit = function (e) {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombre').value;
            let strApellido = document.querySelector('#txtApellido').value;
            let strEmail = document.querySelector('#txtEmail').value;
            let intTelefono = document.querySelector('#txtTelefono').value;

            if (strApellido == '' || strNombre == '' || strEmail == '' || intTelefono == '')
            {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Usuarios/setUsuario';
            let formData = new FormData(formUsuario);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        tableUsuarios.api().ajax.reload();
                        $('#modalFormUsuario').modal("hide");
                        swal("Exito !!", objData.msg, "success");
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                return false;
            };
        };
    }
    //actualizar Cargo Cliente
    if (document.querySelector("#formCargoCliente")) {
        let formCargoCliente = document.querySelector("#formCargoCliente");
        formCargoCliente.onsubmit = function (e) {
            e.preventDefault();
            let CargoCli = 0;
            let tipoNegocio = $('input[name="opcionNegocio"]:checked').val();
            let descripCargo = $("#descripcionCargo").val();
            let idNegocio = $('select#negocioTipo option:selected').val();
            let idDetailNegocio = $("#idDetailNegocio").val();
            let idUser = $("#idUser").val();
            let msg = "", txt = "";
            //console.log(tipoNegocio + " : " + descripCargo+" : "+idNegocio);
            if (tipoNegocio == 1) {
                CargoCli = idNegocio;
            } else if (tipoNegocio == 2) {
                CargoCli = "";
            }

            if (idDetailNegocio != 5) {
                msg = "Actualizar Cargo del Cliente";
                txt = "¿Desea actualizar el cargo del Cliente?";
            } else {
                msg = "Registrar Cargo del Cliente";
                txt = "¿Desea registrar el cargo del Cliente?";
            }

            swal({
                title: msg,
                text: txt,
                icon: "info",
                buttons: true
            }).then((isClosed) => {
                if (isClosed) {
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url + '/Negocios/setDetailNegocio';
                    let formData = new FormData();
                    formData.append("idUser", idUser);
                    formData.append("descripCargo", descripCargo);
                    formData.append("idNegocio", CargoCli);
                    formData.append("idDetailNegocio", idDetailNegocio);
                    request.open("POST", ajaxUrl, true);
                    request.send(formData);
                    request.onreadystatechange = function () {
                        if (request.readyState != 4)
                            return;
                        if (request.status == 200) {
                            let objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                tableUsuarios.api().ajax.reload();
                                $('#modalCargoCliente').modal("hide");
                                formCargoCliente.reset();
                                swal("Exito !!", objData.msg, "success");
                            } else {
                                swal("Error", objData.msg, "error");
                            }
                        }
                    };
                }
            });
        };
    }

    //Actualizar Perfil
    if (document.querySelector("#formPerfil")) {
        let formPerfil = document.querySelector("#formPerfil");
        formPerfil.onsubmit = function (e) {
            e.preventDefault();
            let strApellido = document.querySelector('#txtApellido').value;
            let intTelefono = document.querySelector('#txtTelefono').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;

            if (strApellido == '' || intTelefono == '')
            {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                document.querySelector('#txtTelefono').value = "+569";
                return false;
            }
            if (strPassword != '') {
                if (strPassword != "" || strPasswordConfirm != "")
                {
                    if (strPassword != strPasswordConfirm) {
                        swal("Atención", "Las contraseñas no son iguales.", "info");
                        return false;
                    }
                    if (strPassword.length < 8) {
                        swal("Atención", "La contraseña debe tener un mínimo de 8 caracteres.", "info");
                        return false;
                    }
                }
            }
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Usuarios/putPerfil';
            let formData = new FormData(formPerfil);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState != 4)
                    return;
                if (request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        $('#modalFormPerfil').modal("hide");
                        swal({
                            title: "Exito !!",
                            text: objData.msg,
                            icon: "success"
                        }).then(function () {
                            location.reload();
                        });
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
                return false;
            };
        };
    }
    fntNegociosUsuario();
}, false);

function fntNegociosUsuario() {
    let ajaxUrl = base_url + '/Negocios/getSelectNegocios';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            $('.selectNegocios select').html(request.responseText).fadeIn();
        }
    };
}

function fntViewUsuario(idpersona) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Usuarios/getUsuario/' + idpersona;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);

            if (objData.status)
            {
                let estadoUsuario = objData.data.estadoPersona == 1 ?
                        '<span class="badge badge-success">Pendiente</span>' :
                        '<span class="badge badge-primary">Activo</span>';

                document.querySelector("#celNombre").innerHTML = objData.data.nombrePersona;
                document.querySelector("#celApellido").innerHTML = objData.data.apellidoPersona;
                document.querySelector("#celTelefono").innerHTML = objData.data.telefonoPersona;
                document.querySelector("#celEmail").innerHTML = objData.data.emailPersona;
                document.querySelector("#celEstado").innerHTML = estadoUsuario;
                document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
                $('#modalViewUser').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntEditUsuario(element, idpersona) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Usuario";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    $('#btnActionForm').css("background-color", "#007bff").css("color", "#FFF");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Usuarios/getUsuario/' + idpersona;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {

        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);

            if (objData.status)
            {
                document.querySelector("#idUsuario").value = objData.data.idPersona;
                document.querySelector("#txtNombre").value = objData.data.nombrePersona;
                document.querySelector("#txtApellido").value = objData.data.apellidoPersona;
                document.querySelector("#txtComentario").value = objData.data.comentarioPersona;
                document.querySelector("#txtTelefono").value = objData.data.telefonoPersona;
                document.querySelector("#txtEmail").value = objData.data.emailPersona;
            }
        }

        $('#modalFormUsuario').modal('show');
    };
}

function fntViewRolUsuario(element, idpersona) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModalRol').innerHTML = "Ver datos del Usuario";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Usuarios/getUsuarioCargo/' + idpersona;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {

        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                let cargo = objData.data.idNegocio;
                document.querySelector("#idUser").value = objData.data.idPersona;
                document.querySelector("#nombre").value = objData.data.nombrePersona;
                document.querySelector("#correo").value = objData.data.emailPersona;
                document.querySelector("#telefono").value = objData.data.telefonoPersona;
                document.querySelector("#idDetailNegocio").value = objData.data.id_detalleCargoCliente;
                if ((cargo < 0 || cargo != 5) && objData.data.descripcionCargo != " ") {
                    $('input:radio[name="opcionNegocio"]').filter('[value="1"]').prop('checked', true);
                    document.querySelector("#btnNegocio").classList.replace("btn-primary", "btn-info");
                    document.querySelector('.Header-Rol').classList.replace("headerRegister", "headerUpdate");
                    document.querySelector('#btnNegocioCli').innerHTML = "Actualizar Negocio";
                    $("#comboNegocio").show();
                    $("#DescribCargo").show();
                    document.querySelector("#negocioTipo").value = cargo;
                    $("#descripcionCargo").val(objData.data.descripcionCargo);
                } else {
                    $('input:radio[name="opcionNegocio"]').filter('[value="2"]').prop('checked', true);
                    document.querySelector('.Header-Rol').classList.replace("headerUpdate", "headerRegister");
                    document.querySelector("#btnNegocio").classList.replace("btn-info", "btn-primary");
                    document.querySelector('#btnNegocioCli').innerHTML = "Vincular Negocio";
                    $("#comboNegocio").hide();
                    $("#DescribCargo").hide();
                    $("#descripcionCargo").val("");
                    document.querySelector("#negocioTipo").value = 0;
                }
            }
        }

        $('#modalCargoCliente').modal('show');
    };
}

function validarCheckNegocio() {
    if ($('input:radio[name="opcionNegocio"]:checked').val() === '1') {
        $('input:radio[name="opcionNegocio"]').filter('[value="1"]').prop('checked', false);
        $('input:radio[name="opcionNegocio"]').filter('[value="2"]').prop('checked', true);
        $("#comboNegocio").hide();
        $("#DescribCargo").hide();
        $("#negocioTipo").val("0");
    } else if ($('input:radio[name="opcionNegocio"]:checked').val() === '2') {
        $("#comboNegocio").hide();
        $("#DescribCargo").hide();
    } else {
        $("#comboNegocio").hide();
        $("#DescribCargo").hide();
    }
}


function cargarNegocio(opcion) {
    if (opcion == 1) {
        $("#comboNegocio").show();
        $("#DescribCargo").show();
    } else if (opcion == 2) {
        $("#comboNegocio").hide();
        $("#DescribCargo").hide();
        $("#negocioTipo").val("0");
    }
}

function fntDelUsuario(idUsuario) {
    swal({
        title: "Inhabilitar Cliente",
        text: "¿Realmente quiere inhabilitar a este Cliente?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Usuarios/delUsuario';
                let strData = "idUsuario=" + idUsuario;
                request.open("POST", ajaxUrl, true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Inhabilitado!", objData.msg, "success");
                            tableUsuarios.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });

}
function fntActivateUsuario(idUsuario) {
    swal({
        title: "Hahbilitar Cliente",
        text: "¿Realmente quiere habilitar a este Cliente?",
        icon: "info",
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Usuarios/activateUsuario';
                let strData = "idUsuario=" + idUsuario;
                request.open("POST", ajaxUrl, true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Inhabilitado!", objData.msg, "success");
                            tableUsuarios.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });

}


function openModalPerfil() {
    $('#modalFormPerfil').modal('show');
}