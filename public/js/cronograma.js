document.getElementById('form_materials').addEventListener('submit', (e) => {
    e.preventDefault();
    let fecha = document.querySelector('#fecha_inspe').value;
    fecha = new Date(fecha).getDay();
    if ((fecha == 3 || fecha == 4) && !isNaN(fecha)) {
        var formData = new FormData(document.getElementById('form_materials'));
        $.ajax({
            url: e.target.action,
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (data) {
                window.location.reload();
            }
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Fecha no válida',
        })
    }
    /*  */
})

