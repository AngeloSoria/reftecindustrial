@props([
    'x_ref' => null,
    'x_data' => " ",
    'x_click' => null,
])

<div
@if($x_ref) x-ref="{{ $x_ref }}" @endif
@if($x_data) x-data="{{ $x_data }}" @endif
@if($x_click) @click="{{ $x_click }}" @endif

id="{{ $attributes->get('id') }}"
class="quill-editor min-w-[300px] min-h-[100px]">
</div>
