let rowTable;
let tableNegocios;
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tableNegocios = $('#tableNegocios').dataTable({
    "aProcessing": true,
    "aServerSide": true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax": {
        "url": " " + base_url + "/Negocios/getNegocios",
        "dataSrc": ""
    },
    "columns": [
        {"data": "negocioNombre"},
        {"data": "negocioDescripcion"},
        {"data": "estadoNegocio"},
        {"data": "options"}
    ],
    "resonsieve": "true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "desc"]]
});

window.addEventListener('load', function () {
    //NUEVO NEGOCIO
    let formNegocio = document.querySelector("#formNegocio");
    formNegocio.onsubmit = function (e) {
        e.preventDefault();
        let strNameNegocio = document.querySelector('#txtNameNegocio').value;
        let strDescripcionNegocio = document.querySelector('#txtDescripcionNegocio').value;
        if (strNameNegocio == '' || strDescripcionNegocio == '')
        {
            swal("Atención", "Todos los campos son obligatorios.", "error");
            return false;
        }
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Negocios/setNegocio';
        let formData = new FormData(formNegocio);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {

                let objData = JSON.parse(request.responseText);
                if (objData.status)
                {
                    tableNegocios.api().ajax.reload();
                    $('#modalFormNegocios').modal("hide");
                    formNegocio.reset();
                    swal("Negocio", objData.msg, "success");
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
            return false;
        };
    };
}, false);

function fntViewInfo(idnegocio) {
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Negocios/getNegocio/' + idnegocio;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                let estado = objData.data.estadoNegocio == 1 ?
                        '<span class="badge badge-success">Activo</span>' :
                        '<span class="badge badge-danger">Inactivo</span>';
                document.querySelector("#celNameNegocio").innerHTML = objData.data.negocioNombre;
                document.querySelector("#celNegocioDescripcion").innerHTML = objData.data.negocioDescripcion;
                document.querySelector("#celEstadoNegocio").innerHTML = estado;
                $('#modalViewNegocio').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function fntEditInfo(element, idnegocio) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Negocio";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Negocios/getNegocio/' + idnegocio;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                document.querySelector("#idNegocio").value = objData.data.idNegocio;
                document.querySelector("#txtNameNegocio").value = String(objData.data.negocioNombre).toLocaleLowerCase();
                document.querySelector("#txtDescripcionNegocio").value = String(objData.data.negocioDescripcion).toLocaleLowerCase();
                $('#modalFormNegocios').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function fntDelInfo(idNegocio) {
    swal({
        title: "Inhabilitar Negocio",
        text: "¿Realmente quiere inhabilitar este negocio seleccionado?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let status = 0;
                let ajaxUrl = base_url + '/Negocios/setStatusNegocio';
                let formData = new FormData();
                formData.append("idNegocio", idNegocio);
                formData.append("status", status);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Exito!!", objData.msg, "success");
                            tableNegocios.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });

}


function fntActiveInfo(idNegocio) {
    swal({
        title: "Habilitar Negocio",
        text: "¿Realmente quiere habilitar este negocio seleccionado?",
        icon: "info",
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let status = 0;
                let ajaxUrl = base_url + '/Negocios/setStatusNegocio';
                let formData = new FormData();
                formData.append("idNegocio", idNegocio);
                formData.append("status", status);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Exito!!", objData.msg, "success");
                            tableNegocios.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });

}

function openModal() {
    document.querySelector('#idNegocio').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Negocio";
    document.querySelector("#formNegocio").reset();
    $('#modalFormNegocios').modal('show');
}