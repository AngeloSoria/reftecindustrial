import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Alpine from 'alpinejs'

// Charts
import { initAcquisitionsChart } from './Charts/acquisitionsCharts';
import { initVisitorsChart } from './Charts/visitorsCharts';
import { initVisitorsChart as initTotalVisitsCounter } from './Counters/totalVisits';

// Quill
import { initQuill } from './quillManager';




window.Alpine = Alpine
Alpine.start()

AOS.init({
    once: true, // Animate only once
});

document.addEventListener('DOMContentLoaded', () => {
    initVisitorsChart(); // Chart visualization
    initTotalVisitsCounter(); // Counter widget
    initAcquisitionsChart(); // Sample
    initQuill(); // Init Quill
});

