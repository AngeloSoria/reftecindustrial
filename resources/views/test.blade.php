<x-layouts.auth.app viewName="Test" class="font-inter px-2">

    <button
        x-data
        x-on:click="$dispatch('openModal', ['product-details', { mode: 'get', id: 4 }]); console.log(123);"
        class="px-4 py-2 bg-blue-500 text-white rounded-lg cursor-pointer hover:bg-blue-600">
        Add Product
    </button>



    <livewire:modal/>

</x-layouts.auth.app>
