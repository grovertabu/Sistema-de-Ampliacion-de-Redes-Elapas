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

function cambiarMaterial() {
    let valor = document.getElementById('id_material').selectedOptions[0].value;
    if (valor != 0) {
        document.getElementById('precio').value = valor.split('-')[1]
    } else {
        document.getElementById('precio').value = "";

    }

}

