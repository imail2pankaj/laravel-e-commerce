
//without pipeline js
const DataTableBuilder = (() => {
    const defaultOptions = {
        processing: true,
        serverSide: true,
        paging: true,
        searching: true,
        ordering: true,
        language: { processing: "Loading..." },
        scrollX: true,
        lengthMenu: [10, 25, 50, 100],
        pageLength: 10,
    };

    function init(tableId, ajaxUrl, columnsConfig, extraData = null) {
    const columns = Object.keys(columnsConfig).map(key => ({
        data: key,
        name: key,
        orderable: columnsConfig[key].orderable ?? true,
        searchable: columnsConfig[key].searchable ?? true
    }));

    return $('#' + tableId).DataTable({
        ...defaultOptions,
        ajax: {
            url: ajaxUrl,
            type: "GET",
            data: function (d) {
                if (typeof extraData === 'function') {
                    extraData(d); // Add custom filters here
                }
            }
        },
        columns: columns
    });
}


    return { init };
})();
