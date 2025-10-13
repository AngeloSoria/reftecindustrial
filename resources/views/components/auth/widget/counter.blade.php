@props([
    'icon' => 'fluentui-person-16-o',
    'iconColor' => 'bg-brand-secondary-300',
    'label' => '<<PUT LABEL HERE>>'
])

<div class="bg-white px-4 py-5 rounded-xl shadow-md inline-block m-1 font-inter">
    <div class="bg-green-300/0 min-w-[150px] flex flex-col gap-1">

        {{-- icon --}}
        <div class="{{ $iconColor }} rounded-full p-2 w-fit">
            @svg($icon, 'w-6 h-6 text-white')
        </div>

        {{-- counter --}}
        <div class="flex items-center gap-3">
            <p class="text-2xl font-bold">122</p>
            <div class="text-accent-lightseagreen-50 flex items-center gap-1">
                {{-- up/low icon value --}}
                @svg('fluentui-keyboard-shift-uppercase-16', 'w-4 h-4')
                12
            </div>
        </div>

        {{-- label --}}
        <p class="text-sm font-medium text-accent-darkslategray-600">{{ $label }}</p>

        {{-- ratio --}}
        <div class="text-accent-lightseagreen-50 flex items-center text-sm gap-2 font-medium">
            {{-- increase/decrease icon value --}}
            @svg('fluentui-arrow-trending-20', 'w-6 h-6')
            <p>15%</p>
        </div>
    </div>
</div>
