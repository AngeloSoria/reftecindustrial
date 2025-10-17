<x-layouts.auth.app viewName="Content" class="font-inter px-2">
    <div class="bg-white rounded-xl shadow-sm min-h-[400px] max-w-7xl my-2 mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px justify-center-safe sm:justify-start flex flex-wrap space-x-8 [&>*]:cursor-pointer" aria-label="Tabs">
                <button id="general-tab" class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm" onclick="openTab('general')">
                    General
                </button>
                <button id="projects-tab" class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm" onclick="openTab('projects')">
                    Projects
                </button>
                <button id="products-tab" class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm" onclick="openTab('products')">
                    Products
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <x-auth.content.tabs_content id="general">
            <x-layouts.auth.content.general />
        </x-auth.content.tabs_content>


        <div id="projects" class="tab-content mt-6 hidden">
            <x-layouts.auth.content.projects />
        </div>

        <div id="products" class="tab-content mt-6 hidden">
            <x-layouts.auth.content.products />
        </div>
    </div>

    <script>
        function openTab(tabName) {
            // Hide all tab contents
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.add('hidden'));

            // Remove active class from all tab buttons
            const buttons = document.querySelectorAll('.tab-button');
            buttons.forEach(button => {
                button.classList.remove('border-brand-tertiary-950', 'text-brand-tertiary-950');
                button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });

            // Show the selected tab content
            document.getElementById(tabName).classList.remove('hidden');

            // Add active class to the selected tab button
            const activeButton = document.getElementById(tabName + '-tab');
            activeButton.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            activeButton.classList.add('border-brand-tertiary-950', 'text-brand-tertiary-950');
        }

        // Initialize the first tab as active
        document.addEventListener('DOMContentLoaded', function() {
            openTab('general');
        });
    </script>
</x-layouts.auth.app>

