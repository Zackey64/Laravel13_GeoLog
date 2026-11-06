import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

window.L = L;

document.addEventListener('DOMContentLoaded', () => {
    const element = document.getElementById('station-map');

    if (!element) return;

    const map = L.map(element).setView([33.3, 130.8], 8);

    L.tileLayer('https://cyberjapandata.gsi.go.jp/xyz/pale/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap',
    }).addTo(map);

    // 道の駅のマーカーを追加
    const markers = [];

    console.log(window.stations);
    console.log('件数:', window.stations?.length);

    window.stations.forEach(station => {
        const marker = L.circleMarker(
            [station.latitude,station.longitude,],
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

    // 全マーカーが見える範囲に調整
    if (markers.length > 0) {
        const group = L.featureGroup(markers);
        map.fitBounds(group.getBounds(), {
            padding: [30, 30],
        });
    }
});