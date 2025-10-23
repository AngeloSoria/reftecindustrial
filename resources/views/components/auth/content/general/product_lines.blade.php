<h2 class="font-medium text-lg mb-2">Product Lines</h2>

<button @click="$dispatch('open-modal', {'id':'exampleModal'})"
    class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded bg-accent-orange-300 hover:bg-accent-orange-400 transition-colors">
    @svg('fluentui-add-circle-24-o', 'w-5 h-5')
    Add Product Line
</button>

<section class="mt-2 gap-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
    @php
        $fake_data = [
            ['name' => 'Kingspan Rhino Water Tanks, Australia', 'image' => asset('images/kingspan.jpg')],
            ['name' => 'Vilter Refrigeration Equipment, USA', 'image' => asset('images/vilter_logo.png')],
            ['name' => 'Starr Panel, Indonesia', 'image' => asset('images/starr.jpg')],
            ['name' => 'Starr Panel, Indonesia', 'image' => asset('images/starr.jpg')],
            ['name' => 'Starr Panel, Indonesia', 'image' => asset('images/starr.jpg')],
        ];
    @endphp
    @foreach($fake_data as $productLine)
        <div id="id_{{ $productLine['name'] }}"
            class="border-2 border-accent-darkslategray-200/25 bg-white rounded shadow overflow-hidden">
            <div class="p-4 bg-accent-darkslategray-200">
                <img src="{{ $productLine['image'] }}" class="min-h-[150px] max-h-[150px] w-full h-full object-contain" />
            </div>
            <div class="p-4 flex items-start justify-start gap-2">
                <p class="text-lg">{{ $productLine['name'] }}</p>

                {{-- controls --}}
                <div class="grow flex items-center justify-end gap-2">
                    <button title="Edit"
                        class="p-2 rounded-full shadow-sm cursor-pointer hover:outline-1 transition-colors
                        outline-accent-darkslategray-200 hover:bg-blue-600 hover:text-white">
                        @svg('fluentui-edit-20', 'w-4 h-4')
                    </button>
                    <button title="Delete" class="p-2 rounded-full shadow-sm cursor-pointer transition-colors
                             hover:outline-1 outline-accent-darkslategray-200 hover:bg-red-500 hover:text-white">
                        @svg('fluentui-delete-20-o', 'w-4 h-4')
                    </button>
                </div>
            </div>
        </div>
    @endforeach
</section>

<x-auth.modal.add_product_line title="Add new Product Line" />
