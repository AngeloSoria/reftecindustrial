<nav class="relative">
    
    <section class="bg-brand-primary-950 py-3 px-2 lg:px-6 flex shadow-lg font-inter">
        
        <div class="px-4 flex items-center text-white gap-4 grow">
            <button aria-label="Open sidebar button" title="Open sidebar"
                class="p-1 rounded transition-colors cursor-pointer">
                <?php echo e(svg('zondicon-menu', 'w-5 h-5')); ?>
            </button>

            
            <div class="">
                <h2 class="text-lg font-medium">Dashboard</h2>
            </div>
        </div>

        
        <div class="grow hidden md:flex items-center justify-end">

            
            <div class="relative group cursor-pointer">
                <div class="flex items-center justify-center gap-3">
                    <div class="text-white font-normal text-sm">
                        <span>TwentyLongCharacters (Super Admin)</span>
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
                            <a href="#" class="block w-full p-1">
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
        class="flex flex-col items-center justify-start z-50 bg-white fixed top-0 left-0 h-screen shadow-lg p-4 w-full md:max-w-xs">
        
        <div class="w-full flex items-center justify-between md:justify-end">
            <img class="mb-2 h-15 object-contain block md:hidden" src="<?php echo e(asset('images/reftec_logo_transparent.png')); ?>">

            <button title="Close sidebar"
                class="flex items-center justify-center cursor-pointer py-1 px-2 gap-2 rounded hover:bg-accent-darkslategray-400 transition-colors">
                <?php echo e(svg('zondicon-close', 'w-3 h-3')); ?>
                Close
            </button>
        </div>

        
        <div class="w-full grow p-4 flex flex-col overflow-y-auto">
            <img class="mb-2 w-full h-30 object-contain hidden md:block" src="<?php echo e(asset('images/reftec_logo_transparent.png')); ?>">

            <div
                class="flex flex-col gap-1 [&>*]:text-sm [&>*]:flex [&>*]:items-center [&>*]:gap-2 [&>*]:rounded [&>*]:hover:bg-brand-primary-100/50 [&>*]:transition-colors [&>*]:py-3 [&>*]:px-3">
                <a href="#" title="Dashboard" class="text-accent-orange-300 font-medium">
                    <?php echo e(svg('fluentui-board-28-o', 'w-5 h-5')); ?>
                    <span class="grow">Dashboard</span>
                </a>
                <a href="#" title="Content" class="">
                    <?php echo e(svg('fluentui-content-view-28-o', 'w-5 h-5')); ?>
                    <span class="grow">Content</span>
                </a>
                <a href="#" title="Site Monitor" class="">
                    <?php echo e(svg('fluentui-camera-dome-28-o', 'w-5 h-5')); ?>
                    <span class="grow">Site Monitor</span>
                </a>
                <a href="#" title="Cartrack" class="">
                    <?php echo e(svg('fluentui-vehicle-car-28-o', 'w-5 h-5')); ?>
                    <span class="grow">Cartrack</span>
                </a>
                <a href="#" title="Users" class="">
                    <?php echo e(svg('fluentui-person-28-o', 'w-5 h-5')); ?>
                    <span class="grow">Users</span>
                </a>
            </div>
        </div>

        
        <footer class="w-full flex item-center justify-between md:hidden">
            <div class="flex items-center justify-start text-sm">
                <a href="<?php echo e(route('admin.profile')); ?>" title="View profile"
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
</nav>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/admin/main_navbar.blade.php ENDPATH**/ ?>