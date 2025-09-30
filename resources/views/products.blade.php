<!DOCTYPE html>
<html lang="en">
<x-head />

<body>
    <x-navbar_public currentRouteName="products" />

    <x-public-content-container>
        <div class="flex flex-col items-center justify-center my-12">
            <p class="text-2xl md:text-3xl font-inter font-black">
                <span class="text-accent-black_2">OUR </span>
                <span class="text-accent-yellow">PRODUCTS</span>
            </p>
            <p class="text-gray-800 text-sm font-medium text-center">THINKING OF INNOVATION? WE GOT YOU COVERED!</p>
        </div>

        @php
            // TODO: Populate this with server-sided data.
            $fake_items = [
                [
                    "title" => "Item Name 1",
                    "image" => asset('images/kingspan.jpg')
                ],
                [
                    "title" => "Item Name 2",
                    "image" => asset('images/reftec_logo_filled.jpg')
                ],
                [
                    "title" => "Item Name 3",
                    "image" => asset('images/reftec_logo_filled.jpg')
                ],
                [
                    "title" => "Item Name 3",
                    "image" => asset('images/footerbg.jpg')
                ],
            ];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-2">
            @foreach ($fake_items as $item)
                <div
                    class="cursor-pointer bg-white flex flex-col {{ $loop->last && $loop->count === 3 ? 'col-start-1 col-end-3 justify-self-center w-1/2' : '' }}"
                    x-data
                    @click="
                        $dispatch('image_preview_event', {
                            previewInfo: @js($item)
                        })
                    "
                    >
                    <img src="{{ $item['image'] }}" class="w-full grow max-h-[200px] object-cover" />
                    <div class="bg-brand-primary p-2 lg:p-4">
                        <p class="text-sm md:text-lg font-inter font-medium text-white">{{ $item['title'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-public-content-container>

    <x-image_preview escKeyToClose clickOutsideToClose />

    <x-footer_public />
    <x-btn_backtotop />
</body>

</html>
