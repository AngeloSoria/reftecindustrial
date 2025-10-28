<h2 class="font-medium text-lg mb-2">About Us</h2>
<div class="">
    <h2>Gallery</h2>

    <ul id="sortable-container_about_gallery"
        class="p-4 bg-accent-darkslategray-300 rounded gap-2 grid grid-cols-2 md:grid-cols-3">
        @for ($i = 0; $i < 3; $i++)
            <li
                data-id="sortable_item_{{ $i }}"
                title="Drag to change order."
                class="relative p-4 bg-accent-darkslategray-100 border-12 border-white rounded-lg cursor-move shadow-sm min-w-[33%] min-h-[200px]">

                <span class="absolute top-1 left-1 text-xs">Item {{ $i }}</span>
                <img title="Click to view" src="{{ asset('images/kingspan.jpg') }}" class="w-full h-full aspect-video object-contain cursor-pointer" />
            </li>
        @endfor
    </ul>
</div>
