import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Alpine from 'alpinejs'

// Charts
import { initAcquisitionsChart } from './Charts/acquisitionsCharts';
import { initVisitorsChart } from './Charts/visitorsCharts';
import { trackVisit } from './tracker';
import { initVisitorsChart as initTotalVisitsCounter } from './Counters/totalVisits';


window.Alpine = Alpine
Alpine.start()

AOS.init({
    once: true, // Animate only once
});

document.addEventListener('DOMContentLoaded', () => {
    initAcquisitionsChart();
    initVisitorsChart();
    initTotalVisitsCounter();


    trackVisit();
});
