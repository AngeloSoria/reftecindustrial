<!DOCTYPE html>
<html lang="en">
<x-head />

<body class="relative overflow-x-hidden bg-gray-200">
    {{-- <x-navbar_public /> --}}

    {{-- watermark --}}
    <img src="{{ asset('images/reftec_logo_transparent.png') }}"
        class="absolute bottom-0 right-0 -translate-x-10 w-[20%] opacity-50 -z-1" alt="Reftec Logo watermark" />

    <x-public-content-container>

        <section class="min-h-screen p-4 flex flex-col items-center justify-center">
            <div class="mb-2">
                <a href="{{ route('home') }}" class="flex gap-2 items-center text-sm text-blue-500 hover:underline">
                    @svg('heroicon-c-arrow-left-start-on-rectangle', 'w-4 h-4')
                    <p>Go Back to Home</p>
                </a>
            </div>

            <div class="p-8 bg-white rounded shadow-lg h-full min-w-full md:min-w-md max-w-full md:max-w-xl font-inter">
                <h2 class="text-xl font-medium text-center mb-4">ADMIN LOGIN</h2>
                <form method="POST" class="flex flex-col gap-2">
                    @csrf
                    <div class="flex flex-col gap-1">
                        <label for="input_Username" class="text-sm font-medium">Username</label>
                        <input
                            class="px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none"
                            id="input_Username" name="username" type="text" placeholder="Enter your Username" required
                            autocomplete="on" aria-required="true" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label for="input_Password" class="text-sm font-medium">Password</label>
                        <input
                            class="px-4 py-2 rounded border-2 border-gray-200 focus:border-brand-primary-950 focus:outline-none"
                            id="input_Password" name="password" type="password" placeholder="Enter your Password" autocomplete="current-password"
                            required aria-required="true" />
                    </div>
                    <div>
                        <x-checkbox id="input_RememberMe" type="checkbox" name="remember_me" label="Remember me" />
                    </div>
                    <button type="submit"
                        class="mt-4 bg-accent-orange-300 hover:bg-accent-orange-400 text-white p-2 rounded font-medium cursor-pointer">SIGN
                        IN</button>
                </form>
                @error('login_request')
                    <p id="text_errorResult" class="mt-2 text-red-500 text-xs text-center">Invalid Username or Password</p>
                    <script>
                        const input_username = document.getElementById("input_Username");
                        const input_password = document.getElementById("input_Password");

                        function inputDetected() {
                            document.getElementById("text_errorResult").classList.add('hidden');
                            input_username.classList.remove('border-2', 'border-red-300');
                            input_password.classList.remove('border-2', 'border-red-300');
                        }
                        input_username.classList.add('border-2', 'border-red-300');
                        input_password.classList.add('border-2', 'border-red-300');

                        input_username.addEventListener("input", inputDetected);
                        input_password.addEventListener("input", inputDetected);
                    </script>
                @enderror
            </div>

        </section>


    </x-public-content-container>


    {{-- <x-footer_public /> --}}
    <x-btn_backtotop />
</body>

</html>
