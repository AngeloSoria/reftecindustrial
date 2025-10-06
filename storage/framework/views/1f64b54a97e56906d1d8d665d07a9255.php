<?php if(env("APP_ENV") === "production"): ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1FSF4PM5XX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());

        gtag('config', 'G-1FSF4PM5XX');
    </script>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/google_tag.blade.php ENDPATH**/ ?>