<x-layouts.auth.app viewName="Test" class="font-inter p-4" x-data>

    {{-- <button class="px-4 py-2 rounded shadow-card bg-orange-400 cursor-pointer" x-data="test" @click="clickMe">
        Delete
    </button> --}}
    <script>
        function test() {
            return {
                async clickMe() {
                    console.time('web');
                    const response1 = await fetch(
                        "{{ route('api.content.page.home') }}"
                    );
                    await response1.json();
                    console.timeEnd('web');
                }
            }
        }
    </script>

    <x-public.content_container>
        <section x-data="{
            files: null,
            selectedFiles: [],
            async init() {
                const response = await fetch('{{ route('files.get.all') }}');
                const data = await response.json();
                if (data && data.success) {
                    this.files = data.data;
                }
            },

            toggleSelect(obj) {
                const id = obj.id;

                if (this.selectedFiles.includes(id)) {
                    // Remove regardless of position
                    this.selectedFiles = this.selectedFiles.filter(item => item !== id);
                } else {
                    // Add if not selected
                    this.selectedFiles.push(id);
                }
            },
        }">
            <form method="POST" action="{{ route('files.delete.selected') }}">
                @csrf
                <input type="hidden" name="selectedFiles" :value="selectedFiles" />
                <button class="px-4 py-2 rounded shadow-card bg-orange-400 cursor-pointer">
                    Delete (<span x-text="Object.keys(selectedFiles).length"></span>)
                </button>
            </form>
            <section class="grid grid-cols-5 gap-4">
                <template x-for="(file, index) in files" :key="index">
                    <div x-data="{
                            checked: false,
                            init() {
                                $watch('checked', function(value) {
                                    toggleSelect(file);
                                    console.log(selectedFiles);
                                });
                            },
                        }"
                        :class="checked ? 'bg-accent-orange-200 hover:bg-accent-orange-300' : 'bg-white hover:bg-accent-darkslategray-100'"
                        @click="checked = !checked"
                        class="flex flex-col items-start justify-start gap-4 shadow-card p-4 rounded-xl transition-colors">
                        <input type="checkbox" class="scale-[150%]" @click="checked = !checked" :checked="checked" />
                        <p x-text="file.filename"></p>
                    </div>
                </template>
            </section>
        </section>
    </x-public.content_container>

</x-layouts.auth.app>