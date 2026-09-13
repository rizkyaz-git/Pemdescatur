@php
    $initialMessage = session('success') ?? session('status') ?? session('error');
    $initialType = session()->has('error') ? 'error' : 'success';
@endphp

<div
    id="app-toast-notification"
    class="app-toast-container"
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
    style="{{ $initialMessage ? '' : 'display: none;' }}"
    x-show="show"
    x-transition:enter="app-toast-enter"
    x-transition:enter-start="app-toast-enter-start"
    x-transition:enter-end="app-toast-enter-end"
    x-transition:leave="app-toast-leave"
    x-transition:leave-start="app-toast-leave-start"
    x-transition:leave-end="app-toast-leave-end"
>
    <div
        class="app-toast-card"
        :class="type === 'error' ? 'app-toast-error' : 'app-toast-success'"
    >
        <div class="app-toast-inner">
            <!-- Icon Success: Animated Checkmark -->
            <template x-if="type !== 'error'">
                <div class="app-toast-icon-wrap app-toast-icon-bounce">
                    <svg class="app-toast-icon" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path class="app-toast-check-path" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div>
            </template>

            <!-- Icon Error: Animated Shake -->
            <template x-if="type === 'error'">
                <div class="app-toast-icon-wrap app-toast-icon-shake">
                    <svg class="app-toast-icon" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9" stroke="#ffffff" stroke-width="2" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                </div>
            </template>

            <!-- Notification Text -->
            <div class="app-toast-text">
                <span x-text="message">{{ $initialMessage }}</span>
            </div>
        </div>

        <!-- Close Button -->
        <button
            @click="close()"
            type="button"
            class="app-toast-close"
            title="Tutup notifikasi"
            aria-label="Tutup notifikasi"
        >
            <svg class="app-toast-close-icon" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
</div>

<style>
/* Toast Container: Pojok kanan bawah terjamin secara absolut */
.app-toast-container {
    position: fixed !important;
    bottom: 24px !important;
    right: 24px !important;
    z-index: 9999999 !important;
    width: calc(100vw - 48px) !important;
    max-width: 440px !important;
    pointer-events: none !important;
}

@media (min-width: 640px) {
    .app-toast-container {
        width: auto !important;
        min-width: 320px !important;
        max-width: 480px !important;
    }
}

/* Card Notifikasi: Fill solid murni & simpel */
.app-toast-card {
    pointer-events: auto !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    gap: 12px !important;
    padding: 12px 18px !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1) !important;
    color: #ffffff !important;
    font-size: 13.5px !important;
    font-weight: 500 !important;
    line-height: 1.45 !important;
    box-sizing: border-box !important;
}

/* Warna Fill Solid */
.app-toast-success {
    background-color: #059669 !important; /* Hijau emerald solid */
}

.app-toast-error {
    background-color: #dc2626 !important; /* Merah solid */
}

.app-toast-inner {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    min-width: 0 !important;
}

.app-toast-text {
    word-break: break-word !important;
    color: #ffffff !important;
    font-size: 13.5px !important;
    font-weight: 500 !important;
}

.app-toast-icon-wrap {
    width: 24px !important;
    height: 24px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    flex-shrink: 0 !important;
}

.app-toast-icon {
    width: 22px !important;
    height: 22px !important;
    display: block !important;
}

.app-toast-close {
    background: transparent !important;
    border: none !important;
    color: rgba(255, 255, 255, 0.75) !important;
    cursor: pointer !important;
    padding: 4px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    border-radius: 6px !important;
    transition: color 0.15s ease, background 0.15s ease !important;
    flex-shrink: 0 !important;
    margin-right: -4px !important;
}

.app-toast-close:hover {
    color: #ffffff !important;
    background: rgba(255, 255, 255, 0.18) !important;
}

.app-toast-close-icon {
    width: 16px !important;
    height: 16px !important;
}

/* Animasi Masuk dan Keluar (Slide-up & Fade) */
.app-toast-enter {
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1) !important;
}
.app-toast-enter-start {
    opacity: 0 !important;
    transform: translateY(16px) scale(0.95) !important;
}
.app-toast-enter-end {
    opacity: 1 !important;
    transform: translateY(0) scale(1) !important;
}
.app-toast-leave {
    transition: all 0.25s ease-in !important;
}
.app-toast-leave-start {
    opacity: 1 !important;
    transform: translateY(0) scale(1) !important;
}
.app-toast-leave-end {
    opacity: 0 !important;
    transform: translateY(16px) scale(0.95) !important;
}

/* Animasi Ikon Centang (Draw + Pop Bounce) */
@keyframes appToastCheckDraw {
    0% {
        stroke-dashoffset: 28;
    }
    100% {
        stroke-dashoffset: 0;
    }
}

.app-toast-check-path {
    stroke-dasharray: 28;
    stroke-dashoffset: 28;
    animation: appToastCheckDraw 0.45s cubic-bezier(0.65, 0, 0.35, 1) 0.12s forwards;
}

@keyframes appToastPop {
    0% {
        transform: scale(0.5);
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

.app-toast-icon-bounce {
    animation: appToastPop 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
}

/* Animasi Ikon Error (Subtle Shake) */
@keyframes appToastShake {
    0%, 100% { transform: translateX(0); }
    20%, 60% { transform: translateX(-2.5px); }
    40%, 80% { transform: translateX(2.5px); }
}

.app-toast-icon-shake {
    animation: appToastShake 0.4s ease-in-out forwards;
}
</style>
