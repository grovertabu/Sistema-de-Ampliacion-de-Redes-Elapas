document.getElementById('form_materials').addEventListener('submit', (e) => {
    e.preventDefault();
    let material = document.getElementById('id_material').selectedOptions[0].value;
    let precio = document.getElementById('precio').value;
    if (material != '0' && precio > 0.00) {
        document.getElementById('form_materials').submit();
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Seleccione material y precio',
        })
    }
})

function visualizarMapa(lat, long, ruta) {
    mostrarTabla(true);
    document.querySelector('#obtenerAmpliaciones').value = ruta;
    ruta == null ? initMap(lat, long, 'mostrar') : initMap(lat, long);
}

function cambiarMaterial() {
    let valor = document.getElementById('id_material').selectedOptions[0].value;
    let precio = document.getElementById('precio_elapas');
    if (valor != 0) {
        document.getElementById('precio').value = valor.split('-')[1]
        precio_elapas.value = valor.split('-')[1]
    } else {
        document.getElementById('precio').value = "";
        precio_elapas.value = valor.split('-')[1]
    }


}

function habilitarPrecio() {
    let observador = document.querySelectorAll('input[name="observador"]');
    let = valor = "";
    observador.forEach((radio) => {
        if (radio.checked == true) {
            valor = radio.value;
        }
    });
    console.log(valor)
    let precio_material = document.getElementById('id_material').selectedOptions[0].value;
    const precio = document.getElementById('precio');
    const precio_elapas = document.getElementById('precio_elapas');
    if (valor == "Elapas") {
        precio.value = precio_material.split('-')[1];
        precio.disabled = true;
        precio_elapas.value = precio.value != "" ? precio.value : ""
    } else {
        precio.disabled = false;

    }
    console.log(precio_elapas.value);
}

