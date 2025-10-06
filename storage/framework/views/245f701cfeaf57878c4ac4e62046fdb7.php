<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <link rel="shortcut icon" href="<?php echo e(asset('images/logo_favicon_64x64_3.png')); ?>" type="image/x-icon">

    <title><?php echo e($title ?? config('app.name', 'Laravel Project')); ?></title>

    <!-- Styles / Scripts -->
    <?php if(file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))): ?>
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <?php endif; ?>
</head><?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/head.blade.php ENDPATH**/ ?>