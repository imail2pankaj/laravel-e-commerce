window.tableConfigs = {
    brandsTable: {
        DT_RowIndex: { searchable: false, orderable: false },
        name: {},
        status: {},
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
        });

        $('#filterStatus').on('change', function () {
            table.ajax.reload();
        });
    });
});

