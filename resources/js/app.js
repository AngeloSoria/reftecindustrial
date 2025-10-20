import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Alpine from 'alpinejs'
import Quill from 'quill';

import 'quill/dist/quill.snow.css'; // or 'quill/dist/quill.bubble.css'

// Charts
import { initAcquisitionsChart } from './Charts/acquisitionsCharts';
import { initVisitorsChart } from './Charts/visitorsCharts';
import { initVisitorsChart as initTotalVisitsCounter } from './Counters/totalVisits';


window.Alpine = Alpine
Alpine.start()

AOS.init({
    once: true, // Animate only once
});

document.addEventListener('DOMContentLoaded', () => {
    initVisitorsChart(); // Chart visualization
    initTotalVisitsCounter(); // Counter widget
    initAcquisitionsChart(); // Sample

    // --------------------------------------------------------
    // QUILL EDITOR
    // --------------------------------------------------------
    const editors = document.querySelectorAll('.quill-editor');
    const quillInstances = [];

    editors.forEach((editor, index) => {
        // Create a new Quill instance for each
        const quill = new Quill(editor, {
            theme: 'snow',
            placeholder: 'Write something...',
            modules: {
                toolbar: [
                    [{ header: [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    [{ color: [] }, { background: [] }],
                    ['clean']
                ]
            }
        });

        // Load pre-existing HTML from data attribute (if any)
        const initialHTML = editor.dataset.content || '';
        quill.root.innerHTML = initialHTML;

        // Store for later access
        quillInstances.push(quill);
    });

    // Handle form submission
    // const form = document.querySelector('form');
    // if (form) {
    //     form.addEventListener('submit', () => {
    //         const inputs = form.querySelectorAll('.quill-content');
    //         inputs.forEach((input, i) => {
    //             // Match input to same index as editor
    //             if (quillInstances[i]) {
    //                 input.value = quillInstances[i].root.innerHTML;
    //             }
    //         });
    //     });
    // }



});
