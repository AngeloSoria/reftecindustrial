@props([
    'id' => 'modal',
    'show' => false,
    'title' => null,
    'size' => 'max-w-lg',
])

{{--
  Usage:
  <x-modal id="confirm-delete" title="Delete item" :show="false">
      <x-slot name="body">Are you sure?</x-slot>
      <x-slot name="footer">
          <button onclick="closeModal('confirm-delete')">Cancel</button>
          <button class="btn btn-danger">Delete</button>
      </x-slot>
  </x-modal>

  Notes:
  - Place this file at resources/views/components/modal.blade.php
  - Include the script below once (for example in your layout) so openModal/closeModal work.
  - TailwindCSS must be loaded in your app.
--}}

<div x-data="{ open: @js($show) }" x-show="open" x-cloak class="relative z-50">
    <!-- Backdrop -->
    <div id="{{ $id }}-backdrop" class="fixed inset-0 bg-black bg-opacity-50 z-40 transition-opacity"
        x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
        aria-hidden="true"></div>

    <!-- Modal panel -->
    <div id="{{ $id }}" class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4"
        role="dialog" aria-modal="true" aria-labelledby="{{ $id }}-title" x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95" @keydown.escape.window="open = false">
        <div class="bg-white rounded-2xl shadow-xl w-full {{ $size }} max-h-[90vh] overflow-hidden">
            {{-- Header --}}
            @if ($title)
                <div class="px-6 py-4 border-b">
                    <h3 id="{{ $id }}-title" class="text-lg font-semibold">{{ $title }}</h3>
                </div>
            @endif

            {{-- Body slot (scrollable) --}}
            <div class="px-6 py-4 overflow-auto" style="max-height: calc(90vh - 160px);">
                {{ $slot }}
            </div>

            {{-- Footer slot --}}
            @if (View::hasSection('footer') || trim($attributes->get('footer') ?? '') !== '')
                <div class="px-6 py-4 border-t flex justify-end gap-3">
                    {{ $attributes->get('footer') }}
                </div>
            @else
                {{-- If user provided a named footer slot: --}}
                @isset($footer)
                    <div class="px-6 py-4 border-t flex justify-end gap-3">
                        {{ $footer }}
                    </div>
                @endisset
            @endif
        </div>
    </div>
</div>



{{-- -----------------------
  Minimal JS helpers to add once (for example in your app layout before </body>):
  ----------------------- --}}
<script>
    function openModal(id) {
        const el = document.querySelector('#' + id);
        if (!el) return;
        // If using Alpine, toggle the internal state
        const xp = el.closest('[x-data]');
        if (xp && xp.__x) {
            xp.__x.$data.open = true;
            return;
        }
        // fallback: add attribute to show
        el.style.display = 'block';
        const backdrop = document.getElementById(id + '-backdrop');
        if (backdrop) backdrop.style.display = 'block';
    }

    function closeModal(id) {
        const el = document.querySelector('#' + id);
        if (!el) return;
        const xp = el.closest('[x-data]');
        if (xp && xp.__x) {
            xp.__x.$data.open = false;
            return;
        }
        el.style.display = 'none';
        const backdrop = document.getElementById(id + '-backdrop');
        if (backdrop) backdrop.style.display = 'none';
    }
</script>
{{-- Accessibility notes:
  - The template uses aria-modal and aria-labelledby.
  - If you need a focus trap, consider adding a small library or use Alpine plugins. The simple approach above closes on backdrop click and Escape.
 --}}
