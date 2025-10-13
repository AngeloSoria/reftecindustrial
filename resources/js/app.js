import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Alpine from 'alpinejs'

// Charts
import { initAcquisitionsChart } from './Charts/acquisitionsCharts';
import { initVisitorsChart } from './Charts/visitorsCharts';


window.Alpine = Alpine
Alpine.start()

AOS.init({
    once: true, // Animate only once
});

document.addEventListener('DOMContentLoaded', () => {
    initAcquisitionsChart();
    initVisitorsChart();
    trackVisit();
});

async function trackVisit() {
    try {
        // Get geolocation data from a public API
        const geoRes = await fetch('https://ipapi.co/json/');
        const geoData = await geoRes.json();

        const country = geoData.country_name || 'Unknown';
        const ip = geoData.ip || null;

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Send info to your Laravel route
        await fetch('/track-visit', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
            },
            body: JSON.stringify({ country, ip }),
        });

    } catch (err) {
        console.error('Visit tracking failed:', err);
    }
}


