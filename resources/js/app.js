import './bootstrap';
import { createIcons, icons } from 'lucide';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Alpine from 'alpinejs'
import Chart from 'chart.js/auto';


window.Alpine = Alpine

Alpine.start()

AOS.init({
    once: true, // Animate only once
});

// Wait until DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

