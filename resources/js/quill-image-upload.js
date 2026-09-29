const ALLOWED_IMAGE_TYPES = new Set([
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp',
]);

const MAX_IMAGE_SIZE = 5 * 1024 * 1024;

function createQuillImageHandler({ endpoint, csrfToken, overlaySelector = null }) {
    return function openImagePicker() {
        // Quill invokes custom toolbar handlers with the toolbar module as `this`.
        const quill = this.quill;
        if (!quill) {
            console.error('Quill image handler could not resolve the editor instance.');
            return;
        }

        // Save the cursor before opening the native file dialog, which can remove focus.
        const selection = quill.getSelection();
        const insertIndex = Number.isInteger(selection?.index)
            ? selection.index
            : quill.getLength();
        console.log('[Quill] image upload cursor saved', { selection, insertIndex });

        const input = document.createElement('input');
        input.type = 'file';
        input.accept = '.jpg,.jpeg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp';
        input.hidden = true;
        document.body.appendChild(input);

        const overlay = overlaySelector ? document.querySelector(overlaySelector) : null;

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

                const responseText = await response.text();
                let result = null;
                try {
                    result = JSON.parse(responseText);
                } catch (parseError) {
                    console.error('[Quill] upload response is not valid JSON', {
                        status: response.status,
                        responseText,
                        parseError,
                    });
                    throw new Error('Respons server upload bukan JSON yang valid.');
                }

                console.log('[Quill] upload response received', {
                    status: response.status,
                    ok: response.ok,
                    result,
                });

                const hasUrlKey = Boolean(result && Object.prototype.hasOwnProperty.call(result, 'url'));
                const imageUrl = typeof result?.url === 'string' ? result.url.trim() : '';
                if (!response.ok || !result?.success || !hasUrlKey || !imageUrl) {
                    console.error('[Quill] upload response rejected before insertEmbed', {
                        status: response.status,
                        hasUrlKey,
                        imageUrl,
                        result,
                    });
                    throw new Error(result?.message || 'Respons upload tidak berisi URL gambar yang valid.');
                }

                console.log('[Quill] inserting image embed', { insertIndex, imageUrl });
                quill.insertEmbed(insertIndex, 'image', imageUrl, Quill.sources.USER);
                quill.setSelection(insertIndex + 1, Quill.sources.SILENT);
                console.log('[Quill] image embed inserted successfully', { insertIndex, imageUrl });
            } catch (error) {
                console.error('[Quill] image upload/insert error', error);
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
