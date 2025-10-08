<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'icon' => 'fluentui-person-16-o',
    'iconColor' => 'bg-brand-secondary-300',
    'label' => '<<PUT LABEL HERE>>'
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
    'icon' => 'fluentui-person-16-o',
    'iconColor' => 'bg-brand-secondary-300',
    'label' => '<<PUT LABEL HERE>>'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<div class="bg-white px-4 py-5 rounded-xl shadow-md inline-block m-1 font-inter">
    <div class="bg-green-300/0 min-w-[150px] flex flex-col gap-1">

        
        <div class="<?php echo e($iconColor); ?> rounded-full p-2 w-fit">
            <?php echo e(svg($icon, 'w-6 h-6 text-white')); ?>
        </div>

        
        <div class="flex items-center gap-3">
            <p class="text-2xl font-bold">122</p>
            <div class="text-accent-lightseagreen-50 flex items-center gap-1">
                
                <?php echo e(svg('fluentui-keyboard-shift-uppercase-16', 'w-4 h-4')); ?>
                12
            </div>
        </div>

        
        <p class="text-sm font-medium text-accent-darkslategray-600"><?php echo e($label); ?></p>

        
        <div class="text-accent-lightseagreen-50 flex items-center text-sm gap-2 font-medium">
            
            <?php echo e(svg('fluentui-arrow-trending-20', 'w-6 h-6')); ?>
            <p>15%</p>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/admin/db_widget_counter.blade.php ENDPATH**/ ?>