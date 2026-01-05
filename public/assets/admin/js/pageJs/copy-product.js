
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

    /* ============================
       TAGIFY: SEO META KEYWORDS
       ============================ */
    let metaInput = document.querySelector('#metaKeywords');

    if (metaInput) {
        new Tagify(metaInput, {
            maxTags: 15,
            whitelist: [],
            dropdown: {
                maxItems: 20,
                enabled: 0,
                closeOnSelect: false
            }
        });
    }


    /* ============================
       TAGIFY: PRODUCT TAGS
       ============================ */

    
    let tagInput = document.querySelector('#tags');
    if (!tagInput) return;

    let existingTags = window.allTags ?? [];
    let productTags = window.productTags ?? [];

    // Initialize Tagify
    let tagify = new Tagify(tagInput, {
        whitelist: existingTags,
        dropdown: {
            maxItems: 20,
            enabled: 0,
            closeOnSelect: false
        }
    });

    // IMPORTANT: Clear any values browser/Blade pre-filled
    tagify.removeAllTags();

    // Load product tags (edit mode)
    if (productTags.length > 0) {
        tagify.addTags(productTags);
    }

});

///image detele
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('delete-image-btn')) {

        let imageId = e.target.dataset.id;
        let finalUrl = window.deleteImageUrl.replace('__ID__', imageId);
        let imageBox = e.target.closest('.image-box');

        fetch(finalUrl, {
            method: 'DELETE',
            headers: {
                "X-CSRF-TOKEN": window.csrf
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                imageBox.remove();
            }
        });
    }
});

//drag and drop image
let gallery = document.getElementById('galleryContainer');

if (gallery) {

    let sortable = new Sortable(gallery, {
        animation: 150,
        ghostClass: "bg-light",
        onEnd: function () {
            saveSortOrder();
        }
    });

    function saveSortOrder() {
        let order = [];

        document.querySelectorAll('#galleryContainer .image-box')
            .forEach((el, index) => {
                order.push({
                    id: el.dataset.id,
                    position: index + 1
                });
            });

        fetch(window.sortImageUrl, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": window.csrf,
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ order })
        })
        .then(res => res.json())
        .then(data => {
            console.log("Sorting saved");
        });
    }
}


// --------------------------varint----------------------------------------

document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".attribute-checkbox")
        .forEach(cb => cb.addEventListener("change", generateVariants));

    generateVariants();
});

function getSelectedValues() {
    let selection = {};

    document.querySelectorAll(".attribute-checkbox:checked").forEach(cb => {
        let attr = cb.dataset.attributeId;
        if (!selection[attr]) selection[attr] = [];
        selection[attr].push(cb.value);
    });

    return selection;
}

function cartesian(arrays) {
    let result = [[]];
    for (let arr of arrays) {
        let temp = [];
        for (let r of result) {
            for (let v of arr) temp.push([...r, v]);
        }
        result = temp;
    }
    return result;
}

function generateVariants() {

    const selected = getSelectedValues();
    const groups = Object.values(selected);
    const container = document.getElementById("variantTableContainer");
    const hiddenDiv = document.getElementById("selectedValuesHidden");

    hiddenDiv.innerHTML = "";

    document.querySelectorAll(".attribute-checkbox:checked")
        .forEach(cb => {
            hiddenDiv.innerHTML += `<input type="hidden" name="selected_values[]" value="${cb.value}">`;
        });

    let html = "";

    // --------------------------------------------------------
    // PART 1: NEW + VALID VARIANTS (generated from combinations)
    // --------------------------------------------------------
    if (groups.length > 0) {
        const combos = cartesian(groups);

        html += `
            <h6>Valid Variants</h6>
            <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Variant</th>
                    <th>SKU</th>
                    <th>Original Price</th>
                    <th>Selling Price</th>
                    <th>Stock</th>
                    <th>Image</th>
                    <th>Default</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
        `;

        combos.forEach(combo => {
            const existing = findExisting(combo);
            html += rowTemplate(combo, existing);
        });

        html += "</tbody></table>";
    }

    // --------------------------------------------------------
    // PART 2: SHOW INVALID VARIANTS (regardless of selection)
    // --------------------------------------------------------
    let invalids = window.existingVariants.filter(v => v.is_invalid === 1);

    if (invalids.length > 0) {
        html += `
            <h6 class="mt-4 text-danger">Invalid Variants</h6>
            <p class="text-muted">These variants no longer match selected attributes.</p>

            <table class="table table-bordered table-danger">
                <thead>
                    <tr>       
                        <th>Variant</th>
                        <th>SKU</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
        `;

        invalids.forEach(v => {
            let title = v.values.map(x => getLabel(x.attribute_value_id)).join(" / ");

            html += `
            <tr>
                <td>${title}</td>
                <td>${v.sku ? v.sku.sku : ""}</td>
                <td>${v.selling_price ?? ""}</td>
                <td>${v.stock ?? ""}</td>
                <td class="text-danger">${v.invalid_reason}</td>
            </tr>`;
        });

        html += "</tbody></table>";
    }

    container.innerHTML = html;
}


function findExisting(combo) {

    if (!window.existingVariants || window.existingVariants.length === 0)
        return null;

    const comboStr = combo.map(String).sort();

    return window.existingVariants.find(v => {
        const existingStr = v.values
            .map(x => String(x.attribute_value_id))
            .sort();

        return JSON.stringify(existingStr) === JSON.stringify(comboStr);
    });
}

function rowTemplate(combo, existing) {

    let title = combo.map(id => getLabel(id)).join(" / ");

    if (existing) {
        return `
        <tr class="${existing.is_invalid ? 'table-danger' : ''}">
            <td>
                ${title}<br>
                ${existing.is_invalid ? `<small class="text-danger">${existing.invalid_reason}</small>` : ``}
            </td>

            <td>
           
              <input type="text" value="${existing.sku}" readonly class="form-control bg-light">
            </td>

            <td><input type="number" class="form-control" name="variants[${existing.id}][original_price]" value="${existing.original_price ?? ''}" required></td>

            <td><input type="number" class="form-control" name="variants[${existing.id}][selling_price]" value="${existing.selling_price ?? ''}" required></td>

            <td><input type="number" class="form-control" name="variants[${existing.id}][stock]" value="${existing.stock ?? ''}"></td>

            <td>
                <div style="
                    width:55px;
                    height:55px;
                    border:1px solid #ccc;
                    border-radius:6px;
                    overflow:hidden;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    background:#f8f9fa;
                ">
                    ${existing.image 
                        ? `<img src="/storage/${existing.image}" style="width:100%;height:100%;object-fit:cover;">`
                        : `<span style="font-size:10px;color:#888;">No Image</span>`
                    }
                </div>

                <input 
                    type="file" 
                    name="variants[${existing.id}][image]" 
                    class="form-control mt-2"
                    onchange="previewVariantImage(this)"
                >
            </td>


            <td><input type="radio" name="default_variant" value="${existing.id}" ${existing.is_default ? 'checked' : ''}></td>

            <td>
                <!-- Always send 0 by default -->
                <input type="hidden" name="variants[${existing.id}][status]" value="0">

                <div class="form-check form-switch">
                    <input 
                        class="form-check-input"
                        type="checkbox"
                        name="variants[${existing.id}][status]"
                        value="1"
                        ${existing.status == 1 ? 'checked' : ''}>
                </div>
            </td>


        </tr>`;
    }

    const key = combo.join("_");
    // const newSku = generateLiveSKU();

    return `
    <tr>
        <td>${title}</td>

        <td>
        <input type="text" value="(Auto SKU after save)" readonly class="form-control bg-light">

        </td>
 
        <td><input type="number" class="form-control" name="new_variants[${key}][original_price]" required></td>

        <td><input type="number" class="form-control" name="new_variants[${key}][selling_price]" required></td>

        <td><input type="number" class="form-control" name="new_variants[${key}][stock]"></td>

        <td><input type="file" class="form-control" name="new_variants[${key}][image]"></td>

        <td><input type="radio" name="default_variant" value="new_${key}"></td>

        <td>
            <div class="form-check form-switch">
              <input 
                class="form-check-input"
                type="checkbox"
                name="new_variants[${key}][status]"
                value="1"
                checked>
           </div>
        </td>

    </tr>`;
}



function getLabel(id) {
    let el = document.querySelector(`input[value='${id}']`);
    return el ? el.nextSibling.textContent.trim() : id;
}

function previewVariantImage(input) {
    if (!input.files || !input.files[0]) return;

    let reader = new FileReader();
    reader.onload = function (e) {
        let box = input.closest('td').querySelector('div');
        box.innerHTML = `<img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;">`;
    };
    reader.readAsDataURL(input.files[0]);
}