import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';


import Alpine from 'alpinejs'
import focus from '@alpinejs/focus'

// Charts
import { initAcquisitionsChart } from './Charts/acquisitionsCharts';
import { initVisitorsChart } from './Charts/visitorsCharts';
import { initVisitorsChart as initTotalVisitsCounter } from './Counters/totalVisits';

// Quill
import { initQuill } from './quillManager';

// Sortable
import { initSortableAboutUsGallery } from './Sortable/sortableAboutUsGallery'

Alpine.plugin(focus)
window.Alpine = Alpine
Alpine.start()

AOS.init({
    once: true, // Animate only once
});

window.backToTop = function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

document.addEventListener('DOMContentLoaded', () => {
    initVisitorsChart(); // Chart visualization
    initTotalVisitsCounter(); // Counter widget
    initAcquisitionsChart(); // Sample
    initQuill(); // Init Quill
    const aboutUsGallerySortable = initSortableAboutUsGallery(); // Gallery SortableJS

    window.aboutUsGallerySortable = aboutUsGallerySortable; // Expose to global scope for testing
});
