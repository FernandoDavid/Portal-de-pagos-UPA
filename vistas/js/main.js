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

function reg(element, foto) {
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
        success: res => {
            // console.log(res);
            (res.tipo == 0) ? res.tipo = "diplomado" : res.tipo = "curso";
            $('#data-curso .invitacion').text(`¡Inscríbete al ${res.tipo}!`);
            $('#data-curso .curso-title').text(res.curso);
            $('#data-curso .curso-obj').text(res.objetivo);
            (res.modalidad == 0) ? res.modalidad = "Presencial" : res.modalidad = "En línea";
            $($('#data-curso .curso-feature h6.text-secondary')[0]).text(res.modalidad);
            $($('#data-curso .curso-feature h6.text-secondary')[1]).text(res.aula);

            // Formateo de fechas
            var fec_inicio = new Date(res.fec_inicio);
            fec_inicio = (fec_inicio.getDate() + 1) + '/' + ((fec_inicio.getMonth() + 1 < 10) ? '0' + fec_inicio.getMonth() + 1 : fec_inicio.getMonth() + 1) + '/' + fec_inicio.getFullYear();
            var fec_fin = new Date(res.fec_fin);
            fec_fin = (fec_fin.getDate() + 1) + '/' + ((fec_fin.getMonth() + 1 < 10) ? '0' + fec_fin.getMonth() + 1 : fec_fin.getMonth() + 1) + '/' + fec_fin.getFullYear();

            // Formateo de horas
            var hora_inicio = new Date(res.fec_inicio + ' ' + res.hora_inicio);
            hora_inicio = (("0" + hora_inicio.getHours()).slice(-2)) + ':' + (("0" + hora_inicio.getMinutes()).slice(-2));
            var hora_fin = new Date(res.fec_fin + ' ' + res.hora_fin);
            hora_fin = (("0" + hora_fin.getHours()).slice(-2)) + ':' + (("0" + hora_fin.getMinutes()).slice(-2));

            (res.dia == "sabado") ? res.dia = "Sábado" : ((res.dia == "miercoles") ? res.dia = "Miércoles" : null);
            $($('#data-curso .curso-feature h6')[4]).text(res.dia);

            $($('#data-curso .curso-feature h6.text-secondary')[2]).text(`${fec_inicio} - ${fec_fin}`);
            $($('#data-curso .curso-feature h6.text-secondary')[3]).text(`${hora_inicio} - ${hora_fin}`);
            $($('#data-curso .precios h5')[0]).text(parseFloat(res.precio).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            $($('#data-curso .precios h5')[1]).text((parseFloat(res.precio) * (1 - parseFloat(res.desc) / 100)).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

            let arr = res.temario.split('|||')[0].split('\r\n');
            $('#temario-curso .list-group').empty();
            
            arr.forEach((e,i) => {
                let tema = e.split(':')[1].trim();
                let html = `
                <li>
                    <div class="col-12 d-flex">
                        <span class="rounded-circle align-self-center text-white p-2 d-flex"><h1 class="m-auto fs-4 fw-bold">${convertToRoman(i+1)}</h1></span>
                        <div class="my-auto ms-3">
                            <h6 class="fw-bold mb-0 text-uppercase">Unidad ${convertToRoman(i+1)}</h6>
                            <h6 class="fw-lighter text-white mb-0">${tema}</h6>
                        </div>
                    </div>
                </li>
                `;
                $('#temario-curso .list-group').append(html);    
            });
        }
    }).done(()=>{
        $("#temario-curso ul").mCustomScrollbar({
            theme: 'minimal'
        });
    });

    if ($(element).text() == "Ver más") {
        $('#btnRegresar').attr("data-bs-toggle", "tooltip");
        $($('#header-cursos .cover')[0]).animate({ opacity: 0 }, 'slow', () => {
            $($('#header-cursos .cover')[0]).css({ "background-image": "url(" + dominio + "vistas/img/banners/" + foto + ")" })
                .animate({ height: "15rem", opacity: 1 }, 'slow');
        });

        $('#card0').slideUp('slow');

        $('#header-cursos h1').animate({ opacity: 0 }, 400, () => {
            $('#header-cursos h1').text(cursoTitle).animate({ opacity: 1 }, 800);
        });

        $('#card1').show('slow');
    }
    else {
        $('#card0').slideUp('slow');
    }

    stepAlert("Paso 2: Registro", "Ingresa tus datos personales..");
    $(".progress-bar").width(parseInt(100 / 3) + "%");
    $("#step2").toggleClass("btn-secondary btn-primary");
}

function mostrarFactura() {
    // var facturacion=document.getElementById("facturacion-form");
    var checkfactura = document.getElementById("checkfactura");
    var i1 = document.getElementById("rfc");
    var i2 = document.getElementById("cfdi");
    if (checkfactura.checked == true) {
        // $('#facturacion-form').attr("hidden","false");
        $('#facturacion-form').show();
        $('#facturacion-form .mb-3').map((e) => {
            $($('#facturacion-form .mb-3')[e]).show('fast');
        });
        i1.required = true;
        i2.required = true;
    }
    else if (checkfactura.checked == false) {
        $('#facturacion-form .mb-3').map((e) => {
            $($('#facturacion-form .mb-3')[e]).hide('fast');
        });
        i1.required = false;
        i2.required = false;
        // $('#facturacion-form').attr("hidden","true");
    }
}

const convertToRoman = (num)=>{
    var lookup = { M: 1000, CM: 900, D: 500, CD: 400, C: 100, XC: 90, L: 50, XL: 40, X: 10, IX: 9, V: 5, IV: 4, I: 1 }, roman = '', i;

    for (i in lookup) {
        while (num >= lookup[i]) {
            roman += i;
            num -= lookup[i];   
        }
    }
    return roman;
}

$(window).scroll(() => {
    var header = $('#header-cursos').outerHeight();
    // console.log(header);
    if ($(this).scrollTop() > header) {
        $('#steps').addClass('sticky-top');
    } else {
        $('#steps').removeClass('sticky-top');
    }
});