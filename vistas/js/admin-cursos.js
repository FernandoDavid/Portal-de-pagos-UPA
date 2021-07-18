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
                "tabla": "inscritos",
                "campo": "idInscrito",
                "dato": tr.children('td')[0].className.split('-')[1]
            },
            dataType: "json",
            async: true,
            success: function(res) {
                let inputs = $('#modalModificarAlumno').find('input');
                $(inputs[0]).val(tr.children('td')[0].className.split('-')[1]);
                $(inputs[1]).val(res["nombre"]);
                $(inputs[2]).val(res["telefono"]);
                $(inputs[3]).val(res["direc"]);
                $(inputs[4]).val(res["correo"]);
                (res["sexo"] == "H") ? inputs[6].checked = true: inputs[7].checked = true;
                $(inputs[5]).val(res["curp"]);
                $(inputs[8]).val(res["rfc"]);
                (res["est_civil"] == "soltero") ? inputs[9].checked = true: inputs[10].checked = true;
                $($('#modalModificarAlumno').find('select')[0]).val(res["idCurso"]);
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
                "tabla": "cursos",
                "campo": "idCurso",
                "dato": tr.children('td')[0].className.split('-')[1]
            },
            dataType: "json",
            async: true,
            success: function(res) {
                let inputs = $('#modalModificarCurso').find('input');
                $(inputs[0]).val(tr.children('td')[0].className.split('-')[1]);
                $(inputs[1]).val(res["curso"]);
                $(inputs[2]).val(res["instructor"]);
                $(inputs[3]).val(res["lugar"]);
                $('#modalModificarCurso').find('textarea').val(res["desc"]);
                $(inputs[4]).val(res["precio"]);
                $(inputs[5]).val(res["cupo"]);
                $(inputs[6]).val(res["fec_inicio"]);
                $(inputs[7]).val(res["fec_fin"]);
                $(inputs[8]).val(res["hora_inicio"]);
                $(inputs[9]).val(res["hora_fin"]);
                $(inputs[10]).val(res["descto"]);
            },
            error: function(err) {
                console.log("Error",err);
            }
        });
    });

    $(".btnEliminarCurso").on('click', function() {
        $('#modalEliminarCurso').modal('show');
        var $tr = $(this).closest('tr');

        $('#idCursoEliminar').val($tr.children('td')[0].className.split('-')[1]);
    });

    $(".btnComprobante").on('click', function() {
        $('#modalRevisar').modal('show');
        var tr = $(this).closest('tr');

        $.ajax({
            url: dominio + 'ajax/formularios.ajax.php',
            method: "POST",
            data: {
                "tabla": "inscritos",
                "campo": "idInscrito",
                "dato": tr.children('td')[0].className.split('-')[1]
            },
            dataType: "json",
            success: function(res) {
                let labels = $('#info-inscrito').children();
                $(labels[0]).text(res["nombre"]);
                $(labels[2]).html('<b>Correo: </b>' + res["correo"]);
                $(labels[3]).html('<b>Teléfono: </b>' + res["telefono"]);
                $(labels[4]).html('<b>Dirección: </b>' + res["direc"]);
                $(labels[5]).html('<b>CURP: </b>' + res["curp"]);
                $(labels[6]).html('<b>RFC: </b>' + res["rfc"]);
                $(labels[7]).html('<b>Sexo: </b>' + ((res["sexo"] == "H") ? "Masculino" : "Femenino"));
                $(labels[8]).html('<b>Estado civil: </b>' + res["est_civil"]);
                $(labels[9]).html('<b>Curso: </b>' + tr.children('td')[4].innerText);
                let rev = "No validado";
                (res["rev2"]) ? rev="Validado" : rev="No validado" ;
                $(labels[10]).html('<b>Validación (Administración): </b>'+rev);
                if (res["pago"]) {
                    $('#modalRevisar .modal-body img').attr({
                        "src": dominio + 'vistas/img/comprobantes/' + res["idCurso"] + '/' + res["pago"],
                        "alt": res["pago"]
                    });
                } else {
                    $('#modalRevisar .modal-body img').attr({
                        "src": "",
                        "alt": ""
                    });
                }

                $('#idRev').val(res["idInscrito"]);
                $('#idRevCurso').val(res["idCurso"]);
                if (res[campo]) {
                    $($('#modalRevisar .modal-footer')[0]).addClass("visually-hidden-focusable");
                } else {
                    $($('#modalRevisar .modal-footer')[0]).removeClass("visually-hidden-focusable");
                }
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