$('.login-content [data-toggle="flip"]').click(function () {
    $('.login-box').toggleClass('flipped');
    return false;
});

//var divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function () {
    $("#terminos").hide();

    if (document.querySelector("#Direcciones")) {
        $("#Direcciones").hide();
    }

    if (document.querySelector("#formLogin")) {
        let formLogin = document.querySelector("#formLogin");
        formLogin.onsubmit = function (e) {
            e.preventDefault();

            let strEmail = document.querySelector('#txtEmail').value;
            let strPassword = document.querySelector('#txtPassword').value;
            let opcionSesion = document.querySelector("#OpcionS").value;
            if (strEmail == "" || strPassword == "")
            {
                swal("Por favor", "Escribe su correo y contraseña...", "error");
                return false;
            } else {
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url + '/Login/loginUser';
                var formData = new FormData(formLogin);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState != 4)
                        return;
                    if (request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        //console.log(objData.userData.nombreRol);
                        if (objData.status)
                        {
                            if (objData.userData.nombreRol != "Cliente") {
                                swal({
                                    title: "Exito !",
                                    text: "Bienvenido(a) señor(a) " + objData.userData.nombrePersona,
                                    icon: "success"
                                }).then(function () {
                                    window.location = base_url + '/dashboard';
                                });
                            } else {
                                swal({
                                    title: "Exito !!",
                                    text: "Bienvenido(a) señor(a) " + objData.userData.nombrePersona,
                                    icon: "success"
                                }).then(function () {
                                    if (opcionSesion == "ordenes") {
                                        window.location = base_url + '/tienda/verOrdenes';
                                    } else if (opcionSesion == "preferencias") {
                                        window.location = base_url + '/tienda/preferencias/';
                                    } else if (opcionSesion == "procesarCarrito") {
                                        window.location = base_url + '/carrito/procesarpago';
                                    } else {
                                        window.location = base_url;
                                    }
                                });
                            }
                        } else {
                            swal("Atención", objData.msg, "error");
                            document.querySelector('#txtPassword').value = "";
                        }
                    } else {
                        swal("Atención", "Error en el proceso", "error");
                    }
                    return false;
                };
            }
        };
    }

    if (document.querySelector("#formRegister")) {
        let formRegister = document.querySelector("#formRegister");
        formRegister.onsubmit = function (e) {
            e.preventDefault();
            var regexCoreo = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
            //var regexClave = new RegExp("^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$");
            var regulTele = /^(\+?56)?(\s?)(0?9)(\s?)[9876543]\d{7}$/;
            let txtNombreRegister = document.querySelector("#txtNombreRegister").value;
            let txtApellidoRegister = document.querySelector("#txtApellidoRegister").value;
            let txtEmailRegister = $("#txtEmailRegister").val();
            let txtPassRegister = $("#txtPassRegister").val();
            let txtTelefonoRegister = $("#txtTelefonoRegister").val();
            let txtPass2Register = document.querySelector("#txtPass2Register").value;
            let opcionSesion = document.querySelector("#OpcionSR").value;

            if (txtNombreRegister == "" || txtApellidoRegister == "" || txtEmailRegister == "" || txtPassRegister != txtPass2Register) {
                swal("Por favor", "Ingrese un Nombre, Apellido y Correo y Password Valido para registrarse...", "error");
                $("#txtTelefonoRegister").val("+569");
                $("#txtPassRegister").val("");
                return false;
            } else if (!regexCoreo.test(txtEmailRegister.trim()) || !regulTele.test(txtTelefonoRegister.trim())) {
                swal("Por favor", "Ingrese un Telefono o Correo Valido para registrarse...", "error");
                $("#txtTelefonoRegister").val("+569");
                $("#txtPassRegister").val("");
                document.querySelector("#txtPass2Register").value = "";
                return false;
            } else {
                var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                var ajaxUrl = base_url + '/Home/registerUser';
                var formData = new FormData(formRegister);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState != 4)
                        return;
                    if (request.status == 200) {
                        var objData = JSON.parse(request.responseText);
                        //console.log(objData.userData.nombreRol);
                        if (objData.status) {
                            swal({
                                title: "Exito !!",
                                text: "Bienvenido(a) señor(a) " + objData.userData.nombrePersona,
                                icon: "success"
                            }).then(function () {
                                if (opcionSesion == "ordenes") {
                                    window.location = base_url + '/tienda/verOrdenes';
                                } else if (opcionSesion == "preferencias") {
                                    window.location = base_url + '/tienda/preferencias/';
                                } else if (opcionSesion == "procesarCarrito") {
                                    window.location = base_url + '/carrito/procesarpago';
                                } else {
                                    window.location = base_url;
                                }
                            });
                        } else {
                            swal("Atención", objData.msg, "error");
                            document.querySelector('#txtPassRegister').value = "";
                        }
                    } else {
                        swal("Atención", "Error en el proceso", "error");
                    }
                    return false;
                };
            }
        };
    }

    if (document.querySelector("#formSuscripcion")) {
        let formSuscripcion = document.querySelector("#formSuscripcion");
        formSuscripcion.onsubmit = function (e) {
            var regexCoreo = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
            let txtCorreoSuscripcion = $("#txtCorreoSuscripcion").val();
            e.preventDefault();
            if (txtCorreoSuscripcion == "") {
                swal("Error", "Ingrese un correo para suscribirse...", "error");
                return false;
            } else if (!regexCoreo.test(txtCorreoSuscripcion.trim())) {
                swal("Error", "Ingrese un correo valido para suscribirse...", "error");
                $("#txtCorreoSuscripcion").val("");
                return false;
            } else {
                swal({
                    title: "Suscribirse",
                    text: "¿Desea suscribirse a nuestro catalogo especial?",
                    icon: "info",
                    buttons: true
                }).then((isClosed) => {
                    if (isClosed) {
                        var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                        var ajaxUrl = base_url + '/Tienda/setSuscripcion';
                        var formData = new FormData(formSuscripcion);
                        request.open("POST", ajaxUrl, true);
                        request.send(formData);
                        request.onreadystatechange = function () {
                            if (request.readyState != 4)
                                return;
                            if (request.status == 200) {
                                var objData = JSON.parse(request.responseText);
                                if (objData.status) {
                                    swal({
                                        title: "Exito !!",
                                        text: objData.msg,
                                        icon: "success"
                                    }).then(function () {
                                        window.location = base_url;
                                    });
                                    //$("#containerFormSuscript").load(" #containerFormSuscript");
                                } else {
                                    swal("Atención", objData.msg, "error");
                                }
                            } else {
                                swal("Atención", "Error en el proceso", "error");
                            }
                            return false;
                        };
                    }
                });
            }
        };
    }

    if (document.querySelector("#formDesuscripcion")) {
        let formDesuscripcion = document.querySelector("#formDesuscripcion");
        formDesuscripcion.onsubmit = function (e) {
            e.preventDefault();
            let txtCorreoSuscripcion = $("#txtCorreoDesuscripcion").val();
            console.log(txtCorreoSuscripcion);
            swal({
                title: "Desuscribirse",
                text: "¿Desea ya no estar suscrito a nuestro catalogo especial?",
                icon: "warning",
                buttons: true
            }).then((isClosed) => {
                if (isClosed) {
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxUrl = base_url + '/Tienda/delSuscripcion';
                    var formData = new FormData();
                    formData.append('txtCorreoDesuscripcion', txtCorreoSuscripcion);
                    request.open("POST", ajaxUrl, true);
                    request.send(formData);
                    request.onreadystatechange = function () {
                        if (request.readyState != 4)
                            return;
                        if (request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                swal({
                                    title: "Exito !!",
                                    text: objData.msg,
                                    icon: "success"
                                }).then(function () {
                                    window.location = base_url;
                                });
                            } else {
                                swal("Atención", objData.msg, "error");
                            }
                        } else {
                            swal("Atención", "Error en el proceso", "error");
                        }
                        return false;
                    };
                }
            });
        };
    }

}, false);

function cerrarSesionTienda() {
    swal({
        title: "Cerrar Sesion",
        text: "¿Realmente salir de su sesion?",
        icon: "info",
        buttons: true,
        dangerMode: false
    }).then((isClosed) => {
        if (isClosed) {
            $.ajax({
                type: "POST",
                url: base_url + "/logout",
                success: function (data) {
                    if (data) {
                        swal({
                            title: "Exito !",
                            text: "Sesion Finalizada !!",
                            icon: "success"
                        }).then(function () {
                            window.location = base_url;
                        });
                    }
                }
            });
        }
    });
}

function openModalSesion(opcion) {
    $("#txtEmail").val("");
    $("#txtPassword").val("");
    if (opcion == 'orden') {
        $(".cerrarCarrito").trigger("click");
        $("#OpcionS").val("procesarCarrito");
    } else if (opcion == 'pedidos') {
        $("#OpcionS").val("ordenes");
    } else if (opcion == 'prefefer') {
        $("#OpcionS").val("preferencias");
    } else if (opcion == "") {
        $("#OpcionS").val("");
    }
    $('#modalLoginTienda').modal('show');
}

function openModalRegister() {
    document.querySelector("#formRegister").reset();
    if ($("#OpcionS").val() != "") {
        $("#OpcionSR").val($("#OpcionS").val());
    }
    $('#modalLoginTienda').modal('hide');
    $("#modalRegisterTienda").modal('show');
}

//funciones para el carrito
$('.js-addcart-detail').each(function () {
    let opcionCarrito = "";
    if (document.querySelector("#opcionCarrito")) {
        opcionCarrito = document.querySelector("#opcionCarrito").value;
    }
    let opcionSuscripcion = "";
    let cant = 1;
    if (document.querySelector("#opcionSuscripion")) {
        opcionSuscripcion = document.querySelector("#opcionSuscripion").value;
        cant = $(this).attr("cant");
    }
    $(this).on('click', function (e) {
        e.preventDefault();
        //console.log(opcionSuscripcion + ":" + idDetailSus + ": " + cant);
        let id = this.getAttribute('id');
        if (document.querySelector('#cant-product')) {
            cant = document.querySelector('#cant-product').value;
        }
        if (this.getAttribute('pr')) {
            cant = this.getAttribute('pr');
        }

        if (isNaN(cant) || cant < 1) {
            swal("", "La cantidad debe ser mayor o igual que 1", "error");
            return;
        }
        swal({
            title: "Agregar producto",
            text: "¿Desea agregar este producto al carrito?",
            icon: "info",
            buttons: true
        }).then((isClosed) => {
            if (isClosed) {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Tienda/addCarrito';
                let formData = new FormData();
                formData.append('id', id);
                formData.append('cant', cant);
                formData.append('Pref', opcionCarrito);
                formData.append('Suscript', opcionSuscripcion);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState != 4)
                        return;
                    if (request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            document.querySelector(".cantCarrito").innerHTML = objData.cantCarrito;
                            document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
                            if (opcionCarrito == "preferido" && objData.respuestaPref == true) {
                                document.querySelector(".cantPreferencias").innerHTML = objData.cantPreferencias;
                                swal({
                                    title: objData.nameProduct,
                                    text: objData.msg,
                                    icon: "success"
                                }).then(function () {
                                    if (document.querySelectorAll("#preferenciasClient tr").length == 1) {
                                        window.location.href = base_url;
                                    } else {
                                        window.location = base_url + "/tienda/preferencias";
                                    }
                                });

                            } else if (opcionSuscripcion == "suscripcion" && objData.respuestaSus == true) {
                                document.querySelector(".cantSuscripciones").innerHTML = objData.cantSuscripciones;
                                swal({
                                    title: objData.nameProduct,
                                    text: objData.msg,
                                    icon: "success"
                                }).then(function () {
                                    if (document.querySelectorAll("#tableSuscrip tr").length == 1) {
                                        window.location.href = base_url;
                                    } else {
                                        window.location = base_url + "/tienda/suscripciones";
                                    }
                                });

                            } else {
                                swal(objData.nameProduct, objData.msg, "success");
                            }
                        } else {
                            swal("Error !!", objData.msg, "error");
                        }
                    }
                    return false;
                };
            }
        });
    });
});

//funciones del procesamiento del pago del pedido
function seleccionarDireccion(idComuna) {
    $.ajax({
        type: 'POST',
        url: base_url + '/carrito/selectDirecciones',
        data: {idComuna: idComuna},
        success: function (data) {
            if (idComuna != 0) {
                document.querySelector("#listDirecciones").innerHTML = data;
                $(".selecDireccion").addClass("nice-select");
                $("#Direcciones").show();
                $("#terminos").hide();
                $('#shipping-form').slideUp();
            } else {
                $("#Direcciones").hide();
                $('#shipping-form').slideUp();
                $("#terminos").hide();
            }
        }
    });
}

function mostrarTerminos(idDireccion) {
    if (idDireccion != 0) {
        $("#terminos").show();
        $('[data-shipping]').prop("checked", false);
    } else {
        $("#terminos").hide();
        $('#shipping-form').slideUp();
        $("#selectMedioPago").val('0');
        $("#selectMedioPago").change();
    }
}

if (document.querySelector("#btnCupon")) {
    let btnCupon = document.querySelector("#btnCupon");
    btnCupon.addEventListener('click', function (e) {
        e.preventDefault();
        let txtCodeDescount = $("#txtCodeDescount").val();
        let cantCupon = $("#cantCupon").val();
        //console.log(txtCodeDescount + ", " + cantCupon);
        let opcion = document.querySelector("#cantCupon").getAttribute("opcion");
        let title = "";
        let msg = "";
        let icon = "";
        //console.log(opcion);
        if (opcion == 1) {
            title = "Agregar Descuento";
            msg = "¿Desea ingresar a el codigo para hacer el descuento?";
            icon = "info";
        } else {
            title = "Remover Descuento";
            msg = "¿Desea remover este cupon de descuento?";
            icon = "warning";
        }
        if (txtCodeDescount == "") {
            swal("Error !!", "Ingrese el codigo para hacer el descuento...", "error");
            return false;
        } else if (/^([0-9])*$/.test(txtCodeDescount.trim())) {
            swal("Error !!", "El codigo ingresado no es valido..", "error");
            return false;
        } else {
            swal({
                title: title,
                text: msg,
                icon: icon,
                buttons: true
            }).then((isClosed) => {
                if (isClosed) {
                    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    var ajaxUrl = "";
                    if (opcion == 1) {
                        ajaxUrl = base_url + '/Tienda/addCupon';
                    } else {
                        ajaxUrl = base_url + '/Tienda/delCupon';
                    }
                    var formData = new FormData();
                    formData.append("txtCodeDescount", txtCodeDescount);
                    formData.append("cantCupon", cantCupon);
                    request.open("POST", ajaxUrl, true);
                    request.send(formData);
                    request.onreadystatechange = function () {
                        if (request.readyState != 4)
                            return;
                        if (request.status == 200) {
                            var objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
                                document.querySelector("#totalCompra").innerHTML = objData.total;
                                swal({
                                    title: "Exito !!",
                                    text: objData.msg,
                                    icon: "success"
                                }).then(function () {
                                    window.location = base_url + "/carrito";
                                });
                            } else {
                                swal("Atención", objData.msg, "error");
                                $("#txtCodeDescount").val("");
                            }
                        } else {
                            swal("Atención", "Error en el proceso", "error");
                        }
                        return false;
                    };
                }
            });
        }
    });
}

$("#listasCupones li a").click(function (e) {
    e.preventDefault();
    let nameCupon = "";
    let cant = 1;
    nameCupon = $(this).attr("nameCu");
    //console.log(nameCupon);
    swal({
        title: "Agregar Descuento",
        text: "¿Desea ingresar a el codigo para hacer el descuento?",
        icon: "info",
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            var ajaxUrl = base_url + '/Tienda/addCupon';
            var formData = new FormData();
            formData.append("txtCodeDescount", nameCupon);
            formData.append("cantCupon", cant);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState != 4)
                    return;
                if (request.status == 200) {
                    var objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
                        swal("Exito !!", objData.msg, "success");
                    } else {
                        swal("Atención", objData.msg, "error");
                    }
                } else {
                    swal("Atención", "Error en el proceso", "error");
                }
                return false;

            };
        }
    });
});

if (document.querySelector("#btnComprar")) {
    let btnPago = document.querySelector("#btnComprar");
    btnPago.addEventListener('click', function (e) {
        e.preventDefault();
        swal({
            title: "Procesar Venta",
            text: "¿Desea concretar este pedido que tiene el carrito?",
            icon: "info",
            buttons: true
        }).then((isClosed) => {
            if (isClosed) {
                let dir = document.querySelector("#listDirecciones").value;
                let comuna = document.querySelector("#selectComuna").value;
                let inttipopago = document.querySelector("#selectMedioPago").value;
                //console.log("comuna: " + comuna + "direccion :" + dir + ", pago :" + inttipopago);
                if (dir == 0 || comuna == 0 || inttipopago == 0) {
                    swal("Error !!", "Complete los datos de envío", "error");
                    return;
                } else {
                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url + '/Tienda/procesarVenta';
                    let formData = new FormData();
                    formData.append('direccion', dir);
                    formData.append('inttipopago', inttipopago);
                    request.open("POST", ajaxUrl, true);
                    request.send(formData);
                    request.onreadystatechange = function () {
                        if (request.readyState != 4)
                            return;
                        if (request.status == 200) {
                            let objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                swal({
                                    title: "Felicidades Sr(a) " + objData.userName,
                                    text: objData.msg,
                                    icon: "success"
                                }).then(function () {
                                    window.location = base_url;
                                });
                            } else {
                                swal("", objData.msg, "error");
                            }
                        }
                        return false;
                    };
                }
            }
        });
    });

}

/*==================================================================
 [ +/- num product ]*/
$('.prev-item').on('click', function () {
    let numProduct = Number($(this).next().val());
    let idpr = this.getAttribute('idpr');
    if (numProduct > 1)
        $(this).next().val(numProduct - 1);
    let cant = Number($(this).next().val());
    if (idpr != null) {
        fntUpdateCant(idpr, cant);
    }
});

$('.next-item').on('click', function () {
    let numProduct = Number($(this).prev().val());
    let idpr = this.getAttribute('idpr');
    $(this).prev().val(numProduct + 1);
    let cant = $(this).prev().val();
    if (idpr != null) {
        fntUpdateCant(idpr, cant);
    }
});

//Actualizar producto
if (document.querySelector(".num-product")) {
    let inputCant = document.querySelectorAll(".num-product");
    inputCant.forEach(function (inputCant) {
        inputCant.addEventListener('keyup', function () {
            let idpr = this.getAttribute('idpr');
            let cant = this.value;
            if (idpr != null) {
                fntUpdateCant(idpr, cant);
            }
        });
    });
}

function fntUpdateCant(pro, cant) {
    if (cant <= 0) {
        swal("Error!!", "La cantidad ingresada debe ser mayor a Cero", "error");
        return false;
    } else {
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Tienda/updCarrito';
        let formData = new FormData();
        formData.append('id', pro);
        formData.append('cantidad', cant);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState != 4)
                return;
            if (request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    let colSubtotal = document.getElementsByClassName(pro)[0];
                    colSubtotal.cells[4].innerHTML = "<span>" + objData.totalProducto + "</span>";
                    document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
                    if (document.querySelector("#newsubTotalCompra") && objData.newSubtotal != 0) {
                        document.querySelector("#newsubTotalCompra").innerHTML = objData.newSubtotal;
                    } else {
                        document.querySelector("#newsubTotalCompra");
                    }
                    if (document.querySelector("#montoDescount") && objData.montoDescount != 0) {
                        document.querySelector("#montoDescount").innerHTML = objData.montoDescount
                    } else {
                        document.querySelector("#montoDescount");
                    }
                    document.querySelector("#totalCompra").innerHTML = objData.total;
                } else {
                    swal("", objData.msg, "error");
                }
            }

        };
    }
    return false;
}

//funciones para las preferencias
$('.js-addpreference-detail').each(function () {
    let nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
    $(this).on('click', function () {
        //console.log(nameProduct + ": " + opcionCarrito + ":" + idPreferences);
        let id = this.getAttribute('id');
        //console.log("nombre Producto: " + nameProduct + ", idproducto : " + id);
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url + '/Preferencias/setPreferencia';
        let formData = new FormData();
        formData.append('id', id);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState != 4)
                return;
            if (request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    document.querySelector(".cantPreferencias").innerHTML = objData.cantPreferencias;
                    swal(nameProduct, objData.msg, "success");
                } else {
                    swal("Error", objData.msg, "error");
                }
            }
            return false;
        };
    });
});

function delItemPreferido(element) {
    swal({
        title: "Eliminar producto",
        text: "¿Realmente desea eliminar este producto como preferido?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            let idpref = element.getAttribute("idpref");
            //console.log(idpref);
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Preferencias/delPreferencia';
            let formData = new FormData();
            formData.append('idpref', idpref);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState != 4)
                    return;
                if (request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        document.querySelector(".cantPreferencias").innerHTML = objData.cantPreferencias;
                        swal("Exito !!", objData.msg, "success");
                        element.parentNode.parentNode.remove();
                        if (document.querySelectorAll("#preferenciasClient tr").length == 1) {
                            window.location.href = base_url;
                        }
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            };
        }
    });
}

function delItemSuscripcionPro(element) {
    swal({
        title: "Eliminar producto suscrito",
        text: "¿Realmente desea eliminar este producto suscrito?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            let idproduct = element.getAttribute("idpr");
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Tienda/delProductSuscript';
            let formData = new FormData();
            formData.append('idproducto', idproduct);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState != 4)
                    return;
                if (request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        document.querySelector(".cantSuscripciones").innerHTML = objData.cantSuscripciones;
                        swal({
                            title: "Exito !!",
                            text: objData.msg,
                            icon: "success"
                        }).then(function () {
                            window.location = base_url + '/tienda/suscripciones';
                        });
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            };
        }
    });
}

function delItemPedido(element) {
    swal({
        title: "Eliminar pedido realizado",
        text: "¿Realmente desea eliminar este producto suscrito?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            let idpedido = element.getAttribute("idpdo");
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Tienda/delPedido';
            let formData = new FormData();
            formData.append('idpedido', idpedido);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState != 4)
                    return;
                if (request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status) {
                        swal("Exito !!", objData.msg, "success");
                        element.parentNode.parentNode.remove();
                        $("#OrdenesCliente").load(" #OrdenesCliente");
                        if (document.querySelectorAll("#OrdenesCliente tr").length == 1) {
                            window.location.href = base_url;
                        }
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            };
        }
    });
}



function delItemCart(element) {
    swal({
        title: "Eliminar producto",
        text: "¿Realmente eliminar este producto del carrito?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            //Option 1 = Modal
            //Option 2 = Vista Carrito
            let option = element.getAttribute("op");
            let idpr = element.getAttribute("idpr");
            if (option == 1 || option == 2) {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Tienda/delCarrito';
                let formData = new FormData();
                formData.append('id', idpr);
                formData.append('option', option);
                request.open("POST", ajaxUrl, true);
                request.send(formData);
                request.onreadystatechange = function () {
                    if (request.readyState != 4)
                        return;
                    if (request.status == 200) {
                        let objData = JSON.parse(request.responseText);
                        if (objData.status) {
                            if (option == 1) {
                                document.querySelector("#productosCarrito").innerHTML = objData.htmlCarrito;
                                document.querySelector(".cantCarrito").innerHTML = objData.cantCarrito;
                                swal("Producto Eliminado !!", objData.msg, "success");
                            } else {
                                element.parentNode.parentNode.remove();
                                swal("Producto Eliminado !!", objData.msg, "success");
                                document.querySelector("#subTotalCompra").innerHTML = objData.subTotal;
                                if (document.querySelector("#newsubTotalCompra") && objData.newSubtotal != 0) {
                                    document.querySelector("#newsubTotalCompra").innerHTML = objData.newSubtotal;
                                } else {
                                    document.querySelector("#newsubTotalCompra");
                                }
                                if (document.querySelector("#montoDescount") && objData.montoDescount != 0) {
                                    document.querySelector("#montoDescount").innerHTML = objData.montoDescount
                                } else {
                                    document.querySelector("#montoDescount");
                                }
                                document.querySelector("#totalCompra").innerHTML = objData.total;
                                if (document.querySelectorAll("#tblCarrito tr").length == 1) {
                                    window.location.href = base_url;
                                }
                            }
                        }
                    }
                };
            }
        }
    });
}