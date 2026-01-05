
let table = $('#inventoryTable').DataTable();

// Product Filter
$('#filterProductSelect').on('change', function () {
    table.column(1).search($(this).val()).draw();
});


// Status Filter
$('#filterStatus').on('change', function () {
    table.column(6).search(this.value).draw(); 
});

// Sync status text on toggle change
$(document).on('change', '.status-toggle', function () {
    let row = $(this).closest('tr');
    row.find('.status-text').text($(this).is(':checked') ? 'Active' : 'Inactive');
});


let saveTimeout = null;

function showError(input, message) {
    input.addClass('is-invalid');

    if (input.next('.invalid-feedback').length === 0) {
        input.after(`<div class="invalid-feedback d-block">${message}</div>`);
    }
}

function clearError(input) {
    input.removeClass('is-invalid');
    input.next('.invalid-feedback').remove();
}

$(document).on(
    'input change',
    '.selling-price-input, .stock-input, .original-price-input, .status-toggle',
    function () {

        let row = $(this).closest('tr');
        let sellingPrice = row.find('.selling-price-input');
        let stock = row.find('.stock-input');

        let hasError = false;

       //  Selling price required
        if (!sellingPrice.val()) {
            showError(sellingPrice, 'Selling price is required');
            hasError = true;
        } else {
            clearError(sellingPrice);
        }

        //  Selling price must be > 0
        if (parseFloat(sellingPrice.val()) <= 0) {
            showError(sellingPrice, 'Selling price must be greater than 0');
            hasError = true;
        }

        //  Stock required
        if (!stock.val()) {
            showError(stock, 'Stock is required');
            hasError = true;
        } else {
            clearError(stock);
        }

        // Stock must be > 0
        if (parseFloat(stock.val()) <= 0) {
            showError(stock, 'Stock must be greater than 0');
            hasError = true;
        }

        // 🚫 Stop auto-save if validation fails
        if (hasError) return;

        clearTimeout(saveTimeout);

        saveTimeout = setTimeout(() => {

            let payload = {
                _token: window.inventoryConfig.csrfToken,
                variants: [{
                    id: sellingPrice.data('id'),
                    original_price: row.find('.original-price-input').val(),
                    selling_price: sellingPrice.val(),
                    stock: stock.val(),
                    status: row.find('.status-toggle').is(':checked') ? 1 : 0
                }]
            };

            $.ajax({
                url: window.inventoryConfig.updateUrl,
                type: "POST",
                data: payload
            });


        }, 600);
    }
);
