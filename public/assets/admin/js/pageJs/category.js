
//----For quill editor----
document.addEventListener('DOMContentLoaded', function () {

    initEditor(
        '#full-editor',     // editor container
        '#description',     // hidden textarea
        {
            placeholder: 'Write category description...'
        }
    );

});


//--------title to slug conversion

document.getElementById('name').addEventListener('keyup', function() {
    let title = this.value;

    let slug = title
        .toLowerCase()
        .trim()
        .replace(/[^a-z0-9\s-]/g, '') // remove special chars
        .replace(/\s+/g, '-')        // spaces to hyphens
        .replace(/-+/g, '-');       // multiple hyphens to single

    document.getElementById('slug').value = slug;
});

// Tag (meta keyword)

document.addEventListener('DOMContentLoaded', function () {

    // Meta keywords tag input
    initTagify('#metaKeywords', {
        maxTags: 15,
        whitelist: [], // optional future use
    });

});
