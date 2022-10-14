let rowTable;
let tableCupones;
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tableCupones = $('#tableCupones').dataTable({
    "aProcessing": true,
    "aServerSide": true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax": {
        "url": " " + base_url + "/Cupones/getCupones",
        "dataSrc": ""
    },
    "columns": [
        {"data": "nombrePro"},
        {"data": "precioPro"},
        {"data": "stockPro"},
        {"data": "estadoPro"},
        {"data": "options"}
    ],
    "resonsieve": "true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "desc"]]
});
window.addEventListener('load', function () {
    if (document.querySelector("#formCupones")) {
        let formCupones = document.querySelector("#formCupones");
        formCupones.onsubmit = function (e) {
            e.preventDefault();
            let txtCodigo = document.querySelector('#txtCodigo').value;
            let txtDescuento = document.querySelector('#txtDescuento').value;
            let txtStockCup = document.querySelector('#txtStockCup').value;
            var noValido = /\s/;
            if (txtCodigo == '' || txtDescuento == '' || isNaN(txtDescuento) || txtStockCup == '')
            {
                swal("Atención", "Todos los campos son deben estar correctos.", "error");
                return false;
            } else if (noValido.test(txtCodigo)) {
                swal("Error !!", "El codigo no puede tener espacios..", "error");
                return false;
            }
            let request = (window.XMLHttpRequest) ?
                    new XMLHttpRequest() :
                    new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Cupones/setCupon';
            let formData = new FormData(formCupones);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        tableCupones.api().ajax.reload();
                        swal("Exito", objData.msg, "success");
                        $('#modalFormCupones').modal('hide');
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            };
        };
    }
}, false);


function fntEditInfo(element, idProducto) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML = "Actualizar Cupon";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Cupones/getCupon/' + idProducto;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                let objCupon = objData.data;
                document.querySelector("#idProducto").value = objCupon.idproducto;
                document.querySelector("#txtCodigo").value = objCupon.nombrePro;
                document.querySelector("#txtDescuento").value = Math.round(objCupon.precioPro);
                document.querySelector("#txtStockCup").value = objCupon.stockPro;

                $('#modalFormCupones').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntViewInfo(idProducto) {
    let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Cupones/getCupon/' + idProducto;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                let objCupon = objData.data;
                let estadoCupon = "";

                if (objCupon.estadoPro == 1) {
                    estadoCupon = '<span class="badge badge-success">Activo</span>';
                } else if (objCupon.estadoPro == 2) {
                    estadoCupon = '<span class="badge badge-primary">Visible</span>';
                } else {
                    estadoCupon = '<span class="badge badge-danger">Inactivo</span>';
                }

                document.querySelector("#celCodCup").innerHTML = objCupon.nombrePro;
                document.querySelector("#celDesc").innerHTML = Math.round(objCupon.precioPro) + "%";
                document.querySelector("#celStockCup").innerHTML = objCupon.stockPro;
                document.querySelector("#celFechaCup").innerHTML = objCupon.fechaCup;
                document.querySelector("#celHoraCup").innerHTML = objCupon.horaCup;
                document.querySelector("#celStatusCup").innerHTML = estadoCupon;
                $('#modalViewCupon').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}


function fntDelInfo(idProducto) {
    swal({
        title: "Inhabilitar Cupon",
        text: "¿Realmente quiere inhabilitar este Cupon?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let status = 0;
                let ajaxUrl = base_url + '/Cupones/setStatusCupon';
                let formData = new FormData();
                formData.append("idProducto", idProducto);
                formData.append("status", status);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Inhabilitado!", objData.msg, "success");
                            tableCupones.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });

}

function fntActiveInfo(idProducto) {
    swal({
        title: "Activar Cupon",
        text: "¿Realmente quiere dejar activo este cupon?",
        icon: "info",
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let status = 1;
                let ajaxUrl = base_url + '/Cupones/setStatusCupon';
                let formData = new FormData();
                formData.append("idProducto", idProducto);
                formData.append("status", status);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Activado!!", objData.msg, "success");
                            tableCupones.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });
}

function fntTiendaCuponAc(idProducto) {
    swal({
        title: "Visualizar Cupon",
        text: "¿Realmente quiere dejar visible este cupon en la Tienda?",
        icon: "info",
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let status = 2;
                let ajaxUrl = base_url + '/Cupones/setStatusCupon';
                let formData = new FormData();
                formData.append("idProducto", idProducto);
                formData.append("status", status);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Exito!!", objData.msg, "success");
                            tableCupones.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });
}

function fntTiendaCuponDesc(idProducto) {
    swal({
        title: "Ocultar Cupon",
        text: "¿Realmente quiere dejar oculto este cupon en la Tienda?",
        icon: "warning",
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let status = 1;
                let ajaxUrl = base_url + '/Cupones/setStatusCupon';
                let formData = new FormData();
                formData.append("idProducto", idProducto);
                formData.append("status", status);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Exito!!", objData.msg, "success");
                            tableCupones.api().ajax.reload();
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
    rowTable = "";
    document.querySelector('#idProducto').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Cupon";
    document.querySelector("#formCupones").reset();
    $('#modalFormCupones').modal('show');
}


