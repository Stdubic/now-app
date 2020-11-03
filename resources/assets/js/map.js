const DEFAULT_LAT = 51.05604659107056;
const DEFAULT_LNG = 1.2839645343922257;
var maps = [];

function initMaps() {
    const mapContainers = document.querySelectorAll('.map-area');
    for (const mapContainer of mapContainers) initMap(mapContainer);
}

function initMap(mapContainer) {
    const baseName = mapContainer.dataset.basename;
    const inputLat = document.getElementById(baseName + '_lat').value;
    const inputLng = document.getElementById(baseName + '_lng').value;

    const position = {
        lat: inputLat == '' ? DEFAULT_LAT : parseFloat(inputLat),
        lng: inputLng == '' ? DEFAULT_LNG : parseFloat(inputLng)
    };

    maps[baseName] = new google.maps.Map(mapContainer, {
        center: position,
        zoom: 9
    });

    maps[baseName].marker = new google.maps.Marker({
        map: maps[baseName],
        position:
            inputLat == '' && inputLng == ''
                ? null
                : new google.maps.LatLng(parseFloat(inputLat), parseFloat(inputLng)),
        draggable: true
    });

    maps[baseName].addListener('click', event => {
        pinOnMap(maps[baseName].marker, event.latLng.lat(), event.latLng.lng());
    });

    maps[baseName].marker.addListener('position_changed', () => {
        const latLng = maps[baseName].marker.getPosition();
        document.getElementById(baseName + '_lat').value = latLng.lat();
        document.getElementById(baseName + '_lng').value = latLng.lng();
    });
}

function pinOnMap(marker, latitude, longitude) {
    marker.setPosition(new google.maps.LatLng(parseFloat(latitude), parseFloat(longitude)));
    marker.setAnimation(google.maps.Animation.DROP);
}

function coordinateChange(baseName) {
    const latitude = document.getElementById(baseName + '_lat').value;
    const longitude = document.getElementById(baseName + '_lng').value;

    return latitude == '' || longitude == ''
        ? null
        : maps[baseName].marker.setPosition(
            new google.maps.LatLng(parseFloat(latitude), parseFloat(longitude))
        );
}