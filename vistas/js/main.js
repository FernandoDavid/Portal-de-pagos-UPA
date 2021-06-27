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

function stepAlert(title, text){
    Swal.fire({
        title: title,
        icon: "info",
        text: text,
        showConfirmButton: true,
        confirmButtonText: "Entendido"
    });
}

function reg(element){    
    $("#curso").val(element.attributes[0].value);
    $(".titulo-curso")[0].innerText = element.innerText;
    $("#card0").toggleClass("visually-hidden-focusable");
    $("#card1").toggleClass("visually-hidden-focusable");
    
    $(".progress-bar").width(parseInt(100/3)+"%");
    $("#step2").toggleClass("btn-secondary btn-primary");
}