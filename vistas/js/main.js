const Toast = Swal.mixin({
    toast: true,
    position: "bottom-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer)
        toast.addEventListener("mouseleave", Swal.resumeTimer)
    }
});

function stepAlert(title, text) {
    Swal.fire({
        title: title,
        icon: "info",
        text: text,
        showConfirmButton: true,
        confirmButtonText: "Entendido"
    });
}

function reg(element,foto) {
    let idCurso = $($(element).closest('.cursos')[0]).attr("id");
    let cursoTitle = $($(element).closest('.cursos')[0]).find('.curso-title')[0].innerText;
    
    // console.log({"idCurso":idCurso,"curso":cursoTitle});
    $("#curso").val(idCurso);
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
        success: res=>{
            // console.log(res);
            let arr = res.temario.split('|||')[0].split('\r\n');
            // arr.forEach(e => {
            //     $('#data-curso').append(`<p>${e}</p>`);    
            // });
        }
    });

    if($(element).text()=="Ver más"){
        // $('#card0').addClass("animate__zoomOutDown").delay(1000).hide();
        // $('#card0').hide('slow');
        $($('#header-cursos .cover')[0]).animate({opacity:0},'slow',()=>{
            $($('#header-cursos .cover')[0]).css({"background-image": "url("+dominio+"vistas/img/banners/"+foto+")"})
                                            .animate({height: "15rem",opacity:1},'slow');
        });

        $('#card0').slideUp('slow');

        $('#header-cursos h1').animate({opacity:0},400,()=>{
            $('#header-cursos h1').text(cursoTitle).animate({opacity:1},800);
        });

        $('#card1').show('slow');
        // var h = $($('#data-curso > div')[0]).innerHeight();
        // if($(window).width()>992){
        //     $('#data-curso').innerHeight(h);
        // }else{
        //     $('#data-curso').innerHeight(h*2);
        // }
        // console.log('h',h);
    }
    else{
        $('#card0').slideUp('slow');
        // $('#card0').hide('slow');
        // $('#card0').removeAttr("hidden");
    }

    // if($(element).text()=="Regresar"){
    //     $('#card1').attr("hidden","");
    // }else{ 
        
    // } 

    stepAlert("Paso 2: Registro", "Ingresa tus datos personales..");
    $(".progress-bar").width(parseInt(100 / 3) + "%");
    $("#step2").toggleClass("btn-secondary btn-primary");
    // $(".progress-bar").animate({width:parseInt(100 / 3)+"%"},'fast',()=>{
    //     $("#step2").toggleClass("btn-secondary btn-primary");
    // });
}

function mostrarFactura(){
    // var facturacion=document.getElementById("facturacion-form");
    var checkfactura=document.getElementById("checkfactura");
    var i1=document.getElementById("rfc");
    var i2=document.getElementById("cfdi");
    if(checkfactura.checked==true){
        // $('#facturacion-form').attr("hidden","false");
        $('#facturacion-form').show();
        $('#facturacion-form .mb-3').map((e)=>{
            $($('#facturacion-form .mb-3')[e]).show('fast');
        });
        i1.required=true;
        i2.required=true;
    }
    else if (checkfactura.checked==false){
        $('#facturacion-form .mb-3').map((e)=>{
            $($('#facturacion-form .mb-3')[e]).hide('fast');
        });
        i1.required=false;
        i2.required=false;
        // $('#facturacion-form').attr("hidden","true");
    }
}

$(window).scroll(()=>{
    var header = $('#header-cursos').outerHeight();
    // console.log(header);
    if($(this).scrollTop() > header){
        $('#steps').addClass('sticky-top');
    }else{
        $('#steps').removeClass('sticky-top');
    }
});