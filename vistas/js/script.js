$(document).ready(() => {

    var url = window.location.href;
    if(url.includes("admin")){
        // console.log("admin");
        $('body').addClass("bg-light");

        $('.modal-body input').focusin((e)=>{
            $(e['target']).parent().find('span').css({"color": "var(--upa-primary)"});
        });
        $('.modal-body input').focusout((e)=>{
            $(e['target']).parent().find('span').css({"color": "var(--bs-dark)"});
        });

        $('.modal-body select').focusin((e)=>{
                // console.log($(e['target']).parent().find('label'));
                $(e['target']).parent().find('label').css({"color": "var(--upa-primary)"});
        });
        $('.modal-body select').focusout((e)=>{
                // console.log($(e['target']).parent().find('label'));
                $(e['target']).parent().find('label').css({"color": "var(--bs-dark)"});
        });

        $('.modal-body input[type="file"]').focusin((e)=>{
            $(e['target']).parent().find('span').css({"color": "#fff"});
        });
        $('.modal-body input[type="file"]').focusout((e)=>{
            $(e['target']).parent().find('span').css({"color": "#fff"});
        });

        $('.modal-body input.file-caption-name').focusin((e)=>{
            $(e['target']).parent().find('span').css({"color": "#fff"});
            $(e['target']).parent().find('.btn-primary').css({"background-position": "right center"});
        });
        $('.modal-body input.file-caption-name').focusout((e)=>{
            $(e['target']).parent().find('span').css({"color": "#fff"});
            $(e['target']).parent().find('.btn-primary').css({"background-position": "left center"});
        });

    }else{
        if(url.includes("login")){
            $('body').addClass("bg-light-gray");

            $('#form-login input').focusin((e)=>{
                $(e['target']).parent().find('span').css({"color": "var(--upa-primary)"});
            });
            $('#form-login input').focusout((e)=>{
                $(e['target']).parent().find('span').css({"color": "var(--bs-dark)"});
            });

        }else{
            // console.log("registro");
            $('body').addClass("bg-light-gray");
        }
    }

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    $('#card0').hide();
    $('#card1').hide();
    $('#card2').hide();
    $('#card3').hide();

    // $("#temario-curso ul").mCustomScrollbar({
    //     theme: 'minimal'
    // });

    $('#step1').click(() => {
        stepAlert("Paso 1: Elección", "Selecciona tu curso..");
    });
    $('#step2').click(() => {
        stepAlert("Paso 2: Registro", "Ingresa tus datos personales..");
    });
    $('#step3').click(() => {
        stepAlert("Paso 3: Comprobante de pago", "Adjunta tu comprobante de pago..");
    });
    $('#step4').click(() => {
        stepAlert("Paso 4: Confirmación", "Revisa tu información..");
    });

    if (st >= 0) {
        $('#loader').toggleClass("visually-hidden-focusable");
        switch (st) {
            case 0:
                $('#card0').toggle();
                break;
            case 1:
                $('#card1').toggle();
                break;
            case 2:
                $('#card2').toggle();
                break;
            case 3:
                $('#card3').toggle();
                break;
        }
    }

    // $('.filepond--drop-label label').empty().text("Adjunta tu comprobante de pago aquí");

    // var Cleave = require('cleave.js');
    var tel = new Cleave('.telefono-input',{
        phone: true,
        phoneRegionCode: 'MX'
    });

    $('#btnRegresar').on('click',function(){
        // $('#btnRegresar').removeAttr("data-bs-toggle");
        if(window.history.replaceState){
            window.history.replaceState(null,null,window.location.href);
        }

        $('#card1').slideUp('slow');

        $('#card1').hide('slow');
        $('#card0').show('slow');
        
        $($('#header-cursos .cover')[0]).animate({opacity:0},500,()=>{
            $($('#header-cursos .cover')[0]).css({"background-image": "url("+dominio+"vistas/img/rsc/cover.jpg)"})
                                            .animate({opacity:1,height: "25rem"},500);
        });

        $('#header-cursos h1').animate({opacity:0},400,()=>{
            $('#header-cursos h1').text("Cursos UPA").animate({opacity:1},900);
        });

        st = 0;
        $('#step2').removeClass('btn-primary');
        $('#step2').addClass('btn-secondary');
        $('.progress-bar').css("width","0%");
        $('.progress-bar').attr("aria-valuenow","0");
        $('#formRegistro1')[0].reset();

        $('#btnRegresar').tooltip('hide');
    });

    $('#formRegistro1 input[type="text"], #formRegistro1 select').focusin((e)=>{
        $(e['target']).parent().find('span').css({"color": "var(--upa-primary)"});
    });
    $('#formRegistro1 input[type="text"], #formRegistro1 select').focusout((e)=>{
        $(e['target']).parent().find('span').css({"color": "var(--bs-dark)"});
    });

    $('#facturacion-form').hide();
    $('#facturacion-form .mb-3').hide();

});