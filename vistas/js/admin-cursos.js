$(document).ready(function() {

    $('body').addClass('admin-body bg-light').attr("id", "body-pd").removeClass('bg-light-gray');

    $('#flyer, #banner').fileinput({
        language: 'es',
        allowedFileExtensions: ["jpg", "png", "jpeg"],
        showClose: false,
        showUpload: false,
        maxFileCount: 1,
        uploadAsync: false,
        required: true
    });

    $(".btnModificarCurso").on('click', function() {
        $('#modalModificarCurso').modal('show');
        // $('#modalModificarCurso').parent()[0].reset();
        let tr = $($(this).closest('.cursos')[0]).attr("id").split('-');;
        var idCurso = tr[1];
        // console.log(tr);

        $.ajax({
            url: dominio + 'ajax/formularios.ajax.php',
            method: 'POST',
            data: {
                "tabla": "Cursos",
                "campo": "idCurso",
                "dato": idCurso //tr.children('td')[0].className.split('-')[1]
            },
            dataType: "json",
            async: true,
            success: function(res) {
                // console.log(res);
                var keys = Object.keys(res);
                // console.log(keys);
                for(var i=Number.parseInt(keys.length/2);i<=keys.length-1;i++){
                    // console.log(keys[i]+' | '+res[keys[i]]);
                    let selector = "#modalModificarCurso [name='"+keys[i]+"']";
                    // console.log(selector);
                    // console.log($(selector));
                    // $('#idCursoModificar').val(tr.children('td')[0].className.split('-')[1]);
                    $('#idCursoModificar').val(idCurso);
                    if(keys[i]=="temario"){
                        let str = res[keys[i]].split('|||');
                        // console.log(str);
                        $("#modalModificarCurso [name='temario']").val(str[0]);
                        $("#modalModificarCurso [name='recursos']").val(str[1]);
                        $("#modalModificarCurso [name='materiales']").val(str[2]);
                    }else{
                        if(keys[i]=="flyer"){
                            // $('#editFlyer').fileinput('reset');
                            let url = dominio+'vistas/img/flyers/'+res[keys[i]];
                            // console.log('flyer',url);
                            $('#editFlyer').fileinput('destroy').fileinput({
                                uploadAsync: false,
                                showUpload: false,
                                required: true,
                                overwriteInitial: false,
                                // minFileCount: 1,
                                language: 'es',
                                allowedFileExtensions: ["jpg", "png", "jpeg"],
                                showClose: false,
                                maxFileCount: 1,
                                validateInitialCount: true,
                                initialPreviewAsData: true,                   
                                initialPreview: [url],                            
                                initialPreviewConfig: [{
                                    // caption: res[keys[i]],
                                    url: dominio + 'ajax/formularios.ajax.php',
                                    type: 'image',
                                    key: Number.parseInt(idCurso),
                                    extra: {tipo: 'flyer'} 
                                }]
                            });
                        }else{
                            if(keys[i]=="banner"){
                                // $('#editBanner').fileinput('reset');
                                let url = dominio+'vistas/img/banners/'+res[keys[i]];
                                // console.log('banner',url);
                                $('#editBanner').fileinput('destroy').fileinput({
                                    uploadAsync: false,
                                    showUpload: false,
                                    required: true,
                                    overwriteInitial: false,
                                    // minFileCount: 1,
                                    language: 'es',
                                    allowedFileExtensions: ["jpg", "png", "jpeg"],
                                    showClose: false,
                                    maxFileCount: 1,
                                    validateInitialCount: true,
                                    initialPreviewAsData: true,                   
                                    initialPreview: [url],                            
                                    initialPreviewConfig: [{
                                        // caption: res[keys[i]],
                                        url: dominio + 'ajax/formularios.ajax.php',
                                        type: 'image',
                                        key: Number.parseInt(idCurso),
                                        extra: {tipo: 'banner'} 
                                    }]
                                });
                            }else{
                                $(selector).val(res[keys[i]]);
                            }
                        }
                    }
                }
            },
            error: function(err) {
                console.log("Error",err);
            }
        });
    });

    $('#editFlyer').on('filedeleted', function(event, key, jqXHR, data) {
        event.preventDefault();
        // console.log('Key = ' + key);
    });

    $('#editBanner').on('filedeleted', function(event, key, jqXHR, data) {
        event.preventDefault();
        // console.log('Key = ' + key);
    });

    $(".btnEliminarCurso").on('click', function() {
        $('#modalEliminarCurso').modal('show');
        let tr = $($(this).closest('.cursos')[0]).attr("id").split('-');;
        var idCurso = tr[1];

        $('#idCursoEliminar').val(idCurso);
    });


    $('.btn-Report').on('click',function(){
        $('#modalIngresos form')[0].reset();
    });

    // LATERAL NAVBAR
    const showNavbar = (toggleId, navId, bodyId, headerId) => {
        const toggle = document.getElementById(toggleId),
            nav = document.getElementById(navId),
            bodypd = document.getElementById(bodyId),
            headerpd = document.getElementById(headerId);
        // Validate that all variables exist
        if (toggle && nav && bodypd && headerpd) {
            toggle.addEventListener('click', () => {
                // show navbar
                nav.classList.toggle('show_nav');
                // change icon
                toggle.classList.toggle('fa-times');
                // add padding to body
                bodypd.classList.toggle('body-pd');
                // add padding to header
                headerpd.classList.toggle('body-pd');
            });
        }
    }

    showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');

    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link');

    function colorLink() {
        if (linkColor) {
            linkColor.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        }
    }
    linkColor.forEach(l => l.addEventListener('click', colorLink));

    $('#link_inscritos').on('click', () => {
        $('#inscritosTable').removeClass('visually-hidden-focusable');
        $('#cursosTable').addClass('visually-hidden-focusable');
        $('#pendientesTable').addClass('visually-hidden-focusable');
    });
    $('#link_cursos').on('click', () => {
        $('#cursosTable').removeClass('visually-hidden-focusable');
        $('#inscritosTable').addClass('visually-hidden-focusable');
        $('#pendientesTable').addClass('visually-hidden-focusable');
    });
    $('#link_pendientes').on('click', () => {
        $('#cursosTable').addClass('visually-hidden-focusable');
        $('#inscritosTable').addClass('visually-hidden-focusable');
        $('#pendientesTable').removeClass('visually-hidden-focusable');
    });
});

function editarParticipante(e) {
    $('#modalModificarAlumno').modal('show');
    let tr = $(e).closest('tr');

    $.ajax({
        url: dominio + 'ajax/formularios.ajax.php',
        method: 'POST',
        crossDomain: true,
        data: {
            "tabla": "Participantes",
            "campo": "idParticipante",
            "dato": tr.children('td')[0].className.split('-')[1]
        },
        dataType: "json",
        async: true,
        success: function(res) {
            // console.log(res);
            let keys = Object.keys(res);
            for(var i=Number.parseInt(keys.length/2);i<=keys.length-1;i++){
                // console.log(keys[i]+' | '+res[keys[i]]);
                let selector = "#modalModificarAlumno [name='"+keys[i]+"']";
                $('#idAlumno').val(tr.children('td')[0].className.split('-')[1]);
                
                if(keys[i]=="sexo"){
                    if(res[keys[i]]=="H"){
                        $('#modalModificarAlumno #hombreRadio')[0].checked = true;
                    }else{
                        $('#modalModificarAlumno #mujerRadio')[0].checked = true
                    }
                }else{
                    if(keys[i]=="est_civil"){
                        if(res[keys[i]]=="soltero"){
                            $('#modalModificarAlumno #solteroRadio')[0].checked = true;
                        }else{
                            $('#modalModificarAlumno #casadoRadio')[0].checked = true;
                        }
                    }
                }
                $(selector).val(res[keys[i]]);
            }
        },
        error: function(err) {
            console.log("ERR",err);
        }
    });
}

function eliminarParticipante(e) {
    $('#modalEliminarAlumno').modal('show');
    var $tr = $(e).closest('tr');

    $('#idAlumnoEliminar').val($tr.children('td')[0].className.split('-')[1]);
}

function comprobante(e) {
    $('#modalRevisar').modal('show');
    var idParticipante = $(e).closest('tr').children('td')[0].className.split('-')[1];
    // console.log("bnt Comprobante");

    let tipo = $(e).closest('tr').parent().parent().parent().parent().attr("id");
    // console.log(tipo);
    if (tipo=="inscritosTable") {
        $($('#modalRevisar .modal-footer')[0]).addClass("visually-hidden-focusable");
    } else {
        $($('#modalRevisar .modal-footer')[0]).removeClass("visually-hidden-focusable");
    }

    $.ajax({
        url: dominio + 'ajax/formularios.ajax.php',
        method: "POST",
        data: {
            "tabla": "Participantes",
            "campo": "idParticipante",
            "dato": idParticipante
        },
        dataType: "json",
        success: function(participante) {
            $('#participante-name').text(participante.nombre);
            // console.log({participante: participante});
            $.ajax({
                url: dominio + 'ajax/formularios.ajax.php',
                method: "POST",
                data: {
                    "tabla": "Facturas",
                    "campo": "idParticipante",
                    "dato": idParticipante
                },
                dataType: "json",
                success: function(factura) {
                    // console.log({factura:factura});
                    var obs = "";
                    (factura.obs!="")?
                        obs = `
                        <div class="d-flex mt-3">
                            <span class="icon mt-0 rounded-circle d-flex me-3"><i class="far fa-sticky-note text-upa-main fs-6 m-auto"></i></span>
                            <p class="my-auto">${factura.obs}</p>
                        </div>`
                    :obs = "";
                    try{
                        $('#pills-tab').remove();
                        $('#pills-tabContent').remove();
                        $("#user-details").remove();
                    }catch(e){console.log("error al eliminar DOM");}
                    $($('#modalRevisar hr')[0]).after(`
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item w-50" role="presentation">
                                <button class="nav-link active text-secondary mx-auto w-100 py-1" id="user-details-tab" type="button" data-bs-toggle="pill" type="button" aria-selected="true" data-bs-target="#user-details" role="tab" aria-controls="user-details">
                                    <i class="fst-normal fw-bold">Datos personales</i>
                                </button>
                            </li>
                            <li class="nav-item w-50" role="presentation">
                                <button class="nav-link text-secondary mx-auto w-100 py-1" id="user-factura-tab" type="button" data-bs-toggle="pill" type="button" aria-selected="false" data-bs-target="#user-factura" role="tab" aria-controls="user-factura">
                                    <i class="fst-normal fw-bold">Facturación</i>
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="user-details text-secondary w-75 mx-auto mt-4 tab-pane fade show active" role="tabpanel" aria-labelledby="user-details-tab" id="user-details">
                                <div class="d-flex">
                                    <span class="icon mt-0 rounded-circle d-flex me-3"><i class="fas fa-phone-alt text-upa-main fs-6 m-auto"></i></span>
                                    <p class="my-auto">${participante.telefono}</p>
                                </div>
                                <div class="d-flex mt-3">
                                    <span class="icon mt-0 rounded-circle d-flex me-3"><i class="fas fa-hashtag text-upa-main fs-6 m-auto"></i></span>
                                    <p class="my-auto">${participante.curp}</p>
                                </div>
                                <div class="d-flex mt-3">
                                    <span class="icon mt-0 rounded-circle d-flex me-3"><i class="fas fa-home text-upa-main fs-6 m-auto"></i></span>
                                    <p class="my-auto">${participante.direc}</p>
                                </div>
                            </div>
                            <div class="user-details text-secondary w-75 mx-auto mt-4 tab-pane fade show" role="tabpanel" aria-labelledby="user-factura-tab" id="user-factura">
                                <div class="d-flex mt-3">
                                    <span class="icon mt-0 rounded-circle d-flex me-3"><i class="fas fa-address-card text-upa-main fs-6 m-auto"></i></span>
                                    <p class="my-auto">${factura.rfc}</p>
                                </div>
                                <div class="d-flex mt-3">
                                    <span class="icon mt-0 rounded-circle d-flex me-3"><i class="fas fa-file-alt text-upa-main fs-6 m-auto"></i></span>
                                    <p class="my-auto">${factura.cfdi}</p>
                                </div>
                                ${obs}
                            </div>
                        </div>
                    `);
                },
                error: function(){
                    try{
                        $('#pills-tab').remove();
                        $('#pills-tabContent').remove();
                        $("#user-details").remove();
                    }catch(e){console.log('Error al eliminar elementos');}
                    $($('#modalRevisar hr')[0]).after(`
                        <div class="user-details text-secondary w-75 mx-auto mt-4 tab-pane fade show active" role="tabpanel" aria-labelledby="user-details-tab" id="user-details">
                            <div class="d-flex">
                                <span class="icon mt-0 rounded-circle d-flex me-3"><i class="fas fa-phone-alt text-upa-main fs-6 m-auto"></i></span>
                                <p class="my-auto">${participante.telefono}</p>
                            </div>
                            <div class="d-flex mt-3">
                                <span class="icon mt-0 rounded-circle d-flex me-3"><i class="fas fa-hashtag text-upa-main fs-6 m-auto"></i></span>
                                <p class="my-auto">${participante.curp}</p>
                            </div>
                            <div class="d-flex mt-3">
                                <span class="icon mt-0 rounded-circle d-flex me-3"><i class="fas fa-home text-upa-main fs-6 m-auto"></i></span>
                                <p class="my-auto">${participante.direc}</p>
                            </div>
                        </div>
                    `);
                }
            });

            $.ajax({
                url: dominio + 'ajax/formularios.ajax.php',
                method: "POST",
                data: {
                    "tabla": "Pagos",
                    "campo": "idParticipante",
                    "dato": idParticipante
                },
                dataType: "json",
                success: function(resPago){
                    console.log({resPago: resPago});
                    (resPago["r2"]==1) ? 
                        $('#modalRevisar input[name="btnRev"]').removeAttr('disabled')
                    : $('#modalRevisar input[name="btnRev"]').prop('disabled',true); ;
                    try{
                        $(labels[8]).html('<b>Validación (Administración): </b>'+rev);
                    }catch(err){}
                    
                    $('#comprobante-revisar #precio').text(parseFloat(resPago.pago).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                    if(resPago.comprobante!==null){
                        $('#modalRevisar .pre-comprobante').hide();
                        $('#modalRevisar .modal-body img').attr({
                            "src": dominio + 'vistas/img/comprobantes/' + participante["idCurso"] + '/' + resPago["comprobante"],
                            "alt": resPago["comprobante"]
                        });
                        $('#modalRevisar .modal-body img').show();
                    }else {
                        $('#modalRevisar .modal-body img').hide();
                        $('#modalRevisar .modal-body img').attr({
                            "src": "",
                            "alt": ""
                        });
                        $('#modalRevisar .pre-comprobante').show();
                    }
                }
            });
        }
    });

            // -----------------------------------------
    //         let labels = $('#info-inscrito').find('p');
    //         // console.log(labels);
    //         $($('#info-inscrito h4')[0]).text(res["nombre"]);
    //         // $(labels[0]).text(res["nombre"]);
    //         $(labels[0]).html('<b>Correo: </b>' + res["correo"]);
    //         $(labels[1]).html('<b>Teléfono: </b>' + res["telefono"]);
    //         $(labels[2]).html('<b>Dirección: </b>' + res["direc"]);
    //         $(labels[3]).html('<b>CURP: </b>' + res["curp"]);

    //         $.ajax({
    //             url: dominio + 'ajax/formularios.ajax.php',
    //             method: "POST",
    //             data: {
    //                 "tabla": "Facturas",
    //                 "campo": "idParticipante",
    //                 "dato": tr.children('td')[0].className.split('-')[1]
    //             },
    //             dataType: "json",
    //             success: function(res) {
    //                 $(labels[4]).html('<b>RFC: </b>' + res["rfc"]);
    //             },
    //             error: function(){
    //                 $(labels[4]).html('<b>RFC: </b> Sin facturación');
    //             }
    //         });
    //         $(labels[5]).html('<b>Sexo: </b>' + ((res["sexo"] == "H") ? "Masculino" : "Femenino"));
    //         $(labels[6]).html('<b>Estado civil: </b>' + res["est_civil"]);
    //         $(labels[7]).html('<b>Curso: </b>' + tr.children('td')[4].innerText);
    //         let rev = "No validado";

    //         $.ajax({
    //             url: dominio + 'ajax/formularios.ajax.php',
    //             method: "POST",
    //             data: {
    //                 "tabla": "Pagos",
    //                 "campo": "idParticipante",
    //                 "dato": tr.children('td')[0].className.split('-')[1]
    //             },
    //             dataType: "json",
    //             success: function(resPago){
    //                 (resPago["r2"]==1) ? rev="Validado" : rev="No validado" ;
    //                 try{
    //                     $(labels[8]).html('<b>Validación (Administración): </b>'+rev);
    //                 }catch(err){}
                    
    //                 if(resPago["comprobante"]){
    //                     $('#modalRevisar .modal-body img').attr({
    //                         "src": dominio + 'vistas/img/comprobantes/' + res["idCurso"] + '/' + resPago["comprobante"],
    //                         "alt": resPago["comprobante"]
    //                     });
    //                 }else {
    //                     $('#modalRevisar .modal-body img').attr({
    //                         "src": "",
    //                         "alt": ""
    //                     });
    //                 }
    //             }
    //         });

    //         $('#idRev').val(res["idParticipante"]);
    //         $('#idRevCurso').val(res["idCurso"]);
    //     },
    //     error: function() {
    //         alert("err");
    //     }
    // });
}