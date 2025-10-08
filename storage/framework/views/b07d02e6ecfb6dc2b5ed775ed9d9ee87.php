<!DOCTYPE html>
<html lang="en">
<?php if (isset($component)) { $__componentOriginal781d22988f835a9692410092c1d21cd6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal781d22988f835a9692410092c1d21cd6 = $attributes; } ?>
<?php $component = App\View\Components\Head::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('head'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Head::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal781d22988f835a9692410092c1d21cd6)): ?>
<?php $attributes = $__attributesOriginal781d22988f835a9692410092c1d21cd6; ?>
<?php unset($__attributesOriginal781d22988f835a9692410092c1d21cd6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal781d22988f835a9692410092c1d21cd6)): ?>
<?php $component = $__componentOriginal781d22988f835a9692410092c1d21cd6; ?>
<?php unset($__componentOriginal781d22988f835a9692410092c1d21cd6); ?>
<?php endif; ?>

<body class="bg-white">
    <?php if (isset($component)) { $__componentOriginal15f79b7b1115a653aee265fe441ae0aa = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal15f79b7b1115a653aee265fe441ae0aa = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar_public','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar_public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal15f79b7b1115a653aee265fe441ae0aa)): ?>
<?php $attributes = $__attributesOriginal15f79b7b1115a653aee265fe441ae0aa; ?>
<?php unset($__attributesOriginal15f79b7b1115a653aee265fe441ae0aa); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal15f79b7b1115a653aee265fe441ae0aa)): ?>
<?php $component = $__componentOriginal15f79b7b1115a653aee265fe441ae0aa; ?>
<?php unset($__componentOriginal15f79b7b1115a653aee265fe441ae0aa); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalc7ad210725a3e9ba31a9f070a043c34f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7ad210725a3e9ba31a9f070a043c34f = $attributes; } ?>
<?php $component = App\View\Components\PublicContentContainer::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public-content-container'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PublicContentContainer::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <div class="flex flex-col items-center justify-center my-12">
            <p class="text-2xl md:text-3xl font-inter font-black">
                <span class="text-accent-black_2">OUR </span>
                <span class="text-accent-orange-300">PROJECTS</span>
            </p>
            <p class="text-gray-800 text-sm font-medium text-center">FROM VISING TO REALITY - SEE WHAT WE'VE BUILT!</p>
        </div>


        <section class="border border-black p-4">
            
            <?php if (isset($component)) { $__componentOriginalc3aabc9e91b9a0921d1b45aaef52e92e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc3aabc9e91b9a0921d1b45aaef52e92e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.button_primary','data' => ['id' => 'btn_apply_filters','class' => 'px-4 py-2 rounded-sm cursor-pointer font-medium','title' => 'Apply Filters']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button_primary'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'btn_apply_filters','class' => 'px-4 py-2 rounded-sm cursor-pointer font-medium','title' => 'Apply Filters']); ?>
                Apply Filters
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc3aabc9e91b9a0921d1b45aaef52e92e)): ?>
<?php $attributes = $__attributesOriginalc3aabc9e91b9a0921d1b45aaef52e92e; ?>
<?php unset($__attributesOriginalc3aabc9e91b9a0921d1b45aaef52e92e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc3aabc9e91b9a0921d1b45aaef52e92e)): ?>
<?php $component = $__componentOriginalc3aabc9e91b9a0921d1b45aaef52e92e; ?>
<?php unset($__componentOriginalc3aabc9e91b9a0921d1b45aaef52e92e); ?>
<?php endif; ?>

            <section class="bg-red-300 flex flex-col md:flex-row items-end justify-end gap-2">
                <div class="bg-blue-300 flex flex-wrap items-end gap-2 justify-end w-full md:w-fit">

                    <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['name' => 'show_item_count','id' => 'dropdown_show_item_count','class' => 'rounded-sm grow','label' => 'Show item count']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'show_item_count','id' => 'dropdown_show_item_count','class' => 'rounded-sm grow','label' => 'Show item count']); ?>
                        <option value="10" selected>10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['name' => 'filter_status','id' => 'dropdown_filter_status','class' => 'rounded-sm grow','label' => 'Project Status','title' => 'Select Project Status']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'filter_status','id' => 'dropdown_filter_status','class' => 'rounded-sm grow','label' => 'Project Status','title' => 'Select Project Status']); ?>
                        <option>All</option>
                        <option value="ongoing" class="text-accent-orange-300 p-1">Ongoing</option>
                        <option value="completed" class="text-accent-lightseagreen-50 p-1">Completed</option>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>

                    
                    <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['name' => 'filter_date','size' => '6','id' => 'dropdown_filter_year','class' => 'rounded-sm','label' => 'Year','title' => 'Select Year Completed']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'filter_date','size' => '6','id' => 'dropdown_filter_year','class' => 'rounded-sm','label' => 'Year','title' => 'Select Year Completed']); ?>
                        <option value="all">All</option>
                        <?php for($year = date('Y'); $year >= 2005; $year--): ?>
                            <option value="<?php echo e($year); ?>">
                                <?php echo e($year); ?>

                            </option>
                        <?php endfor; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginal10474041cc391e92e186ff6e94ce8fd2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal10474041cc391e92e186ff6e94ce8fd2 = $attributes; } ?>
<?php $component = App\View\Components\Searchbox::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('searchbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Searchbox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'searchbox_projects','class' => 'grow w-full md:w-64 rounded-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal10474041cc391e92e186ff6e94ce8fd2)): ?>
<?php $attributes = $__attributesOriginal10474041cc391e92e186ff6e94ce8fd2; ?>
<?php unset($__attributesOriginal10474041cc391e92e186ff6e94ce8fd2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal10474041cc391e92e186ff6e94ce8fd2)): ?>
<?php $component = $__componentOriginal10474041cc391e92e186ff6e94ce8fd2; ?>
<?php unset($__componentOriginal10474041cc391e92e186ff6e94ce8fd2); ?>
<?php endif; ?>
                </div>
            </section>

            
            <?php
                // TODO: Make these server sided data retrieval.
                $fake_data = [
                    [
                        'status' => 'ongoing',
                        'thumbnail' => asset('images/reftec_logo_transparent_16x9.png'),
                        'title' => 'Bacolor, Pampanga',
                        'description' => 'Hello World Thessssssss.',
                        'date' => '2023-10-01',
                    ],
                    [
                        'status' => 'completed',
                        'thumbnail' => asset('images/layout_light_16x9.png'),
                        'title' => 'Project 2',
                        'description' => 'Description 2',
                        'date' => '2022-08-15',
                    ],
                    [
                        'status' => 'completed',
                        'thumbnail' => asset('images/layout_light_16x9.png'),
                        'title' => 'Project 3',
                        'description' => 'Description 3',
                        'date' => '2021-05-20',
                    ],
                    [
                        'status' => 'ongoing',
                        'thumbnail' => asset('images/layout_light_16x9.png'),
                        'title' => 'Project 4',
                        'description' => 'Description 4',
                        'date' => '2023-11-11',
                    ],
                    [
                        'status' => 'completed',
                        'thumbnail' => asset('images/layout_light_16x9.png'),
                        'title' => 'Project 5',
                        'description' => 'Description 5',
                        'date' => '2020-12-30',
                    ],
                    [
                        'status' => 'completed',
                        'thumbnail' => asset('images/layout_light_16x9.png'),
                        'title' => 'Project 6',
                        'description' => 'Description 6',
                        'date' => '2019-07-04',
                    ],
                ];
                $fake_data2 = [];
            ?>
            <section class="mt-4 p-4 flex flex-wrap gap-2 justify-start items-start">
                <?php if(count($fake_data) > 1): ?>
                    <?php $__currentLoopData = $fake_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="w-88 h-60 grow relative border cursor-pointer" x-data @click="
                                            $dispatch('preview_project_info', {
                                                modalId: 'modal_previewProject',
                                                projectInfo: <?php echo \Illuminate\Support\Js::from($project)->toHtml() ?>
                                            })
                                        ">
                            
                            <img src="<?php echo e($project['thumbnail']); ?>" alt="Project Thumbnail"
                                class="w-full h-full absolute top-0 left-0 object-cover bg-gray-200">

                            
                            <section
                                class="absolute top-0 left-0 w-full h-full opacity-0 hover:opacity-100 transition-opacity duration-300 ease-in-out z-10">

                                <div class="w-full h-full relative bg-red-300/50">
                                    <div
                                        class="relative w-full h-full bg-brand-primary-950/75 text-white p-4 pb-6 flex flex-col items-center justify-end">
                                        <?php if($project['status'] === 'ongoing'): ?>
                                            <p
                                                class="bg-accent-orange-300 absolute top-2 right-2 font-medium uppercase text-black px-2 py-1 rounded-full text-xs mb-2">
                                                Ongoing
                                            </p>
                                        <?php else: ?>
                                            <p
                                                class="bg-accent-lightseagreen-50 absolute top-2 right-2 font-medium uppercase text-white px-2 py-1 rounded-full text-xs mb-2">
                                                Completed
                                            </p>
                                        <?php endif; ?>

                                        <section class="w-[95%] absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                            <h2 class="text-lg font-black text-wrap text-center w-full">
                                                <?php echo e($project['title']); ?>

                                            </h2>
                                            <h3 class="text-accent-orange-300 text-md text-center w-full">
                                                <?php echo e($project['description']); ?>

                                            </h3>
                                        </section>
                                        <p class="text-xxs font-medium absolute bottom-2 left-2"><?php echo e($project['date']); ?></p>
                                    </div>
                                </div>

                            </section>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <section class="bg-gray-300 w-full p-6 flex justify-center items-center">
                        <h1 class="text-gray-600">No Projects Found</h1>
                    </section>
                <?php endif; ?>
            </section>
        </section>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7ad210725a3e9ba31a9f070a043c34f)): ?>
<?php $attributes = $__attributesOriginalc7ad210725a3e9ba31a9f070a043c34f; ?>
<?php unset($__attributesOriginalc7ad210725a3e9ba31a9f070a043c34f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7ad210725a3e9ba31a9f070a043c34f)): ?>
<?php $component = $__componentOriginalc7ad210725a3e9ba31a9f070a043c34f; ?>
<?php unset($__componentOriginalc7ad210725a3e9ba31a9f070a043c34f); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal8b44dd4dd8bb8ed1103dcc4c47e8c585 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8b44dd4dd8bb8ed1103dcc4c47e8c585 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal_preview_project','data' => ['id' => 'modal_previewProject','size' => '3xl','keyEscapeClose' => true,'clickOutsideToClose' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal_preview_project'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'modal_previewProject','size' => '3xl','keyEscapeClose' => true,'clickOutsideToClose' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8b44dd4dd8bb8ed1103dcc4c47e8c585)): ?>
<?php $attributes = $__attributesOriginal8b44dd4dd8bb8ed1103dcc4c47e8c585; ?>
<?php unset($__attributesOriginal8b44dd4dd8bb8ed1103dcc4c47e8c585); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8b44dd4dd8bb8ed1103dcc4c47e8c585)): ?>
<?php $component = $__componentOriginal8b44dd4dd8bb8ed1103dcc4c47e8c585; ?>
<?php unset($__componentOriginal8b44dd4dd8bb8ed1103dcc4c47e8c585); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal051a3d43725c36906c6dad2e76192d0f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal051a3d43725c36906c6dad2e76192d0f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.footer_public','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('footer_public'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal051a3d43725c36906c6dad2e76192d0f)): ?>
<?php $attributes = $__attributesOriginal051a3d43725c36906c6dad2e76192d0f; ?>
<?php unset($__attributesOriginal051a3d43725c36906c6dad2e76192d0f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal051a3d43725c36906c6dad2e76192d0f)): ?>
<?php $component = $__componentOriginal051a3d43725c36906c6dad2e76192d0f; ?>
<?php unset($__componentOriginal051a3d43725c36906c6dad2e76192d0f); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal56627af5da7e5f7ae4bce60ad80ec914 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56627af5da7e5f7ae4bce60ad80ec914 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.btn_backtotop','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('btn_backtotop'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56627af5da7e5f7ae4bce60ad80ec914)): ?>
<?php $attributes = $__attributesOriginal56627af5da7e5f7ae4bce60ad80ec914; ?>
<?php unset($__attributesOriginal56627af5da7e5f7ae4bce60ad80ec914); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56627af5da7e5f7ae4bce60ad80ec914)): ?>
<?php $component = $__componentOriginal56627af5da7e5f7ae4bce60ad80ec914; ?>
<?php unset($__componentOriginal56627af5da7e5f7ae4bce60ad80ec914); ?>
<?php endif; ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/projects.blade.php ENDPATH**/ ?>