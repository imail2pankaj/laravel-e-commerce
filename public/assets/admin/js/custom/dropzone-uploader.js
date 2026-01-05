"use strict";

Dropzone.autoDiscover = false;

document.addEventListener("DOMContentLoaded", function () {

    const dzElements = document.querySelectorAll(".universal-dropzone");
    if (!dzElements.length) return;

    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    dzElements.forEach(function (el) {

        // Read dynamic values from HTML
        const url      = el.dataset.url;
        const maxFiles = parseInt(el.dataset.maxFiles || 1);
        const maxSize  = parseFloat(el.dataset.maxSize || 5);
        const accepted = el.dataset.accepted || ".jpg,.jpeg,.png,.webp";

        if (!url) {
            console.error("Dropzone Error: data-url missing");
            return;
        }

        // Your Bootstrap template
        const previewTemplate = `
        <div class="dz-preview dz-file-preview">
            <div class="dz-details">
                <div class="dz-thumbnail">
                    <img data-dz-thumbnail>
                    <div class="progress">
                        <div class="progress-bar" data-dz-uploadprogress></div>
                    </div>
                </div>
                <div data-dz-name class="dz-filename"></div>
                <div data-dz-size class="dz-size"></div>
                <p class="dz-error-message">
                    <span data-dz-errormessage></span>
                </p>
            </div>
        </div>`;

        new Dropzone(el, {
            url: url,
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrf
            },
            previewTemplate: previewTemplate,
            maxFilesize: maxSize,
            maxFiles: maxFiles,
            acceptedFiles: accepted,
            addRemoveLinks: true
        });

    });
});
