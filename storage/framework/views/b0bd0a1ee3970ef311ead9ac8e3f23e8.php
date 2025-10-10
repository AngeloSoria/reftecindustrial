<!DOCTYPE html>
<html lang="en">
<?php if (isset($component)) { $__componentOriginalf16d502bcc1d2bf0d5792689447a2237 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf16d502bcc1d2bf0d5792689447a2237 = $attributes; } ?>
<?php $component = App\View\Components\Partials\Head::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('partials.head'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Partials\Head::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf16d502bcc1d2bf0d5792689447a2237)): ?>
<?php $attributes = $__attributesOriginalf16d502bcc1d2bf0d5792689447a2237; ?>
<?php unset($__attributesOriginalf16d502bcc1d2bf0d5792689447a2237); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf16d502bcc1d2bf0d5792689447a2237)): ?>
<?php $component = $__componentOriginalf16d502bcc1d2bf0d5792689447a2237; ?>
<?php unset($__componentOriginalf16d502bcc1d2bf0d5792689447a2237); ?>
<?php endif; ?>

<body class="bg-white">
    <?php if (isset($component)) { $__componentOriginal24b26e29529f8623861cf24335ce22b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal24b26e29529f8623861cf24335ce22b5 = $attributes; } ?>
<?php $component = App\View\Components\Public\Navbar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Public\Navbar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal24b26e29529f8623861cf24335ce22b5)): ?>
<?php $attributes = $__attributesOriginal24b26e29529f8623861cf24335ce22b5; ?>
<?php unset($__attributesOriginal24b26e29529f8623861cf24335ce22b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal24b26e29529f8623861cf24335ce22b5)): ?>
<?php $component = $__componentOriginal24b26e29529f8623861cf24335ce22b5; ?>
<?php unset($__componentOriginal24b26e29529f8623861cf24335ce22b5); ?>
<?php endif; ?>

    
    
    <section class="w-full h-100 bg-cover bg-center flex items-center justify-start relative"
        style="background-image: url('<?php echo e(asset('images/bulan.jpg')); ?>');">
        <div class="block absolute top-0 left-0 w-full h-full bg-black/85 z-0"></div>
        <section class="max-w-6xl z-1 mx-auto flex items-center justify-center sm:justify-start w-full px-2 md:px-6">
            <div
                class="font-inter p-2 flex flex-col items-center sm:items-start justify-center sm:justify-start space-y-2 w-full">
                
                <h1 class="text-1xl md:text-2xl text-white italic font-regular">Celebrating <?php echo e(date('Y') - 2005); ?> years
                    of</h1>
                <h1
                    class="text-2xl md:text-4xl text-white uppercase font-black text-wrap max-w-2xl text-center sm:text-start">
                    Reliable Refrigeration & Water System Engineering</h1>
                <div class="mt-4 flex space-x-4">
                    <?php if (isset($component)) { $__componentOriginal88e194ea5af2264fb57a3d3762059d4f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88e194ea5af2264fb57a3d3762059d4f = $attributes; } ?>
<?php $component = App\View\Components\Public\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Public\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['button_type' => 'primary','href' => '#footer_']); ?>Contact Us <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88e194ea5af2264fb57a3d3762059d4f)): ?>
<?php $attributes = $__attributesOriginal88e194ea5af2264fb57a3d3762059d4f; ?>
<?php unset($__attributesOriginal88e194ea5af2264fb57a3d3762059d4f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88e194ea5af2264fb57a3d3762059d4f)): ?>
<?php $component = $__componentOriginal88e194ea5af2264fb57a3d3762059d4f; ?>
<?php unset($__componentOriginal88e194ea5af2264fb57a3d3762059d4f); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal88e194ea5af2264fb57a3d3762059d4f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88e194ea5af2264fb57a3d3762059d4f = $attributes; } ?>
<?php $component = App\View\Components\Public\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Public\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['button_type' => 'secondary','href' => '#OurHistory_']); ?>Learn More <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88e194ea5af2264fb57a3d3762059d4f)): ?>
<?php $attributes = $__attributesOriginal88e194ea5af2264fb57a3d3762059d4f; ?>
<?php unset($__attributesOriginal88e194ea5af2264fb57a3d3762059d4f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88e194ea5af2264fb57a3d3762059d4f)): ?>
<?php $component = $__componentOriginal88e194ea5af2264fb57a3d3762059d4f; ?>
<?php unset($__componentOriginal88e194ea5af2264fb57a3d3762059d4f); ?>
<?php endif; ?>
                </div>
            </div>
        </section>
    </section>

    <?php if (isset($component)) { $__componentOriginal536b7d70a1e0db72e0ac6cabf8a9fee0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal536b7d70a1e0db72e0ac6cabf8a9fee0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.public.content_container','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.content_container'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        
        <section class="px-4 my-6 relative">
            <div class="flex flex-col items-center justify-center">
                <p class="text-2xl md:text-3xl font-inter font-black text-accent-orange-300">PRODUCT LINES</p>
                <p class="text-black text-sm font-medium text-center">HERE TO PROVIDE YOU TOP NOTCH SERVICES AND
                    PRODUCTS</p>
            </div>

            
            <div data-aos="fade-up" data-aos-anchor-placement="center-center"
                class="mt-4 bg-accent-darkslategray-900 grid gap-1 md:gap-0 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 relative">
                <?php
                    // TODO: This will be replaced by server rendered product lines.
                    $productLines = [
                        [
                            'name' => 'KINGSPAN RHINO WATER TANKS, AUSTRALIA',
                            'image' => asset('images/kingspan.jpg'),
                        ],
                        [
                            'name' => 'STARR PANEL, INDONESIA',
                            'image' => asset('images/starr.jpg'),
                        ],
                        [
                            'name' => 'VILTER REFRIGERATION EQUIPMENT, USA',
                            'image' => asset('images/vilter_logo.png'),
                        ],
                    ];
                ?>
                <?php $__currentLoopData = $productLines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productLine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <section class="w-full relative h-24 overflow-hidden">
                        
                        <img src="<?php echo e($productLine['image']); ?>" alt="<?php echo e($productLine['name']); ?>" class="w-full m-auto" />

                        
                        <div class="z-2 w-[90%] absolute bottom-0 left-1/2 -translate-x-1/2 p-2 text-white text-center">
                            <h2 class="text-sm text-shadow font-medium"><?php echo e($productLine['name']); ?></h2>
                        </div>

                        
                        <div
                            class="z-1 absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-black/90 to-transparent pointer-events-none">
                        </div>
                    </section>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>

        
        <section id="OurHistory_" class="scroll-mt-16 px-4 my-6 mt-[100px] relative overflow-hidden">
            <div data-aos="fade-right" data-aos-duration="1500"
                class="flex flex-col mb-10 items-center md:items-start md:ms-[80px]">
                <p class="text-2xl md:text-3xl font-inter font-black">
                    <span class="text-accent-black_2">OUR</span>
                    <span class="text-accent-orange-300">HISTORY</span>
                </p>
            </div>

            <div class="mt-4 p-4 md:p-6 grid grid-cols-1 md:grid-cols-2 gap-2">

                
                <div data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-duration="1200"
                    class="text-black order-2 md:order-1 bg-[#ecf0f1] shadow-md flex flex-col justify-center item-end -border-4 -border-accent-orange-300 p-6 rounded">
                    <p class="text-sm md:text-base text-justify font-inter font-medium leading-relaxed">
                        Founded in 2005 as Single Proprietorship,<span class="font-black text-brand-secondary-300">
                            REFTEC
                            Industrial Supply and Services Inc.</span> is 100%
                        Filipino-owned Company and was registered with Securities and Exchange Commission as Corporation
                        in 2011.

                        <br />
                        <br />

                        The main business is installing ice plants and cold storages and fabricating ice plant
                        components. It also supplies and installs commercial water tanks and other services related to
                        water industry and refrigeration.
                    </p>
                    <section class="flex justify-end w-full">
                        <?php if (isset($component)) { $__componentOriginal88e194ea5af2264fb57a3d3762059d4f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88e194ea5af2264fb57a3d3762059d4f = $attributes; } ?>
<?php $component = App\View\Components\Public\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Public\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['button_type' => 'secondary','href' => ''.e(route('aboutus')).'','class' => 'mt-4 rounded flex items-center gap-2']); ?>
                            Learn More
                            <?php echo e(svg('fluentui-arrow-right-16-o', 'w-4 h-4 text-white')); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88e194ea5af2264fb57a3d3762059d4f)): ?>
<?php $attributes = $__attributesOriginal88e194ea5af2264fb57a3d3762059d4f; ?>
<?php unset($__attributesOriginal88e194ea5af2264fb57a3d3762059d4f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88e194ea5af2264fb57a3d3762059d4f)): ?>
<?php $component = $__componentOriginal88e194ea5af2264fb57a3d3762059d4f; ?>
<?php unset($__componentOriginal88e194ea5af2264fb57a3d3762059d4f); ?>
<?php endif; ?>
                    </section>
                </div>

                
                
                <div data-aos="fade-left" data-aos-anchor-placement="top-bottom" data-aos-duration="1000"
                    class="order-1 md:order-2 w-full md:h-auto aspect-video md:aspect-auto overflow-hidden">
                    <img src="<?php echo e(asset('images/our_history.png')); ?>" alt="Our History"
                        class="w-full h-full object-cover" loading="lazy" />
                </div>

            </div>
        </section>

        
        <section class="scroll-mt-16 px-4 my-6 mt-[100px] relative">
            <div data-aos="fade-down" data-aos-duration="1200" class="flex flex-col items-center">
                <p class="text-2xl md:text-3xl font-inter font-black">
                    <span class="text-accent-black_2">AND</span>
                    <span class="text-accent-orange-300">PROJECTS</span>
                </p>
            </div>

            
            <section class="flex flex-col space-y-7 lg:space-y-20 mt-20 overflow-hidden">
                <?php
                    // Example highlighted projects array
                    $highlightedProjects = [
                        [
                            'title' => 'Project Title 1',
                            'description' => 'Brief description of Project 1. This is a placeholder text.',
                            'image' => asset('images/layout_light_16x9.png'),
                            'status' => 'COMPLETED',
                            'status_color' => 'bg-accent-lightseagreen-50',
                        ],
                        [
                            'title' => 'Project Title 2',
                            'description' => 'Brief description of Project 2. This is a placeholder text.',
                            'image' => asset('images/layout_light_16x9.png'),
                            'status' => 'COMPLETED',
                            'status_color' => 'bg-accent-lightseagreen-50',
                        ],
                        [
                            'title' => 'Project Title 3',
                            'description' => 'Brief description of Project 3. This is a placeholder text.',
                            'image' => asset('images/layout_light_16x9.png'),
                            'status' => 'ON GOING',
                            'status_color' => 'bg-accent-orange-300',
                        ],
                    ];
                ?>

                <?php for($i = 0; $i < count($highlightedProjects); $i++): ?>
                    <?php
                        $project = $highlightedProjects[$i];
                        $isEven = $i % 2 === 1;
                    ?>
                    <div
                        class="p-4 bg-gray-100 shadow-lg md:shadow-none md:bg-transparent flex flex-col md:flex-row items-end justify-center lg:space-x-[-150px] md:-space-x-28">
                        <?php if(!$isEven): ?>
                            
                            <div data-aos="fade-right" data-aos-duration="900"
                                class="w-full h-full lg:w-[685px] lg:h-[400px] overflow-hidden">
                                <img src="<?php echo e($project['image']); ?>" alt="<?php echo e($project['title']); ?>"
                                    class="w-full h-full object-fill" loading="lazy" />
                            </div>
                            
                            <div data-aos="fade-left" data-aos-duration="900"
                                class="z-2 w-full mt-2 lg:w-1/2 mb-6 flex flex-col justify-center">
                                <div>
                                    <span
                                        class="text-sm text-white <?php echo e($project['status_color']); ?> px-2 py-1 font-medium"><?php echo e($project['status']); ?></span>
                                </div>
                                <div class="p-4 md:bg-brand-primary-950 text-black md:text-white">
                                    <h2 class="text-xl font-bold"><?php echo e($project['title']); ?></h2>
                                    <p class="text-sm"><?php echo e($project['description']); ?></p>
                                </div>
                            </div>
                        <?php else: ?>
                            
                            <div data-aos="fade-right" data-aos-duration="900"
                                class="z-2 w-full lg:w-1/2 mb-6 flex flex-col justify-center">
                                <div>
                                    <span
                                        class="text-sm text-white <?php echo e($project['status_color']); ?> px-2 py-1 font-medium"><?php echo e($project['status']); ?></span>
                                </div>
                                <div class="p-4 md:bg-brand-primary-950 text-black md:text-white">
                                    <h2 class="text-xl font-bold"><?php echo e($project['title']); ?></h2>
                                    <p class="text-sm"><?php echo e($project['description']); ?></p>
                                </div>
                            </div>
                            
                            <div data-aos="fade-left" data-aos-duration="900"
                                class="w-full lg:w-[685px] lg:h-[400px] overflow-hidden">
                                <img src="<?php echo e($project['image']); ?>" alt="<?php echo e($project['title']); ?>"
                                    class="w-full h-full object-fill" loading="lazy" />
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endfor; ?>
            </section>

            <div data-aos="fade-up" class="w-full flex justify-center items-center p-8">
                <?php if (isset($component)) { $__componentOriginal88e194ea5af2264fb57a3d3762059d4f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88e194ea5af2264fb57a3d3762059d4f = $attributes; } ?>
<?php $component = App\View\Components\Public\Button::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Public\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['button_type' => 'primary','href' => ''.e(route('projects')).'','class' => 'rounded font-bold text-white','size' => '2xl']); ?>
                    View All Projects
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88e194ea5af2264fb57a3d3762059d4f)): ?>
<?php $attributes = $__attributesOriginal88e194ea5af2264fb57a3d3762059d4f; ?>
<?php unset($__attributesOriginal88e194ea5af2264fb57a3d3762059d4f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88e194ea5af2264fb57a3d3762059d4f)): ?>
<?php $component = $__componentOriginal88e194ea5af2264fb57a3d3762059d4f; ?>
<?php unset($__componentOriginal88e194ea5af2264fb57a3d3762059d4f); ?>
<?php endif; ?>
            </div>
        </section>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal536b7d70a1e0db72e0ac6cabf8a9fee0)): ?>
<?php $attributes = $__attributesOriginal536b7d70a1e0db72e0ac6cabf8a9fee0; ?>
<?php unset($__attributesOriginal536b7d70a1e0db72e0ac6cabf8a9fee0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal536b7d70a1e0db72e0ac6cabf8a9fee0)): ?>
<?php $component = $__componentOriginal536b7d70a1e0db72e0ac6cabf8a9fee0; ?>
<?php unset($__componentOriginal536b7d70a1e0db72e0ac6cabf8a9fee0); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal890ea597e738b5ea559a49d7ff2a5a2b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal890ea597e738b5ea559a49d7ff2a5a2b = $attributes; } ?>
<?php $component = App\View\Components\Public\Footer::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Public\Footer::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal890ea597e738b5ea559a49d7ff2a5a2b)): ?>
<?php $attributes = $__attributesOriginal890ea597e738b5ea559a49d7ff2a5a2b; ?>
<?php unset($__attributesOriginal890ea597e738b5ea559a49d7ff2a5a2b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal890ea597e738b5ea559a49d7ff2a5a2b)): ?>
<?php $component = $__componentOriginal890ea597e738b5ea559a49d7ff2a5a2b; ?>
<?php unset($__componentOriginal890ea597e738b5ea559a49d7ff2a5a2b); ?>
<?php endif; ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/home.blade.php ENDPATH**/ ?>