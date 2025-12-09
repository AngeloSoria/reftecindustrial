<x-layouts.auth.app viewName="Test" class="font-inter p-4" x-data>

    <form method="POST" action="{{ route('content.add.section.test') }}">
        @csrf
        <x-public.button button_type="primary" type="submit">Toast 1</x-public.button>
    </form>

    <div x-data>
        <button class="p-2 shadow-card rounded-sm m-2 bg-accent-lightseagreen-50" @click="$store.modalStack.open('projectModal')">Open Project</button>
        <button class="p-2 shadow-card rounded-sm m-2 bg-accent-lightseagreen-50" @click="$store.modalStack.open('confirmDelete')">Delete</button>
    </div>

    <x-public.modalv2 modalID="projectModal">
        <button @click="$store.modalStack.open('subModal')">Open Sub Modal</button>
    </x-public.modalv2>

    <x-public.modalv2 modalID="subModal">
        <p>Nested modal content.</p>
    </x-public.modalv2>

    <x-public.modalv2 modalID="confirmDelete">
        <p>Are you sure?</p>
    </x-public.modalv2>


    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('modalStack', {
                stack: [],

                open(id) {
                    if (!this.stack.includes(id)) {
                        this.stack.push(id);
                        document.body.classList.add('overflow-hidden'); // lock scroll
                    }
                    console.log(this.stack);
                },

                close(id) {
                    this.stack = this.stack.filter(m => m !== id);
                    if (this.stack.length === 0) {
                        document.body.classList.remove('overflow-hidden'); // restore scroll
                    }
                },

                top() {
                    return this.stack[this.stack.length - 1];
                },

                isOpen(id) {
                    return this.stack.includes(id);
                },

                zIndex(id) {
                    return 1000 + this.stack.indexOf(id) * 10; // each modal +10
                }
            });
        });
    </script>


</x-layouts.auth.app>