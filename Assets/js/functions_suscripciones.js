let tableSuscripciones;
let rowTable = "";
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tableSuscripciones = $("#tableSuscripciones").dataTable({
    "aProcessing": true,
    "aServerSide": true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax": {
        "url": " " + base_url + "/Suscripciones/getSuscripciones",
        "dataSrc": ""
    },
    "columns": [
        {"data": "emailPersona"},
        {"data": "fechaSus"},
        {"data": "horaSus"},
        {"data": "estadoSuscripcion"},
        {"data": "options"}
    ],
    "resonsieve": "true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "desc"]]
});
window.addEventListener('load', function () {
    fntCategorias();
}, false);

function fntViewInfo(idSuscripcion) {
    let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Suscripciones/getSuscripcion/' + idSuscripcion;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {

                let objSuscripcion = objData.data;
                let estadoProducts = objSuscripcion.products.length > 0 ?
                        '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-dark">Inactivo</span>';
                let estadoSus = objSuscripcion.estadoSuscripcion == 1 ?
                        '<span class="badge badge-success">Pendiente</span>' : '<span class="badge badge-primary">Activa</span>';
                document.querySelector("#celCorreo").innerHTML = objSuscripcion.emailPersona;
                document.querySelector("#celFecha").innerHTML = objSuscripcion.fechaSus;
                document.querySelector("#celHora").innerHTML = objSuscripcion.horaSus;
                document.querySelector("#celStatusSus").innerHTML = estadoSus;
                document.querySelector("#celStatusSus").innerHTML = estadoSus;
                document.querySelector("#celProductsSus").innerHTML = estadoProducts;
                $("#modalViewSuscripcion").modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function fntViewSuscrip(element, idSuscripcion) {
    vaciarCampos("#tabla-products > tbody", "#tabla-resumen > tbody", "cantidadProduct", "listProductos", "listCategoriaSus");
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    $("#btnAgregarProduct").addClass("btn-primary");
    $("#btnAgregarProduct").removeAttr("style");
    let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Suscripciones/getSuscripcion/' + idSuscripcion;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let objSuscripcion = objData.data;
                document.querySelector('#titleModal').innerHTML = "Ver Suscripcion - Correo : " + String(objSuscripcion.emailPersona).toLowerCase();
                document.querySelector('#id-Sus').value = objSuscripcion.idSuscripcion;
                $("#opcionSus").val("create");
                $('#modalFormSuscripcion').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function fntEditSuscrip(element, idSuscripcion) {
    vaciarCampos("#tabla-products > tbody", "#tabla-resumen > tbody", "cantidadProduct", "listProductos", "listCategoriaSus");
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    $("#btnAgregarProduct").removeClass("btn-primary");
    $("#btnAgregarProduct").css("background", "#007bff").css("color", "#FFF");
    let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Suscripciones/getSuscripcion/' + idSuscripcion;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
                let objSuscripcion = objData.data;
                document.querySelector('#titleModal').innerHTML = "Actualizar Suscripcion - Correo : " + String(objSuscripcion.emailPersona).toLowerCase();
                document.querySelector('#id-Sus').value = objSuscripcion.idSuscripcion;
                $("#opcionSus").val("edit");
                let objProducts = objData.data.products;
                if (objProducts.length > 0) {
                    for (let i = 0; i < objProducts.length; i++) {
                        $("#tabla-products tbody").append(`<tr>
                                            <td hidden>${objProducts[i].productoSuscrito}</td>
                                            <td>${objProducts[i].nombrePro}</td>
                                            <td class='text-center' id='tdCantidad_${objProducts[i].productoSuscrito}'>${objProducts[i].cantidadProSuscrito}</td>
                                            <td class='text-center'>${Math.round(objProducts[i].precioProSuscrito)}</td>
                                            <td class='text-center' id='tdPrecio_${objProducts[i].productoSuscrito}'>${objProducts[i].precioProSuscrito * objProducts[i].cantidadProSuscrito}</td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(this);"><i class='fas fa-trash'></i></button></td>
                                        </tr>`);
                    }

                }
                mostrarResumen("tabla-products", "resumenSus", "#tabla-products tbody tr", "tabla-resumen", "btnSuscrip", "listProductos", "Actualizar Productos");
                $('#modalFormSuscripcion').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function buscarProductos(idCategoria, idSelect) {
    if (idCategoria != 0) {
        let request = (window.XMLHttpRequest) ?
                new XMLHttpRequest() :
                new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Suscripciones/getSelectProductsCat/' + idCategoria;
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                $('.' + idSelect + ' select').html(request.responseText).fadeIn();
            }
        };
    } else {
        var selectPro = document.getElementById("listProductos");
        selectPro.innerHTML = "<option value='0'>Seleccione un producto</option>";
    }

}

$("#btnAgregarProduct").click(function () {
    let id_product = $("#listProductos option:selected").val();
    let cantidad = $("#cantidadProduct").val();
    let opcion = $("#opcionSus").val();
    let btn = "";
    let mensaje = "";
    let error = false;
    if (id_product < 1) {
        mensaje = "Debe seleccionar un producto al menos..";
        error = true;
    } else if (cantidad == "" || cantidad < 1) {
        mensaje = "Debe ingresar una Cantidad correcta.";
        error = true;
    } else if (opcion == "create") {
        btn = "Registrar Productos";
    } else if (opcion == "edit") {
        btn = "Actualizar Productos";
    }
    if (error == true) {
        swal('Oops...', mensaje, 'error');
        return false;
    } else {
        let request = (window.XMLHttpRequest) ?
                new XMLHttpRequest() :
                new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Suscripciones/getProductoSuscript/' + id_product;
        request.open("GET", ajaxUrl, true);
        request.send();
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    let objProducto = objData.data;
                    let nombre = objProducto.nombrePro;
                    let precio = objProducto.precioPro;
                    var banderaCoincidencia = false;
                    $("#tabla-products tbody tr").each(function (row, element) {
                        var id = $(element).find("td")[0].innerHTML;
                        if (id_product == id) {
                            var cantidadActual = $(element).find("td")[2].innerHTML;
                            var cantidadTotal = parseInt(cantidadActual) + parseInt(cantidad);
                            var precioActualizado = cantidadTotal * precio;
                            $("#tdCantidad_" + id_product).text(cantidadTotal);
                            $("#tdPrecio_" + id_product).text(precioActualizado);
                            banderaCoincidencia = true;
                        }
                    });
                    if (!banderaCoincidencia) {
                        $('#tabla-products tbody').append(`<tr>
                                            <td hidden>${id_product}</td>
                                            <td>${nombre}</td>
                                            <td class='text-center' id='tdCantidad_${id_product}'>${cantidad}</td>
                                            <td class='text-center'>${Math.round(precio)}</td>
                                            <td class='text-center' id='tdPrecio_${id_product}'>${precio * cantidad}</td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(this);"><i class='fas fa-trash'></i></button></td>
                                        </tr>`);
                    }
                    $("#listCategoriaSus").val("0");
                    $("#listProductos").val("0");
                    $("#cantidadProduct").val("");
                    swal('Exito...', "Producto Agregado Exitosamente...", 'success');
                    mostrarResumen("tabla-products", "resumenSus", "#tabla-products tbody tr", "tabla-resumen", "btnSuscrip", "listProductos", btn, opcion);
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
        };
    }
});

$("#resumenSus").on("click", ".btnSuscrip", function () {
    let opcion = $("#opcionSus").val();
    let idSus = $("#id-Sus").val();
    var arregloProducts = [];
    $("#tabla-products tbody tr").each(function (row, element) {
        var idproduct = $(element).find("td")[0].innerHTML;
        var cantidad = parseInt($(element).find("td")[2].innerHTML);
        var precio = parseInt($(element).find("td")[3].innerHTML);
        arregloProducts.push({"idProducto": idproduct, "cantidad": cantidad, "precio": precio});
    });
    swal({
        title: "Registrar Productos",
        text: "¿Desea agregar estos Productos a la suscripcion?",
        icon: "info",
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: base_url + "/Suscripciones/setDetailSuscripcion",
                data: {arregloProducts: arregloProducts, idSuscrip: idSus, opcionSentencia: opcion},
                success: function (data) {
                    let objData = JSON.parse(data);
                    if (objData.status) {
                        swal("Exito !!", objData.msg, "success");
                    }
                    tableSuscripciones.api().ajax.reload();
                    $("#modalFormSuscripcion").modal('hide');
                }
            });
        }
    });
});

function fntCategorias() {
    if (document.querySelector('#listCategoriaSus')) {
        $.ajax({
            type: "POST",
            url: base_url + '/Suscripciones/getSelectCategorias',
            success: function (data) {
                $('.selectCategoriaSus select').html(data).fadeIn();
            }
        });
    }
}

function mostrarResumen(tableInsumos, resumen, tableInsumosCont, tableResumen, btn, selectProduct, valorBtn, opcion) {
    var filas = document.getElementById(tableInsumos).rows.length;
    if (filas > 1) {
        document.getElementById(resumen).removeAttribute("hidden");
        actualizarResumen(tableInsumosCont, tableResumen, btn, resumen, valorBtn, opcion);
    } else {
        document.getElementById(resumen).setAttribute("hidden", "");
        actualizarResumen(tableInsumosCont, tableResumen, btn, resumen, valorBtn, opcion);
    }
    cargarCantiVacia(selectProduct);
}

function cargarCantiVacia(selectProduct) {
    $('option', '#' + selectProduct).remove();
    var selectPro = document.getElementById(selectProduct);
    selectPro.innerHTML = "<option value='0'>Seleccione un producto</option>";
}

function actualizarResumen(table, tableResumen, btn, resumen, valorBtn, opcion) {
    var valorTotal = 0;
    let style = "";
    if (opcion == "create") {
        style = "style='background: #009688; color: #FFF;'";
    } else {
        style = "style='background: #007bff; color: #FFF;'";
    }
    $(table).each(function (row, element) {
        var subtotalT = $(element).find("td")[4].innerHTML;
        var subtotal = parseInt(subtotalT);
        valorTotal += subtotal;
    });
    var html = ` <br><table id="${tableResumen}" style="width: center;">
                     <tbody>
                        <tr>
                            <th style="text-align: left; width:200px;">Valor Total: </th>
                            <td style="text-align: right; width: 100px;">$${valorTotal}</td>
                            <td style="text-align:right; width:700px"><button class="btn rounded-pill ${btn}" ${style}>${valorBtn}</button></td>
                        </tr>
                     </tbody>
                    </table>`;
    document.getElementById(resumen).innerHTML = html;
}

function vaciarCampos(tableProductos, tableResumen, selectCant, ProductSelect, CatSelect) {
    $(tableProductos).empty();
    $(tableResumen).empty();
    cargarCantiVacia(ProductSelect);
    $("#" + selectCant).val("");
    $(ProductSelect).val("0");
    $("#" + CatSelect).val("0");
}

function eliminarProducto(dato) {
    var fila = dato.parentNode.parentNode.rowIndex;
    let opcion = $("#opcionSus").val();
    let btn = "";
    if (opcion == "create") {
        btn = "Registrar Productos";
    } else if (opcion == "edit") {
        btn = "Actualizar Productos";
    }
    swal({
        title: "Eliminar Producto",
        text: "¿Realmente borrar a este Producto?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            swal("Prodcuto Eliminado...", "El producto fue retirado Exitosamente !!", "success");
            document.getElementById("tabla-products").deleteRow(fila);
        }
        mostrarResumen("tabla-products", "resumenSus", "#tabla-products tbody tr", "tabla-resumen", "btnSuscrip", "listProductos", btn);
    });
}

function fntDelInfo(idSuscripcion) {
    swal({
        title: "Inhabilitar Suscripcion",
        text: "¿Realmente quiere inhabilitar esta suscripcion?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Suscripciones/setStatusSuscripcion';
                let status = 0;
                let formData = new FormData();
                formData.append("idSuscripcion", idSuscripcion);
                formData.append("status", status);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Inhabilitado!", objData.msg, "success");
                            tableSuscripciones.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });
}

function fntActivateInfo(idSuscripcion) {
    swal({
        title: "Habilitar Suscripcion",
        text: "¿Realmente quiere habilitar esta suscripcion?",
        icon: "info",
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Suscripciones/setStatusSuscripcion';
                let status = 1;
                let formData = new FormData();
                formData.append("idSuscripcion", idSuscripcion);
                formData.append("status", status);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status)
                        {
                            swal("Habilitado!", objData.msg, "success");
                            tableSuscripciones.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });
}


    