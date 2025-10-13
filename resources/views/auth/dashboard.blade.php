<x-layouts.auth.app viewName="Dashboard" class="p-2 flex gap-2">
    <section class="flex flex-col gap-2">
        <section class="flex items-center gap-2">
            <x-auth.widget.counter icon="fluentui-person-16-o" iconColor="bg-brand-secondary-300"
                label="Total Visits (Week)" />
            <x-auth.widget.counter icon="fluentui-vehicle-car-16-o" iconColor="bg-accent-orange-300"
                label="Total Car Trips (Month)" />
            <x-auth.widget.counter icon="fluentui-camera-dome-16-o" iconColor="bg-accent-lightseagreen-100"
                label="Total Camera (Active)" />
        </section>
        <x-auth.widget.chart_test class="" />
    </section>

    <section class="grow flex flex-col gap-2">
        <x-auth.widget.chart_visitors class="" />
    </section>
</x-layouts.auth.app>
