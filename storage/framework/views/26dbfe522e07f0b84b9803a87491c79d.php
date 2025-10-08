
<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id' => 'modal-' . uniqid(),
    'clickOutsideToClose' => null, // When user clicks outside the modal, it will close.
    'keyEscapeClose' => null,
    'size' => 'md',
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
    'id' => 'modal-' . uniqid(),
    'clickOutsideToClose' => null, // When user clicks outside the modal, it will close.
    'keyEscapeClose' => null,
    'size' => 'md',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    switch ($size) {
        case 'md':
            $modal_size = "max-w-md";
            break;
        case '4xl':
            $modal_size = "max-w-[80%]";
            break;
        case 'full':
            $modal_size = "max-w-full";
            break;
        default:
            $modal_size = "max-w-" . $size;
    }
?>

<section
    id="<?php echo e($id); ?>"
    class="fixed w-full h-screen inset-0 z-100 flex items-center justify-center"
    x-data="{ open: false, projectInfo: {}, }"
    @preview_project_info.window="
        projectInfo = $event.detail.projectInfo
        if (!$event.detail.modalId || $event.detail.modalId !== '<?php echo e($id); ?>') {
            return;
        }
        open = true;
    "
    x-show="open"
    x-cloak
    >
    
    <div
        id="modal-backdrop"
        class="w-full h-full inset-0 bg-black/40 z-40"
        <?php if($clickOutsideToClose ?? false): ?>
            @click="open = false"
        <?php endif; ?>
    ></div>

    
    <div id="modal-content"
        class="absolute bg-white rounded-md shadow-lg w-full <?php echo e($modal_size); ?> z-50 overflow-y-auto max-h-[90vh]"
        <?php if($keyEscapeClose ?? false): ?>
             @keydown.escape.window="open = false"
        <?php endif; ?>
        x-show="open"
        x-transition
        >
        
        <div class="flex justify-between items-center p-4 shadow-sm">
            <h2 class="text-xl font-bold text-brand-primary-950" >Project Details</h2>
            <button @click="open = false" class="text-gray-600 hover:text-gray-800 cursor-pointer">
                <?php echo e(svg('zondicon-close', 'w-4 h-4')); ?>
            </button>
        </div>

        
        <div class="p-4 flex gap-2 flex-col-reverse md:flex-row">
            
            <?php if (isset($component)) { $__componentOriginala12b94ebc36111d9bfa239c257356107 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala12b94ebc36111d9bfa239c257356107 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.slideshow','data' => ['size' => 'max-w-md','class' => 'grow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('slideshow'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'max-w-md','class' => 'grow']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala12b94ebc36111d9bfa239c257356107)): ?>
<?php $attributes = $__attributesOriginala12b94ebc36111d9bfa239c257356107; ?>
<?php unset($__attributesOriginala12b94ebc36111d9bfa239c257356107); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala12b94ebc36111d9bfa239c257356107)): ?>
<?php $component = $__componentOriginala12b94ebc36111d9bfa239c257356107; ?>
<?php unset($__componentOriginala12b94ebc36111d9bfa239c257356107); ?>
<?php endif; ?>
            <section class="bg-brand-primary-950 text-white font-inter p-4 grow flex flex-col gap-4 md:max-w-[280px]">
                <p x-text="projectInfo.title" class="font-medium text-2xl text-wrap"></p>
                <p x-text="projectInfo.description" class="font-regular text-sm"></p>
                <span class="flex gap-2 items-center text-sm">
                    Status:
                    <p
                    x-text="projectInfo.status"
                    :class="{
                        'bg-accent-orange-300': projectInfo.status === 'ongoing',
                        'bg-accent-lightseagreen-50': projectInfo.status === 'completed'
                    }"
                        class="px-2 py-1 rounded-lg text-white font-medium capitalize text-xs"
                        ></p>
                </span>
                <p x-text="'Date Completed: ' + projectInfo.date" class=" text-sm font-regular"></p>
            </section>
        </div>

        
        <div class="flex justify-end p-2">
            
        </div>
    </div>
</section>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/components/modal_preview_project.blade.php ENDPATH**/ ?>