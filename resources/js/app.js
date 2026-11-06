
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

window.L = L;

let map;
let markers = [];

function initializeStationMap() {
    const element = document.getElementById('station-map');

    if (!element || map) return;

    map = L.map(element, {
        minZoom: 6,
        maxZoom: 12,
    }).setView([33.3, 130.8], 8);
    window.stationMap = map;

    L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/pale/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; 国土地理院',
    }).addTo(map);

    window.stations.forEach(station => {
        const marker = L.circleMarker(
            [station.latitude, station.longitude],
            {
                radius: 8,
                color: '#ffffff',
                weight: 2,
                fillColor: '#3388ff',
                fillOpacity: 1,
            }
        ).addTo(map);

        marker.bindPopup(station.name);
        markers.push(marker);
    });

    if (markers.length > 0) {
        map.fitBounds(L.featureGroup(markers).getBounds(), {
            padding: [30, 30],
            maxZoom: 8,
        });
    }
}

document.addEventListener('DOMContentLoaded', initializeStationMap);
