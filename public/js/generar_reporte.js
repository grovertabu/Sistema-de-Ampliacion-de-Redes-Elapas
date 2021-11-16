var formulario = document.getElementById('formReporteInversion');
const btnMaterial = document.getElementById('btnMateriales');
const btnManoObra = document.getElementById('btnManoObra');

function convertirPDF() {
    const element = document.querySelector('#respuesta');
    element.style.display = "block";
    console.log(element)
    const formulario = document.querySelector('#formulario');
    var opt = {
        margin: 0.5,
        filename: 'informe.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'legal', orientation: 'p' }
    };
    html2pdf().set(opt).from(element).outputPdf().then(function (pdf) {
        pdf = btoa(pdf);
        console.log(pdf.length)
        var obj = document.createElement('embed');
        const cardPDF = document.getElementById('cardPDF')
        obj.style.width = '100%';
        obj.style.height = window.screen.height + 'px';
        obj.style.margin = '-10px'
        obj.style.position = 'absolute'
        obj.type = 'application/pdf';
        obj.src = 'data:application/pdf;base64,' + pdf;
        formulario.style.display = 'none';
        document.getElementById('btnVolver').style.display = 'block';
        cardPDF.appendChild(obj);
        cardPDF.style.display = "block";

        // var obj = document.createElement('iframe');
        // obj.style.width = '100%';
        // obj.style.height = window.screen.height + 'px';
        // obj.style.margin = '-10px'
        // obj.style.position = 'absolute'
        // obj.type = 'application/pdf';
        // obj.src = 'data:application/pdf;base64,' + pdf;
        // element.style.display = 'none';
        // document.body.appendChild(obj);


    });
}

function ocultarVolver() {
    const volver = document.getElementById('btnVolver');
    const formulario = document.getElementById('formulario');
    document.getElementById('respuesta').style.display = 'none';
    document.getElementById('cardPDF').style.display = 'none';
    volver.style.display = "none";
    formulario.style.display = "block";
}


formulario.addEventListener('submit', (e) => {
    e.preventDefault();
    const fecha_i = new Date(document.getElementById('fecha_i').value).getTime();
    const fecha_h = new Date(document.getElementById('fecha_h').value).getTime();
    if (fecha_i <= fecha_h) {
        $.post(e.target.action, $("#formReporteInversion").serialize(), (data) => {
            let indice = 0;
            let num = 1;
            let cantidad_elp = 0;
            let cantidad_vecinos = 0;
            let sub_total_elp = 0;
            let sub_total_vecinos = 0;
            let costo_total = 0;
            console.log(data)
            filtrar_data_materiales(data, 'materiales', num, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos, indice, sub_total_elp, sub_total_vecinos, costo_total);
            indice = 0;
            num = 1;
            cantidad = 0;
            sub_total = 0;
            filtrar_data_mano_obra(data, 'mano_obras', num, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos, indice, sub_total_elp, sub_total_vecinos, costo_total);
            convertirPDF();
        });

    } else {
        Swal.fire({
            icon: 'error',
            title: 'Fecha no válida',
            text: 'Elija un rango de fechas válido',
        })
    }
})

function filtrar_data_materiales(data, dato_tabla, num, cantidad_elp, cantidad_vecinos, indice, sub_total_elp, sub_total_vecinos, costo_total) {
    if (data[dato_tabla] != null) {
        document.getElementById('tbody_materiales').innerHTML = "";
        document.getElementById('div_materiales').style.display = "block";
        for (let i = 0; i < data[dato_tabla].length; i++) {
            if (indice != 0) {
                if (indice == data[dato_tabla][i].material_id) {
                    console.log("repetir")
                    data[dato_tabla][i].observador == "Elapas" ? cantidad_elp = cantidad_elp + data[dato_tabla][i].cantidad : cantidad_vecinos = cantidad_vecinos + data[dato_tabla][i].cantidad;
                    // console.log(data[i].precio_uni + '*' + data[i].cantidad)
                    data[dato_tabla][i].observador == "Elapas" ? sub_total_elp = sub_total_elp + Math.round10(data[dato_tabla][i].precio_unitario * data[dato_tabla][i].cantidad, -2) : sub_total_vecinos = sub_total_vecinos + Math.round10(data[dato_tabla][i].precio_unitario * data[dato_tabla][i].cantidad, -2);
                    if (i == data[dato_tabla].length - 1) {
                        dibujar_tabla(num++, dato_tabla, data[dato_tabla][i].nombre_material, data[dato_tabla][i].u_medida, data[dato_tabla][i].precio_unitario, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos);
                    }
                } else {
                    console.log("añadir")
                    dibujar_tabla(num++, dato_tabla, data[dato_tabla][i - 1].nombre_material, data[dato_tabla][i - 1].u_medida, data[dato_tabla][i - 1].precio_unitario, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos);
                    cantidad_elp = 0;
                    cantidad_vecinos = 0;
                    sub_total_elp = 0;
                    sub_total_vecinos = 0;
                    indice = data[dato_tabla][i].material_id;
                    i = i - 1;

                }
            } else {
                console.log("primero")
                indice = data[dato_tabla][i].material_id;
                i = -1;
            }

        }
    } else {
        document.getElementById('div_materiales').style.display = "none";
    }

}

function filtrar_data_mano_obra(data, dato_tabla, num, cantidad_elp, cantidad_vecinos, indice, sub_total_elp, sub_total_vecinos, costo_total) {
    if (data[dato_tabla] != null) {
        document.getElementById('tbody_mano_obras').innerHTML = "";
        document.getElementById('div_mano_obras').style.display = "block"
        for (let i = 0; i < data[dato_tabla].length; i++) {
            if (indice != 0) {
                if (indice == data[dato_tabla][i].actividad_id) {
                    console.log("repetir")
                    data[dato_tabla][i].observador == "Elapas" ? cantidad_elp = cantidad_elp + data[dato_tabla][i].cantidad : cantidad_vecinos = cantidad_vecinos + data[dato_tabla][i].cantidad;
                    // console.log(data[i].precio_uni + '*' + data[i].cantidad)
                    data[dato_tabla][i].observador == "Elapas" ? sub_total_elp = sub_total_elp + Math.round10(data[dato_tabla][i].precio_uni * data[dato_tabla][i].cantidad, -2) : sub_total_vecinos = sub_total_vecinos + Math.round10(data[dato_tabla][i].precio_uni * data[dato_tabla][i].cantidad, -2);
                    if (i == data[dato_tabla].length - 1) {
                        dibujar_tabla(num++, dato_tabla, data[dato_tabla][i].descripcion, data[dato_tabla][i].unidad_medida, data[dato_tabla][i].precio_uni, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos);
                    }
                } else {
                    console.log("añadir")
                    dibujar_tabla(num++, dato_tabla, data[dato_tabla][i - 1].descripcion, data[dato_tabla][i - 1].unidad_medida, data[dato_tabla][i - 1].precio_uni, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos);
                    cantidad_elp = 0;
                    cantidad_vecinos = 0;
                    sub_total_elp = 0;
                    sub_total_vecinos = 0;
                    indice = data[dato_tabla][i].actividad_id;
                    i = i - 1;

                }
            } else {
                console.log("primero")
                indice = data[dato_tabla][i].actividad_id;
                i = -1;
            }

        }

    } else {
        document.getElementById('div_mano_obras').style.display = 'none';
    }
}


function dibujar_tabla(num, tabla, descripcion, unidad, precio, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos) {
    tr_inversion = document.createElement('tr');
    td_num = document.createElement('td');
    td_actividad = document.createElement('td');
    td_precio = document.createElement('td');
    td_cantidad_elp = document.createElement('td');
    td_cantidad_vecinos = document.createElement('td');
    td_unidad = document.createElement('td');
    td_sub_total_elp = document.createElement('td');
    td_sub_total_vecinos = document.createElement('td');
    td_actividad.innerText = descripcion;
    td_cantidad_elp.innerText = cantidad_elp;
    td_cantidad_vecinos.innerText = cantidad_vecinos;
    td_unidad.innerText = unidad
    td_sub_total_elp.innerText = sub_total_elp;
    td_sub_total_vecinos.innerText = sub_total_vecinos;
    td_num.innerText = num;
    td_precio.innerText = precio
    tr_inversion.appendChild(td_num);
    tr_inversion.appendChild(td_actividad);
    tr_inversion.appendChild(td_unidad)
    tr_inversion.appendChild(td_precio)
    tr_inversion.appendChild(td_cantidad_elp);
    tr_inversion.appendChild(td_cantidad_vecinos);
    tr_inversion.appendChild(td_sub_total_elp);
    tr_inversion.appendChild(td_sub_total_vecinos);
    console.log(tabla)
    document.getElementById('tbody_' + tabla).appendChild(tr_inversion);
}
function decimalAdjust(type, value, exp) {
    // Si el exp no está definido o es cero...
    if (typeof exp === 'undefined' || +exp === 0) {
        return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // Si el valor no es un número o el exp no es un entero...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
        return NaN;
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
}

Math.round10 = function (value, exp) {
    return decimalAdjust('round', value, exp);
};

btnMaterial.addEventListener('click', () => {
    const materiales = document.getElementsByName('material_check[]');
    materiales.forEach((material) => {
        material.checked = true;
    })
});

btnManoObra.addEventListener('click', () => {
    const manoObras = document.getElementsByName('mano_obra_check[]');
    manoObras.forEach((mano_obra) => {
        mano_obra.checked = true;
    })
});
