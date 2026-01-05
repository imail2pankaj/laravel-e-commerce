document.addEventListener('DOMContentLoaded', function () {

    const config = window.AttributeValueConfig;
    if (!config) {
        console.error('AttributeValueConfig missing');
        return;
    }

    /* ===============================
       DRAG & DROP SORTING
    =============================== */
    document.querySelectorAll('.sortable-table tbody').forEach(function (tbody) {

        Sortable.create(tbody, {
            handle: '.drag-handle',
            animation: 150,

            onEnd: function () {
                let order = [];

                tbody.querySelectorAll('tr').forEach((row, index) => {
                    order.push({
                        id: row.dataset.id,
                        sort_order: index + 1
                    });
                });

                fetch(config.sortUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': config.csrfToken
                    },
                    body: JSON.stringify({ order })
                });
            }
        });

    });

    /* ===============================
       EDIT MODAL
    =============================== */

    const editModalEl = document.getElementById('editValueModal');
    if (!editModalEl) return;

    const editModal = new bootstrap.Modal(editModalEl);

    document.querySelectorAll('.editValueBtn').forEach(btn => {
        btn.addEventListener('click', function () {

            document.getElementById('edit_value_id').value = this.dataset.id;
            document.getElementById('edit_value').value = this.dataset.value;
            document.getElementById('edit_attribute_name').value = this.dataset.attribute;
            document.getElementById('edit_is_active').checked = this.dataset.status == 1;
            document.getElementById('valueError').innerText = '';

            editModal.show();
        });
    });

    document.getElementById('editValueForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const id = document.getElementById('edit_value_id').value;
        const url = config.updateUrlTemplate.replace(':id', id);

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': config.csrfToken,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                _method: 'PUT',
                value: document.getElementById('edit_value').value,
                is_active: document.getElementById('edit_is_active').checked ? 1 : 0
            })
        })
        .then(res => res.json())
        .then(data => {
            if (!data.status) {
                document.getElementById('valueError').innerText =
                    data.message ?? 'Validation error';
                return;
            }

            editModal.hide();
            location.reload();
        })
        .catch(() => {
            document.getElementById('valueError').innerText =
                'Something went wrong. Please try again.';
        });
    });

});

// value (meta keyword)

document.addEventListener('DOMContentLoaded', function () {

    initTagify('#attributeValues', {
        maxTags: 50,
        dropdown: {
            enabled: 0
        }
    });

});
