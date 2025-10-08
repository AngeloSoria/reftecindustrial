<!DOCTYPE html>
<html lang="en">
<x-head />

<body class="bg-gray-200">
    <x-admin.main_navbar viewName="Dashboard"/>

    <x-admin.db_widget_counter icon="fluentui-person-16-o" iconColor="bg-brand-secondary-300" label="Total Visits (Week)" />
    <x-admin.db_widget_counter icon="fluentui-vehicle-car-16-o" iconColor="bg-accent-orange-300" label="Total Car Trips (Month)" />
    <x-admin.db_widget_counter icon="fluentui-camera-dome-16-o" iconColor="bg-accent-lightseagreen-100" label="Total Camera (Active)" />
</body>

</html>
