let tableProductos;
$(document).on('focusin', function (e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tableProductos = $('#tableProductos').dataTable({
    "aProcessing": true,
    "aServerSide": true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax": {
        "url": " " + base_url + "/Productos/getProductos",
        "dataSrc": ""
    },
    "columns": [
        {"data": "nombrePro"},
        {"data": "precioPro"},
        {"data": "stockPro"},
        {"data": "nombreCategoria"},
        {"data": "estadoPro"},
        {"data": "options"}
    ],
    "resonsieve": "true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order": [[0, "desc"]]
});
window.addEventListener('load', function () {
    if (document.querySelector("#formProductos")) {
        let formProductos = document.querySelector("#formProductos");
        formProductos.onsubmit = function (e) {
            e.preventDefault();
            let strNombre = document.querySelector('#txtNombre').value;
            let strPrecio = document.querySelector('#txtPrecio').value;
            let intStock = document.querySelector('#txtStock').value;
            if (strNombre == '' || strPrecio == '' || intStock == '')
            {
                swal("Atención", "Todos los campos son obligatorios.", "error");
                return false;
            }
            let request = (window.XMLHttpRequest) ?
                    new XMLHttpRequest() :
                    new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Productos/setProducto';
            let formData = new FormData(formProductos);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        swal("", objData.msg, "success");
                        document.querySelector("#idProducto").value = objData.idproducto;
                        document.querySelector("#containerGallery").classList.remove("notblock");
                        tableProductos.api().ajax.reload();
                        swal("Exito !!", objData.msg, "success");
                        $('#modalFormProductos').modal('hide');
                    } else {
                        swal("Error", objData.msg, "error");
                    }
                }
            };
        };
    }

    if (document.querySelector(".btnAddImage")) {
        let btnAddImage = document.querySelector(".btnAddImage");
        btnAddImage.onclick = function (e) {
            let key = Date.now();
            let newElement = document.createElement("div");
            newElement.id = "div" + key;
            newElement.innerHTML = `
            <div class="prevImage"></div>
            <input type="file" name="foto" id="img${key}" class="inputUploadfile">
            <label for="img${key}" class="btnUploadfile"><i class="fas fa-upload "></i></label>
            <button class="btnDeleteImage notblock" type="button" onclick="fntDelItem('#div${key}')"><i class="fas fa-trash-alt"></i></button>`;
            document.querySelector("#containerImages").appendChild(newElement);
            document.querySelector("#div" + key + " .btnUploadfile").click();
            fntInputFile();
        }
    }

    fntInputFile();
    fntCategorias();
}, false);



function fntInputFile() {
    let inputUploadfile = document.querySelectorAll(".inputUploadfile");
    inputUploadfile.forEach(function (inputUploadfile) {
        inputUploadfile.addEventListener('change', function () {
            let idProducto = document.querySelector("#idProducto").value;
            let parentId = this.parentNode.getAttribute("id");
            let idFile = this.getAttribute("id");
            let uploadFoto = document.querySelector("#" + idFile).value;
            let fileimg = document.querySelector("#" + idFile).files;
            let prevImg = document.querySelector("#" + parentId + " .prevImage");
            let nav = window.URL || window.webkitURL;
            if (uploadFoto != '') {
                let type = fileimg[0].type;
                let name = fileimg[0].name;
                if (type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png') {
                    prevImg.innerHTML = "Archivo no válido";
                    uploadFoto.value = "";
                    return false;
                } else {
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    prevImg.innerHTML = `<img class="loading" src="${base_url}/Assets/images/loading.svg" >`;

                    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                    let ajaxUrl = base_url + '/Productos/setImage';
                    let formData = new FormData();
                    formData.append('idproducto', idProducto);
                    formData.append("foto", this.files[0]);
                    request.open("POST", ajaxUrl, true);
                    request.send(formData);
                    request.onreadystatechange = function () {
                        if (request.readyState != 4)
                            return;
                        if (request.status == 200) {
                            let objData = JSON.parse(request.responseText);
                            if (objData.status) {
                                prevImg.innerHTML = `<img src="${objeto_url}">`;
                                document.querySelector("#" + parentId + " .btnDeleteImage").setAttribute("imgname", objData.imgname);
                                document.querySelector("#" + parentId + " .btnUploadfile").classList.add("notblock");
                                document.querySelector("#" + parentId + " .btnDeleteImage").classList.remove("notblock");
                            } else {
                                swal("Error", objData.msg, "error");
                            }
                        }
                    }

                }
            }

        });
    });
}

function fntDelItem(element) {
    swal({
        title: "Borrar Imagen del Producto",
        text: "¿Realmente quiere borrar la imaden del producto?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            let nameImg = document.querySelector(element + ' .btnDeleteImage').getAttribute("imgname");
            let idProducto = document.querySelector("#idProducto").value;
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url + '/Productos/delFile';

            let formData = new FormData();
            formData.append('idproducto', idProducto);
            formData.append("file", nameImg);
            request.open("POST", ajaxUrl, true);
            request.send(formData);
            request.onreadystatechange = function () {
                if (request.readyState != 4)
                    return;
                if (request.status == 200) {
                    let objData = JSON.parse(request.responseText);
                    if (objData.status)
                    {
                        let itemRemove = document.querySelector(element);
                        itemRemove.parentNode.removeChild(itemRemove);
                    } else {
                        swal("", objData.msg, "error");
                    }
                }
            }
        }
    });
}

function fntViewInfo(idProducto) {
    let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Productos/getProducto/' + idProducto;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                let htmlImage = "";
                let objProducto = objData.data;
                let estadoProducto = objProducto.estadoPro == 1 ?
                        '<span class="badge badge-success">Activo</span>' :
                        '<span class="badge badge-danger">Inactivo</span>';

                document.querySelector("#celNombre").innerHTML = objProducto.nombrePro;
                document.querySelector("#celPrecio").innerHTML = objProducto.precio;
                document.querySelector("#celStock").innerHTML = objProducto.stockPro;
                document.querySelector("#celCategoria").innerHTML = objProducto.categoria;
                document.querySelector("#celStatus").innerHTML = estadoProducto;
                document.querySelector("#celDescripcion").innerHTML = objProducto.descripcionPro;

                if (objProducto.images.length > 0) {
                    let objProductos = objProducto.images;
                    for (let p = 0; p < objProductos.length; p++) {
                        htmlImage += `<img src="${objProductos[p].url_image}"></img>`;
                    }
                }
                document.querySelector("#celFotos").innerHTML = htmlImage;
                $('#modalViewProducto').modal('show');

            } else {
                swal("Error", objData.msg, "error");
            }
        }
    };
}

function fntEditInfo(element, idProducto) {
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector(".modal-dialog").classList.add("modal-lg");
    document.querySelector(".contenidoD").classList.replace("bodyForm", "row");
    document.querySelector(".celdas").classList.replace("fila", "col-md-6");
    document.querySelector('#titleModal').innerHTML = "Actualizar Producto";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML = "Actualizar";
    let request = (window.XMLHttpRequest) ?
            new XMLHttpRequest() :
            new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url + '/Productos/getProducto/' + idProducto;
    request.open("GET", ajaxUrl, true);
    request.send();
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status)
            {
                let htmlImage = "";
                let objProducto = objData.data;
                document.querySelector("#idProducto").value = objProducto.idproducto;
                document.querySelector("#txtNombre").value = String(objProducto.nombrePro).toLowerCase();
                document.querySelector("#txtDescripcion").value = String(objProducto.descripcionPro).toLowerCase();
                document.querySelector("#txtPrecio").value = Math.round(objProducto.precioPro);
                document.querySelector("#txtStock").value = objProducto.stockPro;
                document.querySelector("#listCategoria").value = objProducto.categoriaPro;

                if (objProducto.images.length > 0) {
                    let objProductos = objProducto.images;
                    for (let p = 0; p < objProductos.length; p++) {
                        let key = Date.now() + p;
                        htmlImage += `<div id="div${key}">
                            <div class="prevImage">
                            <img src="${objProductos[p].url_image}"></img>
                            </div>
                            <button type="button" class="btnDeleteImage" onclick="fntDelItem('#div${key}')" imgname="${objProductos[p].img}">
                            <i class="fas fa-trash-alt"></i></button></div>`;
                    }
                }
                document.querySelector("#containerImages").innerHTML = htmlImage;
                document.querySelector("#containerGallery").classList.remove("notblock");
                $('#modalFormProductos').modal('show');
            } else {
                swal("Error", objData.msg, "error");
            }
        }
    }
}

function fntDelInfo(idProducto) {
    swal({
        title: "Inhabilitar Producto",
        text: "¿Realmente quiere inhabilitar el producto?",
        icon: "warning",
        dangerMode: true,
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Productos/setStatusProducto';
                let status = 0;
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
                            tableProductos.api().ajax.reload();
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
        title: "Activar Producto",
        text: "¿Realmente quiere dejar activo el producto?",
        icon: "info",
        buttons: true
    }).then((isClosed) => {
        if (isClosed) {
            {
                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl = base_url + '/Productos/setStatusProducto';
                let status = 1;
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
                            swal("Activado!", objData.msg, "success");
                            tableProductos.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg, "error");
                        }
                    }
                };
            }
        }
    });
}

function fntCategorias() {
    if (document.querySelector('#listCategoria')) {
        $.ajax({
            type: "POST",
            url: base_url + '/Categorias/getSelectCategorias',
            success: function (data) {
                $('.selectCategoria select').html(data).fadeIn();
            }
        });
    }
}

function openModal() {
    rowTable = "";
    document.querySelector('#idProducto').value = "";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML = "Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Producto";
    document.querySelector("#formProductos").reset();
    document.querySelector(".modal-dialog").classList.remove("modal-lg");
    document.querySelector(".contenidoD").classList.replace("row", "bodyForm");
    document.querySelector(".celdas").classList.replace("col-md-6", "fila");
    document.querySelector("#containerGallery").classList.add("notblock");
    document.querySelector("#containerImages").innerHTML = "";
    $('#modalFormProductos').modal('show');
}