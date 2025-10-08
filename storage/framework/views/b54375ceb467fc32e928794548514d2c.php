<footer id="footer_" class="bg-cover bg-center relative border-t-4 border-accent-orange-300 mt-[100px]"
    style="background-image: url('<?php echo e(asset('images/footerbg.jpg')); ?>');">
    <div class="block absolute top-0 left-0 w-full h-full bg-accent-darkslategray-900/75 z-0"></div>
    <img class="absolute bottom-3 right-0 opacity-50" src="<?php echo e(asset('images/reftec_logo_transparent.png')); ?>" alt="Reftec Logo" />

    <section class="z-1 relative">
        <section class="px-4 py-10 flex gap-6 items-center justify-center flex-col md:flex-row">
            <?php if (isset($component)) { $__componentOriginal8b34e4595e6f567ba75184140d1924a4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8b34e4595e6f567ba75184140d1924a4 = $attributes; } ?>
<?php $component = App\View\Components\Googlemap::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('googlemap'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Googlemap::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8b34e4595e6f567ba75184140d1924a4)): ?>
<?php $attributes = $__attributesOriginal8b34e4595e6f567ba75184140d1924a4; ?>
<?php unset($__attributesOriginal8b34e4595e6f567ba75184140d1924a4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8b34e4595e6f567ba75184140d1924a4)): ?>
<?php $component = $__componentOriginal8b34e4595e6f567ba75184140d1924a4; ?>
<?php unset($__componentOriginal8b34e4595e6f567ba75184140d1924a4); ?>
<?php endif; ?>

            <div class="flex gap-4 flex-col align-center lg:flex-row">

                <div class="flex flex-col align-center justify-start md:align-start flex-1 text-white">
                    <p class="font-inter font-black text-lg">VISIT US</p>
                    <div class="mt-2">
                        <p class="text-xs">[ Main Office ]</p>
                        <div class="mt-2 flex flex-col justify-start">
                            <div class="flex items-center justify-start gap-2">
                                <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-map-pin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 p-0 m-0 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                </div>
                                <a href="https://maps.app.goo.gl/WGAbyKPD9McargPf6" class="hover:underline" target="_blank" rel="noopener noreferrer">
                                    <p class="text-sm">6001-C Tatalon St., Ugong Valenzuela City, Philippines</p>
                                </a>
                            </div>
                            <div class="flex items-center justify-start gap-2">
                                <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-phone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 p-0 m-0 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                </div>
                                <a href="tel:+63289614549" class="text-sm hover:underline">+63 2 8961 4549</a>
                            </div>
                        </div>
                    </div>
                    <hr class="my-2 opacity-50" />
                    <div>
                        <p class="text-xs">[ Satellite Offices ]</p>
                        <div class="mt-2 flex flex-col justify-start">
                            <div class="flex items-center justify-start gap-2">
                                <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-map-pin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 p-0 m-0 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                </div>
                                <a href="https://maps.app.goo.gl/adGUc1M63rg3dNxYA" class="hover:underline" target="_blank" rel="noopener noreferrer">
                                    <p class="text-sm">JSP Corporate Building, 4378 Dayap St., Palanan Makati City</p>
                                </a>
                            </div>
                            <div class="flex items-center justify-start gap-2">
                                <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-phone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 p-0 m-0 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                </div>
                                <a href="tel:+63279030836" class="text-sm hover:underline">+63 2 7903 0836</a>
                            </div>
                        </div>
                        <div class="mt-2 flex flex-col justify-start">
                            <div class="flex items-center justify-start gap-2">
                                <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-map-pin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 p-0 m-0 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                </div>
                                <p class="text-sm">Loberiza Subdivision, Poblacion Ilawod, Lambunao, Iloilo</p>
                            </div>
                            <div class="flex items-center justify-start gap-2">
                                <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-phone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5 p-0 m-0 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                </div>
                                <a href="tel:+63335337625" class="text-sm hover:underline">+63 33 533 7625</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col align-center justify-start md:align-start flex-1 text-white">
                    <p class="font-inter font-black text-lg">OUR SOCIALS & EMAILS</p>
                    <div class="mt-2">
                        <div class="flex items-center justify-start gap-2">
                            <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                <i data-lucide="facebook" class="w-6 h-6 fill-current text-white"></i>
                            </div>
                            <a href="https://www.facebook.com/ReftecIndustrialSupplyandServicesInc/" class="hover:underline" target="_blank" rel="noopener noreferrer">
                                <p class="text-sm">ReftecIndustrialSupplyandServicesInc</p>
                            </a>
                        </div>
                        <div class="flex items-center justify-start gap-2">
                            <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-envelope'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 p-0 m-0 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            </div>
                            <a href="mailto:reftecindustrialsupply@gmail.com" class="hover:underline" target="_blank" rel="noopener noreferrer">
                                <p class="text-sm">reftecindustrialsupply@gmail.com</p>
                            </a>
                        </div>
                        <div class="flex items-center justify-start gap-2">
                            <div class="p-1 m-0 w-8 h-8 flex items-center justify-center">
                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-s-envelope'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 p-0 m-0 text-white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                            </div>
                            <a href="mailto:reftec.indl@gmail.com" class="hover:underline" target="_blank" rel="noopener noreferrer">
                                <p class="text-sm">reftec.indl@gmail.com</p>
                            </a>
                        </div>

                    </div>
                </div>

                
                <div class="flex flex-col align-center justify-start md:align-start flex-1 text-white">
                    <p class="font-inter font-black text-lg">QUICK LINKS</p>
                    <div class="mt-2">
                        <ul class="flex flex-col gap-2">
                            <li>
                                <a href="<?php echo e(route('home')); ?>" class="hover:underline text-sm">Home</a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('projects')); ?>" class="hover:underline text-sm">Projects</a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('products')); ?>" class="hover:underline text-sm">Products</a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('about_us')); ?>" class="hover:underline text-sm">About Us</a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('login')); ?>" class="hover:underline text-sm">Admin Panel</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>


        </section>

        
        <section class="bg-brand-primary-950 text-white py-4 font-inter font-medium text-center text-xs">
            <p><?php echo e(env('APP_NAME')); ?> &copy; <?php echo e(date('Y')); ?>, All rights reserved.</p>
        </section>
    </section>
</footer>

<?php if (isset($component)) { $__componentOriginalb67903385af8e7d3445bf7490bb5c75b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb67903385af8e7d3445bf7490bb5c75b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.google_tag','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('google_tag'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb67903385af8e7d3445bf7490bb5c75b)): ?>
<?php $attributes = $__attributesOriginalb67903385af8e7d3445bf7490bb5c75b; ?>
<?php unset($__attributesOriginalb67903385af8e7d3445bf7490bb5c75b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb67903385af8e7d3445bf7490bb5c75b)): ?>
<?php $component = $__componentOriginalb67903385af8e7d3445bf7490bb5c75b; ?>
<?php unset($__componentOriginalb67903385af8e7d3445bf7490bb5c75b); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/footer_public.blade.php ENDPATH**/ ?>