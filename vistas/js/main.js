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

function reg(element) {
    // console.log($(element).text());
    $("#curso").val(element.attributes[0].value);
    $(".titulo-curso")[0].innerText = 'Inscripción: '+$($(element).closest('.cursos')[0]).find('.curso-title')[0].innerText;
    ($(element).text()=="Tomar el curso")? $('#card0').attr("hidden","") : $('#card0').removeAttr("hidden"); 
    ($(element).text()=="Regresar")? $('#card1').attr("hidden","") : $('#card1').removeAttr("hidden"); 
    // $("#card0").toggleClass("visually-hidden-focusable");
    // $("#card1").toggleClass("visually-hidden-focusable");

    stepAlert("Paso 2: Registro", "Ingresa tus datos personales..");
    $(".progress-bar").width(parseInt(100 / 3) + "%");
    $("#step2").toggleClass("btn-secondary btn-primary");
}