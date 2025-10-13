<x-layouts.auth.app viewName="Content">
    <h2>Content Page</h2>

    <form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" class="border" />
        <button type="submit" class="bg-brand-secondary-300 text-white p-2 rounded cursor-pointer">Upload</button>
    </form>
</x-layouts.auth.app>

