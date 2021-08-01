$(document).ready(function() {

    $('body').addClass('admin-body').attr("id", "body-pd");

    $(".btnEditarAlumno").on('click', function() {
        $('#modalModificarAlumno').modal('show');
        let tr = $(this).closest('tr');

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
    });

    $(".btnEliminarAlumno").on('click', function() {
        $('#modalEliminarAlumno').modal('show');
        var $tr = $(this).closest('tr');

        $('#idAlumnoEliminar').val($tr.children('td')[0].className.split('-')[1]);
    });

    $(".btnModificarCurso").on('click', function() {
        $('#modalModificarCurso').modal('show');
        let tr = $(this).closest('tr');

        $.ajax({
            url: dominio + 'ajax/formularios.ajax.php',
            method: 'POST',
            data: {
                "tabla": "Cursos",
                "campo": "idCurso",
                "dato": tr.children('td')[0].className.split('-')[1]
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
                    $('#idCursoModificar').val(tr.children('td')[0].className.split('-')[1]);
                    if(keys[i]=="temario"){
                        let str = res[keys[i]].split('|||');
                        console.log(str);
                        $("#modalModificarCurso [name='temario']").val(str[0]);
                        $("#modalModificarCurso [name='recursos']").val(str[1]);
                        $("#modalModificarCurso [name='materiales']").val(str[2]);
                    }else{
                        if(keys[i]=="flyer"){
                            url = dominio+'vistas/img/flyers/'+res[keys[i]];
                            console.log(url);
                            $('#editFlyer').fileinput({
                                uploadAsync: false,
                                showUpload: false,
                                required: true,
                                overwriteInitial: false,
                                // minFileCount: 1,
                                maxFileCount: 1,
                                validateInitialCount: true,
                                initialPreviewAsData: true,                   
                                initialPreview: [url],                            
                                initialPreviewConfig: [{
                                    // caption: res[keys[i]],
                                    url: dominio + 'ajax/formularios.ajax.php',
                                    type: 'image',
                                    key: Number.parseInt(tr.children('td')[0].className.split('-')[1])
                                    // filename: 
                                }]
                            });
                        }else{
                            $(selector).val(res[keys[i]]);
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
        console.log('Key = ' + key);
    });

    $(".btnEliminarCurso").on('click', function() {
        $('#modalEliminarCurso').modal('show');
        var $tr = $(this).closest('tr');

        $('#idCursoEliminar').val($tr.children('td')[0].className.split('-')[1]);
    });

    $(".btnComprobante").on('click', function() {
        $('#modalRevisar').modal('show');

        let tipo = $(this).closest('tr').parent().parent().parent().parent().attr("id");
        // console.log(tipo);
        if (tipo=="inscritosTable") {
            $($('#modalRevisar .modal-footer')[0]).addClass("visually-hidden-focusable");
        } else {
            $($('#modalRevisar .modal-footer')[0]).removeClass("visually-hidden-focusable");
        }
        var tr = $(this).closest('tr');

        $.ajax({
            url: dominio + 'ajax/formularios.ajax.php',
            method: "POST",
            data: {
                "tabla": "Participantes",
                "campo": "idParticipante",
                "dato": tr.children('td')[0].className.split('-')[1]
            },
            dataType: "json",
            success: function(res) {
                let labels = $('#info-inscrito').find('p');
                // console.log(labels);
                $($('#info-inscrito h4')[0]).text(res["nombre"]);
                // $(labels[0]).text(res["nombre"]);
                $(labels[0]).html('<b>Correo: </b>' + res["correo"]);
                $(labels[1]).html('<b>Teléfono: </b>' + res["telefono"]);
                $(labels[2]).html('<b>Dirección: </b>' + res["direc"]);
                $(labels[3]).html('<b>CURP: </b>' + res["curp"]);

                $.ajax({
                    url: dominio + 'ajax/formularios.ajax.php',
                    method: "POST",
                    data: {
                        "tabla": "Facturas",
                        "campo": "idParticipante",
                        "dato": tr.children('td')[0].className.split('-')[1]
                    },
                    dataType: "json",
                    success: function(res) {
                        $(labels[4]).html('<b>RFC: </b>' + res["rfc"]);
                    },
                    error: function(){
                        $(labels[4]).html('<b>RFC: </b> Sin facturación');
                    }
                });
                $(labels[5]).html('<b>Sexo: </b>' + ((res["sexo"] == "H") ? "Masculino" : "Femenino"));
                $(labels[6]).html('<b>Estado civil: </b>' + res["est_civil"]);
                $(labels[7]).html('<b>Curso: </b>' + tr.children('td')[4].innerText);
                let rev = "No validado";

                $.ajax({
                    url: dominio + 'ajax/formularios.ajax.php',
                    method: "POST",
                    data: {
                        "tabla": "Pagos",
                        "campo": "idParticipante",
                        "dato": tr.children('td')[0].className.split('-')[1]
                    },
                    dataType: "json",
                    success: function(resPago){
                        (resPago["r2"]) ? rev="Validado" : rev="No validado" ;
                        try{
                            $(labels[8]).html('<b>Validación (Administración): </b>'+rev);
                        }catch(err){}
                        
                        if(resPago["comprobante"]){
                            $('#modalRevisar .modal-body img').attr({
                                "src": dominio + 'vistas/img/comprobantes/' + res["idCurso"] + '/' + resPago["comprobante"],
                                "alt": resPago["comprobante"]
                            });
                        }else {
                            $('#modalRevisar .modal-body img').attr({
                                "src": "",
                                "alt": ""
                            });
                        }
                    }
                });

                $('#idRev').val(res["idParticipante"]);
                $('#idRevCurso').val(res["idCurso"]);
            },
            error: function() {
                alert("err");
            }
        });
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