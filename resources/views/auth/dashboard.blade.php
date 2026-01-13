{{-- TODO: Other counter widgets to work server-sided. --}}
<x-layouts.auth.app viewName="Dashboard" class="p-4 gap-4 grid grid-cols-[30%_1fr]">
    <section class="gap-4 flex flex-col items-center justify-start">
        <x-auth.widget.counter 
            class="w-full" 
            id="widget_counter_total_visits"
            icon="fluentui-person-16-o" 
            iconColor="brand-secondary-300"
            bgIconColor="bg-brand-secondary-300/10"
            label="Total Site Visits ({{ now()->format('F') }})" />

        <section class="w-full flex items-center justify-center gap-4">
            <div class="bg-gray-200 opacity-75 animate-[pulse_1s_ease-in-out_infinite] rounded-xl shadow-card grow h-[92px] p-2 aspect-video"></div>
            <div class="bg-gray-200 opacity-75 animate-[pulse_1s_ease-in-out_infinite] rounded-xl shadow-card grow h-[92px] p-2 aspect-video"></div>
        </section>
        <section class="w-full flex items-center justify-center gap-4">
            <div class="bg-gray-200 opacity-75 animate-[pulse_2s_ease-in-out_infinite] opacity rounded-xl shadow-card grow h-[92px] p-2 aspect-video"></div>
        </section>
        <section class="w-full flex items-center justify-center gap-4">
            <div class="bg-gray-200 opacity-75 animate-[pulse_1s_ease-in-out_infinite] rounded-xl shadow-card grow h-[92px] p-2 aspect-video"></div>
            <div class="bg-gray-200 opacity-75 animate-[pulse_3s_ease-in-out_infinite] rounded-xl shadow-card w-[25%] h-[92px] p-2 aspect-video"></div>
        </section>

        {{-- <x-auth.widget.counter 
            class="w-full" 
            icon="fluentui-vehicle-car-16-o"
            iconColor="accent-orange-300"
            bgIconColor="bg-accent-orange-300/10"
            label="Total Car Trips (Month)" />

        <x-auth.widget.counter
            class="w-full" 
            icon="fluentui-camera-dome-16-o"
            iconColor="blue-500"
            bgIconColor="bg-blue-500/10"
            label="Total Camera (Active)" /> --}}

    </section>

    <section class="flex md:flex-row flex-col flex-wrap gap-2 justify-center overflow-hidden grow">
        <x-auth.widget.chart_visitors class="grow shadow-xl" />

    </section>
</x-layouts.auth.app>
