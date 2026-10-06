<div x-data="toastManager()" class="fixed top-4 right-4 z-[100] space-y-2 max-w-sm">
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-8"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            :class="{
                'bg-green-600': toast.type === 'success',
                'bg-red-600': toast.type === 'error',
                'bg-amber-500': toast.type === 'warning',
                'bg-blue-600': toast.type === 'info' || !toast.type
            }"
            class="flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-white shadow-lg text-sm"
        >
            <span x-text="toast.message"></span>
            <button @click="dismiss(toast.id)" class="opacity-80 hover:opacity-100">
                <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>
    </template>
</div>
