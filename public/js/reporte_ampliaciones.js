let titulo_reporte = "";
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
    const element = document.querySelector('#reporte_contenido');
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
    titulo_reporte = cadena;
}

document.getElementById('formReporteAmpliaciones').addEventListener('submit', (e) => {
    e.preventDefault();
    const fecha_i = new Date(document.getElementById('fecha_i').value);
    const fecha_h = new Date(document.getElementById('fecha_h').value);
    const contenido = document.getElementById('contenido_tabla');
    const tabla = document.getElementById('tabla_respuesta');
    if (fecha_i.getTime() <= fecha_h.getTime()) {
        $.post(e.target.action, $("#formReporteAmpliaciones").serialize(), (data) => {
            if (data.ampliaciones.length > 0) {
                let fecham_i = document.getElementById('fecha_i').value
                let fecham_h = document.getElementById('fecha_h').value
                console.log(data)
                poner_titulo(fecham_i, fecham_h);
                contenido.innerHTML = "";
                tabla.style.display = 'block';
                let cadena = "";
                data.ampliaciones.forEach((ampliacion) => {
                    cadena += `<tr>
                    <td align="center" style="border: 1px solid black; border-collapse: collapse;">${'S-' + ampliacion.id_sol}</td>
                    <td align="center" style="border: 1px solid black; border-collapse: collapse;">${ampliacion.solicitante}</td>
                    <td align="center" style="border: 1px solid black; border-collapse: collapse;">${ampliacion.zona}</td>
                    <td align="center" style="border: 1px solid black; border-collapse: collapse;">${ampliacion.fecha_inspeccion == null ? "sin fecha" : ampliacion.fecha_inspeccion.split(' ')[0]}</td>
                    <td align="center" style="border: 1px solid black; border-collapse: collapse;">${ampliacion.nombre}</td>
                    <td align="center" style="border: 1px solid black; border-collapse: collapse;">${ampliacion.fecha_autorizacion == null ? "sin fecha" : ampliacion.fecha_autorizacion}</td>
                    <td align="center" style="border: 1px solid black; border-collapse: collapse;">${ampliacion.fecha_visto_bueno == null ? "sin fecha" : ampliacion.fecha_visto_bueno}</td>
                    <td align="center" style="border: 1px solid black; border-collapse: collapse;">${ampliacion.fecha_ejecutada == null ? "sin fecha" : ampliacion.fecha_ejecutada}</td>
                    <td align="center" style="border: 1px solid black; border-collapse: collapse;" width="20px">${ampliacion.estado.toUpperCase()}</td>
                    <td align="center" style="border: 1px solid black; border-collapse: collapse;">${ampliacion.longitud}</td>
                </tr>`
                })
                contenido.innerHTML = cadena;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'No existen datos'
                })
                tabla.style.display = 'none';
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

function exportTableToExcel() {
    let filename = titulo_reporte;
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById('tbl_contenido');
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

    // Specify file name
    filename = filename ? filename + '.xls' : 'excel_data.xls';

    // Create download link element
    downloadLink = document.createElement("a");

    document.body.appendChild(downloadLink);

    if (navigator.msSaveOrOpenBlob) {
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob(blob, filename);
    } else {
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

        // Setting the file name
        downloadLink.download = filename;

        //triggering the function
        downloadLink.click();
    }
}

