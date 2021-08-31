function search(e){
    var txt = $(e).val();
    var name = $(e).attr("name");
    // console.log({name:name});

    var datos={};
    switch(name){
        case 'searchPendientesAdm':
            datos = {
                "coincidencia":txt,
                "campo": "r2",
                "if": 0
            };
            nameCont = "adminPendientes";
        ;break;
        case 'searchPendientesPos':
            datos = {
                "coincidencia":txt,
                "campo": "r1",
                "if": 0
            };
            nameCont = "posPendientes";
        ;break;
        case 'searchInscritosPos':
            datos = {
                "coincidencia":txt,
                "campo": "r1",
                "if": 1
            };
            nameCont = "posInscritos";
        ;break;
    }

    $.ajax({
        url: dominio + 'ajax/formularios.ajax.php',
        method: 'POST',
        crossDomain: true,
        data: datos,
        dataType: "json",
        async: true,
        success: function(res) {
            // console.log(res);
            // console.log(nameCont);
            let container = $('.searchContainer[name="'+nameCont+'"]'); 
            container.empty();
            if(res.length>0){
                res.forEach((element,index) => { 
                    // console.log(element);
                    if(name=="searchPendientesAdm"){
                        let comp = (element.comprobante)?'btn-primary':''; 
                        container.append(`
                        <tr>
                            <td class="i-${element.idParticipante}">
                                ${index+1}
                            </td>
                            <td>
                                ${element.nombre}
                            </td>
                            <td>
                                ${element.correo}
                            </td>
                            <td>
                                ${element.curp}
                            </td>
                            <td class="c-${element.idCurso}">
                                ${element.curso}
                            </td>
                            <td>
                                <button type="submit" class="btn p-1 ${comp} btnComprobante position-relative" onclick="comprobante(this)">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                </button>
                            </td>
                        </tr>
                        `);
                    }else{
                        var btn = `
                        <td>
                            <button type="button" class="btn p-1 btn-primary btnComprobante" onclick="comprobante(this)"><i
                                class="fas fa-file-invoice-dollar"></i></button>
                        </td>
                        `;
                        if(datos.if==0){
                            let comp = (element.comprobante)?'btn-primary':''; 
                            // console.log({element:element,campo:datos.campo,r: element[datos.campo]});
                            let span = (element.r2==1) ? `<span class="position-absolute mt-1 top-0 start-100 translate-middle p-2 bg-danger rounded-circle"><span class="visually-hidden"></span></span>` : ``;
                            btn = `
                            <td>
                                <button type="button" class="btn p-1 ${comp} btnComprobante position-relative" onclick="comprobante(this)">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    ${span}
                                </button>
                            </td>
                            `;
                        }
                        container.append(`
                        <tr>
                            <td class="i-${element.idParticipante}">
                                ${index+1}
                            </td>
                            <td>
                                ${element.nombre}
                            </td>
                            <td>
                                ${element.correo}
                            </td>
                            <td>
                                ${element.curp}
                            </td>
                            <td class="c-${element.idCurso}">
                                ${element.curso}
                            </td>
                            ${btn}
                            <td>
                                <button type="button" class="btn p-1 btnEditarAlumno" onclick="editarParticipante(this)"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar aspirante">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button type="button" class="btn p-1 btnEliminarAlumno" onclick="eliminarParticipante(this)"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Eliminar aspirante">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        `);
                    }
                    
                });
            }else{

            }
            
        },
        error: function(err) {
            console.log("ERR",err);
        }
    }).done(()=>{
        tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
}