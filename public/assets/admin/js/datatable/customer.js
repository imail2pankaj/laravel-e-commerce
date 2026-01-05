window.tableConfigs = {
    customersTable: {
        DT_RowIndex: { searchable: false, orderable: false },
        name: {},
        email: {},
        action: { searchable: false, orderable: false }
    }
};

$(document).ready(function () {
    $('table[data-route]').each(function () {
        const tableId = $(this).attr('id');
        const ajaxUrl = $(this).data('route');
        const config = window.tableConfigs?.[tableId] || {};

         DataTableBuilder.init(tableId, ajaxUrl, config);
    });
});