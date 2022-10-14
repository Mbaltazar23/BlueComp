$('.date-picker').datepicker({
    closeText: 'Cerrar',
    prevText: '<Ant',
    nextText: 'Sig>',
    currentText: 'Hoy',
    monthNames: ['1 -', '2 -', '3 -', '4 -', '5 -', '6 -', '7 -', '8 -', '9 -', '10 -', '11 -', '12 -'],
    monthNamesShort: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM yy',
    showDays: false,
    onClose: function (dateText, inst) {
        $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
    }
});

function fntSearchPagos() {
    let fecha = document.querySelector(".pagoMes").value;
    if (fecha == "") {
        swal("", "Seleccione mes y año", "error");
        return false;
    } else {
        let request = (window.XMLHttpRequest) ?
                new XMLHttpRequest() :
                new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Dashboard/tipoPagoMes';
        divLoading.style.display = "flex";
        let formData = new FormData();
        formData.append('fecha', fecha);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState != 4)
                return;
            if (request.status == 200) {
                $("#pagosMesAnio").html(request.responseText);
                divLoading.style.display = "none";
                return false;
            }
        };
    }
}

function fntSearchVMes() {
    let fecha = document.querySelector(".ventasMes").value;
    if (fecha == "") {
        swal("", "Seleccione mes y año", "error");
        return false;
    } else {
        let request = (window.XMLHttpRequest) ?
                new XMLHttpRequest() :
                new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Dashboard/ventasMes';
        divLoading.style.display = "flex";
        let formData = new FormData();
        formData.append('fecha', fecha);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState != 4)
                return;
            if (request.status == 200) {
                $("#graficaMes").html(request.responseText);
                divLoading.style.display = "none";
                return false;
            }
        };
    }
}

function fntSearchVAnio() {
    let anio = document.querySelector(".ventasAnio").value;
    if (anio == "") {
        swal("", "Ingrese año ", "error");
        return false;
    } else {
        let request = (window.XMLHttpRequest) ?
                new XMLHttpRequest() :
                new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Dashboard/ventasAnio';
        divLoading.style.display = "flex";
        let formData = new FormData();
        formData.append('anio', anio);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState != 4)
                return;
            if (request.status == 200) {
                $("#graficaAnio").html(request.responseText);
                divLoading.style.display = "none";
                return false;
            }
        }
    }
}



$(document).ready(function () {
    if (rol == "Jefa") {
        cargarGraficoProductosJefa();
        cargarGraficaClientesRegistro();
    } else if (rol == "Administrador de Empresas" || rol == "Contador Auditor") {
        cargarGananciasPagosAdminCont();
        cargarCantRecibosAdminCont();
    } else if (rol == "Analista-financiero") {
        cargarGraficaCantVentas();
        cargarGraficaInsumosV();
    }
});


/*graficas para el personal "Directora"*/

function cargarGraficoProductosJefa() {
    $.ajax({
        type: 'POST',
        url: base_url + "/dashboard/setGraficaProductos"
    }).done(function (response) {
        if (response.length > 0) {
            var insumos = JSON.parse(response);
            var titulo = [];
            var cantidad = [];
            var colores = [];
            var fechas = [];
            for (var i = 0; i < insumos.length; i++) {
                titulo.push(insumos[i]["nombrePro"]);
                cantidad.push(insumos[i]["CantidadVendida"]);
                fechas.push("Ultino registro vendido el :" + insumos[i]["fechaVenta"]);
                colores.push(colorRGB());
            }
            GenerarGrafico(titulo, cantidad, fechas, colores, 'bar', "Ultimos productos vendidos a la fecha", "insumoG");
        }
    });
}

function cargarGraficaClientesRegistro() {
    $.ajax({
        type: 'POST',
        url: base_url + "/dashboard/setGraficaClientes"
    }).done(function (response) {
        if (response.length > 0) {
            var registros = JSON.parse(response);
            //console.log(registros);
            var mes = [];
            var cantidad = [];
            var fecha = [];
            var colores = [];

            for (var i = 0; i < registros.length; i++) {
                mes.push(registros[i]["mesRegistro"]);
                cantidad.push(registros[i]["registroClientes"]);
                fecha.push("Año :" + registros[i]["Anioregistro"] + ", Ultimo Registro :" + registros[i]["fechaRegistro"] + ",Hora :" + registros[i]["HoraVista"]);
                colores.push(colorRGB());
            }
            GenerarGrafico(mes, cantidad, fecha, colores, 'bar', "Ultimos Clientes registrados a la fecha", "clientesG");
        }
    });
}

/*graficas para el personal "Adminstrador de Empresas" y "Contador Auditor"*/

function cargarGananciasPagosAdminCont() {
    $.ajax({
        type: 'POST',
        url: base_url + "/dashboard/setGraficaGanacias"
    }).done(function (response) {
        if (response.length > 0) {
            let pago = JSON.parse(response);
            var mes = [];
            var montoAcumulado = [];
            var colores = [];
            var detalle = [];
            for (var i = 0; i < pago.length; i++) {
                mes.push(pago[i]["mesPago"]);
                montoAcumulado.push(pago[i]["totalP"]);
                detalle.push("Ultimo pago registrado: " + pago[i]["ultimaFecha"] + ", Ganacias en total: " + pago[i]["totalP"]);
                colores.push(colorRGB());
            }
            GenerarGrafico(mes, montoAcumulado, detalle, colores, 'bar', "Ultimas Ventas del mes en $", "pagosA-C");
        }
    });
}

function cargarCantRecibosAdminCont() {
    $.ajax({
        type: 'POST',
        url: base_url + "/dashboard/setGraficaCantPedidosCli"
    }).done(function (response) {
        if (response.length > 0) {
            let recibos = JSON.parse(response);
            var clientes = [];
            var cantRecibos = [];
            var detallesRecibo = [];
            var colores = [];
            for (var i = 0; i < recibos.length; i++) {
                clientes.push(recibos[i]["nombrePersona"]);
                cantRecibos.push(recibos[i]["CantRecibos"]);
                detallesRecibo.push("Ultimo recibo Registrado: " + recibos[i]["fechaRecibo"] + ", Fono del Cliente: " + recibos[i]["telefonoPersona"]);
                colores.push(colorRGB());
            }
            GenerarGrafico(clientes, cantRecibos, detallesRecibo, colores, 'bar', "Ultimos pedidos realizados por estos Clientes", "recibosA-C");
        }
    });
}

/*graficas para el personal "Analista-financiero"*/

function cargarGraficaCantVentas() {
    $.ajax({
        type: 'POST',
        url: base_url + "/dashboard/setGraficaCantPedidosMes"
    }).done(function (response) {
        if (response.length > 0) {
            let ventas = JSON.parse(response);
            var mes = [];
            var cantidad = [];
            var fecha = [];
            var colores = [];

            for (var i = 0; i < ventas.length; i++) {
                mes.push(ventas[i]["mesVenta"]);
                cantidad.push(ventas[i]["idVen"]);
                fecha.push("Ultima Fecha de la Venta: " + ventas[i]["ultimaFecha"]);
                colores.push(colorRGB());
            }
            GenerarGrafico(mes, cantidad, fecha, colores, 'bar', "Ultimas pedidos realizados en el Mes/Año", "CantVentasG");
        }
    });
}

function cargarGraficaInsumosV() {
    $.ajax({
        type: 'POST',
        url: base_url + "/dashboard/setGraficaCantProductsPedidos"
    }).done(function (response) {
        if (response.length > 0) {
            let ventas = JSON.parse(response);
            var insumo = [];
            var cantidad = [];
            var colores = [];
            var precio_fecha = [];
            for (var i = 0; i < ventas.length; i++) {
                if (ventas[i]["categoriaPro"] != 10) {//el numero 10 presenta la categoria de los productos que son : "Cupones"
                    insumo.push(ventas[i]["nombrePro"]);
                    cantidad.push(ventas[i]["CantidadVendida"]);
                    precio_fecha.push("Valor unitario : $" + Math.round(ventas[i]["ValorVenta"]) + ", Ganancias : $" + Math.round(ventas[i]["totalV"]) + ", Ultima fecha registrada: " + ventas[i]["fechaRegistro"]);
                    colores.push(colorRGB());
                }
            }
            GenerarGrafico(insumo, cantidad, precio_fecha, colores, 'bar', "Ulitmos productos vendidos de cada Pedido", "InsumosVentasG");
        }
    });
}

/*funciones encargadas de general la grafica*/

function GenerarGrafico(titulo, cantidad, texto, colores, tipo, encabezado, idGrafica) {
    var grafica = {
        x: titulo,
        y: cantidad,
        type: tipo,
        text: texto,
        marker: {
            color: colores
        }
    };

    var data = [grafica];

    var layout = {
        title: encabezado,
        font: {
            family: 'Raleway, sans-serif'
        },
        showlegend: false,
        xaxis: {
            tickangle: -45
        },
        yaxis: {
            zeroline: false,
            gridwidth: 4
        },
        bargap: 0.05
    };

    Plotly.newPlot(idGrafica, data, layout);
}

function generarNumero(numero) {
    return (Math.random() * numero).toFixed(0);
}

function colorRGB() {
    var coolor = "(" + generarNumero(243) + "," + generarNumero(235) + "," + generarNumero(254) + ")";
    return "rgb" + coolor;
}