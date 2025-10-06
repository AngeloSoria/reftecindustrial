<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id' => uniqid('checkbox-'),
    'name' => '',
    'label' => '',
    'checked' => false
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
    'id' => uniqid('checkbox-'),
    'name' => '',
    'label' => '',
    'checked' => false
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<label for="<?php echo e($id); ?>" class="flex items-center space-x-2 cursor-pointer select-none">
    <!-- Hidden Native Checkbox -->
    <input
        id="<?php echo e($id); ?>"
        type="checkbox"
        name="<?php echo e($name); ?>"
        <?php if($checked): echo 'checked'; endif; ?>
        class="peer hidden"
    />

    <!-- Custom Checkbox -->
    <div class="w-4 h-4 border-2 border-gray-400 rounded-sm flex items-center justify-center
                peer-checked:bg-brand-primary-950 peer-checked:border-brand-primary-950 transition duration-200 ease-in-out">
        <!-- Check Icon -->
        <?php echo e(svg('zondicon-checkmark', "w-full h-full text-white peer-checked:block")); ?>
    </div>

    <!-- Label -->
    <?php if($label): ?>
        <span class="text-gray-700"><?php echo e($label); ?></span>
    <?php endif; ?>
</label>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/checkbox.blade.php ENDPATH**/ ?>