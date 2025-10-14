<x-layouts.auth.app viewName="Content">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
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
        <div id="general" class="tab-content mt-6">
            <h3 class="text-lg font-medium text-gray-900">General</h3>
            <p class="mt-2 text-sm text-gray-500">This is the general content section. Add your general information here.</p>
            <!-- Add more content as needed -->
        </div>

        <div id="projects" class="tab-content mt-6 hidden">
            <h3 class="text-lg font-medium text-gray-900">Projects</h3>
            <p class="mt-2 text-sm text-gray-500">This is the projects content section. Display project-related information here.</p>
            <!-- Add more content as needed -->
        </div>

        <div id="products" class="tab-content mt-6 hidden">
            <h3 class="text-lg font-medium text-gray-900">Products</h3>
            <p class="mt-2 text-sm text-gray-500">This is the products content section. Showcase product details here.</p>
            <!-- Add more content as needed -->
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
                button.classList.remove('border-indigo-500', 'text-indigo-600');
                button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });

            // Show the selected tab content
            document.getElementById(tabName).classList.remove('hidden');

            // Add active class to the selected tab button
            const activeButton = document.getElementById(tabName + '-tab');
            activeButton.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            activeButton.classList.add('border-indigo-500', 'text-indigo-600');
        }

        // Initialize the first tab as active
        document.addEventListener('DOMContentLoaded', function() {
            openTab('general');
        });
    </script>
</x-layouts.auth.app>

