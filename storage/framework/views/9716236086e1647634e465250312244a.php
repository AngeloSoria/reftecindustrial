

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

<body class="bg-gray-200">
    <?php if (isset($component)) { $__componentOriginaldfec92ee2ee21047beee3ae96bc01f9c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldfec92ee2ee21047beee3ae96bc01f9c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.main_navbar','data' => ['viewName' => 'Profile Information']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.main_navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['viewName' => 'Profile Information']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldfec92ee2ee21047beee3ae96bc01f9c)): ?>
<?php $attributes = $__attributesOriginaldfec92ee2ee21047beee3ae96bc01f9c; ?>
<?php unset($__attributesOriginaldfec92ee2ee21047beee3ae96bc01f9c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldfec92ee2ee21047beee3ae96bc01f9c)): ?>
<?php $component = $__componentOriginaldfec92ee2ee21047beee3ae96bc01f9c; ?>
<?php unset($__componentOriginaldfec92ee2ee21047beee3ae96bc01f9c); ?>
<?php endif; ?>

    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-8">
                    <div class="flex items-center">
                        <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-3xl font-bold text-gray-700">
                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                        </div>
                        <div class="ml-6">
                            <h1 class="text-3xl font-bold text-white"><?php echo e($user->name); ?></h1>
                            <p class="text-blue-100">&commat;<?php echo e($user->username); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="px-6 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Personal Information -->
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Personal Information</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Full Name</label>
                                    <p class="mt-1 text-lg text-gray-900"><?php echo e($user->name); ?></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Username</label>
                                    <p class="mt-1 text-lg text-gray-900"><?php echo e($user->username); ?></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600">Role</label>
                                    <p class="mt-1 text-lg text-gray-900"><?php echo e(ucfirst($user->role)); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Account Settings -->
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Account Settings</h2>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Email Notifications</h3>
                                        <p class="text-sm text-gray-600">Receive notifications via email</p>
                                    </div>
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                                        Manage
                                    </button>
                                </div>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Password</h3>
                                        <p class="text-sm text-gray-600">Update your password</p>
                                    </div>
                                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200">
                                        Change
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <button class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-md font-medium transition duration-200">
                            Edit Profile
                        </button>
                        <button class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-md font-medium transition duration-200">
                            Delete Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/auth/profile.blade.php ENDPATH**/ ?>