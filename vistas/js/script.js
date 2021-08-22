$(document).ready(() => {

    $('#card0').hide();
    $('#card1').hide();
    $('#card2').hide();
    $('#card3').hide();

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
                // $('#card0').toggleClass("visually-hidden-focusable");
                break;
            case 1:
                $('#card1').toggle();
                // $('#card1').toggleClass("visually-hidden-focusable");
                break;
            case 2:
                $('#card2').toggle();
                // $('#card2').toggleClass("visually-hidden-focusable");
                break;
            case 3:
                $('#card3').toggle();
                // $('#card3').toggleClass("visually-hidden-focusable");
                break;
        }
    }

    console.log('$("#data-curso > div"): ', $('#data-curso > div'));

    // $(window).on('resize',()=>{
    //     $('#data-curso').height("auto");
    //     var h = $($('#data-curso > div')[0]).innerHeight();
    //     console.log('w: ',$(window).width());
    //     if($(window).width()>992){
    //         $('#data-curso').innerHeight(h);
    //     }else{
    //         $('#data-curso').innerHeight(h*2);
    //     }
    //     console.log('h: ', h);
    // })

    // $('.filepond--drop-label label').empty().text("Adjunta tu comprobante de pago aquí");

    $('#btnRegresar').on('click',function(){
        if(window.history.replaceState){
            window.history.replaceState(null,null,window.location.href);
        }

        $('#card1').slideUp('slow');

        $('#card1').hide('slow');
        $('#card0').show('slow');
        // $('#card1').attr("hidden","");
        // $('#card0').removeAttr("hidden");

        // $($('#header-cursos .cover')[0]).css({"background-image": "url("+dominio+"vistas/img/rsc/cover.jpg)"});
        
        $($('#header-cursos .cover')[0]).animate({opacity:0},500,()=>{
            $($('#header-cursos .cover')[0]).css({"background-image": "url("+dominio+"vistas/img/rsc/cover.jpg)"})
                                            .animate({opacity:1,height: "25rem"},500);
        });

        // $('#header-cursos h1').text("Cursos UPA");
        $('#header-cursos h1').animate({opacity:0},400,()=>{
            $('#header-cursos h1').text("Cursos UPA").animate({opacity:1},900);
        });

        st = 0;
        $('#step2').removeClass('btn-primary');
        $('#step2').addClass('btn-secondary');
        $('.progress-bar').css("width","0%");
        $('.progress-bar').attr("aria-valuenow","0");
        $('#formRegistro1')[0].reset();
    });

    $('#formRegistro1 input[type="text"]').focusin((e)=>{
        $(e['target']).parent().find('span').css({"color": "var(--upa-primary)"});
    });
    $('#formRegistro1 input[type="text"]').focusout((e)=>{
        $(e['target']).parent().find('span').css({"color": "var(--bs-dark)"});
    });

    $('#facturacion-form').hide();
    $('#facturacion-form .mb-3').hide();
});