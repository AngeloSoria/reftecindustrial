{{-- TODO: Other counter widgets to work server-sided. --}}
<x-layouts.auth.app viewName="Dashboard" class="p-2 flex flex-col flex-wrap gap-2">
    <section class="gap-2 flex flex-wrap ">
        <x-auth.widget.counter class="grow basis-full sm:basis-[48%] lg:basis-[32%]" id="widget_counter_total_visits"
            icon="fluentui-person-16-o" iconColor="bg-brand-secondary-300"
            label="Total Visits ({{ now()->format('F') }})" />

        <x-auth.widget.counter class="grow basis-full sm:basis-[48%] lg:basis-[32%]" icon="fluentui-vehicle-car-16-o"
            iconColor="bg-accent-orange-300" label="Total Car Trips (Month)" />

        <x-auth.widget.counter class="grow basis-full sm:basis-[48%] lg:basis-[32%]" icon="fluentui-camera-dome-16-o"
            iconColor="bg-accent-lightseagreen-100" label="Total Camera (Active)" />
    </section>

    <section class="flex md:flex-row flex-col flex-wrap gap-2 justify-center overflow-hidden grow">
        <x-auth.widget.chart_visitors class="basis-full md:basis-[49%] grow" />

        {{-- TODO: Make this api-sided --}}
        <x-auth.widget.chart_completed_car_trips class="basis-full md:basis-[49%] grow" />
    </section>
</x-layouts.auth.app>
