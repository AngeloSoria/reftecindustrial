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

Alpine.plugin(focus);
window.Alpine = Alpine;
Alpine.store('app', {
    modalSystem: {
        rootZIndexValue: 300,
        modals: [],
        activeModals: [],
        registerModal(element) {
            this.modals.push(element);
        },
        openModal(id, config = null) {
            if (id === null || id === undefined) {
                return console.error('id parameter not found.');
            }
            if (config === null || config === undefined) {
                return console.error('config parameter not found.');
            }

            // Incremented index for stacking z-index modals.
            const newIndex = this.rootZIndexValue + this.activeModals.length + 1;
            const payload = config.payload ?? [];
            const modalTitle = config.title;

            // if (!payload) return console.error('payload does not exists in config param.');
            if (!modalTitle) return console.error('modalTitle does not exists in config param.');

            document.dispatchEvent(new CustomEvent('openmodal', {
                detail: {
                    modalID: id,
                    title: modalTitle,
                    modalZIndex: newIndex,
                    payload_data: payload,
                },
                bubbles: true
            }));

            this.activeModals.push(id);
        },
        closeModal(id) {
            document.dispatchEvent(new CustomEvent('closemodal', {
                detail: {
                    modalID: id,
                },
                bubbles: true
            }));
            this.activeModals.pop(id);
        },
        getModal(parent_id) {
            return this.activeModals[parent_id];
        },
    }
});
Alpine.start();

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
