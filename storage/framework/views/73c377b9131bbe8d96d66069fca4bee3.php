<?php if (isset($component)) { $__componentOriginal9f5317c909fa206256be66ed1f97ca7f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f5317c909fa206256be66ed1f97ca7f = $attributes; } ?>
<?php $component = App\View\Components\Topbarcompanycontacts::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('topbarcompanycontacts'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Topbarcompanycontacts::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f5317c909fa206256be66ed1f97ca7f)): ?>
<?php $attributes = $__attributesOriginal9f5317c909fa206256be66ed1f97ca7f; ?>
<?php unset($__attributesOriginal9f5317c909fa206256be66ed1f97ca7f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f5317c909fa206256be66ed1f97ca7f)): ?>
<?php $component = $__componentOriginal9f5317c909fa206256be66ed1f97ca7f; ?>
<?php unset($__componentOriginal9f5317c909fa206256be66ed1f97ca7f); ?>
<?php endif; ?>
<nav class="sticky shadow-md bg-white px-5 py-2 top-0 z-50 transition-all duration-300 ease-out transform scale-y-100 origin-top"
    id="main-navbar">
    <section class="max-w-6xl mx-auto">
        
        <section class="flex flex-wrap justify-between items-center mx-auto">
            
            <a href="<?php echo e(false ? null : route('home')); ?>" class="flex items-center space-x-2 py-2">
                <img src="<?php echo e(asset('images/reftec_logo_notext.svg')); ?>" class="w-15 sm:w-20" alt="Logo" loading="lazy">
                <span class="p-0 m-0 font-semibold text-xs md:text-lg text-gray-800 font-castle uppercase">Industrial
                    Supply and <br class="block sm:hidden" /> Services Inc.</span>
            </a>

            
            <section class="md:hidden">
                <button id="mobile-menu-toggle" class="p-2 rounded hover:bg-gray-200 cursor-pointer" title="menu">
                    <i data-lucide="menu" class="w-6 h-6 text-black"></i>
                </button>
            </section>

            
            <section class="hidden md:block">
                <ul class="flex space-x-2">
                    <?php
                        $nav_links = [
                            ['name' => 'Home', 'route' => 'home'],
                            ['name' => 'Projects', 'route' => 'projects'],
                            ['name' => 'Products', 'route' => 'products'],
                            ['name' => 'About Us', 'route' => 'about_us'],
                        ];
                    ?>
                    <?php $__currentLoopData = $nav_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="px-2 py-2">
                            <a href="<?php echo e(route($link['route'])); ?>"
                                class="<?php echo e(Route::currentRouteName() === $link['route'] ? 'font-bold text-accent-orange-300' : 'text-black font-regular'); ?> text-sm uppercase hover:font-bold">
                                <?php echo e($link['name']); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </ul>
            </section>
        </section>

        
        <section class="flex justify-center">
            
            <section id="mobile-menu"
                class="flex-1 md:hidden hidden transition-all duration-300 ease-out transform -translate-y-4 opacity-0 pointer-events-none">
                <ul class="w-full flex flex-col">
                    <?php $__currentLoopData = $nav_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(Route::has($link['route'])): ?>
                            <li class="w-full px-4 py-2 text-center font-inter">
                                <a href="<?php echo e(route($link['route'])); ?>"
                                    class="<?php echo e(Route::currentRouteName() === $link['route'] ? 'font-bold text-accent-orange-300' : 'text-black font-regular'); ?> text-sm uppercase hover:font-bold">
                                    <?php echo e($link['name']); ?>

                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </section>
        </section>
    </section>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('mobile-menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        toggleBtn.addEventListener('click', function() {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                setTimeout(() => {
                    mobileMenu.classList.remove('-translate-y-4', 'opacity-0',
                        'pointer-events-none');
                    mobileMenu.classList.add('translate-y-0', 'opacity-100');
                }, 10);
            } else {
                mobileMenu.classList.remove('translate-y-0', 'opacity-100');
                mobileMenu.classList.add('-translate-y-4', 'opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300); // match duration-300
            }
        });
    });
</script>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/navbar_public.blade.php ENDPATH**/ ?>