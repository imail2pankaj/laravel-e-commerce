window.tableConfigs = {
    productsTable: {
       DT_RowIndex: { searchable: false, orderable: false },
        image: { searchable: false, orderable: false },
        name: {},
        category: {},
        brand: {},
        price: { orderable: false },
        status: { orderable: false },
        action: { searchable: false, orderable: false }
    }
};

$(document).ready(function () {
    $('table[data-route]').each(function () {
        const tableId = $(this).attr('id');
        const ajaxUrl = $(this).data('route');
        const config = window.tableConfigs?.[tableId] || {};

        const table = DataTableBuilder.init(tableId, ajaxUrl, config, function (d) {
            d.status = $('#filterStatus').val();
            d.category_id = $('#filterCategory').val();
            d.brand_id = $('#filterBrand').val();
        });

       $('#filterStatus, #filterCategory, #filterBrand').on('change', function () {
            table.ajax.reload();
        });

    });
});

