$(document).ready(() => {
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
                $('#card0').toggleClass("visually-hidden-focusable");
                break;
            case 1:
                $('#card1').toggleClass("visually-hidden-focusable");
                break;
            case 2:
                $('#card2').toggleClass("visually-hidden-focusable");
                break;
            case 3:
                $('#card3').toggleClass("visually-hidden-focusable");
                break;
        }
    }

    $('.filepond--drop-label label').empty().text("Adjunta tu comprobante de pago aquí");
});