var formulario = document.getElementById('formReporteInversion');
const btnMaterial = document.getElementById('btnMateriales');
const btnManoObra = document.getElementById('btnManoObra');

function mostrarPDF(url) {
    let es_chrome = navigator.userAgent.toLowerCase().indexOf("chrome") > -1;
    if (es_chrome) {
        var iframe = document.createElement("iframe");
        iframe.style.display = "none";
        iframe.srcdoc = url;
        iframe.title = "Reporte Inversion";
        document.body.appendChild(iframe);
        iframe.focus();
        console.log(iframe.contentWindow);
        iframe.contentWindow.print();

    } else {
        var win = window.open(url, "_blank");
        win.focus();
    }
}


function convertirPDF() {
    const element = document.querySelector('#respuesta');
    element.focus()
    console.log(element)
    mostrarPDF(element.innerHTML);
}

function ocultarVolver() {
    const volver = document.getElementById('btnVolver');
    const formulario = document.getElementById('formulario');
    document.getElementById('respuesta').style.display = 'none';
    document.getElementById('cardPDF').style.display = 'none';
    volver.style.display = "none";
    formulario.style.display = "block";
}

function poner_titulo(fecha_i, fecha_h) {
    const titulo = document.getElementById('titulo_reporte');
    const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
    const date_i = fecha_i.split('-');
    const date_h = fecha_h.split('-');
    let cadena = "";
    console.log(date_i)
    console.log(date_h)
    if (date_i[0] == date_h[0] && date_i[1] == date_h[1]) {
        console.log("iguales")
        cadena = `del ${date_i[2]} al ${date_h[2]}, ${meses[date_i[1] - 1]} de ${date_i[0]}`
    } else if (date_i[0] == date_h[0] && date_i[1] != date_h[1]) {
        console.log("iguales 2")
        cadena = `del ${date_i[2]} de ${meses[date_i[1] - 1]} al ${date_h[2]} de ${meses[date_h[1] - 1]} del ${date_i[0]}`
    } else {
        cadena = `Reporte Inversión del ${fecha_i} al ${fecha_h}`
    }
    titulo.innerText = cadena;
}

formulario.addEventListener('submit', (e) => {
    e.preventDefault();
    const fecha_i = new Date(document.getElementById('fecha_i').value).getTime();
    const fecha_h = new Date(document.getElementById('fecha_h').value).getTime();
    if (fecha_i <= fecha_h) {
        $.post(e.target.action, $("#formReporteInversion").serialize(), (data) => {
            if (data['materiales'].length > 0 || data['mano_obras'].length > 0) {
                let indice = 0;
                let num = 1;
                let cantidad_elp = 0;
                let cantidad_vecinos = 0;
                let sub_total_elp = 0;
                let sub_total_vecinos = 0;
                let total_elp = 0;
                let total_vecinos = 0;
                console.log(data)
                filtrar_data_materiales(data, 'materiales', num, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos, indice, sub_total_elp, sub_total_vecinos, total_elp, total_vecinos);
                indice = 0;
                num = 1;
                cantidad_elp = 0;
                cantidad_vecinos = 0;
                sub_total_elp = 0;
                sub_total_vecinos = 0;
                total_elp = 0;
                total_vecinos = 0;
                filtrar_data_mano_obra(data, 'mano_obras', num, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos, indice, sub_total_elp, sub_total_vecinos, total_elp, total_vecinos);
                poner_titulo(data.fecha_i, data.fecha_h);
                convertirPDF();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'No existen datos',
                    text: 'No existen datos entre las fechas seleccionadas',
                })
            }

        });

    } else {
        Swal.fire({
            icon: 'error',
            title: 'Fecha no válida',
            text: 'Elija un rango de fechas válido',
        })
    }
})

function filtrar_data_materiales(data, dato_tabla, num, cantidad_elp, cantidad_vecinos, indice, sub_total_elp, sub_total_vecinos, total_elp, total_vecinos) {
    if (data[dato_tabla].length > 0) {
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
                        total_elp = total_elp + sub_total_elp;
                        total_vecinos = total_vecinos + sub_total_vecinos;
                        dibujar_tabla(num++, dato_tabla, data[dato_tabla][i].nombre_material, data[dato_tabla][i].u_medida, data[dato_tabla][i].precio_unitario, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos, total_elp, total_vecinos);
                    }
                } else {
                    console.log("añadir")
                    total_elp = total_elp + sub_total_elp;
                    total_vecinos = total_vecinos + sub_total_vecinos;
                    dibujar_tabla(num++, dato_tabla, data[dato_tabla][i - 1].nombre_material, data[dato_tabla][i - 1].u_medida, data[dato_tabla][i - 1].precio_unitario, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos, total_elp, total_vecinos);
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

function filtrar_data_mano_obra(data, dato_tabla, num, cantidad_elp, cantidad_vecinos, indice, sub_total_elp, sub_total_vecinos, total_elp, total_vecinos) {
    if (data[dato_tabla].length > 0) {
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
                        total_elp = total_elp + sub_total_elp;
                        total_vecinos = total_vecinos + sub_total_vecinos;
                        dibujar_tabla(num++, dato_tabla, data[dato_tabla][i].descripcion, data[dato_tabla][i].unidad_medida, data[dato_tabla][i].precio_uni, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos, total_elp, total_vecinos);
                    }
                } else {
                    console.log("añadir")
                    total_elp = total_elp + sub_total_elp;
                    total_vecinos = total_vecinos + sub_total_vecinos;
                    dibujar_tabla(num++, dato_tabla, data[dato_tabla][i - 1].descripcion, data[dato_tabla][i - 1].unidad_medida, data[dato_tabla][i - 1].precio_uni, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos, total_elp, total_vecinos);
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


function dibujar_tabla(num, tabla, descripcion, unidad, precio, cantidad_elp, cantidad_vecinos, sub_total_elp, sub_total_vecinos, total_elp = null, total_vecinos = null) {
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
    if (total_elp != null && total_vecinos != null) {
        document.getElementById('total_elp_' + tabla).innerHTML = '<b>' + Math.round10(total_elp, -2) + '</b>'
        document.getElementById('total_vecinos_' + tabla).innerHTML = '<b>' + Math.round(total_vecinos, -2) + '</b>'
        document.getElementById('costo_total_' + tabla).innerHTML = '<b>' + Math.round10(total_elp + total_vecinos, -2) + '</b>'
    }
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
