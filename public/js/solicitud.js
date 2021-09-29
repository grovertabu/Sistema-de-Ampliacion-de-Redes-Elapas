function modalObservaciones(ruta){
    document.querySelector('#id_ruta').value = 'solicitud/'+ ruta +'/rechazar'; 
    document.querySelector('#observaciones').value = "";
}
function visualizarMapa(lat, long, ruta){
    mostrarTabla(true);
    document.querySelector('#obtenerAmpliaciones').value = 'solicitud/'+ ruta +'/obtener_ampliacion';
    ruta== null ? initMap(lat,long,'mostrar'):initMap(lat,long);
    
}
// manda form observaciones 
document.querySelector('#formObservaciones').addEventListener('submit', (e)=>{
e.preventDefault();
var formData = new FormData(e.target);

$.ajax({
        url: document.querySelector('#id_ruta').value,
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function(data) {
                window.location.reload();
        }
});
});
// aprobar solicitud
document.querySelector('.boton-aprobar').addEventListener('click', (e)=>{
    e.preventDefault();
    Swal.fire({
    title: '¿Está seguro?',
    text: "¿Desea aprobar esta solicitud?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Aprobar',
    cancelButtonText: 'cancelar'
    }).then((result) => {
    if (result.isConfirmed) {
        window.location= e.target.href;
    }
    });
});
