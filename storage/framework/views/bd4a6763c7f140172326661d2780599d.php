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

<body class="relative overflow-x-hidden bg-gray-200">
    

    
    <img src="<?php echo e(asset('images/reftec_logo_transparent.png')); ?>"
        class="absolute bottom-0 right-0 -translate-x-10 w-[20%] opacity-50 -z-1" alt="Reftec Logo watermark" />

    <?php if (isset($component)) { $__componentOriginalc7ad210725a3e9ba31a9f070a043c34f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7ad210725a3e9ba31a9f070a043c34f = $attributes; } ?>
<?php $component = App\View\Components\PublicContentContainer::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public-content-container'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PublicContentContainer::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>

        <section class="min-h-screen p-4 flex flex-col items-center justify-center">
            <div class="mb-2">
                <a href="<?php echo e(route('home')); ?>" class="flex gap-2 items-center text-sm text-blue-500 hover:underline">
                    <?php echo e(svg('heroicon-c-arrow-left-start-on-rectangle', 'w-4 h-4')); ?>
                    <p>Go Back to Home</p>
                </a>
            </div>

            <div class="p-8 bg-white rounded shadow-lg h-full min-w-full md:min-w-md max-w-full md:max-w-xl font-inter">
                <h2 class="text-xl font-medium text-center mb-4">ADMIN LOGIN</h2>
                <form method="POST" class="flex flex-col gap-2">
                    <?php echo csrf_field(); ?>
                    <div class="flex flex-col gap-1">
                        <label for="input_Username" class="text-sm font-medium">Username</label>
                        <input
                            class="px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none"
                            id="input_Username" name="username" type="text" placeholder="Enter your Username" required
                            autocomplete="on" aria-required="true" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="input_Password" class="text-sm font-medium">Password</label>
                        <input
                            class="px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none"
                            id="input_Password" name="password" type="password" placeholder="Enter your Password" autocomplete="current-password"
                            required aria-required="true" />
                    </div>
                    <div>
                        <?php if (isset($component)) { $__componentOriginal29f3e5beab852ff66871181e8857b9b3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal29f3e5beab852ff66871181e8857b9b3 = $attributes; } ?>
<?php $component = App\View\Components\Checkbox::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('checkbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Checkbox::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'input_RememberMe','type' => 'checkbox','name' => 'remember_me','label' => 'Remember me']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal29f3e5beab852ff66871181e8857b9b3)): ?>
<?php $attributes = $__attributesOriginal29f3e5beab852ff66871181e8857b9b3; ?>
<?php unset($__attributesOriginal29f3e5beab852ff66871181e8857b9b3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal29f3e5beab852ff66871181e8857b9b3)): ?>
<?php $component = $__componentOriginal29f3e5beab852ff66871181e8857b9b3; ?>
<?php unset($__componentOriginal29f3e5beab852ff66871181e8857b9b3); ?>
<?php endif; ?>
                    </div>
                    <button type="submit"
                        class="mt-4 bg-accent-orange-300 hover:bg-accent-orange-400 text-white p-2 rounded font-medium cursor-pointer">SIGN
                        IN</button>
                </form>
                <?php $__errorArgs = ['login_request'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p id="text_errorResult" class="mt-2 text-red-500 text-xs text-center">Invalid Username or Password</p>
                    <script>
                        const input_username = document.getElementById("input_Username");
                        const input_password = document.getElementById("input_Password");

                        function inputDetected() {
                            document.getElementById("text_errorResult").classList.add('hidden');
                            input_username.classList.remove('border-2', 'border-red-300');
                            input_password.classList.remove('border-2', 'border-red-300');
                        }
                        input_username.classList.add('border-2', 'border-red-300');
                        input_password.classList.add('border-2', 'border-red-300');

                        input_username.addEventListener("input", inputDetected);
                        input_password.addEventListener("input", inputDetected);
                    </script>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

        </section>


     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7ad210725a3e9ba31a9f070a043c34f)): ?>
<?php $attributes = $__attributesOriginalc7ad210725a3e9ba31a9f070a043c34f; ?>
<?php unset($__attributesOriginalc7ad210725a3e9ba31a9f070a043c34f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7ad210725a3e9ba31a9f070a043c34f)): ?>
<?php $component = $__componentOriginalc7ad210725a3e9ba31a9f070a043c34f; ?>
<?php unset($__componentOriginalc7ad210725a3e9ba31a9f070a043c34f); ?>
<?php endif; ?>


    
    <?php if (isset($component)) { $__componentOriginal56627af5da7e5f7ae4bce60ad80ec914 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal56627af5da7e5f7ae4bce60ad80ec914 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.btn_backtotop','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('btn_backtotop'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal56627af5da7e5f7ae4bce60ad80ec914)): ?>
<?php $attributes = $__attributesOriginal56627af5da7e5f7ae4bce60ad80ec914; ?>
<?php unset($__attributesOriginal56627af5da7e5f7ae4bce60ad80ec914); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal56627af5da7e5f7ae4bce60ad80ec914)): ?>
<?php $component = $__componentOriginal56627af5da7e5f7ae4bce60ad80ec914; ?>
<?php unset($__componentOriginal56627af5da7e5f7ae4bce60ad80ec914); ?>
<?php endif; ?>
</body>

</html>
<?php /**PATH C:\xampp\htdocs\reftecindustrial\resources\views/admin/login.blade.php ENDPATH**/ ?>