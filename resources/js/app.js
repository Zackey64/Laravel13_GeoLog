import L from 'leaflet';
import 'leaflet/dist/leaflet.css';

import Alpine from 'alpinejs';
import GeolocationService from './services/GeolocationService';

import {
    initializeStationMap,
    initializeCityMap,
} from './services/MapService';

window.L = L;
window.Alpine = Alpine;
window.GeolocationService = GeolocationService;

window.initializeStationMap = initializeStationMap;
window.initializeCityMap = initializeCityMap;

Alpine.start();