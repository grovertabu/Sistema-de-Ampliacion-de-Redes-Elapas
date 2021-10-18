
var baseUrl = "http://100.100.100.126:6080/arcgis/rest/services/Mapas/";
var acceso = false;
var map;
var streets;
var openStreetMap;
var labels;
//Limite de Sucre
var mapAreaConcesion;

// AguaPotable
var mapTuberiasAguaPotable;
// Ampliaciones
var mapAmpliaciones;
var drawnItems;
var concesionItems;
var tuberiasItems;
var controles;
// Check areas

L.Polyline = L.Polyline.include({
    getDistance: function () {
        // distance in meters
        var mDistanse = 0,
            length = this._latlngs.length;
        for (var i = 1; i < length; i++) {
            mDistanse += this._latlngs[i].distanceTo(this._latlngs[i - 1]);
        }
        // optional
        return Math.round(mDistanse);
    }
});

function initEditMap(x_aprox, y_aprox) {
    map = null;
    iniciarLayers(x_aprox, y_aprox, 'actualizar');

}
function initMap(x_aprox, y_aprox, opcion = 'mapa') {
    map = null;
    iniciarLayers(x_aprox, y_aprox, opcion);

}

function mapTools(lat, long) {
    var searchControl = L.esri.Geocoding.geosearch({
        position: 'topright',
        useMapBounds: false,
        placeholder: 'Ej: Junín',
        title: 'Buscar una dirección',
        zoomToResult: false,
        providers: [
            L.esri.Geocoding.featureLayerProvider({
                label: 'Dirección y Barrio',
                url: baseUrl + 'MapaBaseWebMercator/MapServer/1',
                searchFields: ['DIRECCION']
            })
        ]
    }).addTo(map);


    L.easyButton('fa-map-marker', function () {
        var sucre = [lat, long];
        map.setView(sucre, 18);
    }).addTo(map);

    var results = new L.LayerGroup().addTo(map);

    searchControl.on('results', function (data) {
        results.clearLayers();
        results.addLayer(L.marker(data.results[0].latlng));
        results.eachLayer(function (layer) {
            layer.bindPopup('<strong>Dirección: </strong>' + data.results[0].text);
        });
        map.setView(data.results[0].latlng, 18);
    });
}

function mostrarTabla(flag, distance = false) {
    if (flag) {
        let contenedorMapa = $("#contenedor-mapa");
        if (acceso) {
            let mapa = document.createElement("div");
            mapa.setAttribute("id", "map");
            contenedorMapa.append(mapa);
        }
        $("#contenedor-tabla").hide();
        contenedorMapa.show();
        acceso = true;
    } else {
        $("#map").remove();
        $("#contenedor-tabla").show();
        $("#contenedor-mapa").hide();
        if (distance) calcularDistancia();
    }
}


function drawMapa(flag) {
    let lat = document.getElementById('x_exact').value;
    let long = document.getElementById('y_exact').value;
    mostrarTabla(flag);

    iniciarLayers(lat, long, 'editar');

}



function bindPopup(layer) {
    let props = {}
    if (features.has(layer._leaflet_id)) {
        props = features.get(layer._leaflet_id).properties
    } else {
        props = featuresDB.get(layer._leaflet_id).properties
    }

    let table = ''
    for (var key in props) {
        if (!String(key).startsWith('_')) {
            table += '<tr><th><input type="text" value="' + key + '"' + ' /></th>' +
                '<td><input type="text" value="' + props[key] + '"' + ' /></td></tr>'
        }
    }
    content = '<table class="tablaPopup">' + table + '</table>' +
        '<div class="popupButtons">' +
        '<button class="guardar">Guardar</button> ' +
        '<button class="cancelar">Cancelar</button>' +
        '</div>'
    layer.bindPopup(L.popup({
        closeButton: false,
        maxWidth: 500,
        maxHeight: 400,
        autoPanPadding: [5, 45]
    }, layer).setContent(content))

    layer.on('popupopen', popupOpen)
}

function cargarTuberias() {
    mapTuberiasAguaPotable = L.esri.featureLayer({
        url: baseUrl + 'InventarioRedes/MapServer/6'
    });
    mapTuberiasAguaPotable.bindPopup(function (layer) {
        var material;
        if (layer.feature.properties.MATERIAL === 1) {
            material = 'PVC';
        } else if (layer.feature.properties.MATERIAL === 2) {
            material = 'FF';
        } else if (layer.feature.properties.MATERIAL === 3) {
            material = 'FG';
        } else if (layer.feature.properties.MATERIAL === 4) {
            material = 'HDPE';
        }
        return L.Util.template('<strong>ID: </strong>{OBJECTID}<br><strong>Codigo de Catastro: </strong>{CodigoCatastro}<br><strong>Material: </strong>' + material + '<br><strong>Diametro: </strong>{Diametro}<br><strong>Nombre de Red: </strong>{NombreRed}', layer.feature.properties);
    });
}

function cargarConcesion() {
    mapAreaConcesion = L.esri.featureLayer({
        url: baseUrl + 'MapaBaseWebMercator/MapServer/3'
    });
}

function iniciarLayers(lat, long, opcion, datos = null) {
    if (opcion === 'actualizar') {
        cargarLayersActualizar(lat, long);
    } else if (opcion === 'mostrar') {
        cargarLayers(datos, lat, long);
    } else {
        $.get(document.getElementById('obtenerAmpliaciones').value, function (data) {

            if (data != null) {
                data = JSON.parse(data.ampliacion);
            }
            if (opcion === 'editar') {
                cargarLayersEditar(data, lat, long);
            } else if (opcion === 'mapa') {
                cargarLayers(data, lat, long);
            }
        });
    }


}

function cargarLayersEditar(data, lat, long) {
    cargarConcesion();
    cargarTuberias();
    mapAmpliaciones = L.geoJSON(data, {
        style: function (feature) {
            return { color: '#ff0000' }
        }
    });
    drawnItems = L.featureGroup();
    addNonGroupLayers(mapAmpliaciones, drawnItems);
    concesionItems = L.featureGroup([mapAreaConcesion]);
    tuberiasItems = L.featureGroup([mapTuberiasAguaPotable]);


    openStreetMap = L.tileLayer('http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 22,
        maxNativeZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });
    const mapasBase = {
        "Hibrido": openStreetMap
    }
    const capasLineas = {
        "Ampliaciones": drawnItems,
        "Mapa de Tuberias": tuberiasItems,
        "Area de Concesion": concesionItems
    }
    map = L.map('map', {
        center: { lat: lat, lng: long },
        zoom: 18,
        zoomControl: false,
        layers: [openStreetMap, drawnItems],
        fullscreenControl: true
    })

    controles = L.control.layers(
        mapasBase,
        capasLineas, { position: 'topright', collapsed: true }
    )
    controles.addTo(map)

    map.addControl(new L.Control.Draw({
        edit: {
            featureGroup: drawnItems,
        },
        draw: {
            rectangle: false,
            polygon: false,
            circle: false,
            marker: false,
            circlemarker: false

        }

    }))

    map.on(L.Draw.Event.CREATED, function (e) {
        var type = e.layerType,
            layer = e.layer;
        if (type === 'polyline') {
            console.log(layer);
            layer.options.color = '#ff0000'
            layer.options.opacity = 1.0;
            drawnItems.addLayer(layer);
            guardarcambios('crear');
            console.log(layer.getDistance())
        }
    });

    map.on('draw:edited', function (e) {
        var layers = e.layers;
        layers.eachLayer(function (layer) {
            guardarcambios('editar');
        });
    });

    map.on('draw:deleted', function (e) {
        var layers = e.layers;
        layers.eachLayer(function (layer) {
            guardarcambios('eliminar');
        });
    });


    L.marker([lat, long], { color: 'red' }).addTo(map);

    tuberiasItems.addTo(map);


    /* capasMapa(); */

    mapTools(lat, long);

}

function cargarLayers(data, lat, long) {
    cargarConcesion();
    cargarTuberias();
    mapAmpliaciones = L.geoJSON(data, {
        style: function (feature) {
            return {
                color: '#ff0000',
                weight: 6
            }
            //return {color:'#48E120'}

        }
    });
    drawnItems = L.featureGroup();
    addNonGroupLayers(mapAmpliaciones, drawnItems);
    concesionItems = L.featureGroup([mapAreaConcesion]);
    tuberiasItems = L.featureGroup([mapTuberiasAguaPotable]);


    openStreetMap = L.tileLayer('http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 22,
        maxNativeZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });
    const mapasBase = {
        "Hibrido": openStreetMap
    }
    const capasLineas = {
        "Ampliaciones": drawnItems,
        "Area de Concesion": concesionItems,
        "Mapa de Tuberias": tuberiasItems
    }
    map = L.map('map', {
        center: { lat: lat, lng: long },
        zoom: 18,
        zoomControl: false,
        layers: [openStreetMap, drawnItems],
        fullscreenControl: true
    })

    L.control.layers(
        mapasBase,
        capasLineas, { position: 'topright', collapsed: true }
    ).addTo(map)


    L.marker([lat, long], { color: 'red' }).addTo(map);


    /* capasMapa(); */

    mapTools(lat, long);

}

function cargarLayersActualizar(lat, long) {
    let options = {};
    cargarConcesion();
    cargarTuberias();
    drawnItems = L.featureGroup();
    concesionItems = L.featureGroup([mapAreaConcesion]);
    tuberiasItems = L.featureGroup([mapTuberiasAguaPotable]);


    openStreetMap = L.tileLayer('http://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
        maxZoom: 22,
        maxNativeZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });
    const mapasBase = {
        "Hibrido": openStreetMap
    }
    const capasLineas = {
        "Ubicación": drawnItems,
        "Area de Concesion": concesionItems,
        "Mapa de Tuberias": tuberiasItems
    }
    if (lat != -19.034432 && long != -65.264812) {
        options = {
            center: { lat: lat, lng: long },
            zoom: 18,
            zoomControl: false,
            layers: [openStreetMap, drawnItems],
            fullscreenControl: true
        }
    } else {
        options = {
            center: { lat: -19.0429, lng: -65.2554 },
            zoom: 15,
            zoomControl: false,
            layers: [openStreetMap, drawnItems],
            fullscreenControl: true
        }
    }

    map = L.map('map', options);

    L.control.layers(
        mapasBase,
        capasLineas, { position: 'topright', collapsed: true }
    ).addTo(map)

    map.addControl(new L.Control.Draw({
        edit: {
            featureGroup: drawnItems,
        },
        delete: {
            disabled: true,
        },
        draw: {
            rectangle: false,
            polygon: false,
            circle: false,
            polyline: false,
            circlemarker: false

        }

    }))

    map.on(L.Draw.Event.CREATED, function (e) {
        var type = e.layerType,
            layer = e.layer;
        if (type === 'marker') {
            drawnItems.clearLayers();
            drawnItems.addLayer(layer);
            document.getElementById('x_aprox').value = layer._latlng.lat;
            document.getElementById('y_aprox').value = layer._latlng.lng;
        }
    });

    map.on('draw:edited', function (e) {
        var layers = e.layers;
        layers.eachLayer(function (layer) {
            document.getElementById('x_aprox').value = layer._latlng.lat;
            document.getElementById('y_aprox').value = layer._latlng.lng;
        });
    });

    map.on('draw:deleted', function (e) {
        var layers = e.layers;
        layers.eachLayer(function (layer) {
            document.getElementById('x_aprox').value = lat;
            document.getElementById('y_aprox').value = long;
        });
    });

    if (lat != -19.034432 && long != -65.264812) {
        var marcador = L.marker([lat, long], { color: 'red' })
        drawnItems.addLayer(marcador)
    }


    /* capasMapa(); */

    mapTools(lat, long);
}

function addNonGroupLayers(sourceLayer, targetGroup) {
    if (sourceLayer instanceof L.LayerGroup) {
        sourceLayer.eachLayer(function (layer) {
            addNonGroupLayers(layer, targetGroup);
        });
    } else {
        targetGroup.addLayer(sourceLayer);
    }
}

function guardarcambios(cadena) {
    const layerJSON = drawnItems.toGeoJSON();
    let formData = new FormData(document.getElementById('formAmpliaciones'));
    formData.append('ampliaciones', JSON.stringify(layerJSON));
    $.ajax({
        url: document.querySelector('#formAmpliaciones').action,
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
        }
    });
}

function calcularDistancia() {

    $.get(document.getElementById('obtenerAmpliaciones').value, function (data) {
        let distancia = 0;
        if (data != null) {
            data = JSON.parse(data.ampliacion);
            var sourceLayer = L.geoJSON(data);
            sourceLayer.eachLayer(function (layer) {
                let linea = L.polyline(layer._latlngs);
                distancia = distancia + linea.getDistance();
                document.getElementById('longitud_in').value = distancia;
                document.getElementById('longitud_in').placeholder = `Longitud: ${distancia}`;

            });
        }
    });
}

function downloadMap(caption) {
    ocultarBotones(true);
    console.log(map._container.width)
    var downloadOptions = {
        container: map._container,
        caption: {
            text: caption,
            font: '30px Arial',
            fillStyle: 'black',
            position: [100, 200]
        },
        exclude: ['.leaflet-control-zoom', '.leaflet-control-attribution'],
        format: 'image/png',
        fileName: 'Map.png'
    };
    var promise = map.downloadExport(downloadOptions);
    var data = promise.then(function (result) {

        document.querySelector('#imgMap').src = result.data;
        document.querySelector('#textMap').value = result.data;
        Swal.fire(
            'Exito!',
            'Captura guardada.',
            'success'
        )
        ocultarBotones(false);
    });
}

function mapLink() {
    let lat = document.getElementById('x_exact').value;
    let lng = document.getElementById('y_exact').value;
    var enlace = "https://maps.google.com/?q=" + lat + "," + lng;
    document.getElementById('ubicacion_geo').value = enlace;
}

function ocultarBotones(flag) {
    const barras = document.querySelectorAll('.leaflet-top');

    if (flag) {
        barras.forEach((clase) => {
            clase.style.display = 'none';
        });
    } else {
        barras.forEach((clase) => {
            clase.style.display = 'block';
        });
    }
}
