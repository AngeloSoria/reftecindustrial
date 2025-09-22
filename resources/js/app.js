import './bootstrap';
import { createIcons, icons } from 'lucide';
import AOS from 'aos';
import 'aos/dist/aos.css';

AOS.init({
  once: true, // Animate only once
});

// Wait until DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});
