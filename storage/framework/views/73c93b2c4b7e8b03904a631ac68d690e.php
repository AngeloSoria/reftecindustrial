<?php
    $sizeClasses = match ($size ?? 'md') {
        'sm' => 'px-3 py-1 text-sm',
        'md' => 'px-4 py-2 text-base',
        'lg' => 'px-5 py-3 text-lg',
        'xl' => 'px-6 py-4 text-xl',
        default => 'px-4 py-2 text-base',
    };

    $colorClasses = match ($color ?? 'primary') {
        'primary' => 'bg-accent-orange-300 text-black hover:bg-yellow-600',
        'secondary' => 'bg-brand-primary-950 text-white hover:bg-brand-tertiary-950',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        default => 'bg-accent-orange-300 text-black hover:bg-yellow-400',
    };
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => null,   // 'submit' | 'button' | null
    'href' => null,   // link destination
    'prefixIcon' => null,
    'suffixIcon' => null,
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
    'type' => null,   // 'submit' | 'button' | null
    'href' => null,   // link destination
    'prefixIcon' => null,
    'suffixIcon' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if($href): ?>
    
    <a href="<?php echo e($href); ?>"
       <?php echo e($attributes->merge([
           'class' => "inline-block $sizeClasses $colorClasses",
           'role' => 'button'
       ])); ?>>
        <?php if($suffixIcon): ?>
            <span class="inline-flex items-center space-x-2">
                <span><?php echo e($slot); ?></span>
                <i data-lucide="<?php echo e($suffixIcon); ?>" class="w-4 h-4"></i>
            </span>
        <?php elseif($prefixIcon): ?>
            <span class="inline-flex items-center space-x-2">
                <i data-lucide="<?php echo e($prefixIcon); ?>" class="w-4 h-4"></i>
                <span><?php echo e($slot); ?></span>
            </span>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </a>
<?php else: ?>
    
    <button type="<?php echo e($type ?? 'button'); ?>"
        <?php echo e($attributes->merge([
            'class' => "inline-block $sizeClasses $colorClasses"
        ])); ?>>
        <?php if($suffixIcon): ?>
            <span class="inline-flex items-center space-x-2">
                <span><?php echo e($slot); ?></span>
                <i data-lucide="<?php echo e($suffixIcon); ?>" class="w-4 h-4"></i>
            </span>
        <?php elseif($prefixIcon): ?>
            <span class="inline-flex items-center space-x-2">
                <i data-lucide="<?php echo e($prefixIcon); ?>" class="w-4 h-4"></i>
                <span><?php echo e($slot); ?></span>
            </span>
        <?php else: ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    </button>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/button_primary.blade.php ENDPATH**/ ?>