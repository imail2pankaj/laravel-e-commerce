/**
 * Universal Quill Editor Initializer
 *
 * @param {string} editorSelector - Editor container selector
 * @param {string} inputSelector  - Hidden textarea selector
 * @param {object} options        - Custom Quill options
 */

'use strict';

window.initEditor = function (editorSelector, inputSelector, options = {}) {
    const editorContainer = document.querySelector(editorSelector);
    const hiddenInput = document.querySelector(inputSelector);

    if (!editorContainer || !hiddenInput) return null;

    // Prevent double initialization
    if (editorContainer.__quill) return editorContainer.__quill;

    const defaultToolbar = [
        ['bold', 'italic'],
        [{ header: '2' }],
        [{ list: 'ordered' }, { list: 'bullet' }],
        [{ align: [] }],
        ['link'],
        ['clean']
    ];

    const quill = new Quill(editorContainer, {
        theme: 'snow',
        placeholder: 'Type something...',
        modules: {
            toolbar: defaultToolbar
        },
        ...options
    });

    // Load old/edit value
    if (hiddenInput.value.trim() !== '') {
        quill.root.innerHTML = hiddenInput.value;
    }

    // Sync editor → textarea on form submit
    const form = editorContainer.closest('form');
    if (form) {
        form.addEventListener('submit', function () {
            hiddenInput.value = quill.root.innerHTML;
        });
    }

    return quill;
};
