@php
    $initialMessage = session('success') ?? session('status') ?? session('error');
    $initialType = session()->has('error') ? 'error' : 'success';
@endphp

<!-- 1. Floating Solid Notification Toast (Pojok Kanan Bawah) -->
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

<!-- 2. Interactive Solid Action Confirmation Dialog (Pojok Kanan Bawah) -->
<div
    id="app-confirm-dialog"
    class="app-toast-container"
    x-data="{
        show: false,
        message: '',
        confirmText: 'Ya, Hapus',
        cancelText: 'Batal',
        isDelete: true,
        callback: null,
        open(msg, cb, options = {}) {
            this.message = msg;
            this.callback = cb;
            this.isDelete = (msg || '').toLowerCase().includes('hapus') || (msg || '').toLowerCase().includes('delete') || (msg || '').toLowerCase().includes('reset');
            this.confirmText = options.confirmText || (this.isDelete ? 'Ya, Hapus' : 'Ya, Lanjutkan');
            this.cancelText = options.cancelText || 'Batal';
            this.show = true;
        },
        confirm() {
            this.show = false;
            if (typeof this.callback === 'function') {
                this.callback();
            }
        },
        cancel() {
            this.show = false;
        }
    }"
    x-init="
        window.showConfirmDialog = (opts) => {
            open(opts.message || '', opts.onConfirm, opts);
        };
    "
    style="display: none;"
    x-show="show"
    x-transition:enter="app-toast-enter"
    x-transition:enter-start="app-toast-enter-start"
    x-transition:enter-end="app-toast-enter-end"
    x-transition:leave="app-toast-leave"
    x-transition:leave-start="app-toast-leave-start"
    x-transition:leave-end="app-toast-leave-end"
>
    <div
        class="app-confirm-card"
        :class="isDelete ? 'app-toast-error' : 'app-toast-confirm-dark'"
    >
        <div class="app-confirm-header">
            <!-- Animated Warning / Question Icon -->
            <div class="app-toast-icon-wrap app-confirm-icon-pulse">
                <svg class="app-toast-icon" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <div class="app-confirm-text">
                <span x-text="message"></span>
            </div>
        </div>

        <!-- Confirm Action Buttons -->
        <div class="app-confirm-buttons">
            <button
                @click="cancel()"
                type="button"
                class="app-confirm-btn app-confirm-btn-cancel"
            >
                <span x-text="cancelText">Batal</span>
            </button>
            <button
                @click="confirm()"
                type="button"
                class="app-confirm-btn app-confirm-btn-submit"
            >
                <span x-text="confirmText">Ya, Hapus</span>
            </button>
        </div>
    </div>
</div>

<script>
(function() {
    function setupConfirmInterceptor() {
        // Intercept form submission with confirm(...)
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (!form || form._isConfirmed) return;

            const onsubmitAttr = form.getAttribute('onsubmit') || '';
            const dataConfirm = form.getAttribute('data-confirm') || '';

            let confirmMsg = null;
            // Match confirm('...') or confirm("...")
            const match = onsubmitAttr.match(/confirm\(\s*(['"])([\s\S]*?)\1\s*\)/i);
            if (match) {
                confirmMsg = match[2];
            } else if (dataConfirm) {
                confirmMsg = dataConfirm;
            }

            if (confirmMsg && window.showConfirmDialog) {
                e.preventDefault();
                e.stopImmediatePropagation();

                window.showConfirmDialog({
                    message: confirmMsg,
                    onConfirm: function() {
                        form._isConfirmed = true;
                        const originalOnsubmit = form.getAttribute('onsubmit');
                        form.removeAttribute('onsubmit');
                        form.submit();
                        if (originalOnsubmit) {
                            form.setAttribute('onsubmit', originalOnsubmit);
                        }
                    }
                });
            }
        }, true);

        // Intercept click on button/link with confirm(...) in onclick
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('button, a');
            if (!btn || btn._isConfirmed) return;

            const onclickAttr = btn.getAttribute('onclick') || '';
            const match = onclickAttr.match(/confirm\(\s*(['"])([\s\S]*?)\1\s*\)/i);
            if (match && window.showConfirmDialog) {
                e.preventDefault();
                e.stopImmediatePropagation();
                const confirmMsg = match[2];

                window.showConfirmDialog({
                    message: confirmMsg,
                    onConfirm: function() {
                        btn._isConfirmed = true;
                        const originalOnclick = btn.getAttribute('onclick');
                        btn.removeAttribute('onclick');
                        btn.click();
                        if (originalOnclick) {
                            btn.setAttribute('onclick', originalOnclick);
                        }
                    }
                });
            }
        }, true);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', setupConfirmInterceptor);
    } else {
        setupConfirmInterceptor();
    }
})();
</script>

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

/* Card Konfirmasi: Fill solid dengan tombol aksi */
.app-confirm-card {
    pointer-events: auto !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 12px !important;
    padding: 14px 18px !important;
    border-radius: 14px !important;
    box-shadow: 0 14px 30px -4px rgba(0, 0, 0, 0.3), 0 6px 12px -3px rgba(0, 0, 0, 0.15) !important;
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

.app-toast-confirm-dark {
    background-color: #1e293b !important; /* Slate 800 solid */
}

.app-toast-inner,
.app-confirm-header {
    display: flex !important;
    align-items: flex-start !important;
    gap: 12px !important;
    min-width: 0 !important;
}

.app-toast-text,
.app-confirm-text {
    word-break: break-word !important;
    color: #ffffff !important;
    font-size: 13.5px !important;
    font-weight: 500 !important;
    padding-top: 1px !important;
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

/* Tombol Aksi Konfirmasi */
.app-confirm-buttons {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 8px !important;
    padding-top: 2px !important;
}

.app-confirm-btn {
    border: none !important;
    outline: none !important;
    padding: 6px 14px !important;
    border-radius: 8px !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    transition: all 0.15s ease !important;
    font-family: inherit !important;
}

.app-confirm-btn-cancel {
    background: rgba(255, 255, 255, 0.2) !important;
    color: #ffffff !important;
}

.app-confirm-btn-cancel:hover {
    background: rgba(255, 255, 255, 0.32) !important;
}

.app-confirm-btn-submit {
    background: #ffffff !important;
    color: #dc2626 !important;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15) !important;
}

.app-confirm-btn-submit:hover {
    background: #f8fafc !important;
    transform: scale(1.02) !important;
}

.app-toast-confirm-dark .app-confirm-btn-submit {
    background: #ffffff !important;
    color: #1e293b !important;
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

/* Animasi Ikon Konfirmasi Peringatan (Subtle Pulse) */
@keyframes appConfirmPulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.15);
    }
}

.app-confirm-icon-pulse {
    animation: appConfirmPulse 1.2s ease-in-out infinite !important;
}
</style>
