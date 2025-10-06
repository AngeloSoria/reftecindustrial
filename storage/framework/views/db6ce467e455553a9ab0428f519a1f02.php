<div class="fixed bottom-0 right-0 p-4 z-10 w-full flex justify-end">
    <button title="button back-to-top" id="backToTopBtn" class="cursor-pointer bg-accent-orange-300 text-black px-3 py-3 rounded-full shadow-lg hover:bg-yellow-400 transition duration-300 opacity-0 pointer-events-none transform translate-y-4">
        <i data-lucide="arrow-up" class="w-5 h-5"></i>
    </button>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const backToTopBtn = document.getElementById('backToTopBtn');

        // Function to show button with animation
        function showButton() {
            backToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
            backToTopBtn.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
        }

        // Function to hide button with animation
        function hideButton() {
            backToTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
            backToTopBtn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
        }

        // On scroll, toggle button visibility
        window.addEventListener('scroll', function () {
            if (window.scrollY > 100) {
                showButton();
            } else {
                hideButton();
            }
        });

        // On button click, scroll to top smoothly
        backToTopBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/btn_backtotop.blade.php ENDPATH**/ ?>