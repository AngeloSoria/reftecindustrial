<!DOCTYPE html>
<html lang="en">
<x-head />

<body class="bg-gray-200">
    <x-admin.main_navbar/>

    {{-- <form action="{{ route('user.logout') }}" method="POST">
        @csrf
        <button
            x-data
            type="submit"
            @click="$el.disabled = true"
            class="px-4 py-2 rounded bg-accent-orange-300 hover:bg-accent-orange-400 transition-colors font-medium cursor-pointer">
            Logout-1
        </button>
    </form> --}}
</body>

</html>
