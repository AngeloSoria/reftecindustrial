<div class="relative">
    <?php if($label ?? false): ?>
        <p class="block text-sm font-medium text-gray-700 mb-1"><?php echo e($label); ?></p>
    <?php endif; ?>

    <div class="relative">
        <select

            <?php if($id ?? false): ?> id="<?php echo e($id); ?>" <?php endif; ?>
            <?php if($name ?? false): ?> name="<?php echo e($name); ?>" <?php endif; ?>
            <?php if($title ?? false): ?> title="<?php echo e($title); ?>" <?php endif; ?>
            <?php if($required ?? false): ?> required <?php endif; ?>
            <?php if($multiple ?? false): ?> multiple <?php endif; ?>

            class="min-w-[150px] md:min-w-[200px] font-medium px-4 py-2 appearance-none <?php echo e($attributes->get('class')); ?> bg-brand-primary-950 hover:bg-brand-primary-950-light text-white">

            <?php if($placeholder ?? false): ?>
                <option disabled selected class="text-gray-500"><?php echo e($placeholder); ?></option>
            <?php endif; ?>

            <?php echo e($slot); ?>

        </select>

        <?php echo e(svg('bxs-down-arrow', 'w-4 h-4 text-white absolute top-1/2 right-3 -translate-y-1/2 pointer-events-none')); ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/dropdown.blade.php ENDPATH**/ ?>