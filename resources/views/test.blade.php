<x-layouts.auth.app viewName="Test" class="font-inter p-4">

    <form method="POST" action="{{ route('content.add.section.test') }}">
        @csrf
        <x-public.button button_type="primary" type="submit">Toast 1</x-public.button>
    </form>

</x-layouts.auth.app>
