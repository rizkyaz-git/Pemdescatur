const ALLOWED_IMAGE_TYPES = new Set([
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp',
]);

const MAX_IMAGE_SIZE = 5 * 1024 * 1024;

function createQuillImageHandler({ endpoint, csrfToken, overlaySelector = null }) {
    return function openImagePicker() {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = '.jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp';
        input.hidden = true;
        document.body.appendChild(input);

        // Quill invokes custom toolbar handlers with the editor as `this`.
        const quill = this;
        const overlay = overlaySelector ? document.querySelector(overlaySelector) : null;
        const selection = quill.getSelection(true);
        const insertIndex = selection?.index ?? Math.max(quill.getLength() - 1, 0);

        const setLoading = (loading) => {
            if (loading) {
                quill.disable();
                overlay?.classList.remove('hidden');
            } else {
                quill.enable();
                overlay?.classList.add('hidden');
            }
        };

        const showError = (message) => {
            window.alert(message);
        };

        input.addEventListener('change', async () => {
            const file = input.files?.[0];
            if (!file) {
                input.remove();
                return;
            }

            if (!ALLOWED_IMAGE_TYPES.has(file.type) || file.size > MAX_IMAGE_SIZE) {
                showError('Gunakan gambar JPG, PNG, GIF, atau WebP dengan ukuran maksimal 5 MB.');
                input.remove();
                return;
            }

            const formData = new FormData();
            formData.append('image', file, file.name);

            setLoading(true);

            try {
                const response = await fetch(endpoint, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                    headers: {
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                const result = await response.json().catch(() => null);
                if (!response.ok || !result?.success || !result?.url) {
                    throw new Error(result?.message || 'Gambar gagal diunggah.');
                }

                quill.insertEmbed(insertIndex, 'image', result.url, Quill.sources.USER);
                quill.setSelection(insertIndex + 1, Quill.sources.SILENT);
            } catch (error) {
                console.error('Quill image upload error:', error);
                showError(error instanceof Error ? error.message : 'Gambar gagal diunggah. Silakan coba lagi.');
            } finally {
                setLoading(false);
                input.remove();
            }
        }, { once: true });

        input.click();
    };
}

window.QuillImageUpload = Object.freeze({ createHandler: createQuillImageHandler });

export { createQuillImageHandler };
