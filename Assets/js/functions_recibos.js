let rowTable;
let tableRecibos;
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tableRecibos = $('#tableRecibos').dataTable({
    "aProcessing": true,
    "aServerSide": true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax": {
        "url": " " + base_url + "/Recibos/getRecibos",
        "dataSrc": ""
    },
    "columns": [
        {"data": "nombrePersona"},
        {"data": "fecha"},
        {"data": "hora"},
        {"data": "montoTotalPedido"},
        {"data": "statusPedido"},
        {"data": "estadoPedido"},
        {"data": "options"}
    ],
    "resonsieve": "true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "desc"]]
});

function fntViewInfo(idRecibo) {
    let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Recibos/getRecibo/' + idRecibo;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let obj = objData.data;
                let objCliente = obj.cliente;
                let objRecibo = obj.orden;
                let objProducts = obj.detalle;
                let idCup = 0;
                for (let i = 0; i < objProducts.length; i++) {
                    if (objProducts[i].categoriaPro == 10) {
                        idCup = objProducts[i].categoriaPro;
                    }
                }
                let cuponApli = idCup == 10 ? "Si" : "No";

                $("#idOrdenRecibo").text(objRecibo.idCliPed);
                $("#nombreCliRe").text(objCliente.nombrePersona);
                $("#telefonoCliR").text(objCliente.telefonoPersona);
                $("#FechaR").text(objRecibo.fecha);
                $("#HoraR").text(objRecibo.hora);
                $("#SubTotalR").text(objRecibo.subtotalPedido);
                $("#TotalR").text(objRecibo.montoTotalPedido);
                $("#DireccionR").text(objRecibo.nombreDireccion);
                $("#CuidadR").text(objRecibo.nombreComuna);
                $("#CostoEnvio").text(objRecibo.costoEnvioPedido);
                $("#CuponValid").text(cuponApli);
                //console.log(objData);
                $("#modalReciboView").modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function fntViewProducts(idRecibo) {
    $("#tableDetalleP tbody").empty();
    let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Recibos/getRecibo/' + idRecibo;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let obj = objData.data;
                let objCliente = obj.cliente;
                let objRecibo = obj.orden;
                let objProducts = obj.detalle;
                let cantProduct = 0;
                $("#idReciboCli").text(objRecibo.idCliPed);
                $("#nombrePago").text(objCliente.nombrePersona);
                $("#fechaPago").text(objRecibo.fecha);
                $("#horaPago").text(objRecibo.hora);
                $("#medioPago").text(objRecibo.nombrePago);
                $("#telefonoP").text(objCliente.telefonoPersona);
                $("#estadoP").text(objRecibo.statusPedido);
                let subtotal = 0;
                for (let i = 0; i < objProducts.length; i++) {
                    if (objProducts[i].categoriaPro != 10) {//el numero 10 presenta la categoria de los productos que son : "Cupones"
                        $("#tableDetalleP tbody").append(`<tr>
                                            <td>${objProducts[i].producto}</td>
                                            <td>${objProducts[i].cantidadDetalle}</td>
                                            <td>$${Math.round(objProducts[i].precioDetalle)}</td>
                                            <td>$${(objProducts[i].precioDetalle * objProducts[i].cantidadDetalle)}</td>
                                        </tr>`);
                        subtotal += Number(objProducts[i].precioDetalle * objProducts[i].cantidadDetalle);
                        cantProduct += Number(objProducts[i].cantidadDetalle);
                    }
                }

                $("#cantPago").text(cantProduct);
                $("#totalP").text(smony + subtotal);
                $("#modalReciboProducts").modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function fntDelInfo(idRecibo) {
    swal({
        title: "Inhabilitar Recibo",
        text: "¿Realmente quiere inhabilitar este recibo seleccionado?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let status = 0;
                let ajaxUrl = base_url + '/Recibos/setStatusRecibo';
                let formData = new FormData();
                formData.append("idRecibo", idRecibo);
                formData.append("status", status);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Exito!!", objData.msg, "success");
                            tableRecibos.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });

}

function fntActInfo(idRecibo) {
    swal({
        title: "Activar Recibo",
        text: "¿Realmente quiere dejar activo este recibo seleccionado?",
        icon: "info",
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let status = 1;
                let ajaxUrl = base_url + '/Recibos/setStatusRecibo';
                let formData = new FormData();
                formData.append("idRecibo", idRecibo);
                formData.append("status", status);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Exito!!", objData.msg, "success");
                            tableRecibos.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });

}