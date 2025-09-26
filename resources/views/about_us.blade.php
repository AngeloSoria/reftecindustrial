<!DOCTYPE html>
<html lang="en">
<x-head />

<body class="bg-gray-200">
    <x-navbar_public currentRouteName="about_us" />

    <x-public-content-container>
        <h1 class="font-castle font-bold text-4xl">about us page</h1>

        <x-modal id="previewProject" />
        <x-modal id="modalTest" maxWidth="max-w-3xl"/>

        @php
            $items = [
                ['title' => 'Title 1', 'description' => 'Desc 1'],
                ['title' => 'Title 2', 'description' => 'Desc 2'],
                ['title' => 'Title 3', 'description' => 'Desc 3'],
                ['title' => 'Title 4', 'description' => 'Desc 4'],
                ['title' => 'Title 5', 'description' => 'Desc 5'],
            ];
        @endphp
        <div class="grid grid-cols-3 gap-4">
            @foreach ($items as $item)
                <div class="p-4 border rounded shadow">
                    <h3 class="font-semibold">{{ $item['title'] }}</h3>
                    <p>{{ Str::limit($item['description'], 50) }}</p>

                    <button class="mt-2 px-3 py-1 bg-blue-600 text-white rounded cursor-pointer hover:bg-blue-700" x-data
                        @click="
                            $dispatch('open-modal', {
                                modalID: 'previewProject',
                                title: '{{ addslashes($item['title']) }}',
                                content: '{{ addslashes($item['description']) }}'
                            });
                        ">
                        View Details
                    </button>
                </div>
            @endforeach
        </div>

        <div x-data="{ sayHi() { console.log('Hi there!') } }">
            <button @click="$dispatch('open-modal', {
                modalID: 'modalTest'
            })" class="px-4 py-2 bg-purple-600 text-white rounded">
                Say Hi
            </button>
        </div>

    </x-public-content-container>


    <x-footer_public />
    <x-btn_backtotop />
</body>

</html>
