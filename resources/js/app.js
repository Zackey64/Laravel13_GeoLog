
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

window.L = L;

// 道の駅マップ
let stationMap;

function initializeStationMap() {
    const element = document.getElementById('station-map');

    if (!element || stationMap) return;

    stationMap = L.map(element, {
        minZoom: 6,
        maxZoom: 12,
    }).setView([33.3, 130.8], 8);

    window.stationMap = stationMap;

    L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/pale/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; 国土地理院',
    }).addTo(stationMap);

    const markers = [];

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
        ).addTo(stationMap);

        marker.bindPopup(station.name);
        markers.push(marker);
    });

    if (markers.length > 0) {
        stationMap.fitBounds(L.featureGroup(markers).getBounds(), {
            padding: [30, 30],
            maxZoom: 8,
        });
    }

    stationMap.invalidateSize();
}

// 市区町村マップ
let cityMap;

function initializeCityMap() {
    const element = document.getElementById('city-map');

    if (!element || cityMap) return;

    cityMap = L.map(element, {
        minZoom: 6,
        maxZoom: 12,
    }).setView([33.3, 130.8], 8);

    window.cityMap = cityMap;

    L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/pale/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; 国土地理院',
    }).addTo(cityMap);

    const markers = [];

    window.cities.forEach(city => {
        const marker = L.circleMarker(
            [city.latitude, city.longitude],
            {
                radius: 6,
                color: '#ffffff',
                weight: 2,
                fillColor: '#3388ff',
                fillOpacity: 1,
            }
        ).addTo(cityMap);

        marker.bindPopup(`${city.prefecture}${city.name}`);
        markers.push(marker);
    });

    if (markers.length > 0) {
        const center = L.featureGroup(markers).getBounds().getCenter();
        cityMap.setView(center, 8);
    }

    cityMap.invalidateSize();
}

window.initializeStationMap = initializeStationMap;
window.initializeCityMap = initializeCityMap;
