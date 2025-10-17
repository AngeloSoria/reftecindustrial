<div x-data="{
        toasts: [],
        add(message, type = 'info', duration = 3) { // default: 3 seconds
            const id = Date.now();
            const totalTime = duration * 1000; // convert to ms
            const intervalStep = 100; // ms per interval
            const decrement = (intervalStep / totalTime) * 100;

            this.toasts.push({ id, message, type, progress: 100 });

            const interval = setInterval(() => {
                const toast = this.toasts.find(t => t.id === id);
                if (!toast) return clearInterval(interval);

                toast.progress -= decrement;
                if (toast.progress <= 0) {
                    this.remove(id);
                    clearInterval(interval);
                }
            }, intervalStep);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }" @toast.window="add($event.detail.message, $event.detail.type, $event.detail.duration)"
    class="fixed bottom-5 right-5 z-[150] flex flex-col gap-2">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-transition:enter="transform ease-out duration-300 transition"
            x-transition:enter-start="translate-x-20 opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform ease-in duration-200 transition"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-20 opacity-0"
            class="relative overflow-hidden px-4 py-3 rounded-lg shadow-lg text-white min-w-[300px] max-w-[400px] flex items-start justify-between"
            :class="{
                'bg-green-600': toast.type === 'success',
                'bg-red-600': toast.type === 'error',
                'bg-blue-600': toast.type === 'info',
                'bg-yellow-500': toast.type === 'warning',
            }">
            <div class="flex-1 pr-3">
                <span x-text="toast.message"></span>
            </div>

            <!-- Close button -->
            <button @click="remove(toast.id)" class="text-white/70 hover:text-white text-lg leading-none">
                ×
            </button>

            <!-- Progress bar -->
            <div class="absolute bottom-0 left-0 h-1 bg-white/60 transition-all duration-75"
                :style="`width: ${toast.progress}%;`"></div>
        </div>
    </template>
</div>

<script>
    window.toast = (message, type = 'info', duration = 3) => {
        window.dispatchEvent(new CustomEvent('toast', {
            detail: { message, type, duration }
        }));
    };
</script>
