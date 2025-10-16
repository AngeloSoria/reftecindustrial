<!-- resources/views/components/toast.blade.php -->
<div
    x-data="{
        toasts: [],
        add(message, type = 'info') {
            const id = Date.now();
            this.toasts.push({ id, message, type, progress: 100 });

            // Animate progress bar
            const interval = setInterval(() => {
                const toast = this.toasts.find(t => t.id === id);
                if (!toast) return clearInterval(interval);

                toast.progress -= 2; // lower = slower
                if (toast.progress <= 0) {
                    this.remove(id);
                    clearInterval(interval);
                }
            }, 60);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }"
    @toast.window="add($event.detail.message, $event.detail.type)"
    class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-x-20 opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform ease-in duration-200 transition"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-20 opacity-0"
            class="relative overflow-hidden px-4 py-3 rounded-lg shadow-lg text-white min-w-[250px] max-w-[300px] flex items-start justify-between"
            :class="{
                'bg-green-600': toast.type === 'success',
                'bg-red-600': toast.type === 'error',
                'bg-blue-600': toast.type === 'info',
                'bg-yellow-500': toast.type === 'warning',
            }"
        >
            <div class="flex-1 pr-3">
                <span x-text="toast.message"></span>
            </div>

            <!-- Close button -->
            <button
                @click="remove(toast.id)"
                class="text-white/70 hover:text-white text-lg leading-none"
            >
                ×
            </button>

            <!-- Progress bar -->
            <div
                class="absolute bottom-0 left-0 h-1 bg-white/60 transition-all duration-75"
                :style="`width: ${toast.progress}%;`"
            ></div>
        </div>
    </template>
</div>

<script>
window.toast = (message, type = 'info') => {
    window.dispatchEvent(new CustomEvent('toast', {
        detail: { message, type }
    }));
};
</script>
