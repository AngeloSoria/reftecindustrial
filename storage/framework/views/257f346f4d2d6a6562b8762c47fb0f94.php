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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.main_navbar','data' => ['viewName' => 'Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.main_navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['viewName' => 'Dashboard']); ?>
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

    <?php if (isset($component)) { $__componentOriginal4847a34d9a9b51a112e7c621e54cdc94 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4847a34d9a9b51a112e7c621e54cdc94 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.db_widget_counter','data' => ['icon' => 'fluentui-person-16-o','iconColor' => 'bg-brand-secondary-300','label' => 'Total Visits (Week)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.db_widget_counter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'fluentui-person-16-o','iconColor' => 'bg-brand-secondary-300','label' => 'Total Visits (Week)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4847a34d9a9b51a112e7c621e54cdc94)): ?>
<?php $attributes = $__attributesOriginal4847a34d9a9b51a112e7c621e54cdc94; ?>
<?php unset($__attributesOriginal4847a34d9a9b51a112e7c621e54cdc94); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4847a34d9a9b51a112e7c621e54cdc94)): ?>
<?php $component = $__componentOriginal4847a34d9a9b51a112e7c621e54cdc94; ?>
<?php unset($__componentOriginal4847a34d9a9b51a112e7c621e54cdc94); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal4847a34d9a9b51a112e7c621e54cdc94 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4847a34d9a9b51a112e7c621e54cdc94 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.db_widget_counter','data' => ['icon' => 'fluentui-vehicle-car-16-o','iconColor' => 'bg-accent-orange-300','label' => 'Total Car Trips (Month)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.db_widget_counter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'fluentui-vehicle-car-16-o','iconColor' => 'bg-accent-orange-300','label' => 'Total Car Trips (Month)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4847a34d9a9b51a112e7c621e54cdc94)): ?>
<?php $attributes = $__attributesOriginal4847a34d9a9b51a112e7c621e54cdc94; ?>
<?php unset($__attributesOriginal4847a34d9a9b51a112e7c621e54cdc94); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4847a34d9a9b51a112e7c621e54cdc94)): ?>
<?php $component = $__componentOriginal4847a34d9a9b51a112e7c621e54cdc94; ?>
<?php unset($__componentOriginal4847a34d9a9b51a112e7c621e54cdc94); ?>
<?php endif; ?>
    <?php if (isset($component)) { $__componentOriginal4847a34d9a9b51a112e7c621e54cdc94 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4847a34d9a9b51a112e7c621e54cdc94 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.db_widget_counter','data' => ['icon' => 'fluentui-camera-dome-16-o','iconColor' => 'bg-accent-lightseagreen-100','label' => 'Total Camera (Active)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.db_widget_counter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'fluentui-camera-dome-16-o','iconColor' => 'bg-accent-lightseagreen-100','label' => 'Total Camera (Active)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4847a34d9a9b51a112e7c621e54cdc94)): ?>
<?php $attributes = $__attributesOriginal4847a34d9a9b51a112e7c621e54cdc94; ?>
<?php unset($__attributesOriginal4847a34d9a9b51a112e7c621e54cdc94); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4847a34d9a9b51a112e7c621e54cdc94)): ?>
<?php $component = $__componentOriginal4847a34d9a9b51a112e7c621e54cdc94; ?>
<?php unset($__componentOriginal4847a34d9a9b51a112e7c621e54cdc94); ?>
<?php endif; ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/auth/dashboard.blade.php ENDPATH**/ ?>