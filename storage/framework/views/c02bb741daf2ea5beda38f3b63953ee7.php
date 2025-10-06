
<?php
    $buttonType = $attributes->get('button_type');
    switch ($buttonType) {
        case 'primary':
            $classes = 'bg-accent-orange-300 text-white hover:bg-accent-orange-400';
            break;
        case 'secondary':
            $classes = 'bg-accent-darkslategray-900 text-white hover:bg-accent-darkslategray-800';
            break;
        default:
            $classes = 'bg-white';
            break;
    }
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'href' => null,
    'type' => 'button'
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
    'href' => null,
    'type' => 'button'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if($href): ?>
    <a role="button" href="<?php echo e($href); ?>" class="py-2 px-5 rounded shadow-sm <?php echo e($attributes->get('class') ?? 'transition-colors cursor-pointer'); ?> <?php echo e($classes); ?>">
        <?php echo e($slot); ?>

    </a>
<?php else: ?>
    <button class="py-2 px-4 rounded <?php echo e($attributes->get('class') ?? 'transition-colors cursor-pointer'); ?> <?php echo e($classes); ?>">
        <?php echo e($slot); ?>

    </button>
<?php endif; ?>

<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/button.blade.php ENDPATH**/ ?>