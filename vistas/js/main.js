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
    console.log(element);
    $("#curso").val(element.attributes[0].value);
    $(".titulo-curso")[0].innerText = element.children[0].innerText;
    $("#card0").toggleClass("visually-hidden-focusable");
    $("#card1").toggleClass("visually-hidden-focusable");

    stepAlert("Paso 2: Registro", "Ingresa tus datos personales..");
    $(".progress-bar").width(parseInt(100 / 3) + "%");
    $("#step2").toggleClass("btn-secondary btn-primary");
}

// function fillData(tabla, item, id) {
//     var datos = {
//         "tablaFD": tabla,
//         "itemFD": item,
//         "idFD": id
//     }
//     // console.log("datos:");
//     // console.log(datos);
//     console.log("2");
//     var dat = new Array();
//     $.ajax({
//         url: dominio + 'ajax/formularios.ajax.php',
//         method: 'POST',
//         data: datos,
//         dataType: "json",
//         async: true,
//         success: function (res) {
//             console.log("3");
//             // console.log("exito");
//             // console.log(res);
//             return res;
//         },
//         error: function (err) {
//             console.log(err);
//         }
//     });
// }