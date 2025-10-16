<section class="">

    <div class="w-full mx-auto">
        <div x-data="{selected:null}">
            <ul class="[&>*]:relative [&>*]:border-b [&>*]:border-gray-200 [&>*:last-child]:border-0">

                <!-- Accordion Item 1 -->
                <li>
                    <button type="button" title="toggle" class="cursor-pointer hover:bg-gray-200 w-full px-8 py-6 text-left"
                        @click="selected !== 1 ? selected = 1 : selected = null">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-medium text-gray-900">
                                Hero Section
                            </span>
                            <span x-ref="container1" x-bind:class="selected == 1 ? '-rotate-90' : ''"
                                class="transition-transform">
                                @svg('fluentui-chevron-down-20', 'accordion-icon rotate-90 w-6 h-6')
                            </span>
                        </div>
                    </button>
                    <div class="bg-gray-100 relative overflow-hidden transition-all max-h-0 duration-700" style=""
                        x-ref="container1"
                        x-bind:style="selected == 1 ? 'max-height: ' + $refs.container1.scrollHeight + 'px' : ''">
                        <div class="p-6">
                            <x-layouts.file_upload_drag privateUpload="false" uploadMultiple="false" />
                            <button class="px-4 py-2 bg-brand-secondary-300 text-white" x-data @click="
                                    $dispatch('image_preview_event', {
                                        previewInfo: @js(['image' => asset('images/lubricants.png')])
                                    })
                                ">
                                Test
                            </button>
                        </div>
                    </div>
                </li>

                <!-- Accordion Item 2 -->
                <li>
                    <button type="button" title="toggle" class="cursor-pointer hover:bg-gray-200 w-full px-8 py-6 text-left"
                        @click="selected !== 2 ? selected = 2 : selected = null">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-medium text-gray-900">
                                Accordion Item 2
                            </span>
                            <span x-ref="container2" x-bind:class="selected == 2 ? '-rotate-90' : ''"
                                class="transition-transform">
                                @svg('fluentui-chevron-down-20', 'accordion-icon rotate-90 w-6 h-6')
                            </span>
                        </div>
                    </button>
                    <div class="relative overflow-hidden transition-all max-h-0 duration-700" style=""
                        x-ref="container2"
                        x-bind:style="selected == 2 ? 'max-height: ' + $refs.container2.scrollHeight + 'px' : ''">
                        <div class="p-6">
                            <p class="text-gray-700">Content for accordion item 2 goes here. You can add any HTML
                                content.
                            </p>
                            <p class="text-gray-700">Content for accordion item 2 goes here. You can add any HTML
                                content.
                            </p>
                            <p class="text-gray-700">Content for accordion item 2 goes here. You can add any HTML
                                content.
                            </p>
                            <p class="text-gray-700">Content for accordion item 2 goes here. You can add any HTML
                                content.
                            </p>
                            <p class="text-gray-700">Content for accordion item 2 goes here. You can add any HTML
                                content.
                            </p>
                            <p class="text-gray-700">Content for accordion item 2 goes here. You can add any HTML
                                content.
                            </p>
                        </div>
                    </div>
                </li>

                <!-- Accordion Item 3 -->
                <li>
                    <button type="button" title="toggle" class="cursor-pointer hover:bg-gray-200 w-full px-8 py-6 text-left"
                        @click="selected !== 3 ? selected = 3 : selected = null">
                        <div class="flex items-center justify-between">
                            <span class="text-lg font-medium text-gray-900">
                                Accordion Item 3
                            </span>
                            <span x-ref="container3" x-bind:class="selected == 3 ? '-rotate-90' : ''"
                                class="transition-transform">
                                @svg('fluentui-chevron-down-20', 'accordion-icon rotate-90 w-6 h-6')
                            </span>
                        </div>
                    </button>
                    <div class="relative overflow-hidden transition-all max-h-0 duration-700" style=""
                        x-ref="container3"
                        x-bind:style="selected == 3 ? 'max-height: ' + $refs.container3.scrollHeight + 'px' : ''">
                        <div class="p-6">
                            <p class="text-gray-700">Content for accordion item 3 goes here. You can add any HTML
                                content.
                            </p>
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>


</section>
<x-public.modal.image_preview escKeyToClose clickOutsideToClose />
