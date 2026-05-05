import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Import and expose jQuery
import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

// Import and expose Chart.js
import Chart from 'chart.js/auto';
window.Chart = Chart;

// Import and expose SweetAlert2
import Swal from 'sweetalert2';
window.Swal = Swal;

// Removed Cropper.js import to avoid clashing with the v1.5.13 CDN in layout

// Import and expose Leaflet & Routing Machine
import L from 'leaflet';
window.L = L;
import 'leaflet-routing-machine';

// Import and expose Signature Pad
import SignaturePad from 'signature_pad';
window.SignaturePad = SignaturePad;
