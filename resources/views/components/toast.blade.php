@php
    $initialMessage = session('success') ?? session('status') ?? session('error');
    $initialType = session()->has('error') ? 'error' : 'success';
@endphp

<div
    x-data="{
        show: {{ $initialMessage ? 'true' : 'false' }},
        type: '{{ $initialType }}',
        message: @js($initialMessage ?? ''),
        timeoutId: null,
        trigger(msg, toastType = 'success') {
            this.message = msg;
            this.type = toastType;
            this.show = true;
            this.startTimer();
        },
        startTimer() {
            if (this.timeoutId) clearTimeout(this.timeoutId);
            this.timeoutId = setTimeout(() => {
                this.show = false;
            }, 4500);
        },
        close() {
            this.show = false;
            if (this.timeoutId) clearTimeout(this.timeoutId);
        }
    }"
    x-init="
        if (show) {
            startTimer();
        }
        window.addEventListener('show-toast', (e) => {
            const detail = e.detail || {};
            trigger(detail.message || '', detail.type || 'success');
        });
    "
    class="fixed bottom-5 right-5 z-[99999] max-w-sm sm:max-w-md w-[calc(100%-2.5rem)] sm:w-auto pointer-events-none"
    style="display: none;"
    x-show="show"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="opacity-0 translate-y-3 scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-3 scale-95"
>
    <div
        class="pointer-events-auto flex items-center justify-between gap-3 px-4 py-3.5 rounded-xl shadow-lg text-white text-xs sm:text-sm font-medium transition-colors"
        :class="type === 'error' ? 'bg-[#DC2626]' : 'bg-[#059669]'"
    >
        <div class="flex items-center gap-3 min-w-0">
            <!-- Icon Success (Animated Checkmark) -->
            <template x-if="type !== 'error'">
                <div class="shrink-0 w-6 h-6 flex items-center justify-center toast-icon-bounce">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path class="toast-check-path" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
            </template>

            <!-- Icon Error (Animated Shake) -->
            <template x-if="type === 'error'">
                <div class="shrink-0 w-6 h-6 flex items-center justify-center toast-icon-shake">
                    <svg class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                </div>
            </template>

            <!-- Notification Text -->
            <div class="leading-snug break-words">
                <span x-text="message"></span>
            </div>
        </div>

        <!-- Close Button -->
        <button
            @click="close()"
            type="button"
            class="shrink-0 text-white/70 hover:text-white transition-colors p-1 rounded-md focus:outline-none -mr-1"
            title="Tutup"
            aria-label="Tutup"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>

<style>
@keyframes toastCheckDraw {
    0% {
        stroke-dashoffset: 28;
    }
    100% {
        stroke-dashoffset: 0;
    }
}

.toast-check-path {
    stroke-dasharray: 28;
    stroke-dashoffset: 28;
    animation: toastCheckDraw 0.45s cubic-bezier(0.65, 0, 0.35, 1) 0.1s forwards;
}

@keyframes toastIconBounce {
    0% {
        transform: scale(0.6);
        opacity: 0;
    }
    60% {
        transform: scale(1.2);
        opacity: 1;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.toast-icon-bounce {
    animation: toastIconBounce 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

@keyframes toastIconShake {
    0%, 100% { transform: translateX(0); }
    20%, 60% { transform: translateX(-2.5px); }
    40%, 80% { transform: translateX(2.5px); }
}

.toast-icon-shake {
    animation: toastIconShake 0.4s ease-in-out forwards;
}
</style>
