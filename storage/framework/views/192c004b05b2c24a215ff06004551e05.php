<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'viewName' => null
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'viewName' => null
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<nav class="sticky top-0">
    <section class="relative">
        
        <section class="sticky bg-brand-primary-950 py-3 px-2 lg:px-6 flex shadow-lg font-inter">
            
            <div class="px-4 flex items-center text-white gap-4 grow">
                <button aria-label="Open sidebar button" title="Open sidebar"
                    x-data
                    @click="document.getElementById('nav_sidebar').classList.add('sidebar_show');"
                    class="p-1 rounded transition-colors cursor-pointer">
                    <?php echo e(svg('zondicon-menu', 'w-5 h-5')); ?>
                </button>

                
                <div class="">
                    <h2 class="text-lg font-medium"><?php echo e($viewName); ?></h2>
                </div>
            </div>

            
            <div class="grow hidden md:flex items-center justify-end">

                
                <div class="relative group cursor-pointer">
                    <div class="flex items-center justify-end px-2 gap-3 min-w-[180px]">
                        <div class="text-white font-normal text-sm">
                            <span><?php echo e(Auth::user()->username); ?> (<?php echo e(Auth::user()->role); ?>)</span>
                        </div>
                        
                        <div>
                            <button class="text-white p-1">
                                <?php echo e(svg('tni-down', 'w-3 h-3')); ?>
                            </button>
                        </div>
                    </div>

                    
                    <div class="absolute top-full left-0 w-full bg-white rounded shadow-lg hidden group-hover:block">
                        <ul class="p-2 [&>*]:p-1 [&>*]:rounded-sm [&_*]:cursor-pointer text-sm">
                            <li class="hover:bg-gray-200">
                                <a href="<?php echo e(route('my_profile')); ?>" class="block w-full p-1">
                                    <span class="flex items-center gap-1">
                                        <?php echo e(svg('bi-person', 'w-5 h-5')); ?>
                                        My Profile
                                    </span>
                                </a>
                            </li>
                            <li class="hover:bg-red-300 hover:text-red-400">
                                <form method="POST" action="<?php echo e(route('user.logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="block w-full text-left p-1">
                                        <span class="flex items-center gap-1">
                                            <?php echo e(svg('css-log-out', 'w-5 h-5')); ?>
                                            Logout
                                        </span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>
        </section>

        
        <section
            id="nav_sidebar"
            class="sidebar flex flex-col items-center justify-start z-50 bg-white fixed top-0 left-0 h-screen shadow-lg p-4 w-full md:max-w-xs">
            
            <div class="w-full flex items-center justify-between md:justify-end">
                <img class="mb-2 h-15 object-contain block md:hidden" src="<?php echo e(asset('images/reftec_logo_transparent.png')); ?>">

                <button title="Close sidebar"
                    x-data
                    @click="document.getElementById('nav_sidebar').classList.remove('sidebar_show');"
                    class="flex items-center justify-center cursor-pointer py-1 px-2 gap-2 rounded hover:bg-accent-darkslategray-400 transition-colors">
                    <?php echo e(svg('zondicon-close', 'w-3 h-3')); ?>
                    Close
                </button>
            </div>

            
            
            <div class="w-full grow p-4 flex flex-col overflow-y-auto">
                <img class="mb-2 w-full h-30 object-contain hidden md:block" src="<?php echo e(asset('images/reftec_logo_transparent.png')); ?>">

                <div
                    class="flex flex-col gap-1 [&>*]:text-sm [&>*]:flex [&>*]:items-center [&>*]:gap-2 [&>*]:rounded [&>*]:hover:bg-brand-primary-100/75 [&>*]:transition-colors [&>*]:py-3 [&>*]:px-3">
                    <?php
                        $active_link_class_indicator = 'text-accent-orange-300 font-medium';
                        $sidebar_links = [
                            [
                                'route' => route('dashboard'),
                                'label' => 'Dashboard',
                                'active_name' => 'Dashboard',
                                'icon' => 'fluentui-board-28-o',
                            ],
                            [
                                'route' => '#',
                                'label' => 'Content',
                                'active_name' => 'Content',
                                'icon' => 'fluentui-content-view-28-o',
                            ],
                            [
                                'route' => '#',
                                'label' => 'Site Monitor',
                                'active_name' => 'Site Monitor',
                                'icon' => 'fluentui-camera-dome-28-o',
                            ],
                            [
                                'route' => '#',
                                'label' => 'Cartrack',
                                'active_name' => 'Cartrack',
                                'icon' => 'fluentui-vehicle-car-28-o',
                            ],
                            [
                                'route' => '#',
                                'label' => 'Users',
                                'active_name' => 'Users',
                                'icon' => 'fluentui-person-28-o',
                            ],
                        ];
                    ?>
                    <?php $__currentLoopData = $sidebar_links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e($link['route']); ?>" title="<?php echo e($link['label']); ?>"
                            <?php if($viewName === $link['active_name']): ?>
                                class="<?php echo e($active_link_class_indicator); ?>"
                            <?php endif; ?>
                            >
                            <?php echo e(svg($link['icon'], 'w-5 h-5')); ?>
                            <span class="grow"><?php echo e($link['label']); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            
            <footer class="w-full flex item-center justify-between md:hidden">
                <div class="flex items-center justify-start text-sm">
                    <a href="<?php echo e(route('my_profile')); ?>" title="View profile"
                        class="grow truncate flex items-center gap-1 hover:underline">
                        <?php echo e(svg('heroicon-o-user-circle', 'w-4 h-4')); ?>
                        <p class="truncate"><?php echo e(Auth::user()->username); ?> (<?php echo e(Auth::user()->role); ?>)</p>
                    </a>
                </div>
                <div class="">
                    <form method="POST" action="<?php echo e(route('user.logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" title="Logout"
                            class="scale-75 flex items-center justify-center px-2 py-1 cursor-pointer bg-brand-secondary-200 hover:bg-brand-secondary-300 text-brand-secondary-400 hover:text-brand-secondary-600 transition-colors rounded">
                            <?php echo e(svg('css-log-out', 'w-5 h-5')); ?>
                            Logout
                        </button>
                    </form>
                </div>
            </footer>
        </section>
    </section>
</nav>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/admin/main_navbar.blade.php ENDPATH**/ ?>