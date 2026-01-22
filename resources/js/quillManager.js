import Quill from 'quill';
import 'quill/dist/quill.snow.css'; // or 'quill/dist/quill.bubble.css'

export function initQuill() {
    window.quills = {}; // optional registry for external access

    document.querySelectorAll('.quill-editor').forEach((el) => {
        const editorId = el.id;
        const content = el.dataset.content ?? '';
        const inputName = el.dataset.name;
        const height = el.dataset.height ?? '300px';
        const hiddenInput = document.querySelector(`#hidden_${editorId}`);

        // Init Quill
        const quill = new Quill(el, {
            theme: 'snow',
            placeholder: 'Write something...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    [{ color: [] }, { background: [] }],
                    ['clean']
                ]
            },
        });

        // Set height dynamically
        el.style.height = height;

        // Inject backend content
        quill.root.innerHTML = content;

        // Sync Quill content to hidden input
        quill.on('text-change', () => {
            if (hiddenInput) hiddenInput.value = quill.root.innerHTML;
        });

        // Optionally expose globally
        window.quills[editorId] = quill;

        document.dispatchEvent(new Event('quill-initialized'));
    });
}
