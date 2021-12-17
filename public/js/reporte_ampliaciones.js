function mostrarPDF(url) {
    let es_chrome = navigator.userAgent.toLowerCase().indexOf("chrome") > -1;
    if (es_chrome) {
        var iframe = document.createElement("iframe");
        iframe.style.display = "none";
        iframe.srcdoc = url;
        iframe.title = "Reporte Inversion";
        document.body.appendChild(iframe);
        iframe.focus();
        iframe.contentWindow.print();


    } else {
        var win = window.open(url, "_blank");
        win.focus();
    }
}

function convertirPDF() {
    const element = document.querySelector('#tabla_respuesta');
    element.focus()
    mostrarPDF(element.innerHTML);
}

function poner_titulo(fecha_i, fecha_h) {
    const titulo = document.getElementById('titulo_reporte');
    const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
    const date_i = fecha_i.split('-');
    const date_h = fecha_h.split('-');
    let cadena = "";
    if (date_i[0] == date_h[0] && date_i[1] == date_h[1]) {
        cadena = `Reporte Ampliaciones del ${date_i[2]} al ${date_h[2]}, ${meses[date_i[1] - 1]} de ${date_i[0]}`
    } else if (date_i[0] == date_h[0] && date_i[1] != date_h[1]) {
        cadena = `Reporte Ampliaciones del ${date_i[2]} de ${meses[date_i[1] - 1]} al ${date_h[2]} de ${meses[date_h[1] - 1]} del ${date_i[0]}`
    } else {
        cadena = `Reporte Ampliaciones del ${fecha_i} al ${fecha_h}`
    }
    titulo.innerText = cadena;
}

document.getElementById().addEventListener('submit', (e) => {
    e.preventDefault();
    const fecha_i = new Date(document.getElementById('fecha_i').value).getTime();
    const fecha_h = new Date(document.getElementById('fecha_h').value).getTime();
    if (fecha_i <= fecha_h) {
        $.post(e.target.action, $("#formReporteInversion").serialize(), (data) => {


        });

    } else {
        Swal.fire({
            icon: 'error',
            title: 'Fecha no válida',
            text: 'Elija un rango de fechas válido',
        })
    }
})
