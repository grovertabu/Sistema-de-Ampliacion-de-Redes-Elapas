function habilitarForm(valor) {
    $('#form_actividad')[0].reset();
    calcularVolumen();
    let valores = valor.split('-')
    if (valor != 0) {
        habilitarCampos(true);
        document.getElementById('btnRegistrar').disabled = false;
        document.getElementById('txtActividad').innerText = 'Registro de Mano de Obra - ' + document.getElementById('actividad_id').selectedOptions[0].label;
        document.getElementById('id_actividad').value = valores[0];
        document.getElementById('unidad').value = valores[1];
        document.getElementById('precio').value = valores[2];
    } else {
        habilitarCampos(false);
        document.getElementById('btnRegistrar').disabled = true;
        document.getElementById('txtActividad').innerText = 'Registro de Mano de Obra - ' + 'Actividad';
        document.getElementById('id_actividad').value = 0;

    }
}

function habilitarCampos(flag) {
    if (flag) {
        document.getElementById('ancho').disabled = false;
        document.getElementById('alto').disabled = false;
        document.getElementById('largo').disabled = false;
        document.getElementById('cantidad').disabled = false;
        document.getElementById('precio').disabled = false;
    } else {
        document.getElementById('ancho').disabled = true;
        document.getElementById('alto').disabled = true;
        document.getElementById('largo').disabled = true;
        document.getElementById('cantidad').disabled = true;
        document.getElementById('precio').disabled = true;
    }
}

function visualizarMapa(lat, long, ruta) {
    mostrarTabla(true);
    document.querySelector('#obtenerAmpliaciones').value = ruta;
    ruta == null ? initMap(lat, long, 'mostrar') : initMap(lat, long);
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

function calcularVolumen(flag = false) {
    let altura = document.getElementById('alto').value;
    let ancho = document.getElementById('ancho').value;
    let largo = document.getElementById('largo').value;
    if (altura <= 0.00 || altura == "") {
        altura = 1.00;
    }
    if (ancho <= 0.00 || ancho == "") {
        ancho = 1.00;
    }
    if (largo <= 0.00 || largo == "") {
        largo = 1.00;
    }

    let volumen = Math.round10(altura * largo * ancho, -2);

    document.getElementById('cantidad').value = volumen
    if (flag) {
        document.getElementById('alto').value = altura;
        document.getElementById('ancho').value = ancho;
        document.getElementById('largo').value = largo;

    }


}

document.getElementById('form_actividad').addEventListener('submit', (e) => {
    e.preventDefault();
    calcularVolumen(true);
    e.target.submit();
})



calcularVolumen();
